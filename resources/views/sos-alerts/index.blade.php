@extends('layouts.app')

@section('title', 'SOS সতর্কতা - খেয়াল')
@section('page-title', 'SOS সতর্কতা')

@section('content')
                <!-- HEADER ROW -->
                <section class="welcome-section">
                    <div>
                        <h2 class="welcome-title">SOS সতর্কতাসমূহ</h2>
                        <p class="welcome-subtitle">রোগীরা মোবাইল অ্যাপের SOS বাটন থেকে যে সতর্কতা পাঠান, তার তালিকা এখানে দেখা যাবে</p>
                    </div>
                </section>

                <!-- SOS ALERTS LIST -->
                <section>
                    <div id="sosAlertsListContainer">
                        <div style="padding:24px;text-align:center;color:var(--muted);">লোড হচ্ছে...</div>
                    </div>
                </section>
@endsection

@push('styles')
<style>
    .sos-alert-card {
        background: var(--surface-strong);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 16px 18px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }
    .sos-alert-card.active { border-color: #f6c9c9; background: #fff8f8; }
    .sos-alert-patient { font-weight: 700; color: var(--ink); font-size: 0.95rem; margin-bottom: 4px; }
    .sos-alert-detail { color: var(--muted); font-size: 0.85rem; }
    .sos-alert-badge {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 999px;
        margin-bottom: 6px;
    }
    .sos-alert-badge.active { background: #fff0f0; color: #d5484f; }
    .sos-alert-badge.resolved { background: #eef1f5; color: var(--muted); }
    .sos-resolve-btn {
        border: none;
        background: var(--danger);
        color: #fff;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        flex-shrink: 0;
    }
</style>
@endpush

@push('scripts')
    function buildSosAlertCard(alert) {
        const card = document.createElement('div');
        card.className = 'sos-alert-card' + (alert.resolved ? '' : ' active');

        const patientName = alert.patient?.name || 'অজানা রোগী';

        card.innerHTML = `
            <div>
                <span class="sos-alert-badge ${alert.resolved ? 'resolved' : 'active'}">${alert.resolved ? 'সমাধান হয়েছে' : 'সক্রিয়'}</span>
                <div class="sos-alert-patient">${esc(patientName)}</div>
                <div class="sos-alert-detail">
                    ট্রিগার: ${esc(formatDateTime(alert.triggered_at))}
                    ${alert.resolved ? '<br>সমাধান: ' + esc(formatDateTime(alert.resolved_at)) : ''}
                </div>
            </div>
        `;

        if (!alert.resolved) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'sos-resolve-btn';
            btn.textContent = 'সমাধান হয়েছে বলে চিহ্নিত করুন';
            btn.addEventListener('click', () => resolveSosAlert(alert.id));
            card.appendChild(btn);
        }

        return card;
    }

    async function loadSosAlerts() {
        const container = document.getElementById('sosAlertsListContainer');
        const res = await apiFetch('/sos-alerts');
        if (!res || !res.ok) {
            container.innerHTML = '<div style="padding:24px;text-align:center;color:var(--danger);">SOS সতর্কতা লোড করা যায়নি।</div>';
            return;
        }

        const alerts = await res.json();

        if (alerts.length === 0) {
            container.innerHTML = '<div style="padding:32px;text-align:center;color:var(--muted);">এখনো কোনো SOS সতর্কতা আসেনি।</div>';
            return;
        }

        container.innerHTML = '';
        alerts.forEach(a => container.appendChild(buildSosAlertCard(a)));
    }

    async function resolveSosAlert(id) {
        const res = await apiFetch(`/sos-alerts/${id}/resolve`, { method: 'PUT' });
        if (res && res.ok) {
            await loadSosAlerts();
        }
    }

    /* Init */
    if (token) {
        loadProfile();
        loadSosAlerts();
    }
@endpush