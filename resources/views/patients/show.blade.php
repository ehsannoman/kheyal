@extends('layouts.app')

@section('title', 'রোগীর বিবরণ - খেয়াল')
@section('page-title', 'রোগীর বিবরণ')

@section('content')
                <!-- PATIENT HEADER -->
                <section class="welcome-section">
                    <div>
                        <a href="/patients" style="font-size:0.85rem;color:var(--muted);display:inline-flex;align-items:center;gap:4px;margin-bottom:8px;">← রোগীদের তালিকায় ফিরে যান</a>
                        <h2 class="welcome-title" id="patientName">...</h2>
                        <p class="welcome-subtitle" id="patientMeta"></p>
                    </div>
                </section>


                <!-- PATIENT DEVICE SETUP -->
                <section>
                    <div style="background:var(--surface-strong);border:1px solid var(--line);border-radius:14px;padding:20px;">
                        <div style="font-weight:700;color:var(--ink);font-size:0.95rem;margin-bottom:4px;">রোগীর মোবাইল অ্যাপ সেটআপ</div>
                        <p style="color:var(--muted);font-size:0.85rem;margin-bottom:14px;">এই লিংক বা QR কোড রোগীর ফোনে একবার খুলে "Add to Home Screen" করলেই তার নিজের অ্যাপ তৈরি হয়ে যাবে — আলাদা লগইনের দরকার নেই।</p>

                        <div id="deviceSetupContent">
                            <button type="button" id="generateLinkBtn" style="height:44px;padding:0 18px;border-radius:10px;border:none;background:var(--coral);color:#fff;font-weight:600;cursor:pointer;">লিংক তৈরি করুন</button>

                            <div id="deviceLinkResult" style="display:none;margin-top:14px;">
                                <div style="display:flex;gap:8px;margin-bottom:14px;flex-wrap:wrap;">
                                    <input type="text" id="deviceLinkUrl" readonly style="flex:1;min-width:220px;height:42px;padding:0 12px;border:1px solid var(--line);border-radius:8px;background:#fff;color:var(--ink);font-size:0.82rem;">
                                    <button type="button" id="copyLinkBtn" style="height:42px;padding:0 16px;border-radius:8px;border:1px solid var(--line);background:#fff;color:var(--ink);font-weight:600;cursor:pointer;">কপি করুন</button>
                                </div>
                                <div id="qrcodeContainer" style="display:inline-block;padding:12px;background:#fff;border:1px solid var(--line);border-radius:10px;"></div>
                                <div style="margin-top:12px;">
                                    <button type="button" id="resetLinkBtn" style="background:none;border:none;color:var(--danger);font-size:0.8rem;cursor:pointer;font-weight:600;">পুরোনো লিংক বাতিল করে নতুন লিংক তৈরি করুন</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

                <!-- MEDICATIONS -->
                <section>
                    <div class="section-header">
                        <h3 class="section-title">ওষুধসমূহ</h3>
                        <button type="button" id="addMedicationBtn" class="section-link" style="background:none;border:none;cursor:pointer;">+ নতুন ওষুধ যোগ করুন</button>
                    </div>

                    <div id="medicationListContainer">
                        <div style="padding:24px;text-align:center;color:var(--muted);">লোড হচ্ছে...</div>
                    </div>
                </section>

@endsection

