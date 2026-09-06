@extends('layouts.app')

@section('title', 'ওষুধের সময়সূচী - খেয়াল')
@section('page-title', 'ওষুধের সময়সূচী')

@section('content')
                <!-- HEADER ROW -->
                <section class="welcome-section">
                    <div>
                        <h2 class="welcome-title">সব রোগীর ওষুধের সময়সূচী</h2>
                        <p class="welcome-subtitle">কোন ওষুধ কখন খেতে হবে, তার পূর্ণ তালিকা — নতুন ওষুধ যোগ বা সম্পাদনা করতে রোগীর প্রোফাইলে যান</p>
                    </div>
                </section>

                <!-- SCHEDULE LIST -->
                <section>
                    <div id="scheduleListContainer">
                        <div style="padding:24px;text-align:center;color:var(--muted);">লোড হচ্ছে...</div>
                    </div>
                </section>
@endsection

@push('styles')
<style>
    .schedule-patient-group {
        margin-bottom: 20px;
    }
    .schedule-patient-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .schedule-patient-name {
        font-weight: 700;
        color: var(--ink);
        font-size: 0.95rem;
    }
    .schedule-patient-link {
        font-size: 0.8rem;
        color: var(--coral);
        text-decoration: none;
        font-weight: 600;
    }
    .schedule-med-card {
        background: var(--surface-strong);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 8px;
    }
    .schedule-med-name { font-weight: 700; color: var(--ink); font-size: 0.9rem; margin-bottom: 4px; }
    .schedule-med-detail { color: var(--muted); font-size: 0.82rem; }
    .schedule-time-chip {
        display: inline-block;
        background: #eef1f5;
        color: var(--ink);
        border-radius: 999px;
        padding: 2px 10px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-right: 4px;
        margin-top: 4px;
    }
</style>
@endpush

@push('scripts')
    function buildScheduleGroup(patient, medications) {
        const group = document.createElement('div');
        group.className = 'schedule-patient-group';

        const activeMeds = medications.filter(m => m.is_active !== false);

        let medsHtml = '';
        if (activeMeds.length === 0) {
            medsHtml = '<div style="padding:14px;color:var(--muted);font-size:0.85rem;">কোনো সক্রিয় ওষুধ নেই</div>';
        } else {
            activeMeds.forEach(med => {
                const times = (med.schedules || [])
                    .map(s => s.scheduled_time?.slice(0, 5))
                    .filter(Boolean);

                const timeChips = times.length
                    ? times.map(t => `<span class="schedule-time-chip">${esc(t)}</span>`).join('')
                    : '<span class="schedule-time-chip">সময় নির্ধারিত নেই</span>';

                medsHtml += `
                    <div class="schedule-med-card">
                        <div class="schedule-med-name">${esc(med.name)}</div>
                        <div class="schedule-med-detail">${esc(med.dosage || '')} ${esc(med.form || '')}${med.frequency ? ' • ' + esc(med.frequency) : ''}</div>
                        <div style="margin-top:6px;">${timeChips}</div>
                    </div>
                `;
            });
        }

        group.innerHTML = `
            <div class="schedule-patient-header">
                <span class="schedule-patient-name">${esc(patient.name)}</span>
                <a href="/patients/${patient.id}" class="schedule-patient-link">সম্পাদনা করুন →</a>
            </div>
            ${medsHtml}
        `;

        return group;
    }

    async function loadSchedule() {
        const container = document.getElementById('scheduleListContainer');
        const patientsRes = await apiFetch('/patients');
        if (!patientsRes || !patientsRes.ok) {
            container.innerHTML = '<div style="padding:24px;text-align:center;color:var(--danger);">লোড করা যায়নি।</div>';
            return;
        }

        const patients = await patientsRes.json();

        if (patients.length === 0) {
            container.innerHTML = '<div style="padding:32px;text-align:center;color:var(--muted);">এখনো কোনো রোগী যোগ করা হয়নি।</div>';
            return;
        }

        container.innerHTML = '';

        for (const patient of patients) {
            const medsRes = await apiFetch(`/patients/${patient.id}/medications`);
            const medications = medsRes && medsRes.ok ? await medsRes.json() : [];
            container.appendChild(buildScheduleGroup(patient, medications));
        }
    }

    /* Init */
    if (token) {
        loadProfile();
        loadSchedule();
    }
@endpush
