<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar usuário administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@udemyclone.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'bio' => 'Administrador do sistema Udemy Clone',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Criar usuário instrutor de exemplo
        User::create([
            'name' => 'João Silva',
            'email' => 'instrutor@udemyclone.com',
            'password' => Hash::make('instrutor123'),
            'role' => 'instructor',
            'bio' => 'Instrutor especializado em desenvolvimento web',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Criar usuário estudante de exemplo
        User::create([
            'name' => 'Maria Santos',
            'email' => 'estudante@udemyclone.com',
            'password' => Hash::make('estudante123'),
            'role' => 'student',
            'bio' => 'Estudante interessada em tecnologia',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