@push('styles')
<style>
    .med-card {
        background: var(--surface-strong);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 16px 18px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }
    .med-name { font-weight: 700; color: var(--ink); font-size: 1rem; margin-bottom: 4px; }
    .med-detail { color: var(--muted); font-size: 0.85rem; line-height: 1.6; }
    .med-actions { display: flex; gap: 8px; flex-shrink: 0; }
    .med-actions button {
        border: 1px solid var(--line);
        background: #fff;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.8rem;
        cursor: pointer;
        color: var(--ink);
    }
    .med-actions button.danger { color: var(--danger); border-color: #f6c9c9; }
</style>

@endpush

@push('modals')
<!-- MEDICATION ADD/EDIT MODAL -->
<div id="medicationFormModal" style="display:none;position:fixed;inset:0;z-index:1100;background:rgba(15,27,61,0.5);align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;border-radius:16px;width:100%;max-width:460px;max-height:85vh;overflow-y:auto;padding:24px;box-shadow:0 20px 50px rgba(0,0,0,0.2);">
        <h3 id="medicationFormTitle" style="font-family:'Noto Sans Bengali',sans-serif;font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:16px;">নতুন ওষুধ যোগ করুন</h3>

        <form id="medicationForm">
            <input type="hidden" id="medicationId" value="">

            <div style="margin-bottom:12px;">
                <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">ওষুধের নাম *</label>
                <input type="text" id="medName" required style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;">
            </div>

            <div style="display:flex;gap:10px;margin-bottom:12px;">
                <div style="flex:1;">
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">ডোজ</label>
                    <input type="text" id="medDosage" placeholder="যেমন: ৫০০mg" style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;">
                </div>
                <div style="flex:1;">
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">ফর্ম</label>
                    <input type="text" id="medForm" placeholder="যেমন: ট্যাবলেট" style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;">
                </div>
            </div>

            <div style="margin-bottom:12px;">
                <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">ফ্রিকোয়েন্সি</label>
                <input type="text" id="medFrequency" placeholder="যেমন: দিনে ২ বার" style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;">
            </div>

            <div style="display:flex;gap:10px;margin-bottom:12px;">
                <div style="flex:1;">
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">শুরুর তারিখ *</label>
                    <input type="date" id="medStartDate" required style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;">
                </div>
                <div style="flex:1;">
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">শেষের তারিখ</label>
                    <input type="date" id="medEndDate" style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;">
                </div>
            </div>

            <div style="margin-bottom:12px;">
                <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">মোট পরিমাণ (ঐচ্ছিক)</label>
                <input type="number" id="medTotalQty" min="0" style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;">
            </div>

            <div style="margin-bottom:12px;">
                <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">সেবনের সময়সূচী *</label>
                <div id="scheduleTimesContainer"></div>
                <button type="button" id="addScheduleTimeBtn" style="margin-top:6px;background:none;border:none;color:var(--coral);font-weight:600;cursor:pointer;font-size:0.82rem;">+ আরেকটি সময় যোগ করুন</button>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;">নির্দেশনা</label>
                <textarea id="medInstructions" rows="2" style="width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:10px;outline:none;resize:vertical;"></textarea>
            </div>

            <div id="medicationFormError" style="display:none;background:#fff0f0;border:1px solid #f6c9c9;color:var(--danger);border-radius:10px;padding:10px 12px;font-size:0.85rem;margin-bottom:12px;"></div>

            <div style="display:flex;gap:10px;">
                <button type="button" id="cancelMedicationForm" style="flex:1;height:46px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--ink);font-weight:600;cursor:pointer;">বাতিল</button>
                <button type="submit" id="submitMedicationForm" style="flex:1;height:46px;border-radius:10px;border:none;background:var(--coral);color:#fff;font-weight:600;cursor:pointer;">সংরক্ষণ করুন</button>
            </div>
        </form>
    </div>
</div>

@endpush

@push('scripts')
    const patientId = {{ $patientId }};

    async function loadPatientHeader() {
        const res = await apiFetch('/patients/' + patientId);
        if (!res || !res.ok) {
            document.getElementById('patientName').textContent = 'রোগী পাওয়া যায়নি';
            return;
        }
        const patient = await res.json();
        document.getElementById('patientName').textContent = patient.name;

        const relationAge = [patient.relation, patient.age ? `${patient.age} বছর` : null]
            .filter(Boolean).join(' • ');
        document.getElementById('patientMeta').textContent = relationAge || '';
    }

    function buildMedicationCard(med) {
        const card = document.createElement('div');
        card.className = 'med-card';

        const times = (med.schedules || [])
            .map(s => s.scheduled_time?.slice(0, 5))
            .filter(Boolean)
            .join(', ');

        card.innerHTML = `
            <div>
                <div class="med-name">${esc(med.name)}</div>
                <div class="med-detail">
                    ${esc(med.dosage || '')} ${esc(med.form || '')}${med.dosage || med.form ? ' • ' : ''}${esc(med.frequency || '')}<br>
                    সময়: ${esc(times || '—')}<br>
                    শুরু: ${esc(med.start_date || '—')}${med.end_date ? ' | শেষ: ' + esc(med.end_date) : ''}
                    ${med.instructions ? '<br>নির্দেশনা: ' + esc(med.instructions) : ''}
                </div>
            </div>
            <div class="med-actions">
                <button type="button" data-action="edit">সম্পাদনা</button>
                <button type="button" data-action="delete" class="danger">মুছুন</button>
            </div>
        `;

        card.querySelector('[data-action="edit"]').addEventListener('click', () => openMedicationForm(med));
        card.querySelector('[data-action="delete"]').addEventListener('click', () => deleteMedication(med.id));

        return card;
    }

    async function loadMedications() {
        const container = document.getElementById('medicationListContainer');
        const res = await apiFetch(`/patients/${patientId}/medications`);
        if (!res || !res.ok) {
            container.innerHTML = '<div style="padding:24px;text-align:center;color:var(--danger);">ওষুধের তালিকা লোড করা যায়নি।</div>';
            return;
        }

        const medications = await res.json();

        if (medications.length === 0) {
            container.innerHTML = '<div style="padding:32px;text-align:center;color:var(--muted);">এখনো কোনো ওষুধ যোগ করা হয়নি।</div>';
            return;
        }

        container.innerHTML = '';
        medications.forEach(m => container.appendChild(buildMedicationCard(m)));
    }

    /* ==========================================
       MEDICATION FORM MODAL
    =========================================== */
    const medicationFormModal = document.getElementById('medicationFormModal');
    const medicationForm = document.getElementById('medicationForm');
    const medicationFormError = document.getElementById('medicationFormError');
    const scheduleTimesContainer = document.getElementById('scheduleTimesContainer');

    function addScheduleTimeInput(value = '') {
        const wrap = document.createElement('div');
        wrap.style.display = 'flex';
        wrap.style.gap = '8px';
        wrap.style.marginBottom = '6px';
        wrap.innerHTML = `
            <input type="time" class="schedule-time-input" value="${esc(value)}" required style="flex:1;height:40px;padding:0 10px;border:1px solid var(--line);border-radius:8px;outline:none;">
            <button type="button" style="border:none;background:none;color:var(--danger);cursor:pointer;font-size:1.1rem;line-height:1;">&times;</button>
        `;
        wrap.querySelector('button').addEventListener('click', () => {
            if (scheduleTimesContainer.children.length > 1) {
                wrap.remove();
            }
        });
        scheduleTimesContainer.appendChild(wrap);
    }

    document.getElementById('addScheduleTimeBtn').addEventListener('click', () => addScheduleTimeInput());

    function openMedicationForm(medication = null) {
        medicationForm.reset();
        medicationFormError.style.display = 'none';
        scheduleTimesContainer.innerHTML = '';

        if (medication) {
            document.getElementById('medicationFormTitle').textContent = 'ওষুধ সম্পাদনা করুন';
            document.getElementById('medicationId').value = medication.id;
            document.getElementById('medName').value = medication.name || '';
            document.getElementById('medDosage').value = medication.dosage || '';
            document.getElementById('medForm').value = medication.form || '';
            document.getElementById('medFrequency').value = medication.frequency || '';
            document.getElementById('medStartDate').value = medication.start_date || '';
            document.getElementById('medEndDate').value = medication.end_date || '';
            document.getElementById('medTotalQty').value = medication.total_quantity ?? '';
            document.getElementById('medInstructions').value = medication.instructions || '';

            const times = (medication.schedules || []).map(s => s.scheduled_time?.slice(0, 5)).filter(Boolean);
            if (times.length) {
                times.forEach(t => addScheduleTimeInput(t));
            } else {
                addScheduleTimeInput();
            }

            /* Editing an existing medication only updates its fields (schedule times are fixed at creation via the API) */
            scheduleTimesContainer.parentElement.style.opacity = '0.6';
            scheduleTimesContainer.querySelectorAll('input').forEach(i => i.disabled = true);
            document.getElementById('addScheduleTimeBtn').style.display = 'none';
        } else {
            document.getElementById('medicationFormTitle').textContent = 'নতুন ওষুধ যোগ করুন';
            document.getElementById('medicationId').value = '';
            addScheduleTimeInput();
            scheduleTimesContainer.parentElement.style.opacity = '1';
            document.getElementById('addScheduleTimeBtn').style.display = 'inline-block';
        }

        medicationFormModal.style.display = 'flex';
    }

    function closeMedicationForm() {
        medicationFormModal.style.display = 'none';
    }

    document.getElementById('addMedicationBtn').addEventListener('click', () => openMedicationForm());
    document.getElementById('cancelMedicationForm').addEventListener('click', closeMedicationForm);
    medicationFormModal.addEventListener('click', (e) => {
        if (e.target === medicationFormModal) closeMedicationForm();
    });

    medicationForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        medicationFormError.style.display = 'none';

        const submitBtn = document.getElementById('submitMedicationForm');
        submitBtn.disabled = true;
        submitBtn.textContent = 'সংরক্ষণ হচ্ছে...';

        const id = document.getElementById('medicationId').value;

        try {
            let res;

            if (id) {
                /* Update: only editable fields (schedule times are not changed here) */
                const payload = {
                    name: document.getElementById('medName').value.trim(),
                    dosage: document.getElementById('medDosage').value.trim() || null,
                    form: document.getElementById('medForm').value.trim() || null,
                    frequency: document.getElementById('medFrequency').value.trim() || null,
                };
                res = await apiFetch(`/medications/${id}`, {
                    method: 'PUT',
                    body: JSON.stringify(payload),
                });
            } else {
                const scheduleTimes = Array.from(document.querySelectorAll('.schedule-time-input'))
                    .map(i => i.value)
                    .filter(Boolean);

                if (scheduleTimes.length === 0) {
                    medicationFormError.textContent = 'কমপক্ষে একটি সময় দিন।';
                    medicationFormError.style.display = 'block';
                    return;
                }

                const payload = {
                    name: document.getElementById('medName').value.trim(),
                    dosage: document.getElementById('medDosage').value.trim() || null,
                    form: document.getElementById('medForm').value.trim() || null,
                    frequency: document.getElementById('medFrequency').value.trim() || null,
                    start_date: document.getElementById('medStartDate').value,
                    end_date: document.getElementById('medEndDate').value || null,
                    total_quantity: document.getElementById('medTotalQty').value || null,
                    instructions: document.getElementById('medInstructions').value.trim() || null,
                    schedule_times: scheduleTimes,
                };
                res = await apiFetch(`/patients/${patientId}/medications`, {
                    method: 'POST',
                    body: JSON.stringify(payload),
                });
            }

            if (!res) return;

            if (!res.ok) {
                const data = await res.json().catch(() => ({}));
                medicationFormError.textContent = data.message || 'ওষুধ সংরক্ষণ করা যায়নি। আবার চেষ্টা করুন।';
                medicationFormError.style.display = 'block';
                return;
            }

            closeMedicationForm();
            await loadMedications();
        } catch (err) {
            medicationFormError.textContent = 'সার্ভারের সাথে সংযোগ করা যায়নি।';
            medicationFormError.style.display = 'block';
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'সংরক্ষণ করুন';
        }
    });

    async function deleteMedication(id) {
        if (!confirm('আপনি কি নিশ্চিত এই ওষুধটি মুছে ফেলতে চান?')) return;
        const res = await apiFetch(`/medications/${id}`, { method: 'DELETE' });
        if (res && res.ok) {
            await loadMedications();
        }
    }

    /* ==========================================
       PATIENT DEVICE SETUP (link + QR)
    =========================================== */
    function renderQrCode(url) {
        const container = document.getElementById('qrcodeContainer');
        container.innerHTML = '';
        new QRCode(container, {
            text: url,
            width: 180,
            height: 180,
        });
    }

    async function loadExistingAccessLink() {
        // Patient detail already includes access_token via /patients/{id}; if present, show it directly
        const res = await apiFetch('/patients/' + patientId);
        if (!res || !res.ok) return;
        const patient = await res.json();
        if (patient.access_token) {
            showDeviceLink(url_for_token(patient.access_token));
        }
    }

    function url_for_token(token) {
        return window.location.origin + '/patient/' + token + '/home';
    }

    function showDeviceLink(url) {
        document.getElementById('generateLinkBtn').style.display = 'none';
        document.getElementById('deviceLinkResult').style.display = 'block';
        document.getElementById('deviceLinkUrl').value = url;
        renderQrCode(url);
    }

    document.getElementById('generateLinkBtn').addEventListener('click', async () => {
        const res = await apiFetch(`/patients/${patientId}/access-link`, { method: 'POST' });
        if (!res || !res.ok) return;
        const data = await res.json();
        showDeviceLink(data.url);
    });

    document.getElementById('copyLinkBtn').addEventListener('click', () => {
        const input = document.getElementById('deviceLinkUrl');
        input.select();
        navigator.clipboard?.writeText(input.value);
    });

    document.getElementById('resetLinkBtn').addEventListener('click', async () => {
        if (!confirm('পুরোনো লিংক আর কাজ করবে না — রোগীর ফোনে আবার নতুন লিংক দিয়ে সেটআপ করতে হবে। এগোতে চান?')) return;
        const res = await apiFetch(`/patients/${patientId}/access-link/reset`, { method: 'POST' });
        if (!res || !res.ok) return;
        const data = await res.json();
        showDeviceLink(data.url);
    });

    /* Init */
    if (token) {
        loadPatientHeader();
        loadMedications();
        loadExistingAccessLink();
    }

@endpush
