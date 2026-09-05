<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Note;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin / Dentist ────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Dr. Sarah Johnson',
            'email'    => 'admin@mediSmile.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ── Secretary ─────────────────────────────────────────────────────
        User::create([
            'name'     => 'Emily Clark',
            'email'    => 'secretary@mediSmile.com',
            'password' => Hash::make('password'),
            'role'     => 'secretary',
        ]);

        // ── Patients ──────────────────────────────────────────────────────
        $patientsData = [
            ['name' => 'John Smith',   'email' => 'john@example.com',   'phone' => '0612345678', 'address' => '12 Rue de Paris, Tunis'],
            ['name' => 'Maria Garcia', 'email' => 'maria@example.com',  'phone' => '0623456789', 'address' => '5 Avenue Habib, Sfax'],
            ['name' => 'Ahmed Ben Ali','email' => 'ahmed@example.com',  'phone' => '0698765432', 'address' => '8 Rue des Fleurs, Sousse'],
            ['name' => 'Sophie Dupont','email' => 'sophie@example.com', 'phone' => '0654321098', 'address' => '3 Boulevard Tahar, Bizerte'],
        ];

        $patients = [];
        foreach ($patientsData as $pd) {
            $user = User::create([
                'name'     => $pd['name'],
                'email'    => $pd['email'],
                'password' => Hash::make('password'),
                'role'     => 'patient',
            ]);

            $patients[] = Patient::create([
                'user_id' => $user->id,
                'phone'   => $pd['phone'],
                'address' => $pd['address'],
            ]);
        }

        // ── Appointments ──────────────────────────────────────────────────
        $appointmentData = [
            ['patient' => $patients[0], 'date' => now()->toDateString(),              'time' => '09:00', 'reason' => 'Routine check-up',       'status' => 'confirmed'],
            ['patient' => $patients[1], 'date' => now()->toDateString(),              'time' => '10:30', 'reason' => 'Tooth pain',               'status' => 'pending'],
            ['patient' => $patients[2], 'date' => now()->addDays(1)->toDateString(),  'time' => '14:00', 'reason' => 'Teeth cleaning',           'status' => 'confirmed'],
            ['patient' => $patients[3], 'date' => now()->addDays(2)->toDateString(),  'time' => '11:00', 'reason' => 'Braces consultation',      'status' => 'pending'],
            ['patient' => $patients[0], 'date' => now()->subDays(5)->toDateString(),  'time' => '09:30', 'reason' => 'Filling replacement',      'status' => 'confirmed'],
            ['patient' => $patients[1], 'date' => now()->subDays(10)->toDateString(), 'time' => '15:00', 'reason' => 'X-Ray examination',        'status' => 'cancelled'],
        ];

        foreach ($appointmentData as $ad) {
            Appointment::create([
                'patient_id' => $ad['patient']->id,
                'date'       => $ad['date'],
                'time'       => $ad['time'],
                'reason'     => $ad['reason'],
                'status'     => $ad['status'],
            ]);
        }

        // ── Notes ─────────────────────────────────────────────────────────
        Note::create([
            'patient_id' => $patients[0]->id,
            'dentist_id' => $admin->id,
            'note'       => 'Patient has mild sensitivity on upper left molars. Recommended fluoride treatment.',
        ]);

        Note::create([
            'patient_id' => $patients[1]->id,
            'dentist_id' => $admin->id,
            'note'       => 'Early signs of gum disease. Scheduled for deep cleaning next visit.',
        ]);
    }
}
