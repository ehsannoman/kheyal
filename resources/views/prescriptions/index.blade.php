
@extends('layouts.app')

@section('title', 'প্রেসক্রিপশনসমূহ - খেয়াল')
@section('page-title', 'প্রেসক্রিপশনসমূহ')

@section('content')
<style>
    .prescriptions-page{display:flex;flex-direction:column;gap:20px}
    .prescriptions-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:18px}
    .prescriptions-heading h2{margin:0;font-family:'Noto Serif Bengali',sans-serif;font-size:24px;font-weight:700;color:var(--ink)}
    .prescriptions-heading p{margin:6px 0 0;color:var(--muted);font-size:14px;line-height:1.7}
    .scan-new-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;height:42px;padding:0 16px;border:0;border-radius:10px;background:var(--coral);color:#fff;font-size:13px;font-weight:700;text-decoration:none;white-space:nowrap;transition:.2s}
    .scan-new-btn:hover{opacity:.92;transform:translateY(-1px)}
    .scan-new-btn svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}

    .prescription-stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}
    .prescription-stat{display:flex;align-items:center;gap:13px;padding:17px;background:#fff;border:1px solid var(--line);border-radius:15px;box-shadow:0 8px 22px rgba(15,27,61,.05)}
    .stat-icon{width:42px;height:42px;flex:0 0 42px;display:grid;place-items:center;border-radius:11px;background:rgba(255,92,92,.09);color:var(--coral)}
    .stat-icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
    .stat-label{color:var(--muted);font-size:12px}
    .stat-value{margin-top:2px;color:var(--ink);font-size:21px;font-weight:700}

    .prescription-card{overflow:hidden;background:#fff;border:1px solid var(--line);border-radius:18px;box-shadow:0 10px 28px rgba(15,27,61,.06)}
    .prescription-card-header{display:flex;align-items:center;justify-content:space-between;gap:15px;padding:19px 20px;border-bottom:1px solid var(--line)}
    .card-heading{display:flex;align-items:center;gap:11px}
    .card-heading-icon{width:40px;height:40px;display:grid;place-items:center;border-radius:10px;background:#0f1b3d;color:#fff}
    .card-heading-icon svg{width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
    .card-heading-title{color:var(--ink);font-size:15px;font-weight:700}
    .card-heading-subtitle{margin-top:2px;color:var(--muted);font-size:12px}

    .filter-area{display:flex;align-items:center;gap:10px}
    .search-box{position:relative}
    .search-box svg{position:absolute;left:11px;top:50%;width:16px;height:16px;transform:translateY(-50%);fill:none;stroke:var(--muted);stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;pointer-events:none}
    .search-input{width:220px;height:38px;padding:0 11px 0 35px;border:1px solid var(--line);border-radius:9px;outline:none;background:#fff;color:var(--ink);font-size:12px}
    .search-input:focus{border-color:var(--coral);box-shadow:0 0 0 3px rgba(255,92,92,.08)}

    .empty-state{display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:390px;padding:45px 20px;text-align:center}
    .empty-icon{width:78px;height:78px;display:grid;place-items:center;border-radius:22px;background:#f1f4f8;color:#0f1b3d}
    .empty-icon svg{width:38px;height:38px;fill:none;stroke:currentColor;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round}
    .empty-title{margin-top:19px;color:var(--ink);font-size:17px;font-weight:700}
    .empty-text{max-width:430px;margin-top:7px;color:var(--muted);font-size:13px;line-height:1.8}
    .empty-action{margin-top:18px;display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 17px;border-radius:10px;background:#0f1b3d;color:#fff;text-decoration:none;font-size:13px;font-weight:700;transition:.2s}
    .empty-action:hover{background:var(--coral)}
    .empty-action svg{width:17px;height:17px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}

    .prescription-table-wrapper{display:none;overflow-x:auto}
    .prescription-table{width:100%;border-collapse:collapse;min-width:760px}
    .prescription-table th{padding:13px 18px;text-align:left;background:#f8fafc;color:var(--muted);font-size:11px;font-weight:700;white-space:nowrap}
    .prescription-table td{padding:15px 18px;border-top:1px solid var(--line);color:var(--ink);font-size:12px;vertical-align:middle}
    .prescription-table tbody tr:hover{background:#fafbfd}
    .patient-name{font-weight:700}
    .date-text{color:var(--muted)}
    .status-badge{display:inline-flex;align-items:center;height:26px;padding:0 9px;border-radius:999px;font-size:10px;font-weight:700}
    .status-pending{background:#fff4df;color:#9a6700}
    .status-confirmed{background:#eaf7ef;color:#19703b}
    .status-processing{background:#eaf1ff;color:#2454a6}
    .status-failed{background:#fff0f0;color:#b42318}
    .action-group{display:flex;align-items:center;gap:6px}
    .view-btn{display:inline-flex;align-items:center;justify-content:center;height:32px;padding:0 10px;border:1px solid var(--line);border-radius:8px;background:#fff;color:var(--ink);font-size:11px;font-weight:600;white-space:nowrap;cursor:pointer;transition:.15s}
    .view-btn:hover{border-color:var(--coral);color:var(--coral)}
    .delete-btn{color:var(--coral)}
    .view-btn:disabled{opacity:.55;cursor:wait}

    /* Modals */
    .prescription-modal{position:fixed;inset:0;z-index:1000;display:none;align-items:center;justify-content:center;padding:20px}
    .prescription-modal-backdrop{position:absolute;inset:0;background:rgba(15,27,61,.58)}
    .prescription-modal-panel{position:relative;z-index:1;width:100%;max-width:650px;max-height:90vh;overflow-y:auto;background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 24px 70px rgba(15,27,61,.22)}
    .prescription-modal-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;padding:20px 22px;border-bottom:1px solid var(--line)}
    .prescription-modal-header h3{margin:0;color:var(--ink);font-size:18px;font-weight:700}
    .prescription-modal-header p{margin:5px 0 0;color:var(--muted);font-size:12px}
    .modal-close-btn{width:34px;height:34px;flex:0 0 34px;border:1px solid var(--line);border-radius:9px;background:#fff;color:var(--ink);font-size:24px;line-height:1;cursor:pointer}
    .modal-close-btn:hover{border-color:var(--coral);color:var(--coral)}
    .prescription-modal-body{display:flex;flex-direction:column;gap:16px;padding:22px}
    .prescription-form-field{display:flex;flex-direction:column;gap:7px}
    .prescription-form-field label{color:var(--ink);font-size:13px;font-weight:600}
    .prescription-form-field input,.prescription-form-field textarea{width:100%;box-sizing:border-box;padding:11px 12px;border:1px solid var(--line);border-radius:9px;outline:none;background:#fff;color:var(--ink);font:inherit;font-size:13px}
    .prescription-form-field input:focus,.prescription-form-field textarea:focus{border-color:var(--coral);box-shadow:0 0 0 3px rgba(255,92,92,.08)}
    .prescription-form-field textarea{resize:vertical}
    .prescription-modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:4px}
    .modal-primary-btn,.modal-secondary-btn{min-height:40px;padding:0 16px;border-radius:9px;font-size:12px;font-weight:700;cursor:pointer}
    .modal-primary-btn{border:1px solid var(--coral);background:var(--coral);color:#fff}
    .modal-primary-btn:disabled{opacity:.6;cursor:wait}
    .modal-secondary-btn{border:1px solid var(--line);background:#fff;color:var(--ink)}
    .prescription-modal-message{margin:0;color:var(--coral);font-size:12px;line-height:1.7}
    .prescription-detail-image{display:block;width:100%;max-height:420px;object-fit:contain;border:1px solid var(--line);border-radius:10px;background:#f8fafc}
    .prescription-detail-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
    .prescription-detail-item{min-width:0;padding:12px;border:1px solid var(--line);border-radius:10px}
    .prescription-detail-label{color:var(--muted);font-size:11px}
    .prescription-detail-value{margin-top:5px;color:var(--ink);font-size:13px;font-weight:600;overflow-wrap:anywhere;white-space:pre-wrap}
    .prescription-loading{padding:20px;color:var(--muted);font-size:13px;text-align:center}

    @media(max-width:850px){
        .prescriptions-heading{align-items:flex-start;flex-direction:column}
        .prescription-stats{grid-template-columns:1fr}
        .prescription-card-header{align-items:flex-start;flex-direction:column}
        .filter-area,.search-box,.search-input{width:100%}
    }
    @media(max-width:600px){
        .prescriptions-heading h2{font-size:21px}
        .scan-new-btn{width:100%}
        .prescription-card-header{padding:16px}
        .empty-state{min-height:330px}
        .prescription-modal{padding:10px}
        .prescription-modal-header,.prescription-modal-body{padding:16px}
        .prescription-detail-grid{grid-template-columns:1fr}
        .prescription-modal-actions{flex-wrap:wrap}
    }
</style>

<div class="prescriptions-page">
    <div class="prescriptions-heading">
        <div>
            <h2>প্রেসক্রিপশনসমূহ</h2>
            <p>আপনার রোগীদের সংরক্ষিত প্রেসক্রিপশনগুলো এখান থেকে দেখুন ও পরিচালনা করুন।</p>
        </div>
        <a href="/prescriptions/scan" class="scan-new-btn">
            <svg viewBox="0 0 24 24"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
            নতুন প্রেসক্রিপশন
        </a>
    </div>

    <div class="prescription-stats">
        <div class="prescription-stat">
            <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M6 2h9l4 4v16H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/><path d="M14 2v5h5"/><path d="M8 11h8"/><path d="M8 15h8"/><path d="M8 19h5"/></svg></div>
            <div><div class="stat-label">মোট প্রেসক্রিপশন</div><div class="stat-value" id="totalPrescriptions">০</div></div>
        </div>
        <div class="prescription-stat">
            <div class="stat-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
            <div><div class="stat-label">পর্যালোচনার অপেক্ষায়</div><div class="stat-value" id="pendingPrescriptions">০</div></div>
        </div>
        <div class="prescription-stat">
            <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></div>
            <div><div class="stat-label">নিশ্চিত করা হয়েছে</div><div class="stat-value" id="confirmedPrescriptions">০</div></div>
        </div>
    </div>

    <div class="prescription-card">
        <div class="prescription-card-header">
            <div class="card-heading">
                <div class="card-heading-icon"><svg viewBox="0 0 24 24"><path d="M6 2h9l4 4v16H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/><path d="M14 2v5h5"/><path d="M8 11h8"/><path d="M8 15h8"/></svg></div>
                <div>
                    <div class="card-heading-title">সকল প্রেসক্রিপশন</div>
                    <div class="card-heading-subtitle">রোগী অনুযায়ী প্রেসক্রিপশনের তালিকা</div>
                </div>
            </div>
            <div class="filter-area">
                <div class="search-box">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
                    <input type="text" id="prescriptionSearch" class="search-input" placeholder="প্রেসক্রিপশন খুঁজুন...">
                </div>
            </div>
        </div>

        <div id="prescriptionTableWrapper" class="prescription-table-wrapper">
            <table class="prescription-table">
                <thead><tr><th>রোগী</th><th>ডাক্তার</th><th>প্রেসক্রিপশন তারিখ</th><th>আপলোডের তারিখ</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr></thead>
                <tbody id="prescriptionTableBody"></tbody>
            </table>
        </div>

        <div id="emptyState" class="empty-state">
            <div class="empty-icon"><svg viewBox="0 0 24 24"><path d="M6 2h9l4 4v16H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/><path d="M14 2v5h5"/><path d="M8 12h8"/><path d="M8 16h5"/></svg></div>
            <div class="empty-title">এখনো কোনো প্রেসক্রিপশন নেই</div>
            <div class="empty-text">কোনো রোগীর প্রেসক্রিপশন এখনো সংরক্ষণ করা হয়নি। নতুন প্রেসক্রিপশন স্ক্যান করে এখান থেকে দেখতে পারবেন।</div>
            <a href="/prescriptions/scan" class="empty-action"><svg viewBox="0 0 24 24"><path d="M12 5v14"/><path d="M5 12h14"/></svg>প্রেসক্রিপশন স্ক্যান করুন</a>
        </div>
    </div>
</div>

<!-- DETAILS MODAL -->
<div id="prescriptionDetailsModal" class="prescription-modal">
    <div class="prescription-modal-backdrop" data-close-modal></div>
    <section class="prescription-modal-panel" role="dialog" aria-modal="true" aria-labelledby="detailsModalTitle">
        <div class="prescription-modal-header">
            <div><h3 id="detailsModalTitle">প্রেসক্রিপশনের বিস্তারিত</h3><p>সংরক্ষিত তথ্য ও প্রেসক্রিপশনের ছবি</p></div>
            <button type="button" class="modal-close-btn" data-close-modal aria-label="বন্ধ করুন">&times;</button>
        </div>
        <div id="prescriptionDetailsContent" class="prescription-modal-body">
            <div class="prescription-loading">বিস্তারিত লোড হচ্ছে...</div>
        </div>
    </section>
</div>

<!-- EDIT MODAL -->
<div id="prescriptionEditModal" class="prescription-modal">
    <div class="prescription-modal-backdrop" data-close-modal></div>
    <section class="prescription-modal-panel" role="dialog" aria-modal="true" aria-labelledby="editModalTitle">
        <div class="prescription-modal-header">
            <div><h3 id="editModalTitle">প্রেসক্রিপশন সম্পাদনা</h3><p>প্রেসক্রিপশনের তথ্য পরিবর্তন করুন</p></div>
            <button type="button" class="modal-close-btn" data-close-modal aria-label="বন্ধ করুন">&times;</button>
        </div>
        <form id="prescriptionEditForm" class="prescription-modal-body">
            <input type="hidden" id="editPrescriptionId">
            <div class="prescription-form-field"><label for="editDoctorName">ডাক্তারের নাম</label><input type="text" id="editDoctorName" maxlength="255" placeholder="ডাক্তারের নাম লিখুন"></div>
            <div class="prescription-form-field"><label for="editPrescriptionDate">প্রেসক্রিপশনের তারিখ</label><input type="date" id="editPrescriptionDate"></div>
            <div class="prescription-form-field"><label for="editFollowUpDate">পরবর্তী সাক্ষাতের তারিখ</label><input type="date" id="editFollowUpDate"></div>
            <div class="prescription-form-field"><label for="editPrescriptionNotes">নোট</label><textarea id="editPrescriptionNotes" rows="4" maxlength="5000" placeholder="প্রয়োজনীয় তথ্য লিখুন"></textarea></div>
            <p id="prescriptionEditMessage" class="prescription-modal-message" role="status"></p>
            <div class="prescription-modal-actions">
                <button type="button" class="modal-secondary-btn" data-close-modal>বাতিল</button>
                <button type="submit" id="savePrescriptionButton" class="modal-primary-btn">পরিবর্তন সংরক্ষণ</button>
            </div>
        </form>
    </section>
</div>
@endsection

@push('scripts')
const searchInput = document.getElementById('prescriptionSearch');
const tableWrapper = document.getElementById('prescriptionTableWrapper');
const tableBody = document.getElementById('prescriptionTableBody');
const emptyState = document.getElementById('emptyState');
const emptyTitle = emptyState.querySelector('.empty-title');
const emptyText = emptyState.querySelector('.empty-text');

const totalPrescriptions = document.getElementById('totalPrescriptions');
const pendingPrescriptions = document.getElementById('pendingPrescriptions');
const confirmedPrescriptions = document.getElementById('confirmedPrescriptions');

const detailsModal = document.getElementById('prescriptionDetailsModal');
const detailsContent = document.getElementById('prescriptionDetailsContent');
const editModal = document.getElementById('prescriptionEditModal');
const editForm = document.getElementById('prescriptionEditForm');
const editMessage = document.getElementById('prescriptionEditMessage');
const saveButton = document.getElementById('savePrescriptionButton');

let allPrescriptions = [];
let currentImageUrl = null;

const statusLabels = {
    pending: 'অপেক্ষমাণ',
    processing: 'প্রক্রিয়াধীন',
    confirmed: 'নিশ্চিত',
    failed: 'ব্যর্থ'
};

function formatDate(value) {
    if (!value) return '—';
    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return '—';
    return date.toLocaleDateString('bn-BD', {
        day: 'numeric', month: 'short', year: 'numeric'
    });
}

function setEmptyState(title, message) {
    tableWrapper.style.display = 'none';
    emptyState.style.display = 'flex';
    emptyTitle.textContent = title;
    emptyText.textContent = message;
}

function updateStats(items) {
    totalPrescriptions.textContent = items.length.toLocaleString('bn-BD');
    pendingPrescriptions.textContent = items.filter(x => x.status === 'pending').length.toLocaleString('bn-BD');
    confirmedPrescriptions.textContent = items.filter(x => x.status === 'confirmed').length.toLocaleString('bn-BD');
}

function createCell(text, className = '') {
    const td = document.createElement('td');
    if (className) {
        const span = document.createElement('span');
        span.className = className;
        span.textContent = text ?? '—';
        td.appendChild(span);
    } else {
        td.textContent = text ?? '—';
    }
    return td;
}

function renderPrescriptions(items) {
    tableBody.replaceChildren();

    if (!items.length) {
        setEmptyState(
            allPrescriptions.length === 0 ? 'এখনো কোনো প্রেসক্রিপশন নেই' : 'কোনো মিল পাওয়া যায়নি',
            allPrescriptions.length === 0
                ? 'নতুন প্রেসক্রিপশন স্ক্যান করে সংরক্ষণ করলে এখানে দেখতে পারবেন।'
                : 'অন্য নাম বা শব্দ দিয়ে আবার খুঁজে দেখুন।'
        );
        return;
    }

    emptyState.style.display = 'none';
    tableWrapper.style.display = 'block';

    items.forEach(prescription => {
        const row = document.createElement('tr');
        const patientCell = document.createElement('td');
        const patientName = document.createElement('div');

        patientName.className = 'patient-name';
        patientName.textContent = prescription.patient?.name ?? '—';
        patientCell.appendChild(patientName);
        row.appendChild(patientCell);

        row.appendChild(createCell(prescription.doctor_name));
        row.appendChild(createCell(formatDate(prescription.prescription_date), 'date-text'));
        row.appendChild(createCell(formatDate(prescription.created_at), 'date-text'));

        const statusCell = document.createElement('td');
        const badge = document.createElement('span');
        const status = prescription.status ?? 'pending';

        badge.className = 'status-badge';
        badge.textContent = statusLabels[status] ?? status;
        badge.classList.add(
            status === 'confirmed' ? 'status-confirmed' :
            status === 'processing' ? 'status-processing' :
            status === 'failed' ? 'status-failed' : 'status-pending'
        );

        statusCell.appendChild(badge);
        row.appendChild(statusCell);

        const actionCell = document.createElement('td');
        const group = document.createElement('div');
        group.className = 'action-group';

        const viewButton = document.createElement('button');
        viewButton.type = 'button';
        viewButton.className = 'view-btn';
        viewButton.textContent = 'বিস্তারিত';
        viewButton.addEventListener('click', () => openPrescriptionDetails(prescription.id));

        const editButton = document.createElement('button');
        editButton.type = 'button';
        editButton.className = 'view-btn';
        editButton.textContent = 'সম্পাদনা';
        editButton.addEventListener('click', () => openPrescriptionEdit(prescription.id));

        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'view-btn delete-btn';
        deleteButton.textContent = 'মুছুন';
        deleteButton.addEventListener('click', () => deletePrescription(prescription.id));

        group.append(viewButton, editButton, deleteButton);
        actionCell.appendChild(group);
        row.appendChild(actionCell);
        tableBody.appendChild(row);
    });
}

function applySearch() {
    const term = searchInput.value.trim().toLocaleLowerCase();

    const filtered = allPrescriptions.filter(item => {
        const text = [
            item.patient?.name, item.doctor_name, item.status,
            statusLabels[item.status], item.prescription_date, item.created_at
        ].filter(Boolean).join(' ').toLocaleLowerCase();

        return text.includes(term);
    });

    renderPrescriptions(filtered);
}

async function loadPrescriptions() {
    setEmptyState('লোড হচ্ছে...', 'প্রেসক্রিপশনের তালিকা আনা হচ্ছে।');

    try {
        const response = await apiFetch('/prescriptions');

        if (!response || !response.ok) {
            throw new Error(`HTTP error: ${response?.status ?? 'unknown'}`);
        }

        const data = await response.json();
        allPrescriptions = Array.isArray(data.prescriptions) ? data.prescriptions : [];

        updateStats(allPrescriptions);
        applySearch();
    } catch (error) {
        console.error('Prescription loading failed:', error);
        setEmptyState('প্রেসক্রিপশন লোড করা যায়নি', 'ইন্টারনেট বা লগইন পরীক্ষা করে পেজটি আবার রিফ্রেশ করুন।');
    }
}

function openModal(modal) {
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal(modal) {
    modal.style.display = 'none';

    if (detailsModal.style.display === 'none' && editModal.style.display === 'none') {
        document.body.style.overflow = '';
    }

    if (modal === detailsModal && currentImageUrl) {
        URL.revokeObjectURL(currentImageUrl);
        currentImageUrl = null;
    }
}

document.querySelectorAll('[data-close-modal]').forEach(button => {
    button.addEventListener('click', () => {
        closeModal(detailsModal);
        closeModal(editModal);
    });
});

document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
        closeModal(detailsModal);
        closeModal(editModal);
    }
});

function detailItem(label, value) {
    const item = document.createElement('div');
    item.className = 'prescription-detail-item';

    const heading = document.createElement('div');
    heading.className = 'prescription-detail-label';
    heading.textContent = label;

    const content = document.createElement('div');
    content.className = 'prescription-detail-value';
    content.textContent = value || '—';

    item.append(heading, content);
    return item;
}

async function openPrescriptionDetails(id) {
    closeModal(editModal);
    closeModal(detailsModal);

    detailsContent.replaceChildren();
    const loading = document.createElement('div');
    loading.className = 'prescription-loading';
    loading.textContent = 'বিস্তারিত লোড হচ্ছে...';
    detailsContent.appendChild(loading);
    openModal(detailsModal);

    try {
        const response = await apiFetch(`/prescriptions/${id}`);

        if (!response || !response.ok) {
            throw new Error('প্রেসক্রিপশনের তথ্য পাওয়া যায়নি।');
        }

        const data = await response.json();
        const prescription = data.prescription;

        if (!prescription) throw new Error('প্রেসক্রিপশনের তথ্য পাওয়া যায়নি।');

        detailsContent.replaceChildren();

        const imageLoading = document.createElement('div');
        imageLoading.className = 'prescription-loading';
        imageLoading.textContent = 'ছবি লোড হচ্ছে...';
        detailsContent.appendChild(imageLoading);

        try {
            const imageResponse = await apiFetch(`/prescriptions/${id}/image`);

            if (imageResponse && imageResponse.ok) {
                const blob = await imageResponse.blob();
                currentImageUrl = URL.createObjectURL(blob);

                const image = document.createElement('img');
                image.className = 'prescription-detail-image';
                image.alt = 'প্রেসক্রিপশনের ছবি';
                image.src = currentImageUrl;

                imageLoading.replaceWith(image);
            } else {
                imageLoading.textContent = 'প্রেসক্রিপশনের ছবি পাওয়া যায়নি।';
            }
        } catch (imageError) {
            console.error('Prescription image loading failed:', imageError);
            imageLoading.textContent = 'প্রেসক্রিপশনের ছবি লোড করা যায়নি।';
        }

        const grid = document.createElement('div');
        grid.className = 'prescription-detail-grid';

        grid.append(
            detailItem('রোগী', prescription.patient?.name),
            detailItem('ডাক্তারের নাম', prescription.doctor_name),
            detailItem('প্রেসক্রিপশনের তারিখ', formatDate(prescription.prescription_date)),
            detailItem('পরবর্তী সাক্ষাতের তারিখ', formatDate(prescription.follow_up_date)),
            detailItem('স্ট্যাটাস', statusLabels[prescription.status] || prescription.status),
            detailItem('আপলোডের তারিখ', formatDate(prescription.created_at)),
            detailItem('নোট', prescription.notes)
        );

        detailsContent.appendChild(grid);
    } catch (error) {
        console.error(error);
        detailsContent.replaceChildren();

        const message = document.createElement('p');
        message.className = 'prescription-modal-message';
        message.textContent = error.message || 'প্রেসক্রিপশনের বিস্তারিত লোড করা যায়নি।';
        detailsContent.appendChild(message);
    }
}

async function openPrescriptionEdit(id) {
    closeModal(detailsModal);
    closeModal(editModal);

    editForm.reset();
    editMessage.textContent = '';
    document.getElementById('editPrescriptionId').value = id;
    saveButton.disabled = true;
    openModal(editModal);

    try {
        const response = await apiFetch(`/prescriptions/${id}`);

        if (!response || !response.ok) {
            throw new Error('প্রেসক্রিপশনের তথ্য লোড করা যায়নি।');
        }

        const data = await response.json();
        const prescription = data.prescription;

        if (!prescription) throw new Error('প্রেসক্রিপশনের তথ্য পাওয়া যায়নি।');

        document.getElementById('editDoctorName').value = prescription.doctor_name || '';
        document.getElementById('editPrescriptionDate').value = prescription.prescription_date?.slice(0, 10) || '';
        document.getElementById('editFollowUpDate').value = prescription.follow_up_date?.slice(0, 10) || '';
        document.getElementById('editPrescriptionNotes').value = prescription.notes || '';
    } catch (error) {
        console.error(error);
        editMessage.textContent = error.message || 'তথ্য লোড করা যায়নি।';
    } finally {
        saveButton.disabled = false;
    }
}

editForm.addEventListener('submit', async event => {
    event.preventDefault();

    const id = document.getElementById('editPrescriptionId').value;

    const payload = {
        doctor_name: document.getElementById('editDoctorName').value.trim() || null,
        prescription_date: document.getElementById('editPrescriptionDate').value || null,
        follow_up_date: document.getElementById('editFollowUpDate').value || null,
        notes: document.getElementById('editPrescriptionNotes').value.trim() || null
    };

    saveButton.disabled = true;
    editMessage.textContent = 'পরিবর্তন সংরক্ষণ হচ্ছে...';

    try {
        const response = await apiFetch(`/prescriptions/${id}`, {
            method: 'PUT',
            body: JSON.stringify(payload)
        });

        if (!response || !response.ok) {
            const errorData = response ? await response.json().catch(() => ({})) : {};
            const validationMessage = errorData.errors
                ? Object.values(errorData.errors).flat().join(' ')
                : '';

            throw new Error(validationMessage || errorData.message || 'তথ্য সংরক্ষণ করা যায়নি।');
        }

        await loadPrescriptions();
        closeModal(editModal);
    } catch (error) {
        console.error(error);
        editMessage.textContent = error.message || 'একটি সমস্যা হয়েছে।';
    } finally {
        saveButton.disabled = false;
    }
});

async function deletePrescription(id) {
    if (!window.confirm('আপনি কি এই প্রেসক্রিপশনটি মুছে ফেলতে চান? এই কাজটি ফিরিয়ে আনা যাবে না।')) {
        return;
    }

    try {
        const response = await apiFetch(`/prescriptions/${id}`, {
            method: 'DELETE'
        });

        if (!response || !response.ok) {
            const errorData = response ? await response.json().catch(() => ({})) : {};
            throw new Error(errorData.message || 'প্রেসক্রিপশন মুছে ফেলা যায়নি।');
        }

        allPrescriptions = allPrescriptions.filter(item => String(item.id) !== String(id));
        updateStats(allPrescriptions);
        applySearch();

        window.alert('প্রেসক্রিপশন সফলভাবে মুছে ফেলা হয়েছে।');
    } catch (error) {
        console.error(error);
        window.alert(error.message || 'একটি সমস্যা হয়েছে। আবার চেষ্টা করুন।');
    }
}

searchInput.addEventListener('input', applySearch);
loadPrescriptions();
@endpush
