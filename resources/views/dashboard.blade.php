@extends('layouts.app')

@section('title', 'ড্যাশবোর্ড - খেয়াল')
@section('page-title', 'ড্যাশবোর্ড')

@section('content')

<style>
    .quick-actions a.quick-action {
        display: block;
        color: inherit;
        text-decoration: none;
        transition: border-color .18s ease, transform .18s ease, box-shadow .18s ease;
    }

    .quick-actions a.quick-action:hover {
        border-color: #ff5c5c;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(15, 27, 61, .08);
    }

    .alerts-list a.alert-row,
    .history-list a.history-item {
        color: inherit;
        text-decoration: none;
    }

    .alerts-list a.alert-row:hover,
    .history-list a.history-item:hover {
        background: #f8fafc;
    }
</style>

<!-- WELCOME -->
<section class="welcome-section">
    <div>
        <h2 class="welcome-title" id="welcomeTitle">স্বাগতম...</h2>
        <p class="welcome-subtitle">আজ আপনার প্রিয়জনদের যত্নের সারাংশ</p>
    </div>

    <div class="date-card">
        <svg viewBox="0 0 24 24" class="icon">
            <rect x="3" y="4" width="18" height="17" rx="3" />
            <path d="M8 2v4" />
            <path d="M16 2v4" />
            <path d="M3 10h18" />
        </svg>
        <span id="currentDate">...</span>
    </div>
</section>

<!-- STATS -->
<section class="stats-grid">
    <div class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-label">মোট রোগী</div>
                <div class="stat-value" id="statTotalPatients">০</div>
                <div class="stat-meta">সক্রিয়</div>
            </div>
            <div class="stat-icon icon-patient">
                <svg viewBox="0 0 24 24" class="icon">
                    <circle cx="9" cy="7" r="4" />
                    <path d="M2 21v-1a6 6 0 0 1 12 0v1" />
                    <path d="M16 11a4 4 0 1 0 0-8" />
                    <path d="M22 21v-1a6 6 0 0 0-4-5.65" />
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-label">আজকের ওষুধ</div>
                <div class="stat-value" id="statTodayDoses">০</div>
                <div class="stat-meta">মোট ডোজ</div>
            </div>
            <div class="stat-icon icon-medicine">
                <svg viewBox="0 0 24 24" class="icon">
                    <path d="M10.5 3.5a5 5 0 0 1 7 7l-7 7a5 5 0 0 1-7-7z" />
                    <path d="M7 7l10 10" />
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-label">সময়ে নেওয়া</div>
                <div class="stat-value" id="statTakenDoses">০</div>
                <div class="stat-meta success-text" id="statTakenPercent">০%</div>
            </div>
            <div class="stat-icon icon-success">
                <svg viewBox="0 0 24 24" class="icon">
                    <path d="M5 12l4 4L19 6" />
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-label">মিসড ডোজ</div>
                <div class="stat-value" id="statMissedDoses">০</div>
                <div class="stat-meta danger-text" id="statMissedPercent">০%</div>
            </div>
            <div class="stat-icon icon-warning">
                <svg viewBox="0 0 24 24" class="icon">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 7v5l3 2" />
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-label">SOS সতর্কতা</div>
                <div class="stat-value" id="statActiveSos">০</div>
                <div class="stat-meta">সক্রিয়</div>
            </div>
            <div class="stat-icon icon-sos">SOS</div>
        </div>
    </div>
</section>

<!-- PATIENTS -->
<section>
    <div class="section-header">
        <h3 class="section-title">আমার রোগীদের অবস্থা</h3>
        <a href="/patients" class="section-link">সব দেখুন →</a>
    </div>

    <div class="patients-card" id="patientsListContainer">
        <div style="padding:24px;text-align:center;color:var(--muted);">
            লোড হচ্ছে...
        </div>
    </div>
</section>

