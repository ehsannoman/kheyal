
@extends('layouts.app')

@section('title', 'ওষুধ ব্যবস্থাপনা - খেয়াল')
@section('page-title', 'ওষুধ ব্যবস্থাপনা')

@section('content')
<section class="welcome-section">
    <div>
        <h2 class="welcome-title">ওষুধ ব্যবস্থাপনা</h2>
        <p class="welcome-subtitle">
            রোগীদের ওষুধ, সময়সূচি, গ্রহণের ইতিহাস ও রিমাইন্ডার এক জায়গায় পরিচালনা করুন।
        </p>
    </div>
</section>

<section class="med-management">
    <div class="med-tabs" role="tablist" aria-label="ওষুধ ব্যবস্থাপনা">
        <button type="button" class="med-tab active" data-tab="schedule">সময়সূচি</button>
        <button type="button" class="med-tab" data-tab="history">গ্রহণের ইতিহাস</button>
        <button type="button" class="med-tab" data-tab="medicines">ওষুধের তালিকা</button>
        <button type="button" class="med-tab" data-tab="reminders">রিমাইন্ডার</button>
    </div>

    <div id="medMessage" class="med-message" hidden></div>

    <div class="med-panel active" id="panel-schedule">
        <div class="med-panel-heading">
            <div>
                <h3>ওষুধের সময়সূচি</h3>
                <p>কোন রোগীর কোন ওষুধ কখন নির্ধারিত আছে।</p>
            </div>
            <button type="button" class="med-refresh" data-refresh="all">রিফ্রেশ</button>
        </div>
        <div id="scheduleListContainer" class="med-list">
            <div class="med-loading">সময়সূচি লোড হচ্ছে...</div>
        </div>
    </div>

    <div class="med-panel" id="panel-history">
        <div class="med-panel-heading">
            <div>
                <h3>আজকের ওষুধ গ্রহণের ইতিহাস</h3>
            </div>
            <button type="button" class="med-refresh" data-refresh="history">রিফ্রেশ</button>
        </div>
        <div id="trackingListContainer" class="med-list">
            <div class="med-loading">গ্রহণের ইতিহাস লোড হচ্ছে...</div>
        </div>
    </div>

    <div class="med-panel" id="panel-medicines">
        <div class="med-panel-heading">
            <div>
                <h3>সক্রিয় ওষুধের তালিকা</h3>
                <p>ওষুধের তথ্য ও নির্ধারিত সময় দেখুন। সম্পাদনার জন্য রোগীর প্রোফাইলে যান।</p>
            </div>
            <button type="button" class="med-refresh" data-refresh="medicines">রিফ্রেশ</button>
        </div>
        <div id="medicineListContainer" class="med-list">
            <div class="med-loading">ওষুধ লোড হচ্ছে...</div>
        </div>
    </div>

    <div class="med-panel" id="panel-reminders">
        <div class="med-panel-heading">
            <div>
                <h3>রিমাইন্ডার ও নোটিফিকেশন</h3>
                <p>ব্রাউজারের push notification-এর অবস্থা এবং আসন্ন ওষুধের সময় দেখুন।</p>
            </div>
        </div>

        <div class="med-notification-card">
            <div>
                <strong id="notificationStatus">নোটিফিকেশনের অবস্থা যাচাই হচ্ছে...</strong>
                <p id="notificationDescription">রিমাইন্ডার পেতে ব্রাউজারে notification অনুমতি প্রয়োজন।</p>
            </div>
            <button type="button" id="toggleNotificationBtn" class="med-primary-btn" disabled>
                অপেক্ষা করুন
            </button>
        </div>

        <div id="notificationError" class="med-error" hidden></div>

        <h4 class="med-subheading">আজকের বাকি ওষুধ</h4>
        <div id="remindersListContainer" class="med-list">
            <div class="med-loading">রিমাইন্ডার লোড হচ্ছে...</div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .med-management { color: var(--ink); }
    .med-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 18px 0;
        border-bottom: 1px solid var(--line);
        padding-bottom: 12px;
    }
    .med-tab {
        border: 1px solid var(--line);
        background: var(--surface-strong);
        color: var(--ink);
        border-radius: 9px;
        padding: 9px 14px;
        font: inherit;
        font-size: .85rem;
        font-weight: 600;
        cursor: pointer;
    }
    .med-tab.active {
        background: var(--ink);
        color: #fff;
        border-color: var(--ink);
    }
    .med-panel { display: none; }
    .med-panel.active { display: block; }
    .med-panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 18px 0;
    }
    .med-panel-heading h3 {
        margin: 0 0 5px;
        color: var(--ink);
        font-size: 1rem;
    }
    .med-panel-heading p {
        margin: 0;
        color: var(--muted);
        font-size: .83rem;
        line-height: 1.6;
    }
    .med-refresh, .med-primary-btn {
        border: 0;
        border-radius: 8px;
        padding: 9px 13px;
        background: var(--ink);
        color: #fff;
        font: inherit;
        font-size: .82rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }
    .med-primary-btn { background: var(--coral); color: #fff; }
    .med-refresh:disabled, .med-primary-btn:disabled {
        opacity: .55;
        cursor: not-allowed;
    }
    .med-patient-group { margin-bottom: 22px; }
    .med-patient-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 10px;
    }
    .med-patient-name { font-weight: 700; font-size: .94rem; }
    .med-link {
        color: var(--coral);
        text-decoration: none;
        font-size: .82rem;
        font-weight: 600;
    }
    .med-card {
        border: 1px solid var(--line);
        background: var(--surface-strong);
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 9px;
    }
    .med-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }
    .med-name { font-size: .9rem; font-weight: 700; margin-bottom: 5px; }
    .med-detail { color: var(--muted); font-size: .81rem; line-height: 1.7; }
    .med-chip {
        display: inline-block;
        margin: 5px 4px 0 0;
        padding: 3px 9px;
        border-radius: 20px;
        background: #eef1f5;
        color: #172554;
        font-size: .75rem;
        font-weight: 600;
    }
    .med-status {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 20px;
        font-size: .75rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .med-status.pending { background: #fff2cc; color: #805b00; }
    .med-status.taken { background: #dcfce7; color: #166534; }
    .med-status.missed { background: #fee2e2; color: #991b1b; }
    .med-status.skipped { background: #e2e8f0; color: #334155; }
    .med-actions { display: flex; flex-wrap: wrap; gap: 7px; margin-top: 12px; }
    .med-action {
        border: 1px solid var(--line);
        background: #fff;
        color: var(--ink);
        border-radius: 7px;
        padding: 7px 10px;
        font: inherit;
        font-size: .78rem;
        cursor: pointer;
    }
    .med-action.taken { border-color: #86efac; color: #166534; }
    .med-action.missed { border-color: #fca5a5; color: #991b1b; }
    .med-action.skipped { border-color: #cbd5e1; color: #334155; }
    .med-loading, .med-empty {
        padding: 24px;
        text-align: center;
        color: var(--muted);
        font-size: .86rem;
        border: 1px dashed var(--line);
        border-radius: 12px;
    }
    .med-message {
        margin: 12px 0;
        padding: 11px 14px;
        border-radius: 8px;
        background: #dcfce7;
        color: #166534;
        font-size: .84rem;
    }
    .med-message.error { background: #fee2e2; color: #991b1b; }
    .med-notification-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        border: 1px solid var(--line);
        background: var(--surface-strong);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
    }
    .med-notification-card strong { font-size: .88rem; }
    .med-notification-card p { color: var(--muted); font-size: .81rem; margin: 5px 0 0; }
    .med-error { color: #b91c1c; font-size: .83rem; margin: 10px 0; }
    .med-subheading { font-size: .92rem; margin: 20px 0 10px; }
    @media (max-width: 640px) {
        .med-panel-heading { align-items: flex-start; }
        .med-notification-card { align-items: flex-start; flex-direction: column; }
        .med-tabs { gap: 6px; }
        .med-tab { padding: 8px 10px; font-size: .78rem; }
    }
</style>
@endpush

@push('scripts')
(() => {
    const $ = id => document.getElementById(id);

    const statusLabels = {
        pending: 'বাকি',
        taken: 'নেওয়া হয়েছে',
        missed: 'মিস হয়েছে',
        skipped: 'বাদ দেওয়া হয়েছে'
    };

    let patients = [];
    let medicationsByPatient = {};
    let doseLogsByPatient = {};
    let activeTab = 'schedule';
    let loading = false;

    function safe(value) {
        if (typeof esc === 'function') return esc(String(value ?? ''));
        return String(value ?? '').replace(/[&<>"']/g, ch => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;',
            '"': '&quot;', "'": '&#039;'
        })[ch]);
    }

    function showMessage(message, isError = false) {
        const box = $('medMessage');
        box.textContent = message;
        box.classList.toggle('error', isError);
        box.hidden = false;
        window.clearTimeout(showMessage.timer);
        showMessage.timer = window.setTimeout(() => box.hidden = true, 4500);
    }

    function statusBadge(status) {
        const key = statusLabels[status] ? status : 'pending';
        return `<span class="med-status ${key}">${statusLabels[key]}</span>`;
    }

    function formatTime(value) {
        if (!value) return 'সময় নির্ধারিত নেই';
        const parts = String(value).slice(0, 5).split(':');
        if (parts.length !== 2) return safe(value);
        const h = Number(parts[0]);
        const suffix = h >= 12 ? 'PM' : 'AM';
        const hour = h % 12 || 12;
        return `${hour}:${parts[1]} ${suffix}`;
    }

    function empty(message) {
        return `<div class="med-empty">${safe(message)}</div>`;
    }

    function groupHeader(patient, linkText = 'প্রোফাইল দেখুন') {
        return `
            <div class="med-patient-header">
                <span class="med-patient-name">${safe(patient.name || 'রোগী')}</span>
                <a class="med-link" href="/patients/${encodeURIComponent(patient.id)}">${linkText} →</a>
            </div>`;
    }

    function medicationCard(med) {
        const schedules = (med.schedules || []).filter(s => s.is_active !== false);
        const times = schedules.map(s => formatTime(s.scheduled_time));
        return `
            <div class="med-card">
                <div class="med-card-top">
                    <div>
                        <div class="med-name">${safe(med.name || 'ওষুধ')}</div>
                        <div class="med-detail">
                            ${safe(med.dosage || '')}
                            ${med.form ? ' · ' + safe(med.form) : ''}
                            ${med.frequency ? ' · ' + safe(med.frequency) : ''}
                        </div>
                        ${med.remaining_quantity !== null && med.remaining_quantity !== undefined
                            ? `<div class="med-detail">অবশিষ্ট পরিমাণ: ${safe(med.remaining_quantity)}</div>` : ''}
                    </div>
                    <a class="med-link" href="/patients/${encodeURIComponent(med.patient_id)}">সম্পাদনা</a>
                </div>
                <div>${times.length
                    ? times.map(t => `<span class="med-chip">${safe(t)}</span>`).join('')
                    : '<span class="med-chip">সময় নির্ধারিত নেই</span>'}</div>
            </div>`;
    }

    function renderSchedules() {
        const container = $('scheduleListContainer');
        if (!patients.length) {
            container.innerHTML = empty('এখনো কোনো রোগী যোগ করা হয়নি।');
            return;
        }

        container.innerHTML = patients.map(patient => {
            const meds = (medicationsByPatient[patient.id] || []).filter(m => m.is_active !== false);
            return `<div class="med-patient-group">
                ${groupHeader(patient)}
                ${meds.length ? meds.map(medicationCard).join('') : empty('কোনো সক্রিয় ওষুধ নেই।')}
            </div>`;
        }).join('');
    }

    function renderMedicines() {
        const container = $('medicineListContainer');
        if (!patients.length) {
            container.innerHTML = empty('এখনো কোনো রোগী যোগ করা হয়নি।');
            return;
        }

        container.innerHTML = patients.map(patient => {
            const meds = (medicationsByPatient[patient.id] || []).filter(m => m.is_active !== false);
            return `<div class="med-patient-group">
                ${groupHeader(patient)}
                ${meds.length ? meds.map(medicationCard).join('') : empty('কোনো সক্রিয় ওষুধ নেই।')}
            </div>`;
        }).join('');
    }

    
    function renderHistory() {
        const container = $('trackingListContainer');

        if (!patients.length) {
            container.innerHTML = empty('এখনো কোনো রোগী যোগ করা হয়নি।');
            return;
        }

        let html = '';

        for (const patient of patients) {
            const logs = doseLogsByPatient[patient.id] || [];

            html += `<div class="med-patient-group">
                ${groupHeader(patient)}
                ${logs.length ? logs.map(dose => {
                    const med = dose.medication || {};
                    const status = statusLabels[dose.status]
                        ? dose.status
                        : 'pending';

                    return `<div class="med-card">
                        <div class="med-card-top">
                            <div>
                                <div class="med-name">
                                    ${safe(med.name || 'ওষুধ')}
                                </div>
                                <div class="med-detail">
                                    ${safe(med.dosage || '')}
                                </div>
                                <div class="med-detail">
                                    নির্ধারিত সময়:
                                    ${safe(formatTime(dose.scheduled_time))}
                                </div>
                            </div>

                            ${statusBadge(status)}
                        </div>
                    </div>`;
                }).join('') : empty('আজকের জন্য কোনো dose log নেই।')}
            </div>`;
        }

        container.innerHTML = html;
    }


    function renderReminders() {
        const container = $('remindersListContainer');
        let items = [];

        for (const patient of patients) {
            const logs = doseLogsByPatient[patient.id] || [];
            for (const dose of logs) {
                if (dose.status !== 'pending') continue;
                items.push({
                    patient,
                    dose,
                    medication: dose.medication || {}
                });
            }
        }

        items.sort((a, b) => String(a.dose.scheduled_time || '').localeCompare(String(b.dose.scheduled_time || '')));

        container.innerHTML = items.length ? items.map(({patient, dose, medication}) => `
            <div class="med-card">
                <div class="med-name">${safe(medication.name || 'ওষুধ')}</div>
                <div class="med-detail">${safe(patient.name || 'রোগী')} · ${safe(formatTime(dose.scheduled_time))}</div>
                ${statusBadge('pending')}
            </div>`).join('') : empty('আজ আর কোনো বাকি dose নেই।');
    }

    async function fetchJson(path, options = {}) {
        const response = await apiFetch(path, options);
        if (!response) throw new Error('সার্ভারের সঙ্গে সংযোগ করা যায়নি।');
        if (!response.ok) {
            let message = `রিকোয়েস্ট ব্যর্থ হয়েছে (${response.status})`;
            try {
                const body = await response.json();
                message = body.message || message;
            } catch (_) {}
            throw new Error(message);
        }
        return response.json();
    }

    async function loadData() {
        if (loading) return;
        loading = true;

        ['scheduleListContainer', 'trackingListContainer', 'medicineListContainer', 'remindersListContainer']
            .forEach(id => $(id).innerHTML = '<div class="med-loading">লোড হচ্ছে...</div>');

        try {
            patients = await fetchJson('/patients');
            if (!Array.isArray(patients)) patients = [];

            medicationsByPatient = {};
            doseLogsByPatient = {};

            await Promise.all(patients.map(async patient => {
                const [medResult] = await Promise.allSettled([
                    fetchJson(`/patients/${patient.id}/medications`)
                ]);
                medicationsByPatient[patient.id] =
                    medResult.status === 'fulfilled' && Array.isArray(medResult.value)
                        ? medResult.value : [];

                try {
                    await fetchJson(`/patients/${patient.id}/dose-logs/generate`, {
                        method: 'POST'
                    });
                    const logs = await fetchJson(`/patients/${patient.id}/dose-logs/today`);
                    doseLogsByPatient[patient.id] = Array.isArray(logs) ? logs : [];
                } catch (error) {
                    doseLogsByPatient[patient.id] = [];
                    console.error('Dose log load failed:', patient.id, error);
                }
            }));

            renderSchedules();
            renderMedicines();
            renderHistory();
            renderReminders();
        } catch (error) {
            showMessage(error.message || 'তথ্য লোড করা যায়নি।', true);
            ['scheduleListContainer', 'trackingListContainer', 'medicineListContainer', 'remindersListContainer']
                .forEach(id => $(id).innerHTML = empty('তথ্য লোড করা যায়নি। আবার রিফ্রেশ করুন।'));
        } finally {
            loading = false;
        }
    }

    async function markDose(id, status, button) {
        if (button.disabled) return;
        button.disabled = true;

        try {
            await fetchJson(`/dose-logs/${encodeURIComponent(id)}/mark`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ status })
            });

            showMessage(`ওষুধের অবস্থা আপডেট হয়েছে: ${statusLabels[status]}`);
            await loadData();
        } catch (error) {
            showMessage(error.message || 'ওষুধের অবস্থা আপডেট করা যায়নি।', true);
            button.disabled = false;
        }
    }

    function activateTab(name) {
        activeTab = name;
        document.querySelectorAll('.med-tab').forEach(button => {
            const active = button.dataset.tab === name;
            button.classList.toggle('active', active);
            button.setAttribute('aria-selected', active ? 'true' : 'false');
        });
        document.querySelectorAll('.med-panel').forEach(panel => {
            panel.classList.toggle('active', panel.id === `panel-${name}`);
        });
    }

    document.querySelectorAll('.med-tab').forEach(button => {
        button.setAttribute('role', 'tab');
        button.setAttribute('aria-selected', button.dataset.tab === activeTab ? 'true' : 'false');
        button.addEventListener('click', () => activateTab(button.dataset.tab));
    });

    document.querySelectorAll('[data-refresh]').forEach(button => {
        button.addEventListener('click', loadData);
    });

    $('trackingListContainer').addEventListener('click', event => {
        const button = event.target.closest('[data-dose-id][data-status]');
        if (!button) return;
        markDose(button.dataset.doseId, button.dataset.status, button);
    });

    async function refreshNotificationStatus() {
        const status = $('notificationStatus');
        const description = $('notificationDescription');
        const button = $('toggleNotificationBtn');
        const error = $('notificationError');

        error.hidden = true;
        button.disabled = true;

        if (!('Notification' in window) || !('serviceWorker' in navigator)) {
            status.textContent = 'এই ব্রাউজারে push notification সমর্থিত নয়';
            description.textContent = 'সমর্থিত ব্রাউজার ও HTTPS অথবা localhost প্রয়োজন হতে পারে।';
            button.textContent = 'সমর্থিত নয়';
            return;
        }

        if (Notification.permission === 'denied') {
            status.textContent = 'নোটিফিকেশন ব্লক করা আছে';
            description.textContent = 'ব্রাউজারের site settings থেকে notification অনুমতি চালু করুন।';
            button.textContent = 'ব্রাউজার সেটিংস খুলুন';
            button.disabled = false;
            button.dataset.action = 'settings';
            return;
        }

        try {
            const registration = await navigator.serviceWorker.ready;
            const subscription = await registration.pushManager.getSubscription();
            const enabled = Boolean(subscription);

            status.textContent = enabled ? 'নোটিফিকেশন চালু আছে' : 'নোটিফিকেশন বন্ধ আছে';
            description.textContent = enabled
                ? 'এই ব্রাউজারে push subscription পাওয়া গেছে।'
                : 'ওষুধের রিমাইন্ডার পেতে নোটিফিকেশন চালু করুন।';
            button.textContent = enabled ? 'বন্ধ করুন' : 'চালু করুন';
            button.dataset.action = enabled ? 'unsubscribe' : 'subscribe';
            button.disabled = false;
        } catch (error) {
            status.textContent = 'নোটিফিকেশনের অবস্থা যাচাই করা যায়নি';
            description.textContent = 'আবার চেষ্টা করুন।';
            button.textContent = 'আবার চেষ্টা করুন';
            button.disabled = false;
            button.dataset.action = 'retry';
        }
    }

    $('toggleNotificationBtn').addEventListener('click', async () => {
        const button = $('toggleNotificationBtn');
        const error = $('notificationError');
        error.hidden = true;

        if (button.dataset.action === 'settings') {
            showMessage('ব্রাউজারের address bar-এর site settings থেকে notification অনুমতি চালু করুন।', true);
            return;
        }

        button.disabled = true;
        try {
            if (button.dataset.action === 'unsubscribe') {
                if (typeof unsubscribeFromPush !== 'function') {
                    throw new Error('নোটিফিকেশন বন্ধ করার ফাংশন পাওয়া যায়নি।');
                }
                await unsubscribeFromPush();
            } else {
                if (typeof subscribeToPush !== 'function') {
                    throw new Error('নোটিফিকেশন চালু করার ফাংশন পাওয়া যায়নি।');
                }
                await subscribeToPush();
            }
            await refreshNotificationStatus();
        } catch (err) {
            error.textContent = err.message || 'নোটিফিকেশন সেটিং পরিবর্তন করা যায়নি।';
            error.hidden = false;
            button.disabled = false;
        }
    });

    if (typeof token !== 'undefined' && token) {
        if (typeof loadProfile === 'function') loadProfile();
        loadData();
        refreshNotificationStatus();
    } else {
        showMessage('লগইন তথ্য পাওয়া যায়নি। পেজটি রিফ্রেশ করে আবার চেষ্টা করুন।', true);
    }
})();
</script>
@endpush