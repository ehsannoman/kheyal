@extends('layouts.app')

@section('title', 'ড্যাশবোর্ড - খেয়াল')
@section('page-title', 'ড্যাশবোর্ড')

@section('content')
                <!-- WELCOME -->
                <section class="welcome-section">
                    <div>
                        <h2 class="welcome-title" id="welcomeTitle">স্বাগতম... 👋</h2>
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
                        <div style="padding:24px;text-align:center;color:var(--muted);">লোড হচ্ছে...</div>
                    </div>
                </section>

                <!-- MIDDLE GRID -->
                <section class="dashboard-grid">

                    <!-- MEDICINE SUMMARY -->
                    <div class="dashboard-panel">
                        <h3 class="panel-title">ওষুধ গ্রহণের সারাংশ</h3>
                        <p class="panel-subtitle">এই মাস</p>

                        <div class="summary-content">
                            <div class="donut">
                                <svg viewBox="0 0 120 120">
                                    <circle cx="60" cy="60" r="47" fill="none" stroke="#edf1f5" stroke-width="10" />
                                    <circle cx="60" cy="60" r="47" fill="none" stroke="#48a18d" stroke-width="10" stroke-linecap="round" stroke-dasharray="295" stroke-dashoffset="38" />
                                </svg>
                                <div class="donut-center">
                                    <div class="donut-value">৮৭%</div>
                                    <div class="donut-label">সম্পন্ন</div>
                                </div>
                            </div>

                            <div class="summary-legend">
                                <div class="legend-row">
                                    <div class="legend-left">
                                        <span class="legend-dot" style="background:#48a18d"></span>
                                        সময়ে নেওয়া
                                    </div>
                                    <strong>৭৮%</strong>
                                </div>

                                <div class="legend-row">
                                    <div class="legend-left">
                                        <span class="legend-dot" style="background:#e9972c"></span>
                                        দেরিতে নেওয়া
                                    </div>
                                    <strong>৯%</strong>
                                </div>

                                <div class="legend-row">
                                    <div class="legend-left">
                                        <span class="legend-dot" style="background:#ef625c"></span>
                                        মিসড
                                    </div>
                                    <strong>১৩%</strong>
                                </div>

                                <div class="total-dose">
                                    মোট ডোজ: <strong>১২০</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ALERTS -->
                    <div class="dashboard-panel">
                        <h3 class="panel-title">সাম্প্রতিক সতর্কতা</h3>
                        <p class="panel-subtitle">সর্বশেষ আপডেট</p>

                        <div class="alerts-list">
                            <div class="alert-row">
                                <div class="alert-icon" style="background:#ef625c">SOS</div>
                                <div class="alert-info">
                                    <div class="alert-title">SOS সতর্কতা</div>
                                    <div class="alert-description">আব্দুল করিম</div>
                                </div>
                                <div class="alert-time">আজ, ১০:১৫</div>
                            </div>

                            <div class="alert-row">
                                <div class="alert-icon" style="background:#e9972c">✓</div>
                                <div class="alert-info">
                                    <div class="alert-title">চেক-ইন মিসড</div>
                                    <div class="alert-description">রোকেয়া বেগম</div>
                                </div>
                                <div class="alert-time">গতকাল</div>
                            </div>

                            <div class="alert-row">
                                <div class="alert-icon" style="background:#d85b74">Rx</div>
                                <div class="alert-info">
                                    <div class="alert-title">ওষুধ মিসড</div>
                                    <div class="alert-description">আব্দুল করিম – দুপুরের ডোজ</div>
                                </div>
                                <div class="alert-time">আজ, ১:০০</div>
                            </div>
                        </div>

                        <button class="view-alerts">সব সতর্কতা দেখুন</button>
                    </div>

                </section>

                <!-- QUICK ACTIONS -->
                <section class="quick-actions">
                    <div class="quick-action">
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
                    </div>

                    <div class="quick-action">
                        <div class="quick-icon history">
                            <svg viewBox="0 0 24 24" class="icon">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 2" />
                            </svg>
                        </div>
                        <div class="quick-title">স্বাস্থ্য ইতিহাস</div>
                        <div class="quick-text">আগের চিকিৎসা ও ডাক্তার</div>
                    </div>

                    <div class="quick-action">
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
                    </div>

                    <div class="quick-action">
                        <div class="quick-icon vital">
                            <svg viewBox="0 0 24 24" class="icon">
                                <path d="M3 12h4l2-5 4 10 2-5h6" />
                            </svg>
                        </div>
                        <div class="quick-title">ভাইটালস রেকর্ড</div>
                        <div class="quick-text">চাপ, সুগার ও অন্যান্য তথ্য</div>
                    </div>
                </section>

                <!-- HEALTH HISTORY PANEL -->
                <section class="history-panel">
                    <div class="section-header">
                        <div>
                            <h3 class="section-title">সাম্প্রতিক চিকিৎসা ইতিহাস</h3>
                            <p class="panel-subtitle">বিভিন্ন ডাক্তার ও হাসপাতালের পূর্ববর্তী রেকর্ড</p>
                        </div>
                        <a href="#" class="section-link">সম্পূর্ণ ইতিহাস →</a>
                    </div>

                    <div class="history-list">
                        <div class="history-item">
                            <span class="history-type type-visit">চিকিৎসক পরিদর্শন</span>
                            <div class="history-title">ডা. মোহাম্মদ রাহিম</div>
                            <div class="history-meta">
                                ১২ মে ২০২৬<br>
                                পপুলার মেডিকেল কলেজ হাসপাতাল<br>
                                উচ্চ রক্তচাপের চিকিৎসা
                            </div>
                        </div>

                        <div class="history-item">
                            <span class="history-type type-treatment">চিকিৎসা</span>
                            <div class="history-title">ডায়াবেটিস ফলো-আপ</div>
                            <div class="history-meta">
                                ০৫ মে ২০২৬<br>
                                ডা. শারমিন আক্তার<br>
                                নতুন ওষুধ ও ডোজ পরিবর্তন
                            </div>
                        </div>

                        <div class="history-item">
                            <span class="history-type type-admission">হাসপাতালে ভর্তি</span>
                            <div class="history-title">বক্ষব্যথা ও পর্যবেক্ষণ</div>
                            <div class="history-meta">
                                ১৮ মার্চ ২০২৬<br>
                                ঢাকা মেডিকেল কলেজ হাসপাতাল<br>
                                ভর্তি: ২ দিন
                            </div>
                        </div>
                    </div>
                </section>

