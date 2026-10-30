
@extends('layouts.app')

@section('title', 'প্রেসক্রিপশন যাচাই - খেয়াল')
@section('page-title', 'প্রেসক্রিপশন যাচাই')

@section('content')
<style>
    .review-page {
        display: flex;
        flex-direction: column;
        gap: 18px;
        color: var(--ink);
    }

    .review-heading h2 {
        margin: 0;
        font-family: 'Noto Serif Bengali', sans-serif;
        font-size: 23px;
        font-weight: 700;
    }

    .review-heading p {
        margin: 6px 0 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .review-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .review-card {
        min-width: 0;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 8px 24px rgba(15,27,61,.045);
    }

    .review-card-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .review-card-subtitle {
        font-size: 12px;
        color: var(--muted);
        line-height: 1.7;
        margin-bottom: 16px;
    }

    .review-image {
        display: block;
        width: 100%;
        max-height: 600px;
        object-fit: contain;
        background: #f8fafc;
        border: 1px solid var(--line);
        border-radius: 12px;
        cursor: zoom-in;
    }

    .review-help {
        font-size: 12px;
        color: var(--muted);
        line-height: 1.7;
    }

    .review-meta-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 11px;
    }

    .review-meta-item {
        min-width: 0;
        padding: 12px;
        border: 1px solid var(--line);
        border-radius: 10px;
    }

    .review-meta-label {
        font-size: 11px;
        color: var(--muted);
    }

    .review-meta-value {
        margin-top: 5px;
        font-size: 13px;
        font-weight: 600;
        overflow-wrap: anywhere;
        white-space: pre-wrap;
    }

    .review-section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 15px;
    }

    .review-section-heading h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }

    .review-count {
        padding: 5px 10px;
        border-radius: 20px;
        background: #fff1ee;
        color: #b94d48;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .medicine-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 13px;
    }

    .medicine-card {
        min-width: 0;
        padding: 16px;
        border: 1px solid var(--line);
        border-radius: 12px;
        background: #fff;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .medicine-card-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
    }

    .medicine-name {
        font-size: 15px;
        font-weight: 700;
        color: var(--ink);
        overflow-wrap: anywhere;
    }

    .medicine-form {
        display: inline-block;
        margin-top: 5px;
        padding: 4px 8px;
        border-radius: 6px;
        background: #f1f4f8;
        color: #475569;
        font-size: 10px;
    }

    .medicine-number {
        width: 27px;
        height: 27px;
        flex: 0 0 27px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: #fff1ee;
        color: #c64f4b;
        font-size: 12px;
        font-weight: 700;
    }

    .medicine-details {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 9px;
    }

    .medicine-detail {
        min-width: 0;
        padding: 9px;
        background: #f8fafc;
        border-radius: 8px;
    }

    .medicine-detail-label {
        font-size: 10px;
        color: var(--muted);
    }

    .medicine-detail-value {
        margin-top: 4px;
        font-size: 12px;
        font-weight: 600;
        white-space: pre-wrap;
        overflow-wrap: anywhere;
    }

    .medicine-instructions {
        padding: 10px;
        border-left: 3px solid var(--coral);
        background: #fff8f6;
        border-radius: 0 8px 8px 0;
    }

    .medicine-instructions .medicine-detail-value {
        font-weight: 500;
        line-height: 1.7;
    }

    .uncertainty-list {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin: 10px 0 0;
        padding: 0;
        list-style: none;
    }

    .uncertainty-list li {
        padding: 9px 11px;
        border: 1px solid #ffd9cf;
        border-radius: 8px;
        background: #fff8f6;
        color: #8c4540;
        font-size: 11px;
        line-height: 1.7;
    }

    .uncertainty-title {
        font-size: 11px;
        font-weight: 700;
        color: #a34d43;
        margin-top: 13px;
    }

    .followup-card {
        padding: 16px;
        border: 1px solid #ffd4c7;
        border-radius: 12px;
        background: #fff8f6;
    }

    .followup-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--ink);
    }

    .followup-instruction {
        margin-top: 7px;
        font-size: 13px;
        line-height: 1.7;
        color: #7c4140;
    }

    .followup-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }

    .followup-chip {
        padding: 6px 9px;
        border-radius: 7px;
        background: #fff;
        color: #8c4540;
        border: 1px solid #ffd4c7;
        font-size: 11px;
    }

    .review-empty {
        padding: 22px 15px;
        border: 1px dashed var(--line);
        border-radius: 11px;
        text-align: center;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.8;
        background: #fafbfd;
    }

    .review-note {
        padding: 12px 14px;
        background: #fff8f6;
        border: 1px solid #ffd4c7;
        border-radius: 10px;
        color: #8c4540;
        font-size: 12px;
        line-height: 1.8;
    }

    .review-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        border-radius: 20px;
        background: #fff4df;
        color: #9a6700;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .review-status.confirmed {
        background: #eaf7ef;
        color: #19703b;
    }

    .review-status.failed {
        background: #fff0f0;
        color: #b42318;
    }

    .review-status.processing {
        background: #eaf1ff;
        color: #2454a6;
    }

    .review-edit-btn {
        border: 1px solid #ffd4c7;
        background: #fff8f6;
        color: #c64f4b;
        border-radius: 7px;
        padding: 6px 11px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
    }

    .review-edit-btn:hover {
        background: #fff1ee;
    }

    .review-edit-btn:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .review-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 4px;
    }

    .review-btn {
        border: 0;
        border-radius: 9px;
        padding: 11px 17px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .review-btn:disabled {
        opacity: .55;
        cursor: wait;
    }

    .review-primary {
        background: var(--coral);
        color: #fff;
    }

    .review-light {
        background: #fff;
        border: 1px solid var(--line);
        color: var(--ink);
    }

    .review-message {
        display: none;
        padding: 11px 13px;
        border-radius: 9px;
        font-size: 12px;
        line-height: 1.7;
        margin-top: 12px;
    }

    .review-message.error {
        display: block;
        background: #fff1f0;
        color: #b42318;
        border: 1px solid #ffd2ce;
    }

    .review-message.success {
        display: block;
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .review-message.info {
        display: block;
        background: #f3f6fb;
        color: var(--ink);
        border: 1px solid var(--line);
    }

    .review-lightbox {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(10,18,38,.92);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .review-lightbox img {
        max-width: 95vw;
        max-height: 90vh;
        object-fit: contain;
    }

    .review-lightbox button {
        position: absolute;
        right: 22px;
        top: 15px;
        background: #fff;
        border: 0;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        font-size: 24px;
        cursor: pointer;
    }

    /* Floating edit form */

    .review-edit-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 10000;
        background: rgba(10,18,38,.55);
        align-items: center;
        justify-content: center;
        padding: 18px;
    }

    .review-edit-modal.active {
        display: flex;
    }

    .review-edit-modal-content {
        width: 100%;
        max-width: 480px;
        max-height: 88vh;
        overflow-y: auto;
        background: #fff;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
    }

    .review-edit-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 20px;
    }

    .review-edit-modal-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }

    .review-edit-close {
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 8px;
        background: #f1f4f8;
        color: var(--ink);
        font-size: 21px;
        cursor: pointer;
    }

    .review-edit-modal-fields {
        display: grid;
        gap: 14px;
    }

    .review-edit-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0;
    }

    .review-edit-field label {
        font-size: 11px;
        font-weight: 600;
        color: var(--muted);
    }

    .review-edit-field input,
    .review-edit-field textarea {
        width: 100%;
        min-width: 0;
        padding: 10px 11px;
        border: 1px solid var(--line);
        border-radius: 8px;
        background: #fff;
        color: var(--ink);
        font: inherit;
        font-size: 12px;
        outline: none;
    }

    .review-edit-field input:focus,
    .review-edit-field textarea:focus {
        border-color: var(--coral);
        box-shadow: 0 0 0 3px rgba(255,92,92,.10);
    }

    .review-edit-field textarea {
        min-height: 75px;
        resize: vertical;
    }

    .review-edit-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 9px;
        margin-top: 20px;
    }

    .review-edit-cancel {
        border: 1px solid var(--line);
        background: #fff;
        color: var(--ink);
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    @media(max-width:850px) {
        .review-grid {
            grid-template-columns: 1fr;
        }

        .medicine-list {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width:600px) {
        .review-card {
            padding: 16px;
        }

        .review-heading h2 {
            font-size: 20px;
        }

        .review-meta-grid {
            grid-template-columns: 1fr 1fr;
        }

        .medicine-details {
            grid-template-columns: 1fr 1fr;
        }

        .review-actions .review-btn {
            flex: 1;
        }

        .review-edit-modal-content {
            padding: 17px;
        }
    }
</style>

<div class="review-page">

    <div class="review-heading">
        <h2>প্রেসক্রিপশন যাচাই</h2>
        <p>মূল প্রেসক্রিপশনের সঙ্গে AI শনাক্ত করা তথ্য মিলিয়ে দেখুন।</p>
    </div>

    <div id="pageMessage" class="review-message"></div>

    <div class="review-grid">

        <div class="review-card">
            <div class="review-card-title">মূল প্রেসক্রিপশন</div>
            <div class="review-card-subtitle">আপলোড করা প্রেসক্রিপশনের ছবি</div>

            <div id="imageLoading" class="review-help">
                ছবি লোড হচ্ছে...
            </div>

            <img
                id="prescriptionImage"
                class="review-image"
                alt="প্রেসক্রিপশনের ছবি"
                style="display:none"
            >
        </div>

        <div class="review-card">

            <div class="review-section-heading">
                <div class="review-card-title" style="margin:0">
                    প্রেসক্রিপশনের তথ্য
                </div>

                <div style="display:flex;align-items:center;gap:8px">
                    <span class="review-status" id="prescriptionStatus">
                        লোড হচ্ছে
                    </span>

                    <button type="button" class="review-edit-btn" id="editMetaBtn">
                        সম্পাদনা
                    </button>
                </div>
            </div>

            <div class="review-meta-grid" id="prescriptionMeta">
                <div class="review-empty">তথ্য লোড হচ্ছে...</div>
            </div>

        </div>

    </div>

    <div class="review-card">

        <div class="review-section-heading">
            <div>
                <h3>শনাক্ত করা ওষুধ</h3>
                <div class="review-card-subtitle" style="margin:5px 0 0">
                    প্রেসক্রিপশন থেকে AI যে ওষুধগুলো শনাক্ত করেছে
                </div>
            </div>

            <span class="review-count" id="medicineCount">০টি ওষুধ</span>
        </div>

        <div id="medicineList" class="medicine-list">
            <div class="review-empty">ওষুধের তথ্য লোড হচ্ছে...</div>
        </div>

    </div>

    <div class="review-card">

        <div class="review-section-heading">
            <div>
                <h3>পরবর্তী সাক্ষাৎ / Follow-up</h3>
                <div class="review-card-subtitle" style="margin:5px 0 0">
                    পরবর্তী সাক্ষাতের তথ্য
                </div>
            </div>

            <button type="button" class="review-edit-btn" id="editFollowUpBtn">
                সম্পাদনা
            </button>
        </div>

        <div id="followUpContent">
            <div class="review-empty">Follow-up তথ্য লোড হচ্ছে...</div>
        </div>

    </div>

    <div class="review-card" id="uncertaintyCard" style="display:none">
        <div class="review-card-title">যেসব তথ্য পুনরায় যাচাই করা প্রয়োজন</div>

        <div class="review-card-subtitle">
            AI শনাক্তকরণে অস্পষ্ট বা নিশ্চিত নয় এমন তথ্য
        </div>

        <ul class="uncertainty-list" id="overallUncertainties"></ul>
    </div>

    <div class="review-note">
        AI শনাক্ত করা তথ্য সহায়ক প্রস্তাব মাত্র। ওষুধের dosage বা frequency দেখে কোনো Schedule Time অনুমান করা হয়নি। মূল প্রেসক্রিপশনের সঙ্গে মিলিয়ে তথ্য যাচাই করুন।
    </div>

    <div class="review-actions">

        <a href="/prescriptions" class="review-btn review-light">
            তালিকায় ফিরে যান
        </a>

        <button
            type="button"
            class="review-btn review-primary"
            id="savePrescriptionBtn"
        >
            প্রেসক্রিপশন সংরক্ষণ করুন
        </button>

    </div>

    <div id="confirmMessage" class="review-message"></div>

</div>


<!-- Floating Edit Modal -->

<div class="review-edit-modal" id="reviewEditModal">

    <div class="review-edit-modal-content">

        <div class="review-edit-modal-header">
            <h3 id="editModalTitle">তথ্য সম্পাদনা</h3>

            <button
                type="button"
                class="review-edit-close"
                id="closeEditModal"
            >
                &times;
            </button>
        </div>

        <form id="reviewEditForm">

            <div
                class="review-edit-modal-fields"
                id="editModalFields"
            ></div>

            <div class="review-edit-modal-footer">

                <button
                    type="button"
                    class="review-edit-cancel"
                    id="cancelEditModal"
                >
                    বাতিল
                </button>

                <button
                    type="submit"
                    class="review-btn review-primary"
                >
                    সম্পাদনা
                </button>

            </div>

        </form>

    </div>

</div>


<div class="review-lightbox" id="imageLightbox">
    <button type="button" id="closeLightbox">&times;</button>
    <img id="lightboxImage" alt="প্রেসক্রিপশনের বড় ছবি">
</div>

@endsection


@push('scripts')

const prescriptionId = @json($prescriptionId);

let currentPrescription = null;
let imageObjectUrl = null;
let editModalCallback = null;

const $ = id => document.getElementById(id);


// --------------------------------------------------
// Common Helpers
// --------------------------------------------------

function showReviewMessage(id, message, type = 'info') {
    const element = $(id);

    element.textContent = message;
    element.className = 'review-message ' + type;
}

function getErrorMessage(data) {
    if (data?.errors) {
        return Object.values(data.errors).flat().join(' ');
    }

    return data?.message || 'অনুরোধটি সম্পন্ন করা যায়নি।';
}

async function readResponse(response) {
    const data = await response.json().catch(() => ({}));

    if (!response || !response.ok) {
        throw new Error(getErrorMessage(data));
    }

    return data;
}

function displayValue(value) {
    if (value === null || value === undefined || value === '') {
        return '—';
    }

    if (typeof value === 'object') {
        return JSON.stringify(value);
    }

    return String(value);
}

function dateInputValue(value) {
    if (!value) return '';

    return String(value).slice(0, 10);
}

function editingDisabled() {
    return currentPrescription?.status === 'confirmed';
}


// --------------------------------------------------
// Floating Edit Modal
// --------------------------------------------------

function openEditModal(title, fields, callback) {
    if (editingDisabled()) return;

    $('editModalTitle').textContent = title;

    const container = $('editModalFields');
    container.replaceChildren();

    fields.forEach(field => {
        const wrapper = document.createElement('div');
        wrapper.className = 'review-edit-field';

        const label = document.createElement('label');
        label.textContent = field.label;

        const input = document.createElement(
            field.type === 'textarea' ? 'textarea' : 'input'
        );

        if (field.type !== 'textarea') {
            input.type = field.type || 'text';
        }

        input.value = field.value ?? '';
        input.dataset.field = field.name;

        wrapper.append(label, input);
        container.appendChild(wrapper);
    });

    editModalCallback = callback;

    $('reviewEditModal').classList.add('active');
}

function closeEditModal() {
    $('reviewEditModal').classList.remove('active');
    $('reviewEditForm').reset();

    editModalCallback = null;
}

$('closeEditModal').addEventListener('click', closeEditModal);
$('cancelEditModal').addEventListener('click', closeEditModal);

$('reviewEditModal').addEventListener('click', event => {
    if (event.target.id === 'reviewEditModal') {
        closeEditModal();
    }
});

$('reviewEditForm').addEventListener('submit', event => {
    event.preventDefault();

    if (!editModalCallback) return;

    const values = {};

    $('editModalFields')
        .querySelectorAll('[data-field]')
        .forEach(input => {
            values[input.dataset.field] = input.value.trim();
        });

    editModalCallback(values);

    closeEditModal();
});

document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
        closeEditModal();
        $('imageLightbox').style.display = 'none';
    }
});


