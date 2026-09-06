@extends('layouts.app')

@section('title', 'ওষুধ গ্রহণ ট্র্যাকিং - খেয়াল')
@section('page-title', 'ওষুধ গ্রহণ ট্র্যাকিং')

@section('content')
                <!-- HEADER ROW -->
                <section class="welcome-section">
                    <div>
                        <h2 class="welcome-title">আজকের ওষুধ গ্রহণ</h2>
                        <p class="welcome-subtitle" id="trackingDate">...</p>
                        <p style="color:var(--muted);font-size:0.8rem;margin-top:4px;">রোগী নিজে মোবাইল অ্যাপ থেকে ওষুধ নেওয়ার কথা জানাবেন — এখানে শুধু অবস্থা দেখা যাবে</p>
                    </div>
                </section>

                <!-- TRACKING LIST -->
                <section>
                    <div id="trackingListContainer">
                        <div style="padding:24px;text-align:center;color:var(--muted);">লোড হচ্ছে...</div>
                    </div>
                </section>
@endsection

@push('styles')
<style>
    .tracking-patient-group { margin-bottom: 20px; }
    .tracking-patient-name {
        font-weight: 700;
        color: var(--ink);
        font-size: 0.95rem;
        margin-bottom: 10px;
    }
    .tracking-dose-card {
        background: var(--surface-strong);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .tracking-dose-info { flex: 1; }
    .tracking-med-name { font-weight: 700; color: var(--ink); font-size: 0.9rem; }
    .tracking-med-time { color: var(--muted); font-size: 0.82rem; margin-top: 2px; }
    .tracking-status-badge {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 999px;
    }
    .tracking-status-badge.pending { background: #eef1f5; color: var(--muted); }
    .tracking-status-badge.taken { background: #e8f7ee; color: #1f9d55; }
    .tracking-status-badge.missed { background: #fff0f0; color: #d5484f; }
    .tracking-status-badge.skipped { background: #fff3e5; color: #dc8825; }
</style>
@endpush

@push('scripts')
    document.getElementById('trackingDate').textContent =
        new Date().toLocaleDateString('bn-BD', { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' });

    const statusLabels = { pending: 'বাকি', taken: 'নেওয়া হয়েছে', missed: 'মিস হয়েছে', skipped: 'বাদ দেওয়া হয়েছে' };

    function buildDoseCard(dose) {
        const card = document.createElement('div');
        card.className = 'tracking-dose-card';

        const medName = dose.medication?.name || 'ওষুধ';
        const time = dose.scheduled_time?.slice(0, 5) || '';

        card.innerHTML = `
            <div class="tracking-dose-info">
                <div class="tracking-med-name">${esc(medName)}</div>
                <div class="tracking-med-time">${esc(time)} &nbsp;•&nbsp; <span class="tracking-status-badge ${dose.status}">${statusLabels[dose.status] || dose.status}</span></div>
            </div>
        `;

        return card;
    }

    async function loadTracking() {
        const container = document.getElementById('trackingListContainer');
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
            await apiFetch(`/patients/${patient.id}/dose-logs/generate`, { method: 'POST' });
            const dosesRes = await apiFetch(`/patients/${patient.id}/dose-logs/today`);
            const doses = dosesRes && dosesRes.ok ? await dosesRes.json() : [];

            const group = document.createElement('div');
            group.className = 'tracking-patient-group';

            let doseHtml = '<div class="tracking-patient-name">' + esc(patient.name) + '</div>';
            group.innerHTML = doseHtml;

            if (doses.length === 0) {
                const empty = document.createElement('div');
                empty.style.cssText = 'padding:12px;color:var(--muted);font-size:0.85rem;';
                empty.textContent = 'আজকের জন্য কোনো ওষুধ নির্ধারিত নেই';
                group.appendChild(empty);
            } else {
                doses.forEach(d => group.appendChild(buildDoseCard(d)));
            }

            container.appendChild(group);
        }
    }

    /* Init */
    if (token) {
        loadProfile();
        loadTracking();
    }
@endpush