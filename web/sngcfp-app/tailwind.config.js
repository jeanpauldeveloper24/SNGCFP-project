import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // Ajout de Montserrat et Inter pour tes textes BAD
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                montserrat: ['Montserrat', 'sans-serif'],
                inter: ['Inter', 'sans-serif'],
            },
            colors: {
                // Déclaration de tes couleurs pour éviter les erreurs de rendu
                'bad-blue': '#1B4F72',
                'bad-blue-dark': '#0d2a3d',
                'bad-blue-light': '#2E86C1',
                'bad-green': '#27AE60',
                'bad-red': '#ff4d4d',
            },
        },
    },

    plugins: [forms],
};