// --------------------------------------------------
// Display Helpers
// --------------------------------------------------

function createMetaItem(label, value) {
    const item = document.createElement('div');
    item.className = 'review-meta-item';

    const heading = document.createElement('div');
    heading.className = 'review-meta-label';
    heading.textContent = label;

    const content = document.createElement('div');
    content.className = 'review-meta-value';
    content.textContent = displayValue(value);

    item.append(heading, content);

    return item;
}

function createMedicineDetail(label, value) {
    const item = document.createElement('div');
    item.className = 'medicine-detail';

    const heading = document.createElement('div');
    heading.className = 'medicine-detail-label';
    heading.textContent = label;

    const content = document.createElement('div');
    content.className = 'medicine-detail-value';
    content.textContent = displayValue(value);

    item.append(heading, content);

    return item;
}

function appendUncertainties(container, items, title = 'যাচাই প্রয়োজন') {
    if (!Array.isArray(items) || !items.length) return;

    const heading = document.createElement('div');
    heading.className = 'uncertainty-title';
    heading.textContent = title;

    container.appendChild(heading);

    const list = document.createElement('ul');
    list.className = 'uncertainty-list';

    items.forEach(item => {
        const li = document.createElement('li');

        li.textContent = typeof item === 'string'
            ? item
            : displayValue(item);

        list.appendChild(li);
    });

    container.appendChild(list);
}