@endsection

@push('scripts')
    /* Current date, Bengali-ish fallback to locale string */
    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('bn-BD', { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' });

    /* loadProfile() itself is shared (layouts/app.blade.php); this just adds the welcome heading */
    async function loadWelcomeName() {
        const user = await loadProfile();
        if (user) {
            document.getElementById('welcomeTitle').textContent = `স্বাগতম ${user.name || ''} 👋`;
        }
    }

    /* Build one patient row */
    function buildPatientRow(patient, todayCount, takenCount, checkin, sosActive) {
        const row = document.createElement('div');
        row.className = 'patient-row';

        const genderClass = patient.gender === 'female' ? ' female' : '';
        const relationAge = [patient.relation, patient.age ? `${patient.age} বছর` : null]
            .filter(Boolean).join(' • ');

        const checkinLabels = { fine: 'ভালো', not_well: 'একটু অসুস্থ', need_help: 'সাহায্য দরকার' };
        const checkinClass = { fine: 'good', not_well: 'medium', need_help: 'bad' };

        let statusHtml = '<span class="sos-empty">—</span>';
        let checkinHtml = '<div class="sos-empty">এখনো নেই</div>';

        if (checkin) {
            const cls = checkinClass[checkin.status] || 'medium';
            statusHtml = `<span class="status-${cls}">${checkinLabels[checkin.status] || checkin.status}</span>`;
            const timeStr = new Date(checkin.checked_in_at.replace(' ', 'T')).toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit' });
            checkinHtml = `
                <div class="checkin-${cls}">
                    <span class="checkin-icon ${cls}">${checkin.status === 'fine' ? '✓' : '!'}</span>
                    ${timeStr}
                </div>
            `;
        }

        const sosHtml = sosActive
            ? '<span class="status-bad">সক্রিয় SOS</span>'
            : '<div class="sos-empty">–</div>';

        row.innerHTML = `
            <div class="patient-info">
                <div class="patient-avatar${genderClass}">${firstBengaliInitial(patient.name)}</div>
                <div>
                    <div class="patient-name">${patient.name}</div>
                    <div class="patient-relation">${relationAge || '—'}</div>
                </div>
            </div>

            <div>
                <div class="patient-label">আজকের অবস্থা</div>
                ${statusHtml}
            </div>

            <div>
                <div class="patient-label">ওষুধ</div>
                <div class="medicine-count">${takenCount}/${todayCount}</div>
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

            <button class="patient-arrow">
                <svg viewBox="0 0 24 24" class="icon">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </button>
        `;

        row.style.cursor = 'pointer';
        row.addEventListener('click', () => {
            window.location.href = '/patients/' + patient.id;
        });

        return row;
    }

    /* Load patients + today's dose stats, render list + top stat cards */
    async function loadPatients() {
        const container = document.getElementById('patientsListContainer');
        const res = await apiFetch('/patients');
        if (!res || !res.ok) {
            container.innerHTML = '<div style="padding:24px;text-align:center;color:var(--danger);">রোগীর তালিকা লোড করা যায়নি।</div>';
            return;
        }

        const patients = await res.json();
        document.getElementById('statTotalPatients').textContent = patients.length;

        if (patients.length === 0) {
            container.innerHTML = '<div style="padding:32px;text-align:center;color:var(--muted);">এখনো কোনো রোগী যোগ করা হয়নি। উপরের "+ রোগী যোগ করুন" বাটনে চাপ দিন।</div>';
            document.getElementById('statTodayDoses').textContent = '0';
            document.getElementById('statTakenDoses').textContent = '0';
            document.getElementById('statTakenPercent').textContent = '0%';
            document.getElementById('statMissedDoses').textContent = '0';
            document.getElementById('statMissedPercent').textContent = '0%';
            return;
        }

        container.innerHTML = '';

        let totalToday = 0;
        let totalTaken = 0;
        let totalMissed = 0;

        /* Global check-in + SOS data (one call each, not per-patient) */
        const checkinRes = await apiFetch('/checkins/latest');
        const checkinData = checkinRes && checkinRes.ok ? await checkinRes.json() : [];
        const checkinByPatient = {};
        checkinData.forEach(c => { checkinByPatient[c.patient_id] = c.latest_checkin; });

        const sosRes = await apiFetch('/sos-alerts');
        const sosData = sosRes && sosRes.ok ? await sosRes.json() : [];
        const activeSosPatientIds = new Set(sosData.filter(a => !a.resolved).map(a => a.patient_id));
        document.getElementById('statActiveSos').textContent = activeSosPatientIds.size;

        for (const patient of patients) {
            /* make sure today's doses exist, then fetch them */
            await apiFetch(`/patients/${patient.id}/dose-logs/generate`, { method: 'POST' });
            const doseRes = await apiFetch(`/patients/${patient.id}/dose-logs/today`);
            const doses = doseRes && doseRes.ok ? await doseRes.json() : [];

            const takenCount = doses.filter(d => d.status === 'taken').length;
            const missedCount = doses.filter(d => d.status === 'missed').length;

            totalToday += doses.length;
            totalTaken += takenCount;
            totalMissed += missedCount;

            container.appendChild(buildPatientRow(
                patient,
                doses.length,
                takenCount,
                checkinByPatient[patient.id] || null,
                activeSosPatientIds.has(patient.id)
            ));
        }

        document.getElementById('statTodayDoses').textContent = totalToday;
        document.getElementById('statTakenDoses').textContent = totalTaken;
        document.getElementById('statMissedDoses').textContent = totalMissed;
        document.getElementById('statTakenPercent').textContent =
            (totalToday > 0 ? Math.round((totalTaken / totalToday) * 100) : 0) + '%';
        document.getElementById('statMissedPercent').textContent =
            (totalToday > 0 ? Math.round((totalMissed / totalToday) * 100) : 0) + '%';
    }

    /* Init */
    if (token) {
        loadWelcomeName();
        loadPatients();
    }

@endpush