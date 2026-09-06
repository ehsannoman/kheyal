@extends('layouts.app')

@section('title', 'আমার রোগী - খেয়াল')
@section('page-title', 'আমার রোগী')

@section('content')
                <!-- HEADER ROW -->
                <section class="welcome-section">
                    <div>
                        <h2 class="welcome-title">আমার রোগীদের তালিকা</h2>
                        <p class="welcome-subtitle">রোগী যোগ করুন এবং তাদের প্রোফাইল পরিচালনা করুন</p>
                    </div>

                    <button type="button" id="addPatientBtn" style="height:46px;padding:0 20px;border-radius:10px;border:none;background:var(--coral);color:#fff;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px;">
                        <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        নতুন রোগী যোগ করুন
                    </button>
                </section>

                <!-- PATIENTS LIST -->
                <section>
                    <div class="patients-card" id="patientsListContainer">
                        <div style="padding:24px;text-align:center;color:var(--muted);">লোড হচ্ছে...</div>
                    </div>
                </section>

@endsection

@push('modals')
<!-- ADD PATIENT MODAL -->
<div id="addPatientModal" style="display:none;position:fixed;inset:0;z-index:1000;background:rgba(15,27,61,0.45);align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;border-radius:16px;width:100%;max-width:420px;padding:24px;box-shadow:0 20px 50px rgba(0,0,0,0.2);">
        <h3 style="font-family:'Noto Sans Bengali',sans-serif;font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:16px;">নতুন রোগী যোগ করুন</h3>

        <form id="addPatientForm">
            <div style="margin-bottom:12px;">
                <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">নাম *</label>
                <input type="text" id="patientName" required style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;">
            </div>

            <div style="display:flex;gap:10px;margin-bottom:12px;">
                <div style="flex:1;">
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">বয়স</label>
                    <input type="number" id="patientAge" min="0" max="150" style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;">
                </div>
                <div style="flex:1;">
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">লিঙ্গ</label>
                    <select id="patientGender" style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;">
                        <option value="">নির্বাচন করুন</option>
                        <option value="male">পুরুষ</option>
                        <option value="female">নারী</option>
                        <option value="other">অন্যান্য</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">সম্পর্ক</label>
                <input type="text" id="patientRelation" placeholder="যেমন: বাবা, মা" style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;">
            </div>

            <div id="addPatientError" style="display:none;background:#fff0f0;border:1px solid #f6c9c9;color:var(--danger);border-radius:10px;padding:10px 12px;font-size:0.85rem;margin-bottom:12px;"></div>

            <div style="display:flex;gap:10px;">
                <button type="button" id="cancelAddPatient" style="flex:1;height:46px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--ink);font-weight:600;cursor:pointer;">বাতিল</button>
                <button type="submit" id="submitAddPatient" style="flex:1;height:46px;border-radius:10px;border:none;background:var(--coral);color:#fff;font-weight:600;cursor:pointer;">সংরক্ষণ করুন</button>
            </div>
        </form>
    </div>
</div>

@endpush

@push('scripts')
    function buildPatientRow(patient) {
        const row = document.createElement('div');
        row.className = 'patient-row';

        const genderClass = patient.gender === 'female' ? ' female' : '';
        const relationAge = [patient.relation, patient.age ? `${patient.age} বছর` : null]
            .filter(Boolean).join(' • ');

        row.innerHTML = `
            <div class="patient-info">
                <div class="patient-avatar${genderClass}">${firstBengaliInitial(patient.name)}</div>
                <div>
                    <div class="patient-name">${patient.name}</div>
                    <div class="patient-relation">${relationAge || '—'}</div>
                </div>
            </div>

            <button class="patient-arrow">
                <svg viewBox="0 0 24 24" class="icon">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </button>
        `;

        row.style.cursor = 'pointer';
        row.style.gridTemplateColumns = '1fr auto';
        row.addEventListener('click', () => {
            window.location.href = '/patients/' + patient.id;
        });

        return row;
    }

    async function loadPatients() {
        const container = document.getElementById('patientsListContainer');
        const res = await apiFetch('/patients');
        if (!res || !res.ok) {
            container.innerHTML = '<div style="padding:24px;text-align:center;color:var(--danger);">রোগীর তালিকা লোড করা যায়নি।</div>';
            return;
        }

        const patients = await res.json();

        if (patients.length === 0) {
            container.innerHTML = '<div style="padding:32px;text-align:center;color:var(--muted);">এখনো কোনো রোগী যোগ করা হয়নি। উপরের বাটনে চাপ দিন।</div>';
            return;
        }

        container.innerHTML = '';
        patients.forEach(p => container.appendChild(buildPatientRow(p)));
    }

    /* Add patient modal */
    const addPatientModal = document.getElementById('addPatientModal');
    const addPatientForm = document.getElementById('addPatientForm');
    const addPatientError = document.getElementById('addPatientError');

    function openAddPatientModal() {
        addPatientForm.reset();
        addPatientError.style.display = 'none';
        addPatientModal.style.display = 'flex';
    }

    function closeAddPatientModal() {
        addPatientModal.style.display = 'none';
    }

    document.getElementById('addPatientBtn')?.addEventListener('click', openAddPatientModal);
    document.getElementById('cancelAddPatient')?.addEventListener('click', closeAddPatientModal);
    addPatientModal?.addEventListener('click', (e) => {
        if (e.target === addPatientModal) closeAddPatientModal();
    });

    addPatientForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        addPatientError.style.display = 'none';

        const submitBtn = document.getElementById('submitAddPatient');
        submitBtn.disabled = true;
        submitBtn.textContent = 'সংরক্ষণ হচ্ছে...';

        const payload = {
            name: document.getElementById('patientName').value.trim(),
            age: document.getElementById('patientAge').value || null,
            gender: document.getElementById('patientGender').value || null,
            relation: document.getElementById('patientRelation').value.trim() || null,
        };

        try {
            const res = await apiFetch('/patients', {
                method: 'POST',
                body: JSON.stringify(payload),
            });

            if (!res) return;

            if (!res.ok) {
                const data = await res.json().catch(() => ({}));
                addPatientError.textContent = data.message || 'রোগী যোগ করা যায়নি। আবার চেষ্টা করুন।';
                addPatientError.style.display = 'block';
                return;
            }

            closeAddPatientModal();
            await loadPatients();
        } catch (err) {
            addPatientError.textContent = 'সার্ভারের সাথে সংযোগ করা যায়নি।';
            addPatientError.style.display = 'block';
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'সংরক্ষণ করুন';
        }
    });

    /* Init */
    if (token) {
        loadProfile();
        loadPatients();
    }

@endpush