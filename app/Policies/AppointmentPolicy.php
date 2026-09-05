<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function view(User $user, Appointment $appointment): bool
    {
        if (in_array($user->role, ['admin', 'secretary'])) {
            return true;
        }

        return $user->isPatient() && $user->patient?->id === $appointment->patient_id;
    }

    public function cancel(User $user, Appointment $appointment): bool
    {
        return $user->isPatient()
            && $user->patient?->id === $appointment->patient_id
            && $appointment->status === 'pending';
    }
}
