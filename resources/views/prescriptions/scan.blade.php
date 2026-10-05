@extends('layouts.app')

@section('title', 'প্রেসক্রিপশন স্ক্যান - খেয়াল')
@section('page-title', 'প্রেসক্রিপশন স্ক্যান')

@section('content')

<style>
    .prescription-page {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .prescription-heading {
        margin-bottom: 2px;
    }

    .prescription-heading h2 {
        margin: 0;
        font-family: 'Noto Serif Bengali', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--ink);
    }

    .prescription-heading p {
        margin: 6px 0 0;
        color: var(--muted);
        font-size: 14px;
        line-height: 1.7;
    }

    .scan-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.3fr) minmax(280px, .7fr);
        gap: 18px;
    }

    .scan-card,
    .guide-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(15, 27, 61, .06);
    }

    .scan-card {
        padding: 22px;
    }

    .guide-card {
        padding: 22px;
    }

    /* HEADER */

    .card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .card-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: rgba(255, 92, 92, .10);
        color: var(--coral);
        flex-shrink: 0;
    }

    .card-icon svg {
        width: 23px;
        height: 23px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .card-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--ink);
    }

    .card-subtitle {
        margin-top: 2px;
        font-size: 12px;
        color: var(--muted);
    }

    /* FIELD */

    .field {
        margin-bottom: 18px;
    }

    .field label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: var(--ink);
    }

    .patient-select {
        width: 100%;
        height: 46px;
        padding: 0 13px;
        border: 1px solid var(--line);
        border-radius: 11px;
        background: #fff;
        color: var(--ink);
        font-size: 14px;
        outline: none;
    }

    .patient-select:focus {
        border-color: var(--coral);
        box-shadow: 0 0 0 3px rgba(255, 92, 92, .10);
    }

    /* DROPZONE */

    .file-input {
        display: none;
    }

    .drop-zone {
        min-height: 300px;
        padding: 30px;
        border: 1.5px dashed rgba(15, 27, 61, .22);
        border-radius: 16px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        cursor: pointer;
        transition: .2s ease;
    }

    .drop-zone:hover,
    .drop-zone.dragging {
        border-color: var(--coral);
        background: rgba(255, 92, 92, .04);
    }

    .upload-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 14px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        background: var(--deep-navy, #0f1b3d);
        color: #fff;
    }

    .upload-icon svg {
        width: 28px;
        height: 28px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .drop-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--ink);
    }

    .drop-text {
        margin-top: 6px;
        font-size: 13px;
        color: var(--muted);
        line-height: 1.7;
    }

    .choose-btn {
        margin-top: 15px;
        height: 42px;
        padding: 0 18px;
        border: 0;
        border-radius: 10px;
        background: var(--coral);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .choose-btn:hover {
        opacity: .92;
    }

    /* PREVIEW */

    .preview {
        width: 100%;
        display: none;
        align-items: center;
        gap: 18px;
        text-align: left;
    }

    .drop-zone.has-file .upload-content {
        display: none;
    }

    .drop-zone.has-file .preview {
        display: flex;
    }

    .preview img {
        width: 150px;
        height: 190px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid var(--line);
        background: #f1f5f9;
    }

    .file-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--ink);
        overflow-wrap: anywhere;
    }

    .file-info {
        margin-top: 5px;
        font-size: 12px;
        color: var(--muted);
    }

    .change-btn {
        margin-top: 13px;
        height: 37px;
        padding: 0 13px;
        border: 1px solid var(--line);
        border-radius: 9px;
        background: #fff;
        color: var(--ink);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    /* MESSAGE */

    .message {
        display: none;
        margin-top: 14px;
        padding: 11px 13px;
        border-radius: 10px;
        font-size: 12px;
        line-height: 1.6;
    }

    .message.error {
        display: block;
        color: #b42318;
        background: #fff1f0;
        border: 1px solid #ffd2ce;
    }

    .message.info {
        display: block;
        color: var(--ink);
        background: #f3f6fb;
        border: 1px solid var(--line);
    }

    /* ACTION */

    .scan-action {
        display: flex;
        justify-content: flex-end;
        margin-top: 18px;
    }

    .scan-btn {
        min-width: 170px;
        height: 46px;
        padding: 0 18px;
        border: 0;
        border-radius: 10px;
        background: var(--coral);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .scan-btn:disabled {
        background: #d7dce5;
        cursor: not-allowed;
    }

    /* GUIDE */

    .guide-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--ink);
    }

    .guide-list {
        display: flex;
        flex-direction: column;
        gap: 18px;
        margin-top: 20px;
    }

    .guide-item {
        display: flex;
        gap: 11px;
        align-items: flex-start;
    }

    .guide-number {
        width: 28px;
        height: 28px;
        flex: 0 0 28px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: #0f1b3d;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
    }

    .guide-item-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--ink);
    }

    .guide-item-text {
        margin-top: 2px;
        font-size: 12px;
        color: var(--muted);
        line-height: 1.65;
    }

    .safety-note {
        margin-top: 20px;
        padding: 13px 14px;
        border-radius: 11px;
        background: rgba(255, 92, 92, .07);
        border: 1px solid rgba(255, 92, 92, .16);
        color: #5e6470;
        font-size: 12px;
        line-height: 1.7;
    }

    @media (max-width: 900px) {
        .scan-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .scan-card,
        .guide-card {
            padding: 17px;
        }

        .prescription-heading h2 {
            font-size: 21px;
        }

        .drop-zone {
            min-height: 260px;
            padding: 22px;
        }

        .preview {
            flex-direction: column;
            align-items: flex-start;
        }

        .preview img {
            width: 100%;
            height: 230px;
        }

        .scan-btn {
            width: 100%;
        }
    }