// --------------------------------------------------
// Prescription Information
// --------------------------------------------------

function renderPrescriptionMeta(prescription, parsed) {
    const container = $('prescriptionMeta');

    container.replaceChildren();

    container.append(
        createMetaItem('রোগী', prescription.patient?.name),
        createMetaItem(
            'ডাক্তারের নাম',
            prescription.doctor_name || parsed.doctor_name
        ),
        createMetaItem(
            'প্রেসক্রিপশনের তারিখ',
            prescription.prescription_date
        ),
        createMetaItem('হাসপাতাল / প্রতিষ্ঠান', parsed.hospital),
        createMetaItem('আপলোডের তারিখ', prescription.created_at),
        createMetaItem(
            'স্ট্যাটাস',
            {
                pending: 'অপেক্ষমাণ',
                processing: 'প্রক্রিয়াধীন',
                confirmed: 'নিশ্চিত',
                failed: 'ব্যর্থ'
            }[prescription.status] || prescription.status
        )
    );
}


// --------------------------------------------------
// Prescription Information Edit
// --------------------------------------------------

$('editMetaBtn').addEventListener('click', () => {
    if (!currentPrescription || editingDisabled()) return;

    const parsed = currentPrescription.ai_parsed_data || {};

    openEditModal(
        'প্রেসক্রিপশনের তথ্য সম্পাদনা',
        [
            {
                name: 'doctor_name',
                label: 'ডাক্তারের নাম',
                value: currentPrescription.doctor_name || parsed.doctor_name
            },
            {
                name: 'prescription_date',
                label: 'প্রেসক্রিপশনের তারিখ',
                value: dateInputValue(currentPrescription.prescription_date),
                type: 'date'
            },
            {
                name: 'hospital',
                label: 'হাসপাতাল / প্রতিষ্ঠান',
                value: parsed.hospital
            }
        ],
        values => {
            currentPrescription.doctor_name = values.doctor_name || null;

            currentPrescription.prescription_date =
                values.prescription_date || null;

            parsed.doctor_name = values.doctor_name;
            parsed.hospital = values.hospital;

            currentPrescription.ai_parsed_data = parsed;

            renderPrescriptionMeta(currentPrescription, parsed);
        }
    );
});


