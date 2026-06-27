<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function authenticate(): void
{
    $this->ensureIsNotRateLimited();

    if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    // --- DÉBUT DES MODIFICATIONS ---
    $user = Auth::user();

    // On charge la relation role si ce n'est pas déjà fait
    $user->load('role');

    // On vérifie si on est sur une requête API (Flutter) ou Web
    // Si la requête attend du JSON, c'est que ça vient de Flutter
    if ($this->expectsJson()) {
        if (!$user->role || $user->role->platform !== 'flutter_desktop') {
            Auth::logout(); // On déconnecte immédiatement
            throw ValidationException::withMessages([
                'email' => "Accès refusé. Ce compte n'est pas autorisé sur l'application Desktop.",
            ]);
        }
    } else {
        // Sinon, c'est la connexion via le navigateur (Laravel Web)
        if (!$user->role || $user->role->platform !== 'laravel_web') {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => "Accès refusé. Ce compte est réservé à l'application Desktop.",
            ]);
        }
    }
    // --- FIN DES MODIFICATIONS ---

    RateLimiter::clear($this->throttleKey());
}

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