</style>

<div class="prescription-page">

    <div class="prescription-heading">
        <h2>প্রেসক্রিপশন স্ক্যান করুন</h2>
        <p>
            প্রেসক্রিপশনের ছবি আপলোড করুন। পরবর্তী ধাপে ছবির তথ্য OCR ও AI-এর মাধ্যমে শনাক্ত করা হবে।
        </p>
    </div>

    <div class="scan-grid">

        <!-- LEFT -->
        <div class="scan-card">

            <div class="card-header">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                        <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                        <path d="M21 17v2a2 2 0 0 1-2 2h-2"/>
                        <path d="M7 21H5a2 2 0 0 1-2-2v-2"/>
                        <path d="M7 12h10"/>
                        <path d="M12 7v10"/>
                    </svg>
                </div>

                <div>
                    <div class="card-title">নতুন প্রেসক্রিপশন</div>
                    <div class="card-subtitle">
                        রোগী নির্বাচন করে প্রেসক্রিপশনের ছবি আপলোড করুন
                    </div>
                </div>
            </div>

            <!-- PATIENT -->
            <div class="field">
                <label for="patientSelect">রোগী নির্বাচন করুন</label>

                <select id="patientSelect" class="patient-select">
                    <option value="">রোগীর তালিকা লোড হচ্ছে...</option>
                </select>
            </div>

            <!-- FILE -->
            <input
                type="file"
                id="prescriptionFile"
                class="file-input"
                accept="image/jpeg,image/png,image/webp"
            >

            <div id="dropZone" class="drop-zone">

                <!-- Upload -->
                <div id="uploadContent" class="upload-content">

                    <div class="upload-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 16V4"/>
                            <path d="M7 9l5-5 5 5"/>
                            <path d="M5 20h14"/>
                        </svg>
                    </div>

                    <div class="drop-title">
                        প্রেসক্রিপশনের ছবি এখানে দিন
                    </div>

                    <div class="drop-text">
                        ছবি টেনে এনে ছাড়ুন অথবা নিচের বাটনে ক্লিক করুন
                        <br>
                        JPG, PNG অথবা WebP • সর্বোচ্চ ১০ MB
                    </div>

                    <button
                        type="button"
                        id="chooseFileBtn"
                        class="choose-btn"
                    >
                        ছবি নির্বাচন করুন
                    </button>

                </div>

                <!-- Preview -->
                <div id="preview" class="preview">

                    <img
                        id="previewImage"
                        alt="প্রেসক্রিপশন প্রিভিউ"
                    >

                    <div>
                        <div id="fileName" class="file-name"></div>
                        <div id="fileInfo" class="file-info"></div>

                        <button
                            type="button"
                            id="changeFileBtn"
                            class="change-btn"
                        >
                            ছবি পরিবর্তন করুন
                        </button>
                    </div>

                </div>

            </div>

            <div id="message" class="message"></div>

            <div class="scan-action">
                <button
                    type="button"
                    id="scanBtn"
                    class="scan-btn"
                    disabled
                >
                    স্ক্যান শুরু করুন
                </button>
            </div>

        </div>


        <!-- RIGHT -->
        <div class="guide-card">

            <div class="guide-title">
                কীভাবে কাজ করবে
            </div>

            <div class="guide-list">

                <div class="guide-item">
                    <div class="guide-number">১</div>

                    <div>
                        <div class="guide-item-title">
                            রোগী নির্বাচন
                        </div>

                        <div class="guide-item-text">
                            যার প্রেসক্রিপশন, প্রথমে সেই রোগী নির্বাচন করুন।
                        </div>
                    </div>
                </div>


                <div class="guide-item">
                    <div class="guide-number">২</div>

                    <div>
                        <div class="guide-item-title">
                            ছবি আপলোড
                        </div>

                        <div class="guide-item-text">
                            পরিষ্কার ও সম্পূর্ণ প্রেসক্রিপশনের ছবি আপলোড করুন।
                        </div>
                    </div>
                </div>


                <div class="guide-item">
                    <div class="guide-number">৩</div>

                    <div>
                        <div class="guide-item-title">
                            তথ্য শনাক্তকরণ
                        </div>

                        <div class="guide-item-text">
                            পরবর্তী ধাপে OCR ও AI ব্যবহার করে প্রেসক্রিপশনের তথ্য পড়া হবে।
                        </div>
                    </div>
                </div>


                <div class="guide-item">
                    <div class="guide-number">৪</div>

                    <div>
                        <div class="guide-item-title">
                            আপনার যাচাই
                        </div>

                        <div class="guide-item-text">
                            ওষুধের তথ্য নিশ্চিত করার আগে caregiver ফলাফল যাচাই ও সংশোধন করতে পারবেন।
                        </div>
                    </div>
                </div>

            </div>


            <div class="safety-note">
                প্রেসক্রিপশনের তথ্য AI দ্বারা শনাক্ত হলেও সরাসরি ওষুধের সময়সূচীতে যোগ করার আগে caregiver-এর যাচাই রাখা হবে।
            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')