<!-- MIDDLE GRID -->
<section class="dashboard-grid">

    <!-- MEDICINE SUMMARY -->
    <div class="dashboard-panel">
        <h3 class="panel-title">ওষুধ গ্রহণের সারাংশ</h3>
        <p class="panel-subtitle">সামগ্রিক হিসাব</p>

        <div class="summary-content">
            <div class="donut">
                <svg viewBox="0 0 120 120" aria-hidden="true">
                    <circle
                        cx="60" cy="60" r="47"
                        fill="none"
                        stroke="#edf1f5"
                        stroke-width="10"
                    />
                    <circle
                        id="medicineDonutProgress"
                        cx="60" cy="60" r="47"
                        fill="none"
                        stroke="#ff5c5c"
                        stroke-width="10"
                        stroke-linecap="round"
                        stroke-dasharray="295"
                        stroke-dashoffset="295"
                        transform="rotate(-90 60 60)"
                    />
                </svg>

                <div class="donut-center">
                    <div class="donut-value" id="medicineTakenPercent">০%</div>
                    <div class="donut-label">নেওয়া হয়েছে</div>
                </div>
            </div>

            <div class="summary-legend">
                <div class="legend-row">
                    <div class="legend-left">
                        <span class="legend-dot" style="background:#43a68f"></span>
                        সময়মতো নেওয়া
                    </div>
                    <strong id="medicineTakenCount">০</strong>
                </div>

                <div class="legend-row">
                    <div class="legend-left">
                        <span class="legend-dot" style="background:#f59e0b"></span>
                        দেরিতে নেওয়া
                    </div>
                    <strong id="medicineLateCount">০</strong>
                </div>

                <div class="legend-row">
                    <div class="legend-left">
                        <span class="legend-dot" style="background:#ff5c5c"></span>
                        মিসড
                    </div>
                    <strong id="medicineMissedCount">০</strong>
                </div>

                <div class="total-dose">
                    মোট ডোজ: <strong id="medicineTotalCount">০</strong>
                    <a href="/medication-management" class="section-link">
                        ওষুধ ব্যবস্থাপনা →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENT ALERTS -->
    <div class="dashboard-panel">
        <h3 class="panel-title">সাম্প্রতিক সতর্কতা</h3>
        <p class="panel-subtitle">SOS, চেক-ইন ও ওষুধের সর্বশেষ আপডেট</p>

        <div class="alerts-list" id="recentAlertsList">
            <div style="padding:16px;text-align:center;color:var(--muted);">
                লোড হচ্ছে...
            </div>
        </div>

        <a
            href="/sos-alerts"
            class="view-alerts"
            style="display:block;text-align:center;text-decoration:none;"
        >
            সব সতর্কতা দেখুন
        </a>
    </div>
</section>

<!-- QUICK ACTIONS -->
<section class="quick-actions">
    <a href="/prescriptions/scan" class="quick-action">
        <div class="quick-icon scan">
            <svg viewBox="0 0 24 24" class="icon">
                <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                <path d="M7 12h10" />
                <path d="M12 7v10" />
            </svg>
        </div>
        <div class="quick-title">প্রেসক্রিপশন স্ক্যান</div>
        <div class="quick-text">ওষুধ স্বয়ংক্রিয়ভাবে পড়ুন</div>
    </a>

    <a href="/health-history" class="quick-action">
        <div class="quick-icon history">
            <svg viewBox="0 0 24 24" class="icon">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 7v5l3 2" />
            </svg>
        </div>
        <div class="quick-title">স্বাস্থ্য ইতিহাস</div>
        <div class="quick-text">আগের চিকিৎসা ও ডাক্তার</div>
    </a>

    <a href="/appointments" class="quick-action">
        <div class="quick-icon appointment">
            <svg viewBox="0 0 24 24" class="icon">
                <rect x="3" y="4" width="18" height="17" rx="3" />
                <path d="M8 2v4" />
                <path d="M16 2v4" />
                <path d="M3 10h18" />
            </svg>
        </div>
        <div class="quick-title">অ্যাপয়েন্টমেন্ট</div>
        <div class="quick-text">ডাক্তারের সময় নির্ধারণ</div>
    </a>

    <a href="/vitals-health" class="quick-action">
        <div class="quick-icon vital">
            <svg viewBox="0 0 24 24" class="icon">
                <path d="M3 12h4l2-5 4 10 2-5h6" />
            </svg>
        </div>
        <div class="quick-title">ভাইটালস রেকর্ড</div>
        <div class="quick-text">চাপ, সুগার ও অন্যান্য তথ্য</div>
    </a>
