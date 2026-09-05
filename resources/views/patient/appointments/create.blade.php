@extends('layouts.dashboard')
@section('title', 'Prendre un rendez-vous')

@section('styles')
<style>
    .slot-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(90px, 1fr)); gap: .6rem; }
    .slot-btn {
        padding: .5rem .4rem; border-radius: 10px; text-align: center;
        font-size: .82rem; font-weight: 600; cursor: pointer; transition: all .15s;
        border: 2px solid #e2e8f4; background: #fff; color: #1a2236;
    }
    .slot-btn.available:hover { border-color: #4d8af0; background: #eef3fe; color: #4d8af0; }
    .slot-btn.selected { border-color: #4d8af0 !important; background: #4d8af0 !important; color: #fff !important; }
    .slot-btn.booked {
        background: #f8f9fa; color: #adb5bd; cursor: not-allowed;
        border-color: #f0f0f0; text-decoration: line-through; opacity: .65;
    }
    .slot-btn .slot-badge { font-size: .65rem; display: block; margin-top: 2px; }
    #slot-skeleton { display: grid; grid-template-columns: repeat(auto-fill, minmax(90px, 1fr)); gap: .6rem; }
    .skeleton-box { height: 52px; border-radius: 10px; background: linear-gradient(90deg, #f0f2f8 25%, #e8ecf4 50%, #f0f2f8 75%); background-size: 200% 100%; animation: shimmer 1.2s infinite; }
    @keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="content-card">
            <div class="card-header d-flex align-items-center gap-2">
                <a href="{{ route('patient.appointments.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <span><i class="bi bi-calendar-plus me-2 text-primary"></i>Prendre un rendez-vous</span>
            </div>
            <div class="card-body p-4">

                <div class="alert alert-info border-0 small mb-4">
                    <i class="bi bi-info-circle me-2"></i>
                    Choisissez une date puis sélectionnez un créneau disponible. Votre demande sera <strong>confirmée par notre équipe</strong>.
                </div>

                <form method="POST" action="{{ route('patient.appointments.store') }}" id="bookingForm">
                    @csrf

                    {{-- Hidden field filled by slot selection --}}
                    <input type="hidden" name="time" id="selectedTime" value="{{ old('time') }}">

                    {{-- Step 1: Date --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <span class="badge me-1" style="background:#4d8af0;">1</span>
                            Choisissez une date *
                        </label>
                        <input type="date" id="datePicker" name="date"
                               value="{{ old('date', $selectedDate) }}"
                               min="{{ date('Y-m-d') }}"
                               class="form-control @error('date') is-invalid @enderror"
                               style="max-width:220px;" required>
                        @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Step 2: Slot picker --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <span class="badge me-1" style="background:#4d8af0;">2</span>
                            Sélectionnez un créneau *
                        </label>

                        <div class="p-3 bg-light rounded-3">
                            {{-- Skeleton loader --}}
                            <div id="slot-skeleton">
                                @foreach(range(1,12) as $i)
                                    <div class="skeleton-box"></div>
                                @endforeach
                            </div>

                            {{-- Slots grid (filled by JS) --}}
                            <div id="slot-grid" class="slot-grid d-none"></div>

                            {{-- No slot message --}}
                            <div id="no-slots" class="text-center text-muted small py-2 d-none">
                                <i class="bi bi-calendar-x me-1"></i>Aucun créneau disponible pour cette date.
                            </div>
                        </div>

                        @error('time')
                            <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                        <div id="slot-error" class="text-danger small mt-1 d-none">
                            <i class="bi bi-exclamation-circle me-1"></i>Veuillez sélectionner un créneau.
                        </div>

                        {{-- Legend --}}
                        <div class="d-flex gap-3 mt-2 small text-muted">
                            <span><span style="display:inline-block;width:12px;height:12px;background:#4d8af0;border-radius:3px;"></span> Sélectionné</span>
                            <span><span style="display:inline-block;width:12px;height:12px;background:#fff;border:2px solid #e2e8f4;border-radius:3px;"></span> Disponible</span>
                            <span><span style="display:inline-block;width:12px;height:12px;background:#f0f0f0;border-radius:3px;"></span> Réservé</span>
                        </div>
                    </div>

                    {{-- Step 3: Reason --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <span class="badge me-1" style="background:#4d8af0;">3</span>
                            Motif de la visite *
                        </label>
                        <textarea name="reason" rows="3"
                                  class="form-control @error('reason') is-invalid @enderror"
                                  placeholder="Décrivez vos symptômes ou le motif de cette visite…" required>{{ old('reason') }}</textarea>
                        @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-calendar-check me-1"></i>Confirmer la demande
                        </button>
                        <a href="{{ route('patient.appointments.index') }}" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const datePicker   = document.getElementById('datePicker');
const slotGrid     = document.getElementById('slot-grid');
const skeleton     = document.getElementById('slot-skeleton');
const noSlots      = document.getElementById('no-slots');
const selectedTime = document.getElementById('selectedTime');
const slotError    = document.getElementById('slot-error');

async function loadSlots(date) {
    skeleton.classList.remove('d-none');
    slotGrid.classList.add('d-none');
    noSlots.classList.add('d-none');
    slotGrid.innerHTML = '';
    selectedTime.value = '';

    try {
        const res   = await fetch(`{{ route('patient.appointments.slots') }}?date=${date}`);
        const slots = await res.json();

        skeleton.classList.add('d-none');

        if (!slots.length) {
            noSlots.classList.remove('d-none');
            return;
        }

        const available = slots.filter(s => s.available);
        if (!available.length) {
            noSlots.classList.remove('d-none');
            return;
        }

        slots.forEach(slot => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'slot-btn ' + (slot.available ? 'available' : 'booked');
            btn.innerHTML = slot.label
                + `<span class="slot-badge">${slot.available ? '✅ Libre' : '❌ Réservé'}</span>`;
            btn.disabled = !slot.available;

            if (slot.available) {
                // Restore selected state after old() input
                if (slot.time === '{{ old('time') }}') {
                    btn.classList.add('selected');
                    selectedTime.value = slot.time;
                }

                btn.addEventListener('click', () => {
                    slotGrid.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    selectedTime.value = slot.time;
                    slotError.classList.add('d-none');
                });
            }

            slotGrid.appendChild(btn);
        });

        slotGrid.classList.remove('d-none');
    } catch (e) {
        skeleton.classList.add('d-none');
        noSlots.classList.remove('d-none');
    }
}

datePicker.addEventListener('change', () => {
    if (datePicker.value) loadSlots(datePicker.value);
});

// Validate slot on submit
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    if (!selectedTime.value) {
        e.preventDefault();
        slotError.classList.remove('d-none');
        slotGrid.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});

// Load slots on page load
if (datePicker.value) loadSlots(datePicker.value);
</script>
@endsection
