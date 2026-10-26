
@extends('layouts.app')

@section('title', 'ভাইটালস ও স্বাস্থ্য | খেয়াল')
@section('page-title', 'ভাইটালস ও স্বাস্থ্য')

@push('styles')
<style>
    .vh-page {
        display: grid;
        gap: 22px;
        color: var(--ink, #1e293b);
    }

    .vh-intro {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 18px;
    }

    .vh-title {
        margin: 0;
        color: var(--navy-900, #0f1b3d);
        font-size: 1.5rem;
        font-weight: 800;
    }

    .vh-subtitle {
        margin: 7px 0 0;
        color: var(--muted, #64748b);
        font-size: .9rem;
        line-height: 1.7;
    }

    .vh-patient-box {
        min-width: 240px;
    }

    .vh-patient-box label,
    .vh-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--ink, #1e293b);
        font-size: .84rem;
        font-weight: 700;
    }

    .vh-patient-select,
    .vh-field input,
    .vh-field select,
    .vh-field textarea {
        width: 100%;
        min-height: 44px;
        padding: 10px 12px;
        border: 1px solid var(--line, #e2e8f0);
        border-radius: 10px;
        background: #fff;
        color: var(--ink, #1e293b);
        font: inherit;
        font-size: .88rem;
        outline: none;
    }

    .vh-patient-select:focus,
    .vh-field input:focus,
    .vh-field select:focus,
    .vh-field textarea:focus {
        border-color: #ff5c5c;
        box-shadow: 0 0 0 3px rgba(255, 92, 92, .12);
    }

    .vh-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 16px 18px;
        border: 1px solid #e7eaf1;
        border-radius: 14px;
        background: #fff;
    }

    .vh-toolbar-title {
        margin: 0;
        color: #0f1b3d;
        font-size: .95rem;
        font-weight: 750;
    }

    .vh-toolbar-subtitle {
        margin: 5px 0 0;
        color: #758095;
        font-size: .8rem;
    }

    .vh-toolbar-actions {
        display: flex;
        gap: 9px;
        flex-wrap: wrap;
    }

    .vh-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 41px;
        padding: 0 14px;
        border: 1px solid transparent;
        border-radius: 10px;
        font: inherit;
        font-size: .83rem;
        font-weight: 750;
        cursor: pointer;
        transition: .18s ease;
    }

    .vh-btn svg,
    .vh-mini-btn svg {
        width: 17px;
        height: 17px;
        flex: 0 0 auto;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .vh-btn-primary {
        background: #ff5c5c;
        color: #fff;
    }

    .vh-btn-primary:hover {
        background: #ed4d4d;
        transform: translateY(-1px);
    }

    .vh-btn-secondary {
        border-color: #e1e6ef;
        background: #fff;
        color: #0f1b3d;
    }

    .vh-btn-secondary:hover {
        border-color: #ffb5ae;
        background: #fff7f6;
    }

    .vh-btn:disabled {
        cursor: not-allowed;
        opacity: .6;
        transform: none;
    }

    .vh-section {
        min-width: 0;
        padding: 21px;
        border: 1px solid #e7eaf1;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 4px 18px rgba(15, 27, 61, .035);
    }

    .vh-section-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .vh-section-title {
        margin: 0;
        color: #0f1b3d;
        font-size: 1.02rem;
        font-weight: 800;
    }

    .vh-section-description {
        margin: 5px 0 0;
        color: #778195;
        font-size: .82rem;
        line-height: 1.65;
    }

    .vh-vitals-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .vh-vital-card {
        min-width: 0;
        padding: 17px;
        border: 1px solid #e8edf4;
        border-radius: 13px;
        background: #fff;
        transition: border-color .18s, transform .18s;
    }

    .vh-vital-card:hover {
        border-color: #ffc5bf;
        transform: translateY(-2px);
    }

    .vh-vital-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .vh-vital-label {
        color: #586579;
        font-size: .83rem;
        font-weight: 650;
    }

    .vh-vital-icon {
        display: grid;
        place-items: center;
        width: 41px;
        height: 41px;
        flex: 0 0 41px;
        border-radius: 12px;
        background: #fff0ee;
        color: #ff5c5c;
    }

    .vh-vital-icon svg {
        width: 23px;
        height: 23px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .vh-vital-value {
        margin-top: 15px;
        color: #0f1b3d;
        font-size: clamp(1.4rem, 2vw, 1.8rem);
        font-weight: 850;
        overflow-wrap: anywhere;
    }

    .vh-vital-unit {
        margin-left: 4px;
        color: #758095;
        font-size: .77rem;
        font-weight: 550;
    }

    .vh-vital-meta {
        margin-top: 7px;
        color: #7b8597;
        font-size: .75rem;
        line-height: 1.6;
    }

    .vh-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .vh-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .82rem;
        white-space: nowrap;
    }

    .vh-table th {
        padding: 12px;
        background: #f6f8fc;
        color: #5d687a;
        text-align: left;
        font-weight: 750;
    }

    .vh-table td {
        padding: 13px 12px;
        border-bottom: 1px solid #edf0f5;
        color: #334155;
        vertical-align: middle;
    }

    .vh-table tbody tr:hover {
        background: #fffaf9;
    }

    .vh-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .vh-condition-list {
        display: grid;
        gap: 11px;
    }

    .vh-condition {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: center;
        gap: 15px;
        padding: 15px;
        border: 1px solid #e8edf4;
        border-radius: 12px;
    }

    .vh-condition-name {
        color: #0f1b3d;
        font-size: .92rem;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .vh-condition-meta {
        margin-top: 7px;
        color: #778195;
        font-size: .79rem;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }

    .vh-condition-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 7px;
    }

    .vh-condition-actions select {
        max-width: 135px;
        min-height: 36px;
        padding: 6px 8px;
        border: 1px solid #e1e6ef;
        border-radius: 8px;
        background: #fff;
        color: #334155;
        font: inherit;
        font-size: .78rem;
    }

    .vh-mini-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-height: 35px;
        padding: 0 9px;
        border: 1px solid #e1e6ef;
        border-radius: 8px;
        background: #fff;
        color: #263750;
        font: inherit;
        font-size: .77rem;
        font-weight: 700;
        cursor: pointer;
    }

    .vh-mini-btn:hover {
        background: #f7f9fc;
    }

    .vh-mini-btn.danger {
        border-color: #f2d0d0;
        color: #b83232;
    }

    .vh-status {
        display: inline-flex;
        align-items: center;
        padding: 4px 9px;
        border-radius: 20px;
        background: #eef2f7;
        color: #526075;
        font-size: .73rem;
        font-weight: 750;
    }

    .vh-status.active {
        background: #fff0ee;
        color: #c74c42;
    }

    .vh-status.controlled {
        background: #fff6df;
        color: #8d6415;
    }

    .vh-status.resolved {
        background: #e9f8ef;
        color: #247448;
    }

    .vh-empty,
    .vh-loading {
        padding: 25px 14px;
        color: #778195;
        text-align: center;
        font-size: .85rem;
        line-height: 1.8;
    }

    .vh-note {
        margin: 13px 0 0;
        color: #778195;
        font-size: .76rem;
        line-height: 1.7;
    }

    .vh-message {
        display: none;
        margin-bottom: 14px;
        padding: 11px 13px;
        border: 1px solid;
        border-radius: 10px;
        font-size: .84rem;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .vh-message.success {
        display: block;
        border-color: #bce7d0;
        background: #f0fbf5;
        color: #176c43;
    }

    .vh-message.error {
        display: block;
        border-color: #f0caca;
        background: #fff4f4;
        color: #a72c2c;
    }

    /* Modal */
    .vh-modal[hidden] {
        display: none !important;
    }

    .vh-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 22px;
        background: rgba(7, 18, 34, .58);
        backdrop-filter: blur(3px);
    }

    .vh-modal-dialog {
        width: min(100%, 760px);
        max-height: calc(100vh - 44px);
        overflow: auto;
        border: 1px solid rgba(255, 255, 255, .6);
        border-radius: 17px;
        background: #fff;
        box-shadow: 0 24px 80px rgba(7, 18, 34, .24);
        animation: vhModalIn .18s ease-out;
    }

    .vh-modal-dialog.vh-modal-small {
        width: min(100%, 650px);
    }

    @keyframes vhModalIn {
        from {
            opacity: 0;
            transform: translateY(10px) scale(.99);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .vh-modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        padding: 20px 22px;
        border-bottom: 1px solid #edf0f5;
    }

    .vh-modal-title {
        margin: 0;
        color: #0f1b3d;
        font-size: 1.12rem;
        font-weight: 850;
    }

    .vh-modal-subtitle {
        margin: 5px 0 0;
        color: #778195;
        font-size: .81rem;
        line-height: 1.6;
    }

    .vh-modal-close {
        display: grid;
        place-items: center;
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        border: 1px solid #e6eaf1;
        border-radius: 10px;
        background: #fff;
        color: #596579;
        cursor: pointer;
    }

    .vh-modal-close:hover {
        border-color: #ffb9b2;
        background: #fff5f3;
        color: #d94841;
    }

    .vh-modal-close svg {
        width: 19px;
        height: 19px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
    }

    .vh-modal-body {
        padding: 22px;
    }

    .vh-form-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .vh-field {
        min-width: 0;
    }

    .vh-field textarea {
        min-height: 90px;
        resize: vertical;
    }

    .vh-field small {
        display: block;
        margin-top: 5px;
        color: #778195;
        font-size: .74rem;
        line-height: 1.55;
    }

    .vh-span-full {
        grid-column: 1 / -1;
    }

    .vh-modal-footer {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 9px;
        padding-top: 18px;
        margin-top: 20px;
        border-top: 1px solid #edf0f5;
    }

    body.vh-modal-open {
        overflow: hidden;
    }

    @media (max-width: 1050px) {
        .vh-vitals-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .vh-form-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .vh-page {
            gap: 15px;
        }

        .vh-title {
            font-size: 1.28rem;
        }

        .vh-patient-box {
            width: 100%;
        }

        .vh-toolbar {
            align-items: flex-start;
            padding: 15px;
        }

        .vh-toolbar-actions {
            width: 100%;
        }

        .vh-toolbar-actions .vh-btn {
            flex: 1;
            padding: 0 9px;
            font-size: .78rem;
        }

        .vh-section {
            padding: 15px;
        }

        .vh-vitals-grid {
            gap: 9px;
        }

        .vh-vital-card {
            padding: 12px;
        }

        .vh-vital-icon {
            width: 35px;
            height: 35px;
            flex-basis: 35px;
        }

        .vh-vital-icon svg {
            width: 20px;
            height: 20px;
        }

        .vh-vital-value {
            font-size: 1.3rem;
        }

        .vh-form-grid {
            grid-template-columns: 1fr;
            gap: 13px;
        }

        .vh-span-full {
            grid-column: auto;
        }

        .vh-condition {
            grid-template-columns: 1fr;
        }

        .vh-condition-actions {
            justify-content: flex-start;
        }

        .vh-condition-actions select {
            flex: 1;
            max-width: none;
        }

        .vh-modal {
            padding: 10px;
            align-items: flex-end;
        }

        .vh-modal-dialog {
            max-height: calc(100vh - 20px);
            border-radius: 16px;
        }

        .vh-modal-header,
        .vh-modal-body {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="vh-page">

    <section class="vh-intro">
        <div>
            <h2 class="vh-title">ভাইটালস ও স্বাস্থ্য</h2>
            <p class="vh-subtitle">
                রোগীর স্বাস্থ্য পরিমাপ, আগের রেকর্ড এবং দীর্ঘমেয়াদি স্বাস্থ্য সমস্যা এক জায়গায় পরিচালনা করুন।
            </p>
        </div>

        <div class="vh-patient-box">
            <label for="vhPatientSelect">রোগী নির্বাচন করুন</label>
            <select id="vhPatientSelect" class="vh-patient-select">
                <option value="">রোগীর তালিকা লোড হচ্ছে...</option>
            </select>
        </div>
    </section>

    <div id="vhGlobalMessage" class="vh-message" role="status" aria-live="polite"></div>

    <section class="vh-toolbar">
        <div>
            <h3 class="vh-toolbar-title">স্বাস্থ্য রেকর্ড পরিচালনা</h3>
            <p class="vh-toolbar-subtitle">নতুন তথ্য যোগ করতে প্রয়োজনীয় বাটনে ক্লিক করুন।</p>
        </div>

        <div class="vh-toolbar-actions">
            <button type="button" id="vhOpenVitalModal" class="vh-btn vh-btn-primary">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                নতুন রেকর্ড
            </button>

            <button type="button" id="vhOpenConditionModal" class="vh-btn vh-btn-secondary">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 5v14M5 12h14"/>
                    <circle cx="12" cy="12" r="9"/>
                </svg>
                স্বাস্থ্য সমস্যা যোগ
            </button>
        </div>
    </section>

    <section class="vh-section">
        <div class="vh-section-heading">
            <div>
                <h3 class="vh-section-title">সর্বশেষ স্বাস্থ্য পরিমাপ</h3>
                <p class="vh-section-description">প্রতিটি পরিমাপের সর্বশেষ সংরক্ষিত মান</p>
            </div>
        </div>

        <div id="vhVitalSummary" class="vh-vitals-grid">
            <div class="vh-loading">স্বাস্থ্য তথ্য লোড হচ্ছে...</div>
        </div>

        <p class="vh-note">
            কার্ডগুলো সর্বশেষ সংরক্ষিত রেকর্ড দেখায়। এগুলো নিজে থেকে রোগ নির্ণয় করে না।
        </p>
    </section>

    <section class="vh-section">
        <div class="vh-section-heading">
            <div>
                <h3 class="vh-section-title">পরিমাপের ইতিহাস</h3>
                <p class="vh-section-description">সর্বশেষ রেকর্ড আগে দেখানো হবে।</p>
            </div>

            <button type="button" id="vhRefreshHistory" class="vh-btn vh-btn-secondary">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20 7v5h-5"/>
                    <path d="M4 17v-5h5"/>
                    <path d="M5.6 9a7 7 0 0 1 11.8-2L20 12"/>
                    <path d="M4 12l2.6 5a7 7 0 0 0 11.8-2"/>
                </svg>
                রিফ্রেশ
            </button>
        </div>

        <div id="vhHistoryMessage" class="vh-message" role="status" aria-live="polite"></div>

        <div id="vhHistoryContainer" class="vh-table-wrap">
            <div class="vh-empty">রোগী নির্বাচন করুন।</div>
        </div>
    </section>

    <section class="vh-section">
        <div class="vh-section-heading">
            <div>
                <h3 class="vh-section-title">দীর্ঘমেয়াদি রোগ ও স্বাস্থ্য সমস্যা</h3>
                <p class="vh-section-description">
                    রোগীর পূর্ববর্তী বা বর্তমানে চলমান স্বাস্থ্য সমস্যাগুলো।
                </p>
            </div>
        </div>

        <div id="vhConditionMessage" class="vh-message" role="status" aria-live="polite"></div>

        <div id="vhConditionList" class="vh-condition-list">
            <div class="vh-empty">রোগী নির্বাচন করুন।</div>
        </div>
    </section>

</div>

{{-- Vital record modal --}}
<div id="vhVitalModal" class="vh-modal" hidden>
    <div class="vh-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="vhVitalModalTitle">
        <div class="vh-modal-header">
            <div>
                <h3 id="vhVitalModalTitle" class="vh-modal-title">নতুন ভাইটালস রেকর্ড</h3>
                <p class="vh-modal-subtitle">যে পরিমাপগুলো নেওয়া হয়েছে, শুধু সেগুলো পূরণ করুন।</p>
            </div>

            <button type="button" class="vh-modal-close" data-close-modal="vhVitalModal" aria-label="বন্ধ করুন">
                <svg viewBox="0 0 24 24"><path d="m18 6-12 12M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="vh-modal-body">
            <div id="vhVitalMessage" class="vh-message" role="status" aria-live="polite"></div>

            <form id="vhVitalForm">
                <div class="vh-form-grid">
                    <div class="vh-field">
                        <label for="vhSystolic">সিস্টোলিক BP</label>
                        <input id="vhSystolic" type="number" min="1" max="300" step="1" placeholder="যেমন 120">
                        <small>উপরের চাপ · mmHg</small>
                    </div>

                    <div class="vh-field">
                        <label for="vhDiastolic">ডায়াস্টোলিক BP</label>
                        <input id="vhDiastolic" type="number" min="1" max="200" step="1" placeholder="যেমন 80">
                        <small>নিচের চাপ · mmHg</small>
                    </div>

                    <div class="vh-field">
                        <label for="vhHeartRate">হার্ট রেট</label>
                        <input id="vhHeartRate" type="number" min="1" max="300" step="1" placeholder="যেমন 75">
                        <small>একক: bpm</small>
                    </div>

                    <div class="vh-field">
                        <label for="vhTemperature">শরীরের তাপমাত্রা</label>
                        <input id="vhTemperature" type="number" min="25" max="45" step="0.1" placeholder="যেমন 36.8">
                        <small>একক: °C</small>
                    </div>

                    <div class="vh-field">
                        <label for="vhSpo2">SpO₂</label>
                        <input id="vhSpo2" type="number" min="0" max="100" step="1" placeholder="যেমন 98">
                        <small>একক: %</small>
                    </div>

                    <div class="vh-field">
                        <label for="vhGlucose">রক্তে গ্লুকোজ</label>
                        <input id="vhGlucose" type="number" min="0" max="1000" step="any" placeholder="যেমন 126">
                        <small>একক: mg/dL · সীমা 0–1000</small>
                    </div>

                    <div class="vh-field">
                        <label for="vhWeight">ওজন</label>
                        <input id="vhWeight" type="number" min="0" max="500" step="0.1" placeholder="যেমন 62.5">
                        <small>একক: kg</small>
                    </div>

                    <div class="vh-field vh-span-full">
                        <label for="vhMeasuredAt">পরিমাপের তারিখ ও সময় *</label>
                        <input id="vhMeasuredAt" type="datetime-local" required>
                    </div>

                    <div class="vh-field vh-span-full">
                        <label for="vhVitalNotes">নোট (ঐচ্ছিক)</label>
                        <textarea id="vhVitalNotes" maxlength="5000" placeholder="পরিমাপের সময়কার অবস্থা বা অতিরিক্ত তথ্য"></textarea>
                    </div>
                </div>

                <div class="vh-modal-footer">
                    <button type="button" class="vh-btn vh-btn-secondary" data-close-modal="vhVitalModal">বাতিল</button>
                    <button type="submit" id="vhSaveVital" class="vh-btn vh-btn-primary">রেকর্ড সংরক্ষণ</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Condition modal --}}
<div id="vhConditionModal" class="vh-modal" hidden>
    <div class="vh-modal-dialog vh-modal-small" role="dialog" aria-modal="true" aria-labelledby="vhConditionModalTitle">
        <div class="vh-modal-header">
            <div>
                <h3 id="vhConditionModalTitle" class="vh-modal-title">স্বাস্থ্য সমস্যা যোগ করুন</h3>
                <p class="vh-modal-subtitle">রোগের নাম এবং বর্তমান অবস্থা লিখুন।</p>
            </div>

            <button type="button" class="vh-modal-close" data-close-modal="vhConditionModal" aria-label="বন্ধ করুন">
                <svg viewBox="0 0 24 24"><path d="m18 6-12 12M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="vh-modal-body">
            <div id="vhConditionFormMessage" class="vh-message" role="status" aria-live="polite"></div>

            <form id="vhConditionForm">
                <div class="vh-form-grid">
                    <div class="vh-field vh-span-full">
                        <label for="vhConditionName">রোগের নাম *</label>
                        <select id="vhConditionName" required>
                            <option value="">রোগ নির্বাচন করুন</option>
                        </select>
                    </div>

                    <div class="vh-field vh-span-full" id="vhCustomConditionWrap" hidden>
                        <label for="vhCustomCondition">রোগের নাম লিখুন *</label>
                        <input id="vhCustomCondition" type="text" maxlength="255" placeholder="যেমন: Migraine">
                    </div>

                    <div class="vh-field">
                        <label for="vhDiagnosedAt">রোগ নির্ণয়ের তারিখ</label>
                        <input id="vhDiagnosedAt" type="date">
                    </div>

                    <div class="vh-field">
                        <label for="vhConditionStatus">বর্তমান অবস্থা *</label>
                        <select id="vhConditionStatus" required>
                            <option value="active">চলমান</option>
                            <option value="controlled">নিয়ন্ত্রণে</option>
                            <option value="resolved">সেরে গেছে</option>
                        </select>
                    </div>

                    <div class="vh-field vh-span-full">
                        <label for="vhConditionNotes">নোট (ঐচ্ছিক)</label>
                        <textarea id="vhConditionNotes" maxlength="5000" placeholder="চিকিৎসা, সতর্কতা বা অন্যান্য তথ্য"></textarea>
                    </div>
                </div>

                <div class="vh-modal-footer">
                    <button type="button" class="vh-btn vh-btn-secondary" data-close-modal="vhConditionModal">বাতিল</button>
                    <button type="submit" id="vhSaveCondition" class="vh-btn vh-btn-primary">স্বাস্থ্য সমস্যা সংরক্ষণ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
(() => {
    'use strict';

    const patientSelect = document.getElementById('vhPatientSelect');
    const vitalSummary = document.getElementById('vhVitalSummary');
    const historyContainer = document.getElementById('vhHistoryContainer');
    const conditionList = document.getElementById('vhConditionList');
    const vitalForm = document.getElementById('vhVitalForm');
    const conditionForm = document.getElementById('vhConditionForm');
    const conditionSelect = document.getElementById('vhConditionName');
    const customConditionWrap = document.getElementById('vhCustomConditionWrap');
    const customConditionInput = document.getElementById('vhCustomCondition');

    let selectedPatientId = '';
    let conditionOptions = [];
    let lastFocusedElement = null;

    const statusLabels = {
        active: 'চলমান',
        controlled: 'নিয়ন্ত্রণে',
        resolved: 'সেরে গেছে'
    };

    // Inline SVG icons. No external icon library is required.
    const icons = {
        blood_pressure: `
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M3 12h4l2-5 4 10 2-5h6"/>
                <path d="M7 4H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-2"/>
            </svg>`,
        heart_rate: `
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20.8 8.6c0 5.2-8.8 11-8.8 11s-8.8-5.8-8.8-11A4.6 4.6 0 0 1 12 6.3a4.6 4.6 0 0 1 8.8 2.3Z"/>
                <path d="M3.5 12h4l2-3 3 6 2-3h6"/>
            </svg>`,
        temperature: `
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M14 14.8V5a3 3 0 0 0-6 0v9.8a5 5 0 1 0 6 0Z"/>
                <path d="M11 8v9"/>
                <circle cx="11" cy="19" r="1.5"/>
            </svg>`,
        spo2: `
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 21s-8-4.8-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.2-8 11-8 11Z"/>
                <path d="M7 13h3l2-4 2 7 2-3h1"/>
            </svg>`,
        blood_glucose: `
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 3s6 6.8 6 11a6 6 0 0 1-12 0c0-4.2 6-11 6-11Z"/>
                <path d="M9 14h6M12 11v6"/>
            </svg>`,
        weight: `
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="4" y="3" width="16" height="18" rx="3"/>
                <path d="M9 8a3 3 0 0 1 6 0"/>
                <path d="m12 8 2 3"/>
            </svg>`
    };

    const vitalDefinitions = [
        { key: 'blood_pressure', label: 'রক্তচাপ', unit: 'mmHg' },
        { key: 'heart_rate', label: 'হার্ট রেট', unit: 'bpm' },
        { key: 'temperature', label: 'তাপমাত্রা', unit: '°C' },
        { key: 'spo2', label: 'SpO₂', unit: '%' },
        { key: 'blood_glucose', label: 'রক্তে গ্লুকোজ', unit: 'mg/dL' },
        { key: 'weight', label: 'ওজন', unit: 'kg' }
    ];

    function escapeHtml(value) {
        if (typeof esc === 'function') return esc(value ?? '');

        return String(value ?? '').replace(/[&<>"']/g, char => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        })[char]);
    }

    function showMessage(elementId, message, type = 'error') {
        const element = document.getElementById(elementId);
        if (!element) return;

        element.textContent = message || '';
        element.className = 'vh-message ' + type;
    }

    function clearMessage(elementId) {
        const element = document.getElementById(elementId);
        if (!element) return;

        element.textContent = '';
        element.className = 'vh-message';
    }

    async function readJson(response) {
        try {
            return await response.json();
        } catch (_) {
            return {};
        }
    }

    function getErrorMessage(data, fallback) {
        if (data?.errors) {
            const messages = Object.values(data.errors).flat();
            if (messages.length) return messages.join(' ');
        }

        return data?.message || fallback;
    }

    function getList(data, preferredKey) {
        if (Array.isArray(data)) return data;
        if (preferredKey && Array.isArray(data?.[preferredKey])) return data[preferredKey];
        if (Array.isArray(data?.data)) return data.data;
        if (Array.isArray(data?.data?.data)) return data.data.data;
        return [];
    }

    function localDateTimeValue(date = new Date()) {
        const pad = value => String(value).padStart(2, '0');

        return date.getFullYear() + '-' +
            pad(date.getMonth() + 1) + '-' +
            pad(date.getDate()) + 'T' +
            pad(date.getHours()) + ':' +
            pad(date.getMinutes());
    }

    function formatDate(value, withTime = true) {
        if (!value) return '—';

        const normalized = String(value).includes('T')
            ? String(value)
            : String(value).replace(' ', 'T');

        const date = new Date(normalized);
        if (Number.isNaN(date.getTime())) return String(value);

        return date.toLocaleString('bn-BD', withTime
            ? {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }
            : {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
    }

    function formatNumber(value, digits = 1) {
        if (value === null || value === undefined || value === '') return '—';

        const number = Number(value);
        if (!Number.isFinite(number)) return '—';

        return number.toLocaleString('bn-BD', {
            maximumFractionDigits: digits
        });
    }

    function setButtonLoading(button, loading, loadingText, normalText) {
        button.disabled = loading;
        button.textContent = loading ? loadingText : normalText;
    }

    function openModal(modalId) {
        if (!selectedPatientId) {
            showMessage('vhGlobalMessage', 'আগে একজন রোগী নির্বাচন করুন।');
            return;
        }

        const modal = document.getElementById(modalId);
        if (!modal) return;

        lastFocusedElement = document.activeElement;
        modal.hidden = false;
        document.body.classList.add('vh-modal-open');

        const firstInput = modal.querySelector('input:not([type="hidden"]), select, textarea');
        if (firstInput) setTimeout(() => firstInput.focus(), 50);
    }

    function closeModal(modalId, resetForm = false) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        if (resetForm) {
            const form = modal.querySelector('form');
            if (form) form.reset();
        }

        modal.hidden = true;

        if (document.querySelectorAll('.vh-modal:not([hidden])').length === 0) {
            document.body.classList.remove('vh-modal-open');
        }

        if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
            lastFocusedElement.focus();
        }
    }

    document.getElementById('vhOpenVitalModal').addEventListener('click', () => {
        clearMessage('vhVitalMessage');
        document.getElementById('vhMeasuredAt').value = localDateTimeValue();
        openModal('vhVitalModal');
    });

    document.getElementById('vhOpenConditionModal').addEventListener('click', () => {
        clearMessage('vhConditionFormMessage');
        openModal('vhConditionModal');
    });

    document.querySelectorAll('[data-close-modal]').forEach(button => {
        button.addEventListener('click', () => {
            closeModal(button.dataset.closeModal, true);
        });
    });

    document.querySelectorAll('.vh-modal').forEach(modal => {
        modal.addEventListener('click', event => {
            if (event.target === modal) closeModal(modal.id, true);
        });
    });

    document.addEventListener('keydown', event => {
        if (event.key !== 'Escape') return;

        document.querySelectorAll('.vh-modal:not([hidden])').forEach(modal => {
            closeModal(modal.id, true);
        });
    });

    function getVitalValue(record, key) {
        if (!record) return null;

        switch (key) {
            case 'blood_pressure':
                if (record.systolic == null && record.diastolic == null) return null;

                return `${record.systolic ?? '—'}/${record.diastolic ?? '—'}`;

            case 'heart_rate':
                return record.heart_rate;
            case 'temperature':
                return record.temperature;
            case 'spo2':
                return record.spo2;
            case 'blood_glucose':
                return record.blood_glucose;
            case 'weight':
                return record.weight;
            default:
                return null;
        }
    }

    function getLatestForVital(records, key) {
        return records.find(record => {
            if (key === 'blood_pressure') {
                return record.systolic != null || record.diastolic != null;
            }

            return record[key] !== null &&
                record[key] !== undefined &&
                record[key] !== '';
        }) || null;
    }

    function renderVitalSummary(records) {
        vitalSummary.innerHTML = vitalDefinitions.map(item => {
            const latest = getLatestForVital(records, item.key);
            const value = getVitalValue(latest, item.key);
            const hasValue = value !== null && value !== undefined && value !== '';

            const displayValue = item.key === 'blood_pressure'
                ? (hasValue ? value : '—')
                : (hasValue ? formatNumber(value, 1) : '—');

            return `
                <article class="vh-vital-card">
                    <div class="vh-vital-top">
                        <span class="vh-vital-label">${escapeHtml(item.label)}</span>
                        <span class="vh-vital-icon">${icons[item.key]}</span>
                    </div>
                    <div class="vh-vital-value">
                        ${escapeHtml(displayValue)}
                        ${hasValue && item.unit
                            ? `<span class="vh-vital-unit">${escapeHtml(item.unit)}</span>`
                            : ''}
                    </div>
                    <div class="vh-vital-meta">
                        ${hasValue
                            ? `সর্বশেষ: ${escapeHtml(formatDate(latest.measured_at))}`
                            : 'এখনো রেকর্ড নেই'}
                    </div>
                </article>
            `;
        }).join('');
    }

    function renderHistory(records) {
        if (!records.length) {
            historyContainer.innerHTML =
                '<div class="vh-empty">এখনো কোনো ভাইটালস রেকর্ড নেই। “নতুন রেকর্ড” বাটন থেকে প্রথম রেকর্ড যোগ করুন।</div>';
            return;
        }

        historyContainer.innerHTML = `
            <table class="vh-table">
                <thead>
                    <tr>
                        <th>তারিখ ও সময়</th>
                        <th>BP (mmHg)</th>
                        <th>হার্ট রেট</th>
                        <th>তাপমাত্রা</th>
                        <th>SpO₂</th>
                        <th>গ্লুকোজ</th>
                        <th>ওজন</th>
                        <th>নোট</th>
                    </tr>
                </thead>
                <tbody>
                    ${records.map(record => {
                        const bp = record.systolic != null || record.diastolic != null
                            ? `${record.systolic ?? '—'}/${record.diastolic ?? '—'}`
                            : '—';

                        return `
                            <tr>
                                <td>${escapeHtml(formatDate(record.measured_at))}</td>
                                <td>${escapeHtml(bp)}</td>
                                <td>${record.heart_rate != null ? escapeHtml(formatNumber(record.heart_rate, 0)) + ' bpm' : '—'}</td>
                                <td>${record.temperature != null ? escapeHtml(formatNumber(record.temperature)) + ' °C' : '—'}</td>
                                <td>${record.spo2 != null ? escapeHtml(formatNumber(record.spo2, 0)) + '%' : '—'}</td>
                                <td>${record.blood_glucose != null ? escapeHtml(formatNumber(record.blood_glucose)) + ' mg/dL' : '—'}</td>
                                <td>${record.weight != null ? escapeHtml(formatNumber(record.weight)) + ' kg' : '—'}</td>
                                <td title="${escapeHtml(record.notes || '')}">${escapeHtml(record.notes || '—')}</td>
                            </tr>
                        `;
                    }).join('')}
                </tbody>
            </table>
        `;
    }

    function renderConditions(conditions) {
        if (!conditions.length) {
            conditionList.innerHTML =
                '<div class="vh-empty">এখনো কোনো স্বাস্থ্য সমস্যা যোগ করা হয়নি। “স্বাস্থ্য সমস্যা যোগ” বাটন থেকে যোগ করুন।</div>';
            return;
        }

        conditionList.innerHTML = conditions.map(condition => {
            const status = condition.status || 'active';
            const diagnosed = condition.diagnosed_at
                ? `নির্ণয়ের তারিখ: ${formatDate(condition.diagnosed_at, false)}`
                : 'নির্ণয়ের তারিখ দেওয়া হয়নি';

            return `
                <article class="vh-condition" data-condition-id="${escapeHtml(condition.id)}">
                    <div>
                        <div class="vh-condition-name">${escapeHtml(condition.condition_name)}</div>
                        <div class="vh-condition-meta">
                            ${escapeHtml(diagnosed)}<br>
                            <span class="vh-status ${escapeHtml(status)}">${escapeHtml(statusLabels[status] || status)}</span>
                            ${condition.notes
                                ? `<div style="margin-top:7px;">${escapeHtml(condition.notes)}</div>`
                                : ''}
                        </div>
                    </div>

                    <div class="vh-condition-actions">
                        <select class="vh-condition-status" aria-label="স্বাস্থ্য সমস্যার অবস্থা">
                            <option value="active" ${status === 'active' ? 'selected' : ''}>চলমান</option>
                            <option value="controlled" ${status === 'controlled' ? 'selected' : ''}>নিয়ন্ত্রণে</option>
                            <option value="resolved" ${status === 'resolved' ? 'selected' : ''}>সেরে গেছে</option>
                        </select>

                        <button type="button" class="vh-mini-btn" data-action="update-condition">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20 7v5h-5"/>
                                <path d="M4 17v-5h5"/>
                                <path d="M5.6 9a7 7 0 0 1 11.8-2L20 12"/>
                                <path d="M4 12l2.6 5a7 7 0 0 0 11.8-2"/>
                            </svg>
                            আপডেট
                        </button>

                        <button type="button" class="vh-mini-btn danger" data-action="delete-condition">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 6h18"/>
                                <path d="M8 6V4h8v2"/>
                                <path d="m19 6-1 14H6L5 6"/>
                                <path d="M10 10v6M14 10v6"/>
                            </svg>
                            মুছুন
                        </button>
                    </div>
                </article>
            `;
        }).join('');
    }

    async function loadPatients() {
        patientSelect.innerHTML = '<option value="">রোগীর তালিকা লোড হচ্ছে...</option>';

        try {
            const response = await apiFetch('/patients');

            if (!response || !response.ok) {
                patientSelect.innerHTML = '<option value="">রোগীর তালিকা লোড করা যায়নি</option>';
                showMessage('vhGlobalMessage', 'রোগীর তালিকা আনা যায়নি। পেজ রিফ্রেশ করে আবার চেষ্টা করুন।');
                return;
            }

            const data = await readJson(response);
            const patients = getList(data);

            if (!patients.length) {
                patientSelect.innerHTML = '<option value="">প্রথমে একজন রোগী যোগ করুন</option>';
                vitalSummary.innerHTML = '<div class="vh-empty">কোনো রোগী পাওয়া যায়নি। আগে রোগী যোগ করুন।</div>';
                historyContainer.innerHTML = '<div class="vh-empty">রোগী যোগ করার পর এখানে রেকর্ড দেখা যাবে।</div>';
                conditionList.innerHTML = '<div class="vh-empty">রোগী যোগ করার পর স্বাস্থ্য সমস্যা পরিচালনা করতে পারবেন।</div>';
                return;
            }

            patientSelect.innerHTML = '<option value="">রোগী নির্বাচন করুন</option>' +
                patients.map(patient =>
                    `<option value="${escapeHtml(patient.id)}">${escapeHtml(patient.name || 'নাম দেওয়া নেই')}</option>`
                ).join('');

            patientSelect.value = String(patients[0].id);
            selectedPatientId = String(patients[0].id);

            await loadPatientData();
        } catch (_) {
            patientSelect.innerHTML = '<option value="">রোগীর তালিকা লোড করা যায়নি</option>';
            showMessage('vhGlobalMessage', 'সার্ভারের সাথে সংযোগ করা যায়নি। পেজ রিফ্রেশ করে আবার চেষ্টা করুন।');
        }
    }

    async function loadVitals() {
        const response = await apiFetch(`/patients/${selectedPatientId}/vitals`);

        if (!response || !response.ok) {
            vitalSummary.innerHTML = '<div class="vh-empty">ভাইটালস তথ্য লোড করা যায়নি।</div>';
            historyContainer.innerHTML = '<div class="vh-empty">রেকর্ড লোড করা যায়নি।</div>';
            return;
        }

        const data = await readJson(response);
        const records = getList(data);

        renderVitalSummary(records);
        renderHistory(records);
    }

    async function loadConditions() {
        const response = await apiFetch(`/patients/${selectedPatientId}/conditions`);

        if (!response || !response.ok) {
            conditionList.innerHTML = '<div class="vh-empty">স্বাস্থ্য সমস্যার তালিকা লোড করা যায়নি।</div>';
            return;
        }

        const data = await readJson(response);
        renderConditions(getList(data, 'conditions'));
    }

    async function loadConditionOptions() {
        const response = await apiFetch('/patient-conditions/options');

        if (!response || !response.ok) {
            showMessage('vhConditionFormMessage', 'রোগের তালিকা লোড করা যায়নি।');
            return;
        }

        const data = await readJson(response);

        conditionOptions = getList(data, 'options');
        if (!conditionOptions.length) conditionOptions = getList(data, 'conditions');
        if (!conditionOptions.length && Array.isArray(data)) conditionOptions = data;

        conditionSelect.innerHTML = '<option value="">রোগ নির্বাচন করুন</option>' +
            conditionOptions.map(option => {
                const value = typeof option === 'string'
                    ? option
                    : (option.value ?? option.name ?? option.label ?? '');

                const label = typeof option === 'string'
                    ? option
                    : (option.label ?? option.name ?? option.value ?? '');

                return `<option value="${escapeHtml(value)}">${escapeHtml(label)}</option>`;
            }).join('');
    }

    async function loadPatientData() {
        if (!selectedPatientId) return;

        clearMessage('vhGlobalMessage');
        vitalSummary.innerHTML = '<div class="vh-loading">ভাইটালস লোড হচ্ছে...</div>';
        historyContainer.innerHTML = '<div class="vh-loading">ইতিহাস লোড হচ্ছে...</div>';
        conditionList.innerHTML = '<div class="vh-loading">স্বাস্থ্য সমস্যা লোড হচ্ছে...</div>';

        await Promise.all([loadVitals(), loadConditions()]);
    }

    function formVitalPayload() {
        const fields = {
            systolic: 'vhSystolic',
            diastolic: 'vhDiastolic',
            heart_rate: 'vhHeartRate',
            temperature: 'vhTemperature',
            spo2: 'vhSpo2',
            blood_glucose: 'vhGlucose',
            weight: 'vhWeight'
        };

        const payload = {};

        for (const [key, elementId] of Object.entries(fields)) {
            const value = document.getElementById(elementId).value.trim();
            if (value !== '') payload[key] = Number(value);
        }

        payload.measured_at = document.getElementById('vhMeasuredAt').value;

        const notes = document.getElementById('vhVitalNotes').value.trim();
        if (notes) payload.notes = notes;

        return payload;
    }

    vitalForm.addEventListener('reset', () => {
        setTimeout(() => {
            document.getElementById('vhMeasuredAt').value = localDateTimeValue();
            clearMessage('vhVitalMessage');
        }, 0);
    });

    vitalForm.addEventListener('submit', async event => {
        event.preventDefault();
        clearMessage('vhVitalMessage');

        if (!selectedPatientId) {
            showMessage('vhVitalMessage', 'আগে একজন রোগী নির্বাচন করুন।');
            return;
        }

        const payload = formVitalPayload();

        const measurementKeys = [
            'systolic', 'diastolic', 'heart_rate', 'temperature',
            'spo2', 'blood_glucose', 'weight'
        ];

        if (!measurementKeys.some(key => payload[key] !== undefined)) {
            showMessage('vhVitalMessage', 'কমপক্ষে একটি স্বাস্থ্য পরিমাপ লিখুন।');
            return;
        }

        if ((payload.systolic === undefined) !== (payload.diastolic === undefined)) {
            showMessage('vhVitalMessage', 'রক্তচাপ দিতে হলে সিস্টোলিক ও ডায়াস্টোলিক—দুটিই পূরণ করুন।');
            return;
        }

        if (payload.systolic !== undefined && payload.systolic <= payload.diastolic) {
            showMessage('vhVitalMessage', 'সিস্টোলিক চাপ ডায়াস্টোলিক চাপের চেয়ে বেশি হতে হবে।');
            return;
        }

        const button = document.getElementById('vhSaveVital');
        setButtonLoading(button, true, 'সংরক্ষণ হচ্ছে...', 'রেকর্ড সংরক্ষণ');

        try {
            const response = await apiFetch(`/patients/${selectedPatientId}/vitals`, {
                method: 'POST',
                body: JSON.stringify(payload)
            });

            if (!response) return;

            const data = await readJson(response);

            if (!response.ok) {
                showMessage('vhVitalMessage', getErrorMessage(data, 'রেকর্ড সংরক্ষণ করা যায়নি।'));
                return;
            }

            closeModal('vhVitalModal', true);
            showMessage('vhGlobalMessage', data.message || 'ভাইটালস রেকর্ড সফলভাবে সংরক্ষণ হয়েছে।', 'success');

            document.getElementById('vhMeasuredAt').value = localDateTimeValue();
            await loadVitals();
        } catch (_) {
            showMessage('vhVitalMessage', 'সার্ভারের সাথে সংযোগ করা যায়নি। আবার চেষ্টা করুন।');
        } finally {
            setButtonLoading(button, false, '', 'রেকর্ড সংরক্ষণ');
        }
    });

    conditionSelect.addEventListener('change', () => {
        const isOther = conditionSelect.value.toLowerCase() === 'other';

        customConditionWrap.hidden = !isOther;
        customConditionInput.required = isOther;

        if (!isOther) customConditionInput.value = '';
    });

    conditionForm.addEventListener('reset', () => {
        setTimeout(() => {
            customConditionWrap.hidden = true;
            customConditionInput.required = false;
            clearMessage('vhConditionFormMessage');
        }, 0);
    });

    conditionForm.addEventListener('submit', async event => {
        event.preventDefault();
        clearMessage('vhConditionFormMessage');

        if (!selectedPatientId) {
            showMessage('vhConditionFormMessage', 'আগে একজন রোগী নির্বাচন করুন।');
            return;
        }

        const conditionName = conditionSelect.value;
        const isOther = conditionName.toLowerCase() === 'other';

        const payload = {
            condition_name: conditionName,
            status: document.getElementById('vhConditionStatus').value
        };

        if (isOther) {
            const customName = customConditionInput.value.trim();

            if (!customName) {
                showMessage('vhConditionFormMessage', 'অন্যান্য রোগের নাম লিখুন।');
                return;
            }

            payload.custom_condition_name = customName;
        }

        const diagnosedAt = document.getElementById('vhDiagnosedAt').value;
        const notes = document.getElementById('vhConditionNotes').value.trim();

        if (diagnosedAt) payload.diagnosed_at = diagnosedAt;
        if (notes) payload.notes = notes;

        const button = document.getElementById('vhSaveCondition');
        setButtonLoading(button, true, 'সংরক্ষণ হচ্ছে...', 'স্বাস্থ্য সমস্যা সংরক্ষণ');

        try {
            const response = await apiFetch(`/patients/${selectedPatientId}/conditions`, {
                method: 'POST',
                body: JSON.stringify(payload)
            });

            if (!response) return;

            const data = await readJson(response);

            if (!response.ok) {
                showMessage('vhConditionFormMessage', getErrorMessage(data, 'স্বাস্থ্য সমস্যা যোগ করা যায়নি।'));
                return;
            }

            closeModal('vhConditionModal', true);
            showMessage('vhConditionMessage', data.message || 'স্বাস্থ্য সমস্যা যোগ হয়েছে।', 'success');

            await loadConditions();
        } catch (_) {
            showMessage('vhConditionFormMessage', 'সার্ভারের সাথে সংযোগ করা যায়নি। আবার চেষ্টা করুন।');
        } finally {
            setButtonLoading(button, false, '', 'স্বাস্থ্য সমস্যা সংরক্ষণ');
        }
    });

    conditionList.addEventListener('click', async event => {
        const button = event.target.closest('button[data-action]');
        if (!button || !selectedPatientId) return;

        const card = button.closest('[data-condition-id]');
        if (!card) return;

        const conditionId = card.dataset.conditionId;
        const action = button.dataset.action;

        if (action === 'delete-condition') {
            if (!confirm('এই স্বাস্থ্য সমস্যার রেকর্ডটি মুছে ফেলতে চান?')) return;

            button.disabled = true;

            try {
                const response = await apiFetch(
                    `/patients/${selectedPatientId}/conditions/${conditionId}`,
                    { method: 'DELETE' }
                );

                if (!response) return;

                if (!response.ok) {
                    const data = await readJson(response);
                    showMessage('vhConditionMessage', getErrorMessage(data, 'রেকর্ড মুছে ফেলা যায়নি।'));
                    return;
                }

                showMessage('vhConditionMessage', 'স্বাস্থ্য সমস্যার রেকর্ড মুছে ফেলা হয়েছে।', 'success');
                await loadConditions();
            } catch (_) {
                showMessage('vhConditionMessage', 'সার্ভারের সাথে সংযোগ করা যায়নি।');
            } finally {
                button.disabled = false;
            }
        }

        if (action === 'update-condition') {
            const status = card.querySelector('.vh-condition-status').value;
            button.disabled = true;

            try {
                const response = await apiFetch(
                    `/patients/${selectedPatientId}/conditions/${conditionId}`,
                    {
                        method: 'PUT',
                        body: JSON.stringify({ status })
                    }
                );

                if (!response) return;

                const data = await readJson(response);

                if (!response.ok) {
                    showMessage('vhConditionMessage', getErrorMessage(data, 'অবস্থা আপডেট করা যায়নি।'));
                    return;
                }

                showMessage('vhConditionMessage', 'স্বাস্থ্য সমস্যার অবস্থা আপডেট হয়েছে।', 'success');
                await loadConditions();
            } catch (_) {
                showMessage('vhConditionMessage', 'সার্ভারের সাথে সংযোগ করা যায়নি।');
            } finally {
                button.disabled = false;
            }
        }
    });

    patientSelect.addEventListener('change', async () => {
        selectedPatientId = patientSelect.value;

        clearMessage('vhGlobalMessage');
        clearMessage('vhVitalMessage');
        clearMessage('vhConditionMessage');
        clearMessage('vhConditionFormMessage');

        if (!selectedPatientId) {
            vitalSummary.innerHTML = '<div class="vh-empty">একজন রোগী নির্বাচন করুন।</div>';
            historyContainer.innerHTML = '<div class="vh-empty">একজন রোগী নির্বাচন করুন।</div>';
            conditionList.innerHTML = '<div class="vh-empty">একজন রোগী নির্বাচন করুন।</div>';
            return;
        }

        await loadPatientData();
    });

    document.getElementById('vhRefreshHistory').addEventListener('click', async () => {
        if (selectedPatientId) await loadVitals();
    });

    document.getElementById('vhMeasuredAt').value = localDateTimeValue();

    if (typeof token !== 'undefined' && token) {
        loadPatients();
        loadConditionOptions();
    }
})();
@endpush