// --------------------------------------------------
// Medicines
// --------------------------------------------------

function renderMedicines(medicines) {
    const container = $('medicineList');

    container.replaceChildren();

    const validMedicines = Array.isArray(medicines)
        ? medicines
        : [];

    $('medicineCount').textContent =
        validMedicines.length.toLocaleString('bn-BD') + 'টি ওষুধ';

    if (!validMedicines.length) {
        const empty = document.createElement('div');

        empty.className = 'review-empty';
        empty.style.gridColumn = '1 / -1';

        empty.textContent =
            'এই প্রেসক্রিপশন থেকে কোনো ওষুধ শনাক্ত করা যায়নি।';

        container.appendChild(empty);

        return;
    }

    validMedicines.forEach((medicine, index) => {
        const card = document.createElement('article');
        card.className = 'medicine-card';

        const head = document.createElement('div');
        head.className = 'medicine-card-head';

        const identity = document.createElement('div');

        const name = document.createElement('div');
        name.className = 'medicine-name';
        name.textContent = displayValue(medicine.name);

        identity.appendChild(name);

        if (medicine.form) {
            const form = document.createElement('span');

            form.className = 'medicine-form';
            form.textContent = medicine.form;

            identity.appendChild(form);
        }

        const actions = document.createElement('div');

        actions.style.display = 'flex';
        actions.style.alignItems = 'center';
        actions.style.gap = '8px';

        const editButton = document.createElement('button');

        editButton.type = 'button';
        editButton.className = 'review-edit-btn';
        editButton.textContent = 'সম্পাদনা';
        editButton.disabled = editingDisabled();

        editButton.addEventListener('click', () => {
            openEditModal(
                'ওষুধের তথ্য সম্পাদনা',
                [
                    {
                        name: 'name',
                        label: 'ওষুধের নাম',
                        value: medicine.name
                    },
                    {
                        name: 'form',
                        label: 'ওষুধের ধরন',
                        value: medicine.form
                    },
                    {
                        name: 'strength',
                        label: 'Strength',
                        value: medicine.strength
                    },
                    {
                        name: 'dosage',
                        label: 'Dosage',
                        value: medicine.dosage
                    },
                    {
                        name: 'frequency',
                        label: 'Frequency',
                        value: medicine.frequency
                    },
                    {
                        name: 'duration',
                        label: 'Duration',
                        value: medicine.duration
                    },
                    {
                        name: 'instructions',
                        label: 'খাওয়ার নির্দেশনা',
                        value: medicine.instructions,
                        type: 'textarea'
                    }
                ],
                values => {
                    const parsed =
                        currentPrescription.ai_parsed_data || {};

                    const list = Array.isArray(parsed.medicines)
                        ? parsed.medicines
                        : [];

                    list[index] = {
                        ...list[index],
                        ...values
                    };

                    parsed.medicines = list;

                    currentPrescription.ai_parsed_data = parsed;

                    renderMedicines(list);
                }
            );
        });

        const number = document.createElement('span');

        number.className = 'medicine-number';
        number.textContent = (index + 1).toLocaleString('bn-BD');

        actions.append(editButton, number);

        head.append(identity, actions);

        const details = document.createElement('div');
        details.className = 'medicine-details';

        details.append(
            createMedicineDetail('Strength', medicine.strength),
            createMedicineDetail('Dosage notation', medicine.dosage),
            createMedicineDetail('Frequency', medicine.frequency),
            createMedicineDetail('Duration', medicine.duration)
        );

        card.append(head, details);

        if (medicine.instructions) {
            const instructions = document.createElement('div');

            instructions.className = 'medicine-instructions';

            instructions.appendChild(
                createMedicineDetail(
                    'খাওয়ার নির্দেশনা',
                    medicine.instructions
                )
            );

            card.appendChild(instructions);
        }

        appendUncertainties(
            card,
            medicine.uncertainty_notes,
            'এই ওষুধের বিষয়ে যাচাই'
        );

        container.appendChild(card);
    });
}


