@extends('layouts.app')
@section('page-title', 'স্বাস্থ্য ইতিহাস')
@section('content')

<style>
    .health-history-page {
        padding: 28px;
        min-height: calc(100vh - 72px);
        font-family: 'Hind Siliguri', sans-serif;
        color: #0f1b3d;
    }

    .history-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .history-title h1 {
        margin: 0;
        font-family: 'Noto Serif Bengali', serif;
        font-size: 28px;
        font-weight: 700;
        color: #0f1b3d;
    }

    .history-title p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 15px;
    }

    .patient-selector {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 16px;
        min-width: 260px;
    }

    .patient-selector label {
        display: block;
        margin-bottom: 5px;
        color: #64748b;
        font-size: 13px;
    }

    .patient-selector select {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        color: #0f1b3d;
        font: inherit;
        font-weight: 600;
    }

    .history-overview {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .overview-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
    }

    .overview-icon {
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #fff1ee;
        color: #ff5c5c;
        font-size: 19px;
    }

    .overview-info span {
        display: block;
        margin-bottom: 3px;
        color: #64748b;
        font-size: 13px;
    }

    .overview-info strong {
        display: block;
        color: #0f1b3d;
        font-size: 22px;
    }

    .history-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .history-card {
        min-width: 0;
        overflow: hidden;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
    }

    .history-card.full-width {
        grid-column: 1 / -1;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 17px 20px;
        border-bottom: 1px solid #eef2f7;
    }

    .card-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .card-header-icon {
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #0f1b3d;
        color: #fff;
    }

    .card-header h3 {
        margin: 0;
        font-family: 'Noto Serif Bengali', serif;
        font-size: 16px;
        color: #0f1b3d;
    }

    .card-body {
        padding: 20px;
    }

    .history-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .history-item {
        padding: 15px;
        background: #fafbfc;
        border: 1px solid #edf1f5;
        border-radius: 12px;
    }

    .history-item-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 6px;
    }

    .history-item-title {
        font-size: 15px;
        font-weight: 600;
        color: #0f1b3d;
        overflow-wrap: anywhere;
    }

    .history-item-date {
        flex-shrink: 0;
        color: #64748b;
        font-size: 12px;
    }

    .history-item-description {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .history-item-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 12px;
    }

    .history-action-btn,
    .record-btn,
    .history-item-actions button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 8px 11px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        background: #fff;
        color: #0f1b3d;
        font: inherit;
        font-size: 12px;
        cursor: pointer;
    }

    .history-action-btn {
        flex-shrink: 0;
        border-color: #ff5c5c;
        background: #fff1ee;
        font-weight: 600;
    }

    .history-action-btn:hover,
    .record-btn.primary:hover {
        background: #ff5c5c;
        color: #fff;
    }

    .history-item-actions .delete-btn,
    .record-btn.danger {
        color: #dc2626;
        border-color: #fecaca;
    }

    .empty-history {
        padding: 30px 16px;
        text-align: center;
        color: #94a3b8;
    }

    .empty-history-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        border-radius: 14px;
        background: #f8fafc;
        color: #ff5c5c;
        font-size: 20px;
    }

    .empty-history h4 {
        margin: 0 0 5px;
        color: #475569;
        font-size: 15px;
    }

    .empty-history p {
        margin: 0;
        font-size: 13px;
    }

    .doctor-info {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .info-box {
        padding: 14px;
        background: #fafbfc;
        border: 1px solid #edf1f5;
        border-radius: 12px;
        min-width: 0;
    }

    .info-box span {
        display: block;
        margin-bottom: 4px;
        color: #64748b;
        font-size: 12px;
    }

    .info-box strong {
        display: block;
        color: #0f1b3d;
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .record-panel {
        display: none;
        margin-bottom: 20px;
        padding: 22px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-top: 3px solid #ff5c5c;
        border-radius: 16px;
    }

    .record-panel.active {
        display: block;
    }

    .record-panel h3 {
        margin: 0 0 18px;
        font-family: 'Noto Serif Bengali', serif;
        font-size: 19px;
    }

    .record-form {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .form-field {
        min-width: 0;
    }

    .form-field.full {
        grid-column: 1 / -1;
    }

    .form-field label {
        display: block;
        margin-bottom: 6px;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
    }

    .form-field input,
    .form-field select,
    .form-field textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 10px 12px;
        border: 1px solid #dbe3ed;
        border-radius: 9px;
        outline: none;
        background: #fff;
        color: #0f1b3d;
        font: inherit;
        font-size: 14px;
    }

    .form-field input:focus,
    .form-field select:focus,
    .form-field textarea:focus {
        border-color: #ff5c5c;
        box-shadow: 0 0 0 3px rgba(255, 92, 92, .1);
    }

    .form-field textarea {
        resize: vertical;
        min-height: 85px;
    }

    .form-actions {
        grid-column: 1 / -1;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 4px;
    }

    .record-btn.primary {
        border-color: #ff5c5c;
        background: #fff1ee;
        font-weight: 600;
    }

    .record-btn:disabled,
    .history-action-btn:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    .form-message {
        display: none;
        margin: 0 0 14px;
        padding: 10px 12px;
        border-radius: 9px;
        font-size: 13px;
        white-space: pre-line;
    }

    .form-message.error {
        display: block;
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .form-message.success {
        display: block;
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    @media (max-width: 1100px) {
        .history-overview {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 800px) {
        .history-grid {
            grid-template-columns: 1fr;
        }

        .history-card.full-width {
            grid-column: auto;
        }

        .history-header {
            flex-direction: column;
            align-items: stretch;
        }

        .patient-selector {
            min-width: 0;
        }
    }

    @media (max-width: 600px) {
        .health-history-page {
            padding: 16px;
        }

        .history-overview,
        .doctor-info,
        .record-form {
            grid-template-columns: 1fr;
        }

        .history-title h1 {
            font-size: 24px;
        }

        .history-item-top {
            flex-direction: column;
        }

        .card-header {
            flex-wrap: wrap;
            padding: 14px;
        }

        .card-body {
            padding: 14px;
        }

        .form-field.full,
        .form-actions {
            grid-column: auto;
        }

        .form-actions {
            flex-wrap: wrap;
        }
    }
</style>

<div class="health-history-page">

    <div class="history-header">
        <div class="history-title">
            <h1>স্বাস্থ্য ইতিহাস</h1>
            <p>আপনার প্রিয়জনের পূর্ববর্তী স্বাস্থ্য তথ্য ও চিকিৎসার ইতিহাস</p>
        </div>

        <div class="patient-selector">
            <label for="patientSelect">রোগী নির্বাচন করুন</label>
            <select id="patientSelect">
                <option value="">রোগীর তালিকা লোড হচ্ছে...</option>
            </select>
        </div>
    </div>

    <div class="history-overview">
        <div class="overview-card">
            <div class="overview-icon"><i class="fas fa-notes-medical"></i></div>
            <div class="overview-info">
                <span>রোগের ইতিহাস</span>
                <strong id="illnessCount">0</strong>
            </div>
        </div>

        <div class="overview-card">
            <div class="overview-icon"><i class="fas fa-hospital"></i></div>
            <div class="overview-info">
                <span>হাসপাতালে ভর্তি</span>
                <strong id="admissionCount">0</strong>
            </div>
        </div>

        <div class="overview-card">
            <div class="overview-icon"><i class="fas fa-user-md"></i></div>
            <div class="overview-info">
                <span>চিকিৎসক</span>
                <strong id="doctorCount">0</strong>
            </div>
        </div>
    </div>

    {{-- ILLNESS FORM --}}
    <section class="record-panel" id="illnessPanel">
        <h3 id="illnessFormTitle">রোগের তথ্য যোগ করুন</h3>
        <div class="form-message" id="illnessFormMessage"></div>

        <form id="illnessForm" class="record-form">
            <div class="form-field">
                <label for="illnessName">রোগের নাম *</label>
                <input id="illnessName" name="illness_name" maxlength="255" required>
            </div>

            <div class="form-field">
                <label for="diagnosedAt">রোগ নির্ণয়ের তারিখ</label>
                <input id="diagnosedAt" name="diagnosed_at" type="date">
            </div>

            <div class="form-field">
                <label for="illnessStatus">বর্তমান অবস্থা</label>
                <select id="illnessStatus" name="status">
                    <option value="ongoing">চিকিৎসা চলছে</option>
                    <option value="recovered">সুস্থ হয়েছেন</option>
                </select>
            </div>

            <div class="form-field">
                <label for="followUpDate">পরবর্তী ফলো-আপ</label>
                <input id="followUpDate" name="follow_up_date" type="date">
            </div>

            <div class="form-field">
                <label for="illnessDoctor">চিকিৎসকের নাম</label>
                <input id="illnessDoctor" name="doctor_name" maxlength="255">
            </div>

            <div class="form-field">
                <label for="illnessHospital">হাসপাতাল / ক্লিনিক</label>
                <input id="illnessHospital" name="hospital_name" maxlength="255">
            </div>

            <div class="form-field full">
                <label for="illnessNotes">অতিরিক্ত নোট</label>
                <textarea id="illnessNotes" name="notes"></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="record-btn" data-close-panel="illnessPanel">বাতিল</button>
                <button type="submit" class="record-btn primary" id="saveIllnessBtn">সংরক্ষণ করুন</button>
            </div>
        </form>
    </section>

    {{-- ADMISSION FORM --}}
    <section class="record-panel" id="admissionPanel">
        <h3 id="admissionFormTitle">ভর্তির রেকর্ড যোগ করুন</h3>
        <div class="form-message" id="admissionFormMessage"></div>

        <form id="admissionForm" class="record-form">
            <div class="form-field">
                <label for="admissionHospital">হাসপাতালের নাম *</label>
                <input id="admissionHospital" name="hospital_name" maxlength="255" required>
            </div>

            <div class="form-field">
                <label for="admissionIllness">ভর্তির কারণ / রোগ</label>
                <input id="admissionIllness" name="illness_name" maxlength="255">
            </div>

            <div class="form-field">
                <label for="admissionDate">ভর্তির তারিখ *</label>
                <input id="admissionDate" name="admission_date" type="date" required>
            </div>

            <div class="form-field">
                <label for="dischargeDate">ছাড়পত্রের তারিখ</label>
                <input id="dischargeDate" name="discharge_date" type="date">
            </div>

            <div class="form-field">
                <label for="admissionDoctor">চিকিৎসকের নাম</label>
                <input id="admissionDoctor" name="doctor_name" maxlength="255">
            </div>

            <div class="form-field">
                <label for="treatmentDetails">চিকিৎসার বিবরণ</label>
                <input id="treatmentDetails" name="treatment_details">
            </div>

            <div class="form-field full">
                <label for="admissionNotes">অতিরিক্ত নোট</label>
                <textarea id="admissionNotes" name="notes"></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="record-btn" data-close-panel="admissionPanel">বাতিল</button>
                <button type="submit" class="record-btn primary" id="saveAdmissionBtn">সংরক্ষণ করুন</button>
            </div>
        </form>
    </section>

    <div class="history-grid">

        <section class="history-card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-header-icon"><i class="fas fa-heartbeat"></i></div>
                    <h3>পূর্ববর্তী রোগ ও অসুস্থতা</h3>
                </div>
                <button type="button" class="history-action-btn" id="addIllnessBtn">
                    <i class="fas fa-plus"></i> রোগ যোগ করুন
                </button>
            </div>
            <div class="card-body">
                <div id="illnessHistoryList" class="history-list"></div>
            </div>
        </section>

        <section class="history-card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-header-icon"><i class="fas fa-hospital-user"></i></div>
                    <h3>হাসপাতালে ভর্তি হওয়ার ইতিহাস</h3>
                </div>
                <button type="button" class="history-action-btn" id="addAdmissionBtn">
                    <i class="fas fa-plus"></i> ভর্তি রেকর্ড যোগ করুন
                </button>
            </div>
            <div class="card-body">
                <div id="admissionHistoryList" class="history-list"></div>
            </div>
        </section>

        <section class="history-card full-width">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-header-icon"><i class="fas fa-user-md"></i></div>
                    <h3>চিকিৎসক ও হাসপাতালের তথ্য</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="doctor-info">
                    <div class="info-box">
                        <span>সর্বশেষ চিকিৎসক</span>
                        <strong id="latestDoctor">তথ্য নেই</strong>
                    </div>
                    <div class="info-box">
                        <span>হাসপাতাল</span>
                        <strong id="latestHospital">তথ্য নেই</strong>
                    </div>
                    <div class="info-box">
                        <span>শেষ চিকিৎসার তারিখ</span>
                        <strong id="lastTreatmentDate">তথ্য নেই</strong>
                    </div>
                    <div class="info-box">
                        <span>পরবর্তী ফলো-আপ</span>
                        <strong id="nextFollowUp">তথ্য নেই</strong>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

@push('scripts')
(function () {
    const patientSelect = document.getElementById('patientSelect');
    const illnessList = document.getElementById('illnessHistoryList');
    const admissionList = document.getElementById('admissionHistoryList');

    const illnessForm = document.getElementById('illnessForm');
    const admissionForm = document.getElementById('admissionForm');
    const illnessPanel = document.getElementById('illnessPanel');
    const admissionPanel = document.getElementById('admissionPanel');

    const illnessMessage = document.getElementById('illnessFormMessage');
    const admissionMessage = document.getElementById('admissionFormMessage');

    let illnesses = [];
    let admissions = [];
    let editingIllnessId = null;
    let editingAdmissionId = null;
    let requestVersion = 0;

    const $ = id => document.getElementById(id);

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value == null ? '' : String(value);
        return div.innerHTML;
    }

    function showMessage(container, title, description, icon = 'fa-notes-medical') {
        container.innerHTML = `
            <div class="empty-history">
                <div class="empty-history-icon"><i class="fas ${icon}"></i></div>
                <h4>${escapeHtml(title)}</h4>
                <p>${escapeHtml(description)}</p>
            </div>`;
    }

    function formatDate(value) {
        if (!value) return 'তথ্য নেই';

        const part = String(value).substring(0, 10);
        const match = part.match(/^(\d{4})-(\d{2})-(\d{2})$/);

        if (!match) return 'তথ্য নেই';

        const date = new Date(+match[1], +match[2] - 1, +match[3]);

        if (Number.isNaN(date.getTime())) return 'তথ্য নেই';

        return date.toLocaleDateString('bn-BD', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    }

    function dateValue(value) {
        return value ? String(value).substring(0, 10) : '';
    }

    function getRecords(data, keys) {
        if (Array.isArray(data)) return data;

        for (const key of keys) {
            if (Array.isArray(data?.[key])) return data[key];
        }

        return [];
    }

    function selectedPatientId() {
        return patientSelect.value;
    }

    function showFormMessage(container, message, type = 'error') {
        container.textContent = message;
        container.className = `form-message ${type}`;
    }

    function clearFormMessage(container) {
        container.textContent = '';
        container.className = 'form-message';
    }

    function openPanel(panel) {
        illnessPanel.classList.remove('active');
        admissionPanel.classList.remove('active');
        panel.classList.add('active');
        panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function closePanel(panel) {
        panel.classList.remove('active');
    }

    function resetIllnessForm() {
        illnessForm.reset();
        editingIllnessId = null;
        $('illnessFormTitle').textContent = 'রোগের তথ্য যোগ করুন';
        $('saveIllnessBtn').textContent = 'সংরক্ষণ করুন';
        clearFormMessage(illnessMessage);
    }

    function resetAdmissionForm() {
        admissionForm.reset();
        editingAdmissionId = null;
        $('admissionFormTitle').textContent = 'ভর্তির রেকর্ড যোগ করুন';
        $('saveAdmissionBtn').textContent = 'সংরক্ষণ করুন';
        clearFormMessage(admissionMessage);
    }

    function renderIllnesses() {
        $('illnessCount').textContent = illnesses.length;

        if (!illnesses.length) {
            showMessage(
                illnessList,
                'কোনো রোগের তথ্য নেই',
                'রোগ যোগ করুন বাটনে ক্লিক করে প্রথম রেকর্ড তৈরি করুন।'
            );
            return;
        }

        illnessList.innerHTML = illnesses.map(record => {
            const details = [];

            if (record.doctor_name) {
                details.push(`চিকিৎসক: ${escapeHtml(record.doctor_name)}`);
            }

            if (record.hospital_name) {
                details.push(`হাসপাতাল: ${escapeHtml(record.hospital_name)}`);
            }

            if (record.follow_up_date) {
                details.push(`পরবর্তী ফলো-আপ: ${escapeHtml(formatDate(record.follow_up_date))}`);
            }

            if (record.notes) {
                details.push(`নোট: ${escapeHtml(record.notes)}`);
            }

            const status = record.status === 'recovered' ? 'সুস্থ হয়েছেন' : 'চিকিৎসা চলছে';

            return `
                <article class="history-item">
                    <div class="history-item-top">
                        <div class="history-item-title">${escapeHtml(record.illness_name || 'রোগের নাম নেই')}</div>
                        <div class="history-item-date">${escapeHtml(formatDate(record.diagnosed_at))}</div>
                    </div>
                    <p class="history-item-description">অবস্থা: ${status}</p>
                    ${details.length ? `<p class="history-item-description">${details.join('<br>')}</p>` : ''}
                    <div class="history-item-actions">
                        <button type="button" data-edit-illness="${Number(record.id)}">
                            <i class="fas fa-pen"></i> এডিট
                        </button>
                        <button type="button" class="delete-btn" data-delete-illness="${Number(record.id)}">
                            <i class="fas fa-trash"></i> ডিলিট
                        </button>
                    </div>
                </article>`;
        }).join('');
    }

    function renderAdmissions() {
        $('admissionCount').textContent = admissions.length;

        if (!admissions.length) {
            showMessage(
                admissionList,
                'কোনো ভর্তি তথ্য নেই',
                'ভর্তি রেকর্ড যোগ করুন বাটনে ক্লিক করে প্রথম রেকর্ড তৈরি করুন。',
                'fa-hospital'
            );
            return;
        }

        admissionList.innerHTML = admissions.map(record => {
            const details = [];

            if (record.illness_name) {
                details.push(`রোগ: ${escapeHtml(record.illness_name)}`);
            }

            if (record.doctor_name) {
                details.push(`চিকিৎসক: ${escapeHtml(record.doctor_name)}`);
            }

            details.push(
                record.discharge_date
                    ? `ছাড়পত্র: ${escapeHtml(formatDate(record.discharge_date))}`
                    : 'ছাড়পত্রের তারিখ: তথ্য নেই'
            );

            if (record.treatment_details) {
                details.push(`চিকিৎসা: ${escapeHtml(record.treatment_details)}`);
            }

            if (record.notes) {
                details.push(`নোট: ${escapeHtml(record.notes)}`);
            }

            return `
                <article class="history-item">
                    <div class="history-item-top">
                        <div class="history-item-title">${escapeHtml(record.hospital_name || 'হাসপাতালের নাম নেই')}</div>
                        <div class="history-item-date">${escapeHtml(formatDate(record.admission_date))}</div>
                    </div>
                    <p class="history-item-description">${details.join('<br>')}</p>
                    <div class="history-item-actions">
                        <button type="button" data-edit-admission="${Number(record.id)}">
                            <i class="fas fa-pen"></i> এডিট
                        </button>
                        <button type="button" class="delete-btn" data-delete-admission="${Number(record.id)}">
                            <i class="fas fa-trash"></i> ডিলিট
                        </button>
                    </div>
                </article>`;
        }).join('');
    }

    function renderDoctorInfo() {
        const records = [
            ...illnesses.map(record => ({
                doctor: record.doctor_name,
                hospital: record.hospital_name,
                date: record.diagnosed_at,
                followUp: record.follow_up_date,
                source: 'illness'
            })),
            ...admissions.map(record => ({
                doctor: record.doctor_name,
                hospital: record.hospital_name,
                date: record.discharge_date || record.admission_date,
                admissionDate: record.admission_date,
                source: 'admission'
            }))
        ];

        const uniqueDoctors = new Set(
            records
                .map(record => record.doctor?.trim().toLocaleLowerCase())
                .filter(Boolean)
        );

        $('doctorCount').textContent = uniqueDoctors.size;

        const latest = records
            .filter(record => record.doctor || record.hospital || record.date)
            .sort((a, b) => dateValue(b.date).localeCompare(dateValue(a.date)))[0];

        $('latestDoctor').textContent = latest?.doctor || 'তথ্য নেই';
        $('latestHospital').textContent = latest?.hospital || 'তথ্য নেই';
        $('lastTreatmentDate').textContent = latest?.date ? formatDate(latest.date) : 'তথ্য নেই';

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const todayString = [
            today.getFullYear(),
            String(today.getMonth() + 1).padStart(2, '0'),
            String(today.getDate()).padStart(2, '0')
        ].join('-');

        const next = illnesses
            .map(record => record.follow_up_date)
            .filter(date => date && dateValue(date) >= todayString)
            .sort((a, b) => dateValue(a).localeCompare(dateValue(b)))[0];

        $('nextFollowUp').textContent = next ? formatDate(next) : 'তথ্য নেই';
    }

    function renderAll() {
        renderIllnesses();
        renderAdmissions();
        renderDoctorInfo();
    }

    async function loadPatientHistory(patientId) {
        const version = ++requestVersion;

        illnesses = [];
        admissions = [];
        renderAll();

        if (!patientId) {
            showMessage(illnessList, 'রোগী নির্বাচন করুন', 'ইতিহাস দেখতে একজন রোগী নির্বাচন করুন।');
            showMessage(admissionList, 'রোগী নির্বাচন করুন', 'ভর্তির ইতিহাস দেখতে একজন রোগী নির্বাচন করুন।', 'fa-hospital');
            return;
        }

        showMessage(illnessList, 'তথ্য লোড হচ্ছে', 'রোগের ইতিহাস আনা হচ্ছে।', 'fa-spinner fa-spin');
        showMessage(admissionList, 'তথ্য লোড হচ্ছে', 'ভর্তির ইতিহাস আনা হচ্ছে।', 'fa-spinner fa-spin');

        patientSelect.disabled = true;
        $('addIllnessBtn').disabled = true;
        $('addAdmissionBtn').disabled = true;

        try {
            const [illnessResponse, admissionResponse] = await Promise.all([
                apiFetch(`/patients/${patientId}/illness-histories`),
                apiFetch(`/patients/${patientId}/hospital-admissions`)
            ]);

            if (version !== requestVersion) return;
            if (!illnessResponse || !admissionResponse) return;

            if (!illnessResponse.ok || !admissionResponse.ok) {
                throw new Error(`Illness API: ${illnessResponse.status}; Admission API: ${admissionResponse.status}`);
            }

            const [illnessData, admissionData] = await Promise.all([
                illnessResponse.json(),
                admissionResponse.json()
            ]);

            if (version !== requestVersion) return;

            illnesses = getRecords(illnessData, ['illness_histories', 'illnessHistories', 'illnesses']);
            admissions = getRecords(admissionData, ['hospital_admissions', 'hospitalAdmissions', 'admissions']);

            renderAll();
        } catch (error) {
            if (version !== requestVersion) return;

            console.error('Health history error:', error);
            showMessage(illnessList, 'তথ্য লোড করা যায়নি', 'API response পরীক্ষা করে আবার চেষ্টা করুন।', 'fa-triangle-exclamation');
            showMessage(admissionList, 'তথ্য লোড করা যায়নি', 'API response পরীক্ষা করে আবার চেষ্টা করুন।', 'fa-triangle-exclamation');
        } finally {
            if (version === requestVersion) {
                patientSelect.disabled = false;
                $('addIllnessBtn').disabled = !patientSelect.value;
                $('addAdmissionBtn').disabled = !patientSelect.value;
            }
        }
    }

    async function loadPatients() {
        try {
            const response = await apiFetch('/patients');
            if (!response) return;
            if (!response.ok) throw new Error(`Patient API failed: ${response.status}`);

            const data = await response.json();
            const patients = getRecords(data, ['patients']);

            patientSelect.innerHTML = '<option value="">রোগী নির্বাচন করুন</option>';

            patients.forEach(patient => {
                const option = document.createElement('option');
                option.value = patient.id;
                option.textContent = patient.name || `রোগী #${patient.id}`;
                patientSelect.appendChild(option);
            });

            if (!patients.length) {
                showMessage(illnessList, 'কোনো রোগী নেই', 'প্রথমে রোগী যোগ করুন।');
                showMessage(admissionList, 'কোনো রোগী নেই', 'রোগী যোগ করার পর ভর্তি ইতিহাস দেখা যাবে।', 'fa-hospital');
                return;
            }

            patientSelect.value = String(patients[0].id);
            await loadPatientHistory(patientSelect.value);
        } catch (error) {
            console.error('Patient list error:', error);
            patientSelect.innerHTML = '<option value="">রোগীর তালিকা লোড করা যায়নি</option>';
            showMessage(illnessList, 'তথ্য লোড করা যায়নি', 'লগইন এবং Patient API পরীক্ষা করুন।', 'fa-triangle-exclamation');
            showMessage(admissionList, 'তথ্য লোড করা যায়নি', 'লগইন এবং Patient API পরীক্ষা করুন।', 'fa-triangle-exclamation');
        }
    }

    function fillForm(form, record) {
        Object.keys(record).forEach(key => {
            const field = form.elements.namedItem(key);
            if (!field) return;

            field.value = key.endsWith('_date') || key === 'diagnosed_at'
                ? dateValue(record[key])
                : (record[key] ?? '');
        });
    }

    function formObject(form) {
        const data = {};
        new FormData(form).forEach((value, key) => {
            data[key] = typeof value === 'string' ? value.trim() : value;
        });

        // ফাঁকা date/string-গুলো nullable field হিসেবে পাঠানো হবে।
        ['diagnosed_at', 'follow_up_date', 'discharge_date', 'doctor_name',
         'hospital_name', 'illness_name', 'treatment_details', 'notes'].forEach(key => {
            if (key in data && data[key] === '') data[key] = null;
        });

        return data;
    }

    function validationMessage(data) {
        if (data?.errors) {
            return Object.values(data.errors).flat().join('\n');
        }

        return data?.message || 'অনুরোধটি সম্পন্ন করা যায়নি। আবার চেষ্টা করুন।';
    }

    async function submitRecord({ form, message, button, url, method, close, reload }) {
        clearFormMessage(message);

        if (!selectedPatientId()) {
            showFormMessage(message, 'প্রথমে রোগী নির্বাচন করুন।');
            return;
        }

        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = 'সংরক্ষণ হচ্ছে...';

        try {
            const response = await apiFetch(url, {
                method,
                body: JSON.stringify(formObject(form))
            });

            if (!response) return;

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                showFormMessage(message, validationMessage(data));
                return;
            }

            close();
            form.reset();
            await reload();
        } catch (error) {
            console.error('Save record error:', error);
            showFormMessage(message, 'সার্ভারের সঙ্গে যোগাযোগ করা যায়নি। আবার চেষ্টা করুন।');
        } finally {
            button.disabled = false;
            button.textContent = originalText;
        }
    }

    $('addIllnessBtn').addEventListener('click', () => {
        resetIllnessForm();
        openPanel(illnessPanel);
    });

    $('addAdmissionBtn').addEventListener('click', () => {
        resetAdmissionForm();
        openPanel(admissionPanel);
    });

    document.querySelectorAll('[data-close-panel]').forEach(button => {
        button.addEventListener('click', () => {
            const panel = $(button.dataset.closePanel);
            closePanel(panel);

            if (panel === illnessPanel) resetIllnessForm();
            if (panel === admissionPanel) resetAdmissionForm();
        });
    });

    illnessList.addEventListener('click', async event => {
        const editButton = event.target.closest('[data-edit-illness]');
        const deleteButton = event.target.closest('[data-delete-illness]');

        if (editButton) {
            const id = Number(editButton.dataset.editIllness);
            const record = illnesses.find(item => Number(item.id) === id);
            if (!record) return;

            resetIllnessForm();
            editingIllnessId = id;
            fillForm(illnessForm, record);
            $('illnessFormTitle').textContent = 'রোগের তথ্য আপডেট করুন';
            $('saveIllnessBtn').textContent = 'আপডেট করুন';
            openPanel(illnessPanel);
            return;
        }

        if (deleteButton) {
            const id = Number(deleteButton.dataset.deleteIllness);
            const record = illnesses.find(item => Number(item.id) === id);
            if (!record || !confirm(`"${record.illness_name}" রেকর্ডটি মুছে ফেলবেন?`)) return;

            deleteButton.disabled = true;

            try {
                const response = await apiFetch(
                    `/patients/${selectedPatientId()}/illness-histories/${id}`,
                    { method: 'DELETE' }
                );

                if (!response) return;

                const data = await response.json().catch(() => ({}));
                if (!response.ok) {
                    alert(validationMessage(data));
                    return;
                }

                await loadPatientHistory(selectedPatientId());
            } catch (error) {
                console.error(error);
                alert('রেকর্ড মুছতে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
            } finally {
                deleteButton.disabled = false;
            }
        }
    });

    admissionList.addEventListener('click', async event => {
        const editButton = event.target.closest('[data-edit-admission]');
        const deleteButton = event.target.closest('[data-delete-admission]');

        if (editButton) {
            const id = Number(editButton.dataset.editAdmission);
            const record = admissions.find(item => Number(item.id) === id);
            if (!record) return;

            resetAdmissionForm();
            editingAdmissionId = id;
            fillForm(admissionForm, record);
            $('admissionFormTitle').textContent = 'ভর্তির রেকর্ড আপডেট করুন';
            $('saveAdmissionBtn').textContent = 'আপডেট করুন';
            openPanel(admissionPanel);
            return;
        }

        if (deleteButton) {
            const id = Number(deleteButton.dataset.deleteAdmission);
            const record = admissions.find(item => Number(item.id) === id);

            if (!record || !confirm(`"${record.hospital_name}" ভর্তির রেকর্ডটি মুছে ফেলবেন?`)) return;

            deleteButton.disabled = true;

            try {
                const response = await apiFetch(
                    `/patients/${selectedPatientId()}/hospital-admissions/${id}`,
                    { method: 'DELETE' }
                );

                if (!response) return;

                const data = await response.json().catch(() => ({}));
                if (!response.ok) {
                    alert(validationMessage(data));
                    return;
                }

                await loadPatientHistory(selectedPatientId());
            } catch (error) {
                console.error(error);
                alert('রেকর্ড মুছতে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
            } finally {
                deleteButton.disabled = false;
            }
        }
    });

    illnessForm.addEventListener('submit', async event => {
        event.preventDefault();

        const id = editingIllnessId;
        const url = `/patients/${selectedPatientId()}/illness-histories${id ? `/${id}` : ''}`;

        await submitRecord({
            form: illnessForm,
            message: illnessMessage,
            button: $('saveIllnessBtn'),
            url,
            method: id ? 'PUT' : 'POST',
            close: () => closePanel(illnessPanel),
            reload: () => loadPatientHistory(selectedPatientId())
        });
    });

    admissionForm.addEventListener('submit', async event => {
        event.preventDefault();

        const id = editingAdmissionId;
        const url = `/patients/${selectedPatientId()}/hospital-admissions${id ? `/${id}` : ''}`;

        await submitRecord({
            form: admissionForm,
            message: admissionMessage,
            button: $('saveAdmissionBtn'),
            url,
            method: id ? 'PUT' : 'POST',
            close: () => closePanel(admissionPanel),
            reload: () => loadPatientHistory(selectedPatientId())
        });
    });

    patientSelect.addEventListener('change', () => {
        resetIllnessForm();
        resetAdmissionForm();
        closePanel(illnessPanel);
        closePanel(admissionPanel);
        loadPatientHistory(patientSelect.value);
    });

    loadPatients();
})();
@endpush

@endsection