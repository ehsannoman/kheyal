@extends('layouts.app')

@section('content')

<style>
    .health-history-page {
        padding: 28px;
        min-height: calc(100vh - 72px);
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
        color: #0f1b3d;
        font-size: 28px;
        font-weight: 700;
    }

    .history-title p {
        margin: 6px 0 0;
        color: #64748b;
        font-family: 'Hind Siliguri', sans-serif;
        font-size: 15px;
    }

    .patient-selector {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 18px;
        min-width: 280px;
    }

    .patient-selector label {
        display: block;
        margin-bottom: 6px;
        font-family: 'Hind Siliguri', sans-serif;
        font-size: 13px;
        color: #64748b;
    }

    .patient-selector select {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        color: #0f1b3d;
        font-family: 'Hind Siliguri', sans-serif;
        font-size: 15px;
        font-weight: 600;
    }

    .history-overview {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .overview-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .overview-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: #fff1ee;
        color: #ff5c5c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .overview-info span {
        display: block;
        font-family: 'Hind Siliguri', sans-serif;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 3px;
    }

    .overview-info strong {
        display: block;
        font-family: 'Hind Siliguri', sans-serif;
        font-size: 22px;
        color: #0f1b3d;
    }

    .history-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .history-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        overflow: hidden;
    }

    .history-card.full-width {
        grid-column: 1 / -1;
    }

    .card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #0f1b3d;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .card-header h3 {
        margin: 0;
        font-family: 'Noto Serif Bengali', serif;
        color: #0f1b3d;
        font-size: 17px;
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
        border: 1px solid #edf1f5;
        border-radius: 12px;
        background: #fafbfc;
    }

    .history-item-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 6px;
    }

    .history-item-title {
        font-family: 'Hind Siliguri', sans-serif;
        font-size: 15px;
        font-weight: 600;
        color: #0f1b3d;
    }

    .history-item-date {
        font-family: 'Hind Siliguri', sans-serif;
        font-size: 12px;
        color: #64748b;
    }

    .history-item-description {
        margin: 0;
        font-family: 'Hind Siliguri', sans-serif;
        font-size: 13px;
        line-height: 1.6;
        color: #64748b;
    }

    .empty-history {
        text-align: center;
        padding: 34px 20px;
        color: #94a3b8;
    }

    .empty-history-icon {
        width: 52px;
        height: 52px;
        margin: 0 auto 12px;
        border-radius: 14px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff5c5c;
        font-size: 21px;
    }

    .empty-history h4 {
        margin: 0 0 5px;
        font-family: 'Hind Siliguri', sans-serif;
        color: #475569;
        font-size: 15px;
    }

    .empty-history p {
        margin: 0;
        font-family: 'Hind Siliguri', sans-serif;
        font-size: 13px;
    }

    .doctor-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .info-box {
        border: 1px solid #edf1f5;
        border-radius: 12px;
        padding: 14px;
        background: #fafbfc;
    }

    .info-box span {
        display: block;
        font-family: 'Hind Siliguri', sans-serif;
        font-size: 12px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .info-box strong {
        display: block;
        font-family: 'Hind Siliguri', sans-serif;
        font-size: 14px;
        color: #0f1b3d;
    }

    @media (max-width: 1100px) {
        .history-overview {
            grid-template-columns: repeat(2, 1fr);
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
            width: auto;
        }
    }

    @media (max-width: 600px) {
        .health-history-page {
            padding: 18px;
        }

        .history-overview {
            grid-template-columns: 1fr;
        }

        .doctor-info {
            grid-template-columns: 1fr;
        }

        .history-title h1 {
            font-size: 24px;
        }
    }
</style>

<div class="health-history-page">

    {{-- HEADER --}}
    <div class="history-header">

        <div class="history-title">
            <h1>স্বাস্থ্য ইতিহাস</h1>
            <p>আপনার প্রিয়জনের পূর্ববর্তী স্বাস্থ্য তথ্য ও চিকিৎসার ইতিহাস</p>
        </div>

        <div class="patient-selector">
            <label for="patientSelect">রোগী নির্বাচন করুন</label>

            <select id="patientSelect">
                <option value="">রোগী নির্বাচন করুন</option>

                {{-- Backend integration হলে এখানে patient list আসবে --}}
                <option value="1">আব্দুল করিম</option>
            </select>
        </div>

    </div>


    {{-- OVERVIEW --}}
    <div class="history-overview">

        <div class="overview-card">
            <div class="overview-icon">
                <i class="fas fa-notes-medical"></i>
            </div>

            <div class="overview-info">
                <span>রোগের ইতিহাস</span>
                <strong id="illnessCount">0</strong>
            </div>
        </div>


        <div class="overview-card">
            <div class="overview-icon">
                <i class="fas fa-hospital"></i>
            </div>

            <div class="overview-info">
                <span>হাসপাতালে ভর্তি</span>
                <strong id="admissionCount">0</strong>
            </div>
        </div>


        <div class="overview-card">
            <div class="overview-icon">
                <i class="fas fa-file-prescription"></i>
            </div>

            <div class="overview-info">
                <span>প্রেসক্রিপশন</span>
                <strong id="prescriptionCount">0</strong>
            </div>
        </div>


        <div class="overview-card">
            <div class="overview-icon">
                <i class="fas fa-user-md"></i>
            </div>

            <div class="overview-info">
                <span>চিকিৎসক</span>
                <strong id="doctorCount">0</strong>
            </div>
        </div>

    </div>


    {{-- HISTORY CONTENT --}}
    <div class="history-grid">

        {{-- PREVIOUS ILLNESSES --}}
        <div class="history-card">

            <div class="card-header">

                <div class="card-header-left">

                    <div class="card-header-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>

                    <h3>পূর্ববর্তী রোগ ও অসুস্থতা</h3>

                </div>

            </div>

            <div class="card-body">

                <div class="empty-history">

                    <div class="empty-history-icon">
                        <i class="fas fa-notes-medical"></i>
                    </div>

                    <h4>কোনো রোগের তথ্য নেই</h4>

                    <p>
                        রোগীর পূর্ববর্তী অসুস্থতার তথ্য এখানে দেখা যাবে।
                    </p>

                </div>

            </div>

        </div>


        {{-- ADMISSION HISTORY --}}
        <div class="history-card">

            <div class="card-header">

                <div class="card-header-left">

                    <div class="card-header-icon">
                        <i class="fas fa-hospital-user"></i>
                    </div>

                    <h3>হাসপাতালে ভর্তি হওয়ার ইতিহাস</h3>

                </div>

            </div>

            <div class="card-body">

                <div class="empty-history">

                    <div class="empty-history-icon">
                        <i class="fas fa-hospital"></i>
                    </div>

                    <h4>কোনো ভর্তি তথ্য নেই</h4>

                    <p>
                        হাসপাতালে ভর্তি হওয়ার তথ্য এখানে দেখা যাবে।
                    </p>

                </div>

            </div>

        </div>


        {{-- DOCTOR / HOSPITAL --}}
        <div class="history-card">

            <div class="card-header">

                <div class="card-header-left">

                    <div class="card-header-icon">
                        <i class="fas fa-user-md"></i>
                    </div>

                    <h3>চিকিৎসক ও হাসপাতালের তথ্য</h3>

                </div>

            </div>

            <div class="card-body">

                <div class="doctor-info">

                    <div class="info-box">
                        <span>সর্বশেষ চিকিৎসক</span>
                        <strong>তথ্য নেই</strong>
                    </div>

                    <div class="info-box">
                        <span>হাসপাতাল</span>
                        <strong>তথ্য নেই</strong>
                    </div>

                    <div class="info-box">
                        <span>শেষ চিকিৎসার তারিখ</span>
                        <strong>তথ্য নেই</strong>
                    </div>

                    <div class="info-box">
                        <span>পরবর্তী ফলো-আপ</span>
                        <strong>তথ্য নেই</strong>
                    </div>

                </div>

            </div>

        </div>


        {{-- PRESCRIPTION HISTORY --}}
        <div class="history-card">

            <div class="card-header">

                <div class="card-header-left">

                    <div class="card-header-icon">
                        <i class="fas fa-file-medical"></i>
                    </div>

                    <h3>প্রেসক্রিপশন ইতিহাস</h3>

                </div>

            </div>

            <div class="card-body">

                <div class="empty-history">

                    <div class="empty-history-icon">
                        <i class="fas fa-file-prescription"></i>
                    </div>

                    <h4>কোনো প্রেসক্রিপশন নেই</h4>

                    <p>
                        রোগীর পূর্ববর্তী প্রেসক্রিপশনগুলো এখানে দেখা যাবে।
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

    /*
     * Backend integration পরে করা হবে।
     * Patient select করলে selected patient's
     * health history API থেকে load করা হবে।
     */

    document.getElementById('patientSelect').addEventListener('change', function () {

        const patientId = this.value;

        if (!patientId) {
            return;
        }

        console.log('Selected patient:', patientId);

        // Future:
        // fetch(`/api/patients/${patientId}/health-history`)
        //     .then(response => response.json())
        //     .then(data => {
        //         renderHealthHistory(data);
        //     });

    });

</script>

@endsection