</section>

<!-- RECENT MEDICAL HISTORY -->
<section class="history-panel">
    <div class="section-header">
        <div>
            <h3 class="section-title">সাম্প্রতিক চিকিৎসা ইতিহাস</h3>
            <p class="panel-subtitle">
                চিকিৎসক পরিদর্শন, চিকিৎসা ও হাসপাতালে ভর্তি
            </p>
        </div>
        <a href="/health-history" class="section-link">সম্পূর্ণ ইতিহাস →</a>
    </div>

    <div class="history-list" id="recentHistoryList">
        <div style="padding:16px;text-align:center;color:var(--muted);">
            চিকিৎসার ইতিহাস লোড হচ্ছে...
        </div>
    </div>
</section>

@endsection

@push('scripts')

    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('bn-BD', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            weekday: 'long'
        });

    async function loadWelcomeName() {
        const user = await loadProfile();

        if (user) {
            document.getElementById('welcomeTitle').textContent =
                `স্বাগতম ${user.name || ''}`;
        }
    }

    function bnNumber(value) {
        return Number(value || 0).toLocaleString('bn-BD');
    }

    function formatDashboardDate(value) {
        if (!value) return 'তারিখ নেই';

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) return 'তারিখ নেই';

        return date.toLocaleDateString('bn-BD', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        });
    }

    function formatDashboardTime(value) {
        if (!value) return '';

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) return '';

        return date.toLocaleTimeString('bn-BD', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function buildPatientRow(patient, todayCount, takenCount, checkin, sosActive) {
        const row = document.createElement('div');
        row.className = 'patient-row';

        const genderClass = patient.gender === 'female' ? ' female' : '';

        const relationAge = [
            patient.relation,
            patient.age ? `${patient.age} বছর` : null
        ].filter(Boolean).join(' • ');

        const checkinLabels = {
            fine: 'ভালো',
            not_well: 'একটু অসুস্থ',
            need_help: 'সাহায্য দরকার'
        };

        const checkinClass = {
            fine: 'good',
            not_well: 'medium',
            need_help: 'bad'
        };

        let statusHtml = '<span class="sos-empty">—</span>';
        let checkinHtml = '<div class="sos-empty">এখনো নেই</div>';

        if (checkin) {
            const cls = checkinClass[checkin.status] || 'medium';

            statusHtml = `
                <span class="status-${cls}">
                    ${esc(checkinLabels[checkin.status] || checkin.status || '—')}
                </span>
            `;

            const checkedAt = checkin.checked_in_at
                ? new Date(checkin.checked_in_at.replace(' ', 'T'))
                : null;

            const timeStr = checkedAt && !Number.isNaN(checkedAt.getTime())
                ? checkedAt.toLocaleTimeString('bn-BD', {
                    hour: '2-digit',
                    minute: '2-digit'
                })
                : 'সময় নেই';

            checkinHtml = `
                <div class="checkin-${cls}">
                    <span class="checkin-icon ${cls}">
                        ${checkin.status === 'fine' ? '✓' : '!'}
                    </span>
                    ${timeStr}
                </div>
            `;
        }

        const sosHtml = sosActive
            ? '<span class="status-bad">সক্রিয় SOS</span>'
            : '<div class="sos-empty">—</div>';

        row.innerHTML = `
            <div class="patient-info">
                <div class="patient-avatar${genderClass}">
                    ${esc(firstBengaliInitial(patient.name))}
                </div>
                <div>
                    <div class="patient-name">${esc(patient.name || 'নাম নেই')}</div>
                    <div class="patient-relation">${esc(relationAge || '—')}</div>
                </div>
            </div>

            <div>
                <div class="patient-label">আজকের অবস্থা</div>
                ${statusHtml}
            </div>

            <div>
                <div class="patient-label">ওষুধ</div>
                <div class="medicine-count">
                    ${bnNumber(takenCount)}/${bnNumber(todayCount)}
                </div>
                <div class="patient-subtext">ডোজ সম্পন্ন</div>
            </div>

            <div>
                <div class="patient-label">চেক-ইন</div>
                ${checkinHtml}
            </div>

            <div>
                <div class="patient-label">শেষ SOS</div>
                ${sosHtml}
            </div>

            <button class="patient-arrow" type="button" aria-label="রোগীর বিস্তারিত দেখুন">
                <svg viewBox="0 0 24 24" class="icon">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </button>
        `;

        row.style.cursor = 'pointer';

        row.addEventListener('click', () => {
            window.location.href = '/patients/' + encodeURIComponent(patient.id);
        });

        return row;
    }

    async function loadPatients() {
        const container = document.getElementById('patientsListContainer');
        const res = await apiFetch('/patients');

        if (!res || !res.ok) {
            container.innerHTML = `
                <div style="padding:24px;text-align:center;color:var(--danger);">
                    রোগীর তালিকা লোড করা যায়নি।
                </div>
            `;
            return;
        }

        const responseData = await res.json();
        const patients = Array.isArray(responseData)
            ? responseData
            : (responseData.data || []);

        document.getElementById('statTotalPatients').textContent =
            bnNumber(patients.length);

        if (!patients.length) {
            container.innerHTML = `
                <div style="padding:32px;text-align:center;color:var(--muted);">
                    এখনো কোনো রোগী যোগ করা হয়নি।
                </div>
            `;

            [
                'statTodayDoses',
                'statTakenDoses',
                'statMissedDoses'
            ].forEach(id => {
                document.getElementById(id).textContent = '০';
            });

            document.getElementById('statTakenPercent').textContent = '০%';
            document.getElementById('statMissedPercent').textContent = '০%';
            document.getElementById('statActiveSos').textContent = '০';

            return;
        }

        container.innerHTML = '';

        let totalToday = 0;
        let totalTaken = 0;
        let totalMissed = 0;

        const [checkinRes, sosRes] = await Promise.all([
            apiFetch('/checkins/latest'),
            apiFetch('/sos-alerts')
        ]);

        const checkinResponse =
            checkinRes && checkinRes.ok ? await checkinRes.json() : [];

        const checkinData = Array.isArray(checkinResponse)
            ? checkinResponse
            : (checkinResponse.data || []);

        const checkinByPatient = {};

        checkinData.forEach(item => {
            if (item && item.patient_id != null) {
                checkinByPatient[item.patient_id] =
                    item.latest_checkin || item;
            }
        });

        const sosResponse =
            sosRes && sosRes.ok ? await sosRes.json() : [];

        const sosData = Array.isArray(sosResponse)
            ? sosResponse
            : (sosResponse.data || []);

        const activeSosPatientIds = new Set(
            sosData
                .filter(alert => !alert.resolved)
                .map(alert => alert.patient_id)
        );

        document.getElementById('statActiveSos').textContent =
            bnNumber(activeSosPatientIds.size);

        for (const patient of patients) {
            await apiFetch(
                `/patients/${patient.id}/dose-logs/generate`,
                { method: 'POST' }
            );

            const doseRes = await apiFetch(
                `/patients/${patient.id}/dose-logs/today`
            );

            const doseResponse =
                doseRes && doseRes.ok ? await doseRes.json() : [];

            const doses = Array.isArray(doseResponse)
                ? doseResponse
                : (doseResponse.data || []);

            const takenCount = doses.filter(
                dose => dose.status === 'taken'
            ).length;

            const missedCount = doses.filter(
                dose => dose.status === 'missed'
            ).length;

            totalToday += doses.length;
            totalTaken += takenCount;
            totalMissed += missedCount;

            container.appendChild(
                buildPatientRow(
                    patient,
                    doses.length,
                    takenCount,
                    checkinByPatient[patient.id] || null,
                    activeSosPatientIds.has(patient.id)
                )
            );
        }

        document.getElementById('statTodayDoses').textContent =
            bnNumber(totalToday);

        document.getElementById('statTakenDoses').textContent =
            bnNumber(totalTaken);

        document.getElementById('statMissedDoses').textContent =
            bnNumber(totalMissed);

        document.getElementById('statTakenPercent').textContent =
            bnNumber(totalToday ? Math.round(totalTaken / totalToday * 100) : 0) + '%';

        document.getElementById('statMissedPercent').textContent =
            bnNumber(totalToday ? Math.round(totalMissed / totalToday * 100) : 0) + '%';
    }

    async function loadMedicineSummary() {
        const totalEl = document.getElementById('medicineTotalCount');
        const patientsRes = await apiFetch('/patients');

        if (!patientsRes || !patientsRes.ok) {
            totalEl.textContent = '—';
            return;
        }

        const payload = await patientsRes.json();

        const patients = Array.isArray(payload)
            ? payload
            : (payload.data || []);

        const totals = {
            total: 0,
            taken: 0,
            late: 0,
            missed: 0
        };

        await Promise.all(patients.map(async patient => {
            const response = await apiFetch(
                `/patients/${patient.id}/adherence`
            );

            if (!response || !response.ok) return;

            const data = await response.json();

            totals.total += Number(data.total_doses || 0);
            totals.taken += Number(data.taken || 0);
            totals.late += Number(
                data.late || data.taken_late || data.late_taken || 0
            );
            totals.missed += Number(data.missed || 0);
        }));

        const percent = totals.total
            ? Math.round(totals.taken / totals.total * 100)
            : 0;

        document.getElementById('medicineTakenPercent').textContent =
            bnNumber(percent) + '%';

        document.getElementById('medicineTakenCount').textContent =
            bnNumber(totals.taken);

        document.getElementById('medicineLateCount').textContent =
            bnNumber(totals.late);

        document.getElementById('medicineMissedCount').textContent =
            bnNumber(totals.missed);

        totalEl.textContent = bnNumber(totals.total);

        const circumference = 295;

        document.getElementById('medicineDonutProgress').style.strokeDashoffset =
            circumference - circumference * percent / 100;
    }

    async function loadRecentSos() {
        const container = document.getElementById('recentAlertsList');

        const patientsRes = await apiFetch('/patients');

        if (!patientsRes || !patientsRes.ok) {
            container.innerHTML = `
                <div style="padding:16px;text-align:center;color:var(--danger);">
                    সতর্কতা লোড করা যায়নি।
                </div>
            `;
            return;
        }

        const patientPayload = await patientsRes.json();

        const patients = Array.isArray(patientPayload)
            ? patientPayload
            : (patientPayload.data || []);

        const [sosRes, checkinRes] = await Promise.all([
            apiFetch('/sos-alerts'),
            apiFetch('/checkins/latest')
        ]);

        const sosPayload =
            sosRes && sosRes.ok ? await sosRes.json() : [];

        const checkinPayload =
            checkinRes && checkinRes.ok ? await checkinRes.json() : [];

        const sosAlerts = Array.isArray(sosPayload)
            ? sosPayload
            : (sosPayload.data || []);

        const checkins = Array.isArray(checkinPayload)
            ? checkinPayload
            : (checkinPayload.data || []);

        const patientNames = new Map(
            patients.map(patient => [
                String(patient.id),
                patient.name || 'অজানা রোগী'
            ])
        );

        const alerts = [];

        sosAlerts.forEach(item => {
            alerts.push({
                kind: 'sos',
                title: 'SOS সতর্কতা',
                patient: item.patient?.name
                    || patientNames.get(String(item.patient_id))
                    || 'অজানা রোগী',
                detail: item.resolved
                    ? 'সমাধান করা হয়েছে'
                    : 'সক্রিয় SOS',
                date: item.triggered_at || item.created_at,
                href: '/sos-alerts'
            });
        });

        checkins.forEach(entry => {
            const item = entry.latest_checkin || entry;

            if (!item || !item.status) return;

            const status = item.status;

            alerts.push({
                kind: 'checkin',
                title: status === 'fine'
                    ? 'চেক-ইন সম্পন্ন'
                    : (
                        status === 'need_help'
                            ? 'চেক-ইনে সাহায্য চেয়েছে'
                            : 'চেক-ইন আপডেট'
                    ),
                patient: patientNames.get(
                    String(item.patient_id || entry.patient_id)
                ) || entry.patient?.name || 'অজানা রোগী',
                detail: status === 'fine'
                    ? 'অবস্থা ভালো'
                    : (
                        status === 'need_help'
                            ? 'সাহায্য প্রয়োজন'
                            : 'শরীর ভালো নেই'
                    ),
                date: item.checked_in_at || item.created_at,
                href: '/patients'
            });
        });

        const doseGroups = await Promise.all(
            patients.map(async patient => {
                const res = await apiFetch(
                    `/patients/${patient.id}/dose-logs/today`
                );

                if (!res || !res.ok) return [];

                const data = await res.json();

                const logs = Array.isArray(data)
                    ? data
                    : (data.data || []);

                return logs
                    .filter(log => log.status === 'missed')
                    .map(log => ({
                        kind: 'medicine',
                        title: 'ওষুধ মিসড',
                        patient: patient.name || 'অজানা রোগী',
                        detail: log.medication?.name
                            || log.medication_name
                            || 'নির্ধারিত ডোজ নেওয়া হয়নি',
                        date: log.due_at
                            || log.scheduled_at
                            || log.created_at,
                        href: '/medication-management'
                    }));
            })
        );

        doseGroups.flat().forEach(item => alerts.push(item));

        const latest = alerts
            .filter(item => item.date && !Number.isNaN(new Date(item.date).getTime()))
            .sort((a, b) => new Date(b.date) - new Date(a.date))
            .slice(0, 3);

        if (!latest.length) {
            container.innerHTML = `
                <div style="padding:20px;text-align:center;color:var(--muted);">
                    এখনো কোনো সাম্প্রতিক সতর্কতা নেই।
                </div>
            `;
            return;
        }

        container.innerHTML = latest.map(item => {
            const icon = item.kind === 'sos'
                ? 'SOS'
                : (item.kind === 'checkin' ? '✓' : 'Rx');

            const color = item.kind === 'sos'
                ? '#ff5c5c'
                : (item.kind === 'checkin' ? '#43a68f' : '#e05270');

            return `
                <a href="${item.href}" class="alert-row" style="display:flex;">
                    <div class="alert-icon"
                         style="background:${color};color:#ffffff;">
                        ${icon}
                    </div>

                    <div class="alert-info">
                        <div class="alert-title">${esc(item.title)}</div>
                        <div class="alert-description">
                            ${esc(item.patient)} · ${esc(item.detail)}
                        </div>
                    </div>

                    <div class="alert-time">
                        ${formatDashboardTime(item.date) || formatDashboardDate(item.date)}
                    </div>
                </a>
            `;
        }).join('');
    }

    async function loadRecentMedicalHistory() {
        const container = document.getElementById('recentHistoryList');

        const patientsRes = await apiFetch('/patients');

        if (!patientsRes || !patientsRes.ok) {
            container.innerHTML = `
                <div style="padding:16px;color:var(--danger);">
                    রোগীর তথ্য লোড করা যায়নি।
                </div>
            `;
            return;
        }

        const patientPayload = await patientsRes.json();

        const patients = Array.isArray(patientPayload)
            ? patientPayload
            : (patientPayload.data || []);

        if (!patients.length) {
            container.innerHTML = `
                <div style="padding:20px;text-align:center;color:var(--muted);">
                    চিকিৎসার ইতিহাস দেখানোর জন্য রোগী যোগ করুন।
                </div>
            `;
            return;
        }

        const grouped = await Promise.all(
            patients.map(async patient => {
                const [
                    illnessRes,
                    admissionRes,
                    appointmentRes
                ] = await Promise.all([
                    apiFetch(`/patients/${patient.id}/illness-histories`),
                    apiFetch(`/patients/${patient.id}/hospital-admissions`),
                    apiFetch(`/patients/${patient.id}/appointments`)
                ]);

                const illnessData =
                    illnessRes && illnessRes.ok
                        ? await illnessRes.json()
                        : {};

                const admissionData =
                    admissionRes && admissionRes.ok
                        ? await admissionRes.json()
                        : {};

                const appointmentData =
                    appointmentRes && appointmentRes.ok
                        ? await appointmentRes.json()
                        : {};

                const illnesses = illnessData.illness_histories || [];
                const admissions = admissionData.hospital_admissions || [];

                const appointments = Array.isArray(appointmentData)
                    ? appointmentData
                    : (
                        appointmentData.appointments
                        || appointmentData.data
                        || []
                    );

                return {
                    doctor: appointments.map(item => ({
                        kind: 'doctor',
                        patientId: patient.id,
                        patientName: patient.name,
                        title: item.doctor_name
                            || item.doctor?.name
                            || 'চিকিৎসক পরিদর্শন',
                        doctor: item.doctor_name || item.doctor?.name,
                        hospital: item.hospital_name || item.hospital,
                        date: item.appointment_date
                            || item.scheduled_at
                            || item.visited_at
                            || item.created_at,
                        note: item.status || 'অ্যাপয়েন্টমেন্ট'
                    })),

                    treatment: illnesses.map(item => ({
                        kind: 'treatment',
                        patientId: patient.id,
                        patientName: patient.name,
                        title: item.illness_name || 'চিকিৎসা',
                        doctor: item.doctor_name,
                        hospital: item.hospital_name,
                        date: item.diagnosed_at || item.created_at,
                        note: item.status === 'ongoing'
                            ? 'চলমান'
                            : item.status
                    })),

                    admission: admissions.map(item => ({
                        kind: 'admission',
                        patientId: patient.id,
                        patientName: patient.name,
                        title: item.illness_name || 'হাসপাতালে ভর্তি',
                        doctor: item.doctor_name,
                        hospital: item.hospital_name,
                        date: item.admission_date || item.created_at,
                        note: item.discharge_date
                            ? `ছাড়পত্র: ${formatDashboardDate(item.discharge_date)}`
                            : 'ভর্তির রেকর্ড'
                    }))
                };
            })
        );

        const validDate = item =>
            item.date && !Number.isNaN(new Date(item.date).getTime());

        /*
         * Keep the latest record from each category:
         * doctor visit, treatment, and hospital admission.
         */
        const records = ['doctor', 'treatment', 'admission']
            .map(kind =>
                grouped
                    .flatMap(group => group[kind])
                    .filter(validDate)
                    .sort((a, b) => new Date(b.date) - new Date(a.date))[0]
            )
            .filter(Boolean);

        const typeMeta = {
            doctor: {
                label: 'চিকিৎসক পরিদর্শন',
                cls: 'type-doctor'
            },
            treatment: {
                label: 'চিকিৎসা',
                cls: 'type-treatment'
            },
            admission: {
                label: 'হাসপাতালে ভর্তি',
                cls: 'type-admission'
            }
        };

        if (!records.length) {
            container.innerHTML = `
                <div style="padding:20px;text-align:center;color:var(--muted);">
                    এখনো চিকিৎসক পরিদর্শন, চিকিৎসা বা ভর্তির রেকর্ড নেই।
                </div>
            `;
            return;
        }

        container.innerHTML = records.map(item => {
            const meta = typeMeta[item.kind];

            const details = [
                item.patientName,
                item.doctor,
                item.hospital,
                item.note
            ]
                .filter(Boolean)
                .map(value => esc(String(value)));

            return `
                <a
                    href="/patients/${encodeURIComponent(item.patientId)}"
                    class="history-item"
                    style="display:block;"
                >
                    <span class="history-type ${meta.cls}">
                        ${meta.label}
                    </span>

                    <div class="history-title">
                        ${esc(item.title)}
                    </div>

                    <div class="history-meta">
                        ${formatDashboardDate(item.date)}
                        <br>
                        ${details.join('<br>')}
                    </div>
                </a>
            `;
        }).join('');
    }

    if (token) {
        loadWelcomeName();
        loadPatients();
        loadMedicineSummary();
        loadRecentSos();
        loadRecentMedicalHistory();
    }
@endpush