<script>

    const patientSelect = document.getElementById('patientSelect');
    const fileInput = document.getElementById('prescriptionFile');

    const dropZone = document.getElementById('dropZone');

    const chooseFileBtn = document.getElementById('chooseFileBtn');
    const changeFileBtn = document.getElementById('changeFileBtn');

    const previewImage = document.getElementById('previewImage');

    const fileName = document.getElementById('fileName');
    const fileInfo = document.getElementById('fileInfo');

    const scanBtn = document.getElementById('scanBtn');
    const message = document.getElementById('message');

    let selectedFile = null;


    function showMessage(text, type = 'info') {

        message.textContent = text;

        message.className = 'message ' + type;
    }


    function clearMessage() {

        message.textContent = '';

        message.className = 'message';
    }


    function updateButton() {

        scanBtn.disabled = !(patientSelect.value && selectedFile);
    }


    function formatSize(bytes) {

        if (bytes < 1024 * 1024) {

            return Math.round(bytes / 1024) + ' KB';

        }

        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    }


    function selectFile(file) {

        clearMessage();

        if (!file) {
            return;
        }


        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];


        if (!allowedTypes.includes(file.type)) {

            showMessage(
                'শুধু JPG, PNG অথবা WebP ছবি নির্বাচন করুন।',
                'error'
            );

            return;
        }


        if (file.size > 10 * 1024 * 1024) {

            showMessage(
                'ছবির আকার ১০ MB-এর বেশি হতে পারবে না।',
                'error'
            );

            return;
        }


        selectedFile = file;


        previewImage.src = URL.createObjectURL(file);


        fileName.textContent = file.name;

        fileInfo.textContent =
            file.type.split('/')[1].toUpperCase()
            + ' • '
            + formatSize(file.size);


        dropZone.classList.add('has-file');

        updateButton();
    }


    function resetFile() {

        selectedFile = null;

        fileInput.value = '';

        previewImage.removeAttribute('src');

        dropZone.classList.remove('has-file');

        clearMessage();

        updateButton();
    }


    /* Choose file */

    chooseFileBtn.addEventListener('click', function(event) {

        event.stopPropagation();

        fileInput.click();

    });


    /* Change file */

    changeFileBtn.addEventListener('click', function(event) {

        event.stopPropagation();

        fileInput.click();

    });


    /* Dropzone click */

    dropZone.addEventListener('click', function(event) {

        if (event.target.closest('#changeFileBtn')) {
            return;
        }

        if (!selectedFile) {
            fileInput.click();
        }

    });


    /* File selected */

    fileInput.addEventListener('change', function() {

        selectFile(this.files[0]);

    });


    /* Drag */

    ['dragenter', 'dragover'].forEach(function(eventName) {

        dropZone.addEventListener(eventName, function(event) {

            event.preventDefault();

            if (!selectedFile) {
                dropZone.classList.add('dragging');
            }

        });

    });


    ['dragleave', 'drop'].forEach(function(eventName) {

        dropZone.addEventListener(eventName, function(event) {

            event.preventDefault();

            dropZone.classList.remove('dragging');

        });

    });


    dropZone.addEventListener('drop', function(event) {

        if (!selectedFile) {

            selectFile(
                event.dataTransfer.files[0]
            );

        }

    });


    /* Patient */

    patientSelect.addEventListener('change', function() {

        clearMessage();

        updateButton();

    });


    /* Scan */

    scanBtn.addEventListener('click', function() {

        showMessage(
            'প্রেসক্রিপশনের ছবি প্রস্তুত হয়েছে। OCR ও AI processing backend এখনো সংযুক্ত করা হয়নি।',
            'info'
        );

    });


    /* Load patients */

    async function loadPatients() {

        try {

            const response = await apiFetch('/patients');

            if (!response || !response.ok) {

                patientSelect.innerHTML =
                    '<option value="">রোগীর তালিকা লোড করা যায়নি</option>';

                return;
            }


            const patients = await response.json();

            patientSelect.innerHTML = '';


            if (!patients.length) {

                patientSelect.innerHTML =
                    '<option value="">আগে একজন রোগী যোগ করুন</option>';

                return;
            }


            patientSelect.innerHTML =
                '<option value="">রোগী নির্বাচন করুন</option>';


            patients.forEach(function(patient) {

                const option =
                    document.createElement('option');

                option.value = patient.id;

                option.textContent = patient.name;

                patientSelect.appendChild(option);

            });


            updateButton();

        } catch (error) {

            patientSelect.innerHTML =
                '<option value="">রোগীর তালিকা লোড করা যায়নি</option>';

        }

    }


    loadPatients();

</script>
@endpush