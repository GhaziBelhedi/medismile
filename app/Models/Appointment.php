<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'date', 'time', 'reason', 'status'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'confirmed' => 'success',
            'cancelled' => 'danger',
            default     => 'warning',
        };
    }

    // ── Time remaining ────────────────────────────────────────────────────────

    public function getTimeRemainingAttribute(): ?string
    {
        if (! $this->date || ! $this->time || $this->status === 'cancelled') {
            return null;
        }

        $dt  = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->time);
        $now = now();

        if ($dt->isPast()) return null;

        $diff = (int) $now->diffInMinutes($dt);

        if ($diff < 60) {
            return "dans {$diff} min";
        }

        if ($diff < 1440) {
            $h = floor($diff / 60);
            $m = $diff % 60;
            return $m > 0 ? "dans {$h}h{$m}" : "dans {$h}h";
        }

        $d = floor($diff / 1440);
        return $d === 1 ? 'demain' : "dans {$d} jours";
    }

    public function getTimeRemainingClassAttribute(): string
    {
        if (! $this->date || ! $this->time) return 'secondary';

        $dt   = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->time);
        $diff = (int) now()->diffInMinutes($dt, false);

        if ($diff <= 0)    return 'secondary';
        if ($diff < 120)   return 'danger';
        if ($diff < 1440)  return 'warning';
        if ($diff < 10080) return 'info';

        return 'secondary';
    }
}