// --------------------------------------------------
// Follow-up
// --------------------------------------------------

function renderFollowUp(followUp, prescription) {
    const container = $('followUpContent');

    container.replaceChildren();

    const card = document.createElement('div');
    card.className = 'followup-card';

    const title = document.createElement('div');

    title.className = 'followup-title';
    title.textContent = 'পরবর্তী সাক্ষাতের তথ্য';

    const instruction = document.createElement('div');

    instruction.className = 'followup-instruction';

    instruction.textContent =
        followUp?.instruction ||
        'কোনো Follow-up নির্দেশনা দেওয়া হয়নি।';

    const meta = document.createElement('div');
    meta.className = 'followup-meta';

    const dateValue =
        prescription.follow_up_date ||
        followUp?.candidate_date;

    if (dateValue) {
        const date = document.createElement('span');

        date.className = 'followup-chip';
        date.textContent = 'তারিখ: ' + dateValue;

        meta.appendChild(date);
    }

    if (followUp?.interval) {
        const interval = document.createElement('span');

        interval.className = 'followup-chip';
        interval.textContent = 'সময়: ' + followUp.interval;

        meta.appendChild(interval);
    }

    if (followUp?.requires_confirmation === true) {
        const confirmation = document.createElement('span');

        confirmation.className = 'followup-chip';
        confirmation.textContent = 'তারিখ নিশ্চিত করা প্রয়োজন';

        meta.appendChild(confirmation);
    }

    card.append(title, instruction, meta);

    appendUncertainties(
        card,
        followUp?.uncertainty_notes,
        'Follow-up যাচাই'
    );

    container.appendChild(card);
}


