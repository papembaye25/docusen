<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@docusen.sn'],
            [
                'nom'      => 'Super Admin DocuSen',
                'email'    => 'superadmin@docusen.sn',
                'phone'    => '+221771234567',
                'password' => Hash::make('SuperAdmin@2026'),
                'role'     => 'super_admin',
                'status'   => 'actif',
            ]
        );

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@docusen.sn'],
            [
                'nom'      => 'Admin DocuSen',
                'email'    => 'admin@docusen.sn',
                'phone'    => '+221779876543',
                'password' => Hash::make('Admin@2026'),
                'role'     => 'admin',
                'status'   => 'actif',
            ]
        );

        // Citoyen test
        User::updateOrCreate(
            ['email' => 'citoyen@test.sn'],
            [
                'nom'      => 'Citoyen Test',
                'email'    => 'citoyen@test.sn',
                'phone'    => '+221701234567',
                'password' => Hash::make('Citoyen@2026'),
                'role'     => 'citoyen',
                'status'   => 'actif',
            ]
        );

        $this->command->info('✅ Comptes de démonstration créés avec succès !');
        $this->command->info('superadmin@docusen.sn / SuperAdmin@2026');
        $this->command->info('admin@docusen.sn / Admin@2026');
        $this->command->info('citoyen@test.sn / Citoyen@2026');
    }
}