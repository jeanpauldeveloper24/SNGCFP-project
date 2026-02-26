<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. CRÉATION DES RÔLES ---
        $this->createRoles();

        // --- 2. UTILISATEURS WEB ---
        $webUsers = [
            ['name' => 'Koffi Kouamé', 'email' => 'admin@sngcfp.ci', 'role' => 'ADMIN', 'phone' => '0707010203', 'img' => 'profiles/Koffi_Kouamé.png'],
            ['name' => 'Jean-Marc Kouassi', 'email' => 'jm.kouassi@sngcfp.ci', 'role' => 'COMPTABLE_BAD', 'phone' => '0505010203', 'img' => 'profiles/Jean_Marc_Kouassi.png'],
            ['name' => 'Awa Diop', 'email' => 'a.diop@sngcfp.ci', 'role' => 'GESTIONNAIRE_BUDGET', 'phone' => '0101010203', 'img' => 'profiles/Awa_Diop.png'],
            ['name' => 'Moussa Traoré', 'email' => 'm.traore@sngcfp.ci', 'role' => 'SPECIALISTE_MARCHE', 'phone' => '0708091011', 'img' => 'profiles/Moussa_Traore.png'],
            ['name' => 'Christian Yao', 'email' => 'c.yao@sngcfp.ci', 'role' => 'ORDONNATEUR', 'phone' => '0506070809', 'img' => 'profiles/Christian_Yao.png'],
            ['name' => 'Sarah Touré', 'email' => 's.toure@sngcfp.ci', 'role' => 'CONTROLEUR_INTERNE', 'phone' => '0102030405', 'img' => 'profiles/Sarah_Toure.png'],
        ];

        foreach ($webUsers as $u) {
            $role = Role::where('name', $u['role'])->first();
            User::updateOrCreate(['email' => $u['email']], [
                'name' => $u['name'],
                'password' => Hash::make('Password123!'),
                'role_id' => $role->id,
                'phone' => $u['phone'],
                'photo' => $u['img'],
                'status' => 'actif'
            ]);
        }

        // --- 3. UTILISATEURS FLUTTER ---
        $flutterUsers = [
            ['name' => 'Jean Dupont', 'email' => 'bad@test.ci', 'role' => 'badRepresentative', 'phone' => '0707445566', 'img' => 'profiles/Jean_Dupont.png'],
            ['name' => 'Souleymane Diarrassouba', 'email' => 'ministere@test.ci', 'role' => 'ministryOfTutelle', 'phone' => '0505445566', 'img' => 'profiles/Souleymane_Diarrassouba.jpg'],
            ['name' => 'Awa Koné', 'email' => 'direction@test.ci', 'role' => 'nationalDirection', 'phone' => '0101445566', 'img' => 'profiles/Awa_Kone.png'],
            ['name' => 'Cabinet Audit Pro', 'email' => 'audit@test.ci', 'role' => 'externalAuditor', 'phone' => '0747112233', 'img' => 'profiles/Cabinet_Audit_Pro.png'],
            ['name' => 'BTP Construction CI', 'email' => 'entreprise@test.ci', 'role' => 'prestataire', 'phone' => '0545112233', 'img' => 'profiles/BTP_Construction_CI.png'],
        ];

        foreach ($flutterUsers as $u) {
            $role = Role::where('name', $u['role'])->first();
            User::updateOrCreate(['email' => $u['email']], [
                'name' => $u['name'],
                'password' => Hash::make('123Bad'),
                'role_id' => $role->id,
                'phone' => $u['phone'],
                'photo' => $u['img'],
                'status' => 'actif',
                'work_at' => 'SNGP-BAD Unité de Suivi'
            ]);
        }

        // --- 4. PROJETS ---
        $this->seedProjects();

        // --- 5. RISQUES  ---
        $this->call(RiskSeeder::class);
    }

    private function createRoles() {
        $roles = [
            ['ADMIN', 'laravel_web'], ['COMPTABLE_BAD', 'laravel_web'], ['GESTIONNAIRE_BUDGET', 'laravel_web'],
            ['SPECIALISTE_MARCHE', 'laravel_web'], ['ORDONNATEUR', 'laravel_web'], ['CONTROLEUR_INTERNE', 'laravel_web'],
            ['badRepresentative', 'flutter_desktop'], ['ministryOfTutelle', 'flutter_desktop'], 
            ['nationalDirection', 'flutter_desktop'], ['externalAuditor', 'flutter_desktop'], ['prestataire', 'flutter_desktop']
        ];
        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r[0]], ['platform' => $r[1]]);
        }
    }

    private function seedProjects() {
        $projets = [
            ['code' => 'PAIA-2', 'nom' => 'Agro-industrie', 'cat' => 'Travaux Civil', 'alloue' => 45000000000, 'depense' => 28000000000],
            ['code' => 'PTUA', 'nom' => 'Transport Urbain Abidjan', 'cat' => 'Travaux Civil', 'alloue' => 90000000000, 'depense' => 55000000000],
            ['code' => 'PEPT', 'nom' => 'Électricité pour tous', 'cat' => 'Infrastructure', 'alloue' => 60000000000, 'depense' => 42000000000],
            ['code' => 'PSSR', 'nom' => 'Santé Rurale', 'cat' => 'Santé', 'alloue' => 40000000000, 'depense' => 12000000000],
            ['code' => 'PAEPA', 'nom' => 'Eau et Assainissement', 'cat' => 'Infrastructure', 'alloue' => 35000000000, 'depense' => 20000000000],
            ['code' => 'PEJ', 'nom' => 'Emploi Jeunes', 'cat' => 'Social', 'alloue' => 25000000000, 'depense' => 15000000000],
            ['code' => 'PAG', 'nom' => 'Gouvernance Économique', 'cat' => 'Études', 'alloue' => 20000000000, 'depense' => 18000000000],
            ['code' => 'PASC', 'nom' => 'Appui Secteur Cacaoyer', 'cat' => 'Agro', 'alloue' => 50000000000, 'depense' => 35000000000],
            ['code' => 'RSP', 'nom' => 'Route San-Pedro', 'cat' => 'Travaux Civil', 'alloue' => 70000000000, 'depense' => 45000000000],
            ['code' => 'DSP', 'nom' => 'Digitalisation Services', 'cat' => 'Équipements', 'alloue' => 15000000000, 'depense' => 10000000000],
        ];
        foreach ($projets as $p) {
            Project::updateOrCreate(['code' => $p['code']], [
                'nom' => $p['nom'], 'categorie' => $p['cat'], 'budget_alloue' => $p['alloue'],
                'budget_depense' => $p['depense'], 'fonds_recus_bad' => $p['alloue'] * 0.8,
                'taux_execution' => ($p['depense'] / $p['alloue']) * 100,
            ]);
        }
    }
}