// --------------------------------------------------
// Follow-up Edit
// --------------------------------------------------

$('editFollowUpBtn').addEventListener('click', () => {
    if (!currentPrescription || editingDisabled()) return;

    const parsed = currentPrescription.ai_parsed_data || {};
    const followUp = parsed.follow_up || {};

    openEditModal(
        'Follow-up তথ্য সম্পাদনা',
        [
            {
                name: 'candidate_date',
                label: 'পরবর্তী সাক্ষাতের তারিখ',
                value: dateInputValue(
                    currentPrescription.follow_up_date ||
                    followUp.candidate_date
                ),
                type: 'date'
            },
            {
                name: 'interval',
                label: 'কত দিন / মাস পর',
                value: followUp.interval
            },
            {
                name: 'instruction',
                label: 'নির্দেশনা',
                value: followUp.instruction,
                type: 'textarea'
            }
        ],
        values => {
            const hasFollowUp =
                values.candidate_date ||
                values.interval ||
                values.instruction;

            parsed.follow_up = hasFollowUp
                ? {
                    ...followUp,
                    candidate_date: values.candidate_date || null,
                    interval: values.interval,
                    instruction: values.instruction,
                    requires_confirmation: !values.candidate_date
                }
                : null;

            currentPrescription.follow_up_date =
                values.candidate_date || null;

            currentPrescription.ai_parsed_data = parsed;

            renderFollowUp(
                parsed.follow_up,
                currentPrescription
            );
        }
    );
});


