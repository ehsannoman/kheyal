@extends('layouts.app')

@section('title', 'রিমাইন্ডার - খেয়াল')
@section('page-title', 'রিমাইন্ডার')

@section('content')
                <!-- HEADER ROW -->
                <section class="welcome-section">
                    <div>
                        <h2 class="welcome-title">রিমাইন্ডার ও নোটিফিকেশন</h2>
                        <p class="welcome-subtitle">ব্রাউজার নোটিফিকেশন চালু করলে ওষুধের সময় ও আসন্ন অ্যাপয়েন্টমেন্টের আগে সতর্কতা পাবেন</p>
                    </div>
                </section>

                <!-- NOTIFICATION TOGGLE -->
                <section>
                    <div style="background:var(--surface-strong);border:1px solid var(--line);border-radius:14px;padding:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                        <div>
                            <div style="font-weight:700;color:var(--ink);font-size:0.95rem;margin-bottom:4px;">পুশ নোটিফিকেশন</div>
                            <div id="notificationStatus" style="color:var(--muted);font-size:0.85rem;">লোড হচ্ছে...</div>
                        </div>
                        <button type="button" id="toggleNotificationBtn" style="height:44px;padding:0 18px;border-radius:10px;border:none;background:var(--coral);color:#fff;font-weight:600;cursor:pointer;">চালু করুন</button>
                    </div>
                    <div id="notificationError" style="display:none;background:#fff0f0;border:1px solid #f6c9c9;color:var(--danger);border-radius:10px;padding:10px 14px;font-size:0.85rem;margin-top:10px;"></div>
                </section>

                <!-- UPCOMING REMINDERS -->
                <section>
                    <div class="section-header">
                        <h3 class="section-title">আজ ও আগামীকালের রিমাইন্ডার</h3>
                    </div>
                    <div id="remindersListContainer">
                        <div style="padding:24px;text-align:center;color:var(--muted);">লোড হচ্ছে...</div>
                    </div>
                </section>
@endsection

@push('styles')
<style>
    .reminder-card {
        background: var(--surface-strong);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }
    .reminder-title { font-weight: 700; color: var(--ink); font-size: 0.9rem; }
    .reminder-sub { color: var(--muted); font-size: 0.82rem; margin-top: 2px; }
    .reminder-type-badge {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 2px 9px;
        border-radius: 999px;
        flex-shrink: 0;
    }
    .reminder-type-badge.dose { background: #eaf1ff; color: #3763d6; }
    .reminder-type-badge.appointment { background: #f3ebff; color: #7c3fd6; }
</style>
@endpush

@push('scripts')
    /* ==========================================
       NOTIFICATION TOGGLE
    =========================================== */
    async function refreshNotificationStatus() {
        const statusEl = document.getElementById('notificationStatus');
        const btn = document.getElementById('toggleNotificationBtn');

        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            statusEl.textContent = 'এই ব্রাউজারে পুশ নোটিফিকেশন সমর্থিত নয়।';
            btn.style.display = 'none';
            return;
        }

        if (Notification.permission === 'denied') {
            statusEl.textContent = 'নোটিফিকেশন ব্লক করা আছে। ব্রাউজার সেটিংস থেকে অনুমতি দিন।';
            btn.style.display = 'none';
            return;
        }

        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.getSubscription();

        if (subscription) {
            statusEl.textContent = 'চালু আছে — এই ডিভাইসে নোটিফিকেশন পাবেন।';
            btn.textContent = 'বন্ধ করুন';
        } else {
            statusEl.textContent = 'এখনো চালু করা হয়নি।';
            btn.textContent = 'চালু করুন';
        }
    }

    document.getElementById('toggleNotificationBtn').addEventListener('click', async () => {
        const errorEl = document.getElementById('notificationError');
        errorEl.style.display = 'none';
        const btn = document.getElementById('toggleNotificationBtn');
        btn.disabled = true;

        try {
            const registration = await navigator.serviceWorker.ready;
            const existing = await registration.pushManager.getSubscription();

            if (existing) {
                await unsubscribeFromPush();
            } else {
                await subscribeToPush();
            }

            await refreshNotificationStatus();
        } catch (err) {
            errorEl.textContent = err.message || 'কিছু একটা সমস্যা হয়েছে।';
            errorEl.style.display = 'block';
        } finally {
            btn.disabled = false;
        }
    });

    /* ==========================================
       IN-APP UPCOMING REMINDERS (today + tomorrow)
    =========================================== */
    function buildReminderCard(type, title, sub) {
        const card = document.createElement('div');
        card.className = 'reminder-card';
        card.innerHTML = `
            <div>
                <span class="reminder-type-badge ${type}">${type === 'dose' ? 'ওষুধ' : 'অ্যাপয়েন্টমেন্ট'}</span>
                <div class="reminder-title">${esc(title)}</div>
                <div class="reminder-sub">${esc(sub)}</div>
            </div>
        `;
        return card;
    }

    async function loadReminders() {
        const container = document.getElementById('remindersListContainer');
        const patientsRes = await apiFetch('/patients');
        if (!patientsRes || !patientsRes.ok) {
            container.innerHTML = '<div style="padding:24px;text-align:center;color:var(--danger);">লোড করা যায়নি।</div>';
            return;
        }

        const patients = await patientsRes.json();
        const items = [];

        for (const patient of patients) {
            await apiFetch(`/patients/${patient.id}/dose-logs/generate`, { method: 'POST' });
            const dosesRes = await apiFetch(`/patients/${patient.id}/dose-logs/today`);
            const doses = dosesRes && dosesRes.ok ? await dosesRes.json() : [];

            doses.filter(d => d.status === 'pending').forEach(d => {
                items.push({
                    type: 'dose',
                    title: `${patient.name} — ${d.medication?.name || 'ওষুধ'}`,
                    sub: `আজ ${d.scheduled_time?.slice(0, 5)}`,
                    sortKey: d.scheduled_time,
                });
            });
        }

        const apptRes = await apiFetch('/appointments');
        const appointments = apptRes && apptRes.ok ? await apptRes.json() : [];
        const now = new Date();
        const in48h = new Date(now.getTime() + 48 * 60 * 60 * 1000);

        appointments.forEach(a => {
            const when = new Date(a.appointment_date.replace(' ', 'T'));
            if (when >= now && when <= in48h) {
                items.push({
                    type: 'appointment',
                    title: `${a.patient?.name || ''} — ${a.doctor_name || 'অ্যাপয়েন্টমেন্ট'}`,
                    sub: when.toLocaleString('bn-BD', { dateStyle: 'medium', timeStyle: 'short' }),
                    sortKey: a.appointment_date,
                });
            }
        });

        if (items.length === 0) {
            container.innerHTML = '<div style="padding:32px;text-align:center;color:var(--muted);">আপাতত কোনো রিমাইন্ডার নেই।</div>';
            return;
        }

        items.sort((a, b) => String(a.sortKey).localeCompare(String(b.sortKey)));

        container.innerHTML = '';
        items.forEach(item => container.appendChild(buildReminderCard(item.type, item.title, item.sub)));
    }

    /* Init */
    if (token) {
        loadProfile();
        refreshNotificationStatus();
        loadReminders();
    }
@endpush
