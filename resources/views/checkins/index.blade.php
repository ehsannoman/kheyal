@extends('layouts.app')

@section('title', 'চেক-ইন মনিটরিং - খেয়াল')
@section('page-title', 'চেক-ইন মনিটরিং')

@section('content')
                <!-- HEADER ROW -->
                <section class="welcome-section">
                    <div>
                        <h2 class="welcome-title">দৈনিক চেক-ইন মনিটরিং</h2>
                        <p class="welcome-subtitle">রোগীরা মোবাইল অ্যাপ থেকে যে চেক-ইন দেন, তার সর্বশেষ অবস্থা এখানে দেখা যাবে</p>
                    </div>
                </section>

                <!-- CHECKINS LIST -->
                <section>
                    <div id="checkinsListContainer">
                        <div style="padding:24px;text-align:center;color:var(--muted);">লোড হচ্ছে...</div>
                    </div>
                </section>
@endsection

@push('styles')
<style>
    .checkin-card {
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
    .checkin-patient { font-weight: 700; color: var(--ink); font-size: 0.95rem; margin-bottom: 4px; }
    .checkin-detail { color: var(--muted); font-size: 0.85rem; }
    .checkin-badge {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 999px;
        margin-bottom: 4px;
    }
    .checkin-badge.fine { background: #e8f7ee; color: #1f9d55; }
    .checkin-badge.not_well { background: #fff3e5; color: #dc8825; }
    .checkin-badge.need_help { background: #fff0f0; color: #d5484f; }
    .checkin-badge.none { background: #eef1f5; color: var(--muted); }
    .checkin-history-btn {
        border: 1px solid var(--line);
        background: #fff;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.8rem;
        cursor: pointer;
        color: var(--ink);
        flex-shrink: 0;
    }
</style>
@endpush

@push('modals')
<!-- CHECK-IN HISTORY MODAL (read-only, monitoring only) -->
<div id="checkinHistoryModal" style="display:none;position:fixed;inset:0;z-index:1000;background:rgba(15,27,61,0.45);align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;border-radius:16px;width:100%;max-width:420px;max-height:80vh;overflow-y:auto;padding:24px;box-shadow:0 20px 50px rgba(0,0,0,0.2);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <h3 id="checkinHistoryTitle" style="font-family:'Noto Sans Bengali',sans-serif;font-size:1.1rem;font-weight:700;color:var(--ink);">চেক-ইন ইতিহাস</h3>
            <button type="button" id="closeCheckinHistory" style="background:none;border:none;font-size:1.3rem;cursor:pointer;color:var(--muted);">&times;</button>
        </div>
        <div id="checkinHistoryList"></div>
    </div>
</div>
@endpush

@push('scripts')
    const checkinLabels = { fine: 'ভালো আছেন', not_well: 'একটু অসুস্থ', need_help: 'সাহায্য দরকার' };

    function buildCheckinCard(entry) {
        const card = document.createElement('div');
        card.className = 'checkin-card';

        const cls = entry.latest_checkin ? entry.latest_checkin.status : 'none';
        const label = entry.latest_checkin ? (checkinLabels[entry.latest_checkin.status] || entry.latest_checkin.status) : 'কোনো চেক-ইন নেই';
        const time = entry.latest_checkin ? formatDateTime(entry.latest_checkin.checked_in_at) : '';

        card.innerHTML = `
            <div>
                <span class="checkin-badge ${cls}">${esc(label)}</span>
                <div class="checkin-patient">${esc(entry.patient_name)}</div>
                <div class="checkin-detail">${esc(time)}</div>
            </div>
            <button type="button" class="checkin-history-btn">ইতিহাস দেখুন</button>
        `;

        card.querySelector('.checkin-history-btn').addEventListener('click', () => openCheckinHistory(entry.patient_id, entry.patient_name));

        return card;
    }

    async function loadCheckins() {
        const container = document.getElementById('checkinsListContainer');
        const res = await apiFetch('/checkins/latest');
        if (!res || !res.ok) {
            container.innerHTML = '<div style="padding:24px;text-align:center;color:var(--danger);">চেক-ইন লোড করা যায়নি।</div>';
            return;
        }

        const entries = await res.json();

        if (entries.length === 0) {
            container.innerHTML = '<div style="padding:32px;text-align:center;color:var(--muted);">এখনো কোনো রোগী যোগ করা হয়নি।</div>';
            return;
        }

        container.innerHTML = '';
        entries.forEach(e => container.appendChild(buildCheckinCard(e)));
    }

    const checkinHistoryModal = document.getElementById('checkinHistoryModal');

    async function openCheckinHistory(patientId, patientName) {
        document.getElementById('checkinHistoryTitle').textContent = `${patientName} — চেক-ইন ইতিহাস`;
        const listEl = document.getElementById('checkinHistoryList');
        listEl.innerHTML = '<div style="padding:16px;text-align:center;color:var(--muted);">লোড হচ্ছে...</div>';
        checkinHistoryModal.style.display = 'flex';

        const res = await apiFetch(`/patients/${patientId}/checkins`);
        if (!res || !res.ok) {
            listEl.innerHTML = '<div style="padding:16px;text-align:center;color:var(--danger);">লোড করা যায়নি।</div>';
            return;
        }

        const checkins = await res.json();
        if (checkins.length === 0) {
            listEl.innerHTML = '<div style="padding:16px;text-align:center;color:var(--muted);">এখনো কোনো চেক-ইন হয়নি।</div>';
            return;
        }

        listEl.innerHTML = '';
        checkins.forEach(c => {
            const row = document.createElement('div');
            row.style.cssText = 'display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--line);font-size:0.85rem;';
            row.innerHTML = `
                <span class="checkin-badge ${c.status}" style="margin:0;">${esc(checkinLabels[c.status] || c.status)}</span>
                <span style="color:var(--muted);">${esc(formatDateTime(c.checked_in_at))}</span>
            `;
            listEl.appendChild(row);
        });
    }

    document.getElementById('closeCheckinHistory').addEventListener('click', () => {
        checkinHistoryModal.style.display = 'none';
    });
    checkinHistoryModal.addEventListener('click', (e) => {
        if (e.target === checkinHistoryModal) checkinHistoryModal.style.display = 'none';
    });

    /* Init */
    if (token) {
        loadProfile();
        loadCheckins();
    }
@endpush