// --------------------------------------------------
// Overall Uncertainties
// --------------------------------------------------

function renderOverallUncertainties(items) {
    const card = $('uncertaintyCard');
    const list = $('overallUncertainties');

    list.replaceChildren();

    if (!Array.isArray(items) || !items.length) {
        card.style.display = 'none';
        return;
    }

    card.style.display = 'block';

    items.forEach(item => {
        const li = document.createElement('li');

        li.textContent =
            typeof item === 'string'
                ? item
                : displayValue(item);

        list.appendChild(li);
    });
}


// --------------------------------------------------
// Prescription Image
// --------------------------------------------------

async function loadPrescriptionImage() {
    try {
        const response = await apiFetch(
            `/prescriptions/${prescriptionId}/image`
        );

        if (!response || !response.ok) {
            throw new Error('প্রেসক্রিপশনের ছবি পাওয়া যায়নি।');
        }

        const blob = await response.blob();

        if (imageObjectUrl) {
            URL.revokeObjectURL(imageObjectUrl);
        }

        imageObjectUrl = URL.createObjectURL(blob);

        $('prescriptionImage').src = imageObjectUrl;
        $('prescriptionImage').style.display = 'block';

        $('imageLoading').style.display = 'none';

    } catch (error) {
        $('imageLoading').textContent =
            error.message || 'ছবি লোড করা যায়নি।';
    }
}


// --------------------------------------------------
// Load Prescription
// --------------------------------------------------

async function loadPrescription() {
    try {
        const response = await apiFetch(
            `/prescriptions/${prescriptionId}`
        );

        const data = await readResponse(response);

        currentPrescription = data.prescription;

        if (!currentPrescription) {
            throw new Error('প্রেসক্রিপশনের তথ্য পাওয়া যায়নি।');
        }

        const parsed =
            currentPrescription.ai_parsed_data || {};

        renderPrescriptionMeta(currentPrescription, parsed);

        renderMedicines(parsed.medicines);

        renderFollowUp(
            parsed.follow_up,
            currentPrescription
        );

        renderOverallUncertainties(
            parsed.overall_uncertainties
        );

        const status = $('prescriptionStatus');

        const statusLabels = {
            pending: 'অপেক্ষমাণ',
            processing: 'প্রক্রিয়াধীন',
            confirmed: 'নিশ্চিত',
            failed: 'ব্যর্থ'
        };

        status.textContent =
            statusLabels[currentPrescription.status] ||
            currentPrescription.status ||
            '—';

        status.className = 'review-status';

        if (currentPrescription.status === 'confirmed') {
            status.classList.add('confirmed');

            $('savePrescriptionBtn').disabled = true;

            $('savePrescriptionBtn').textContent =
                'ইতোমধ্যে সংরক্ষিত ও Confirm হয়েছে';

            $('editMetaBtn').disabled = true;
            $('editFollowUpBtn').disabled = true;

        } else if (currentPrescription.status === 'failed') {
            status.classList.add('failed');

        } else if (currentPrescription.status === 'processing') {
            status.classList.add('processing');
        }

        await loadPrescriptionImage();

    } catch (error) {
        console.error(error);

        showReviewMessage(
            'pageMessage',
            error.message || 'প্রেসক্রিপশন লোড করা যায়নি।',
            'error'
        );
    }
}


// --------------------------------------------------
// Image Lightbox
// --------------------------------------------------

$('prescriptionImage').addEventListener('click', () => {
    if (!imageObjectUrl) return;

    $('lightboxImage').src = imageObjectUrl;
    $('imageLightbox').style.display = 'flex';
});

$('closeLightbox').addEventListener('click', () => {
    $('imageLightbox').style.display = 'none';
});

$('imageLightbox').addEventListener('click', event => {
    if (event.target.id === 'imageLightbox') {
        $('imageLightbox').style.display = 'none';
    }
});


// --------------------------------------------------
// Save Changes + Confirm Prescription
// --------------------------------------------------

$('savePrescriptionBtn').addEventListener('click', async () => {
    if (!currentPrescription || editingDisabled()) {
        return;
    }

    const button = $('savePrescriptionBtn');

    button.disabled = true;

    showReviewMessage(
        'confirmMessage',
        'প্রেসক্রিপশনের তথ্য সংরক্ষণ হচ্ছে...',
        'info'
    );

    try {
        const parsed =
            currentPrescription.ai_parsed_data || {};

        // Step 1: Save edited prescription information

        const updateResponse = await apiFetch(
            `/prescriptions/${prescriptionId}`,
            {
                method: 'PUT',
                body: JSON.stringify({
                    doctor_name:
                        currentPrescription.doctor_name || null,

                    prescription_date:
                        currentPrescription.prescription_date || null,

                    follow_up_date:
                        currentPrescription.follow_up_date || null,

                    ai_parsed_data: parsed
                })
            }
        );

        const updateData = await readResponse(updateResponse);

        if (updateData.prescription) {
            currentPrescription = {
                ...currentPrescription,
                ...updateData.prescription
            };
        }

        // Step 2: Confirm only after successful save

        showReviewMessage(
            'confirmMessage',
            'তথ্য সংরক্ষিত হয়েছে। প্রেসক্রিপশন Confirm হচ্ছে...',
            'info'
        );

        const confirmResponse = await apiFetch(
            `/prescriptions/${prescriptionId}/confirm`,
            {
                method: 'POST'
            }
        );

        const confirmData = await readResponse(confirmResponse);

        currentPrescription.status = 'confirmed';

        if (confirmData.prescription) {
            currentPrescription = {
                ...currentPrescription,
                ...confirmData.prescription
            };
        }

        $('prescriptionStatus').textContent = 'নিশ্চিত';

        $('prescriptionStatus').className =
            'review-status confirmed';

        $('editMetaBtn').disabled = true;
        $('editFollowUpBtn').disabled = true;

        $('medicineList')
            .querySelectorAll('.review-edit-btn')
            .forEach(btn => btn.disabled = true);

        button.textContent =
            'ইতোমধ্যে সংরক্ষিত ও Confirm হয়েছে';

        showReviewMessage(
            'confirmMessage',
            'প্রেসক্রিপশনের সব পরিবর্তন সংরক্ষিত হয়েছে এবং প্রেসক্রিপশন Confirm করা হয়েছে।',
            'success'
        );

    } catch (error) {
        console.error(error);

        showReviewMessage(
            'confirmMessage',
            error.message || 'প্রেসক্রিপশন সংরক্ষণ করা যায়নি।',
            'error'
        );

        button.disabled = false;
    }
});


// --------------------------------------------------
// Initial Load
// --------------------------------------------------

loadPrescription();
@endpush
