@extends('layouts.app')

@section('title', 'প্রেসক্রিপশনসমূহ - খেয়াল')
@section('page-title', 'প্রেসক্রিপশনসমূহ')

@section('content')

<style>
    .prescriptions-page {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* =========================================================
       PAGE HEADER
    ========================================================= */

    .prescriptions-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
    }

    .prescriptions-heading h2 {
        margin: 0;
        font-family: 'Noto Serif Bengali', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--ink);
    }

    .prescriptions-heading p {
        margin: 6px 0 0;
        color: var(--muted);
        font-size: 14px;
        line-height: 1.7;
    }

    .scan-new-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 42px;
        padding: 0 16px;
        border: 0;
        border-radius: 10px;
        background: var(--coral);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: .2s ease;
    }

    .scan-new-btn:hover {
        opacity: .92;
        transform: translateY(-1px);
    }

    .scan-new-btn svg {
        width: 18px;
        height: 18px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }


    /* =========================================================
       SUMMARY CARDS
    ========================================================= */

    .prescription-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .prescription-stat {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 17px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 15px;
        box-shadow: 0 8px 22px rgba(15, 27, 61, .05);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: grid;
        place-items: center;
        border-radius: 11px;
        background: rgba(255, 92, 92, .09);
        color: var(--coral);
    }

    .stat-icon svg {
        width: 21px;
        height: 21px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .stat-label {
        color: var(--muted);
        font-size: 12px;
    }

    .stat-value {
        margin-top: 2px;
        color: var(--ink);
        font-size: 21px;
        font-weight: 700;
    }


    /* =========================================================
       MAIN CARD
    ========================================================= */

    .prescription-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(15, 27, 61, .06);
    }

    .prescription-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 19px 20px;
        border-bottom: 1px solid var(--line);
    }

    .card-heading {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .card-heading-icon {
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        background: #0f1b3d;
        color: #fff;
    }

    .card-heading-icon svg {
        width: 20px;
        height: 20px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.7;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .card-heading-title {
        color: var(--ink);
        font-size: 15px;
        font-weight: 700;
    }

    .card-heading-subtitle {
        margin-top: 2px;
        color: var(--muted);
        font-size: 12px;
    }


    /* =========================================================
       FILTER
    ========================================================= */

    .filter-area {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-box {
        position: relative;
    }

    .search-box svg {
        position: absolute;
        left: 11px;
        top: 50%;
        width: 16px;
        height: 16px;
        transform: translateY(-50%);
        fill: none;
        stroke: var(--muted);
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
        pointer-events: none;
    }

    .search-input {
        width: 220px;
        height: 38px;
        padding: 0 11px 0 35px;
        border: 1px solid var(--line);
        border-radius: 9px;
        outline: none;
        background: #fff;
        color: var(--ink);
        font-size: 12px;
    }

    .search-input:focus {
        border-color: var(--coral);
        box-shadow: 0 0 0 3px rgba(255, 92, 92, .08);
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 390px;
        padding: 45px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 78px;
        height: 78px;
        display: grid;
        place-items: center;
        border-radius: 22px;
        background: #f1f4f8;
        color: #0f1b3d;
    }

    .empty-icon svg {
        width: 38px;
        height: 38px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.5;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .empty-title {
        margin-top: 19px;
        color: var(--ink);
        font-size: 17px;
        font-weight: 700;
    }

    .empty-text {
        max-width: 430px;
        margin-top: 7px;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.8;
    }

    .empty-action {
        margin-top: 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 42px;
        padding: 0 17px;
        border-radius: 10px;
        background: #0f1b3d;
        color: #fff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: .2s ease;
    }

    .empty-action:hover {
        background: var(--coral);
    }

    .empty-action svg {
        width: 17px;
        height: 17px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }


    /* =========================================================
       TABLE
       Hidden until prescription data exists
    ========================================================= */

    .prescription-table-wrapper {
        display: none;
        overflow-x: auto;
    }

    .prescription-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 760px;
    }

    .prescription-table th {
        padding: 13px 18px;
        text-align: left;
        background: #f8fafc;
        color: var(--muted);
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .prescription-table td {
        padding: 15px 18px;
        border-top: 1px solid var(--line);
        color: var(--ink);
        font-size: 12px;
        vertical-align: middle;
    }

    .prescription-table tbody tr:hover {
        background: #fafbfd;
    }

    .patient-name {
        font-weight: 700;
    }

    .date-text {
        color: var(--muted);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        height: 26px;
        padding: 0 9px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
    }

    .status-pending {
        background: #fff4df;
        color: #9a6700;
    }

    .status-confirmed {
        background: #eaf7ef;
        color: #19703b;
    }

    .view-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 32px;
        padding: 0 11px;
        border: 1px solid var(--line);
        border-radius: 8px;
        background: #fff;
        color: var(--ink);
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
    }

    .view-btn:hover {
        border-color: var(--coral);
        color: var(--coral);
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 850px) {

        .prescriptions-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .prescription-stats {
            grid-template-columns: 1fr;
        }

        .prescription-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .filter-area {
            width: 100%;
        }

        .search-box,
        .search-input {
            width: 100%;
        }
    }

    @media (max-width: 600px) {

        .prescriptions-heading h2 {
            font-size: 21px;
        }

        .scan-new-btn {
            width: 100%;
        }

        .prescription-card-header {
            padding: 16px;
        }

        .empty-state {
            min-height: 330px;
        }
    }
</style>


<div class="prescriptions-page">

    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->

    <div class="prescriptions-heading">

        <div>
            <h2>প্রেসক্রিপশনসমূহ</h2>

            <p>
                আপনার রোগীদের সংরক্ষিত প্রেসক্রিপশনগুলো এখান থেকে দেখুন ও পরিচালনা করুন।
            </p>
        </div>

        <a href="/prescriptions/scan" class="scan-new-btn">

            <svg viewBox="0 0 24 24">
                <path d="M12 5v14"/>
                <path d="M5 12h14"/>
            </svg>

            নতুন প্রেসক্রিপশন
        </a>

    </div>


    <!-- =====================================================
         SUMMARY
    ====================================================== -->

    <div class="prescription-stats">

        <div class="prescription-stat">

            <div class="stat-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M6 2h9l4 4v16H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/>
                    <path d="M14 2v5h5"/>
                    <path d="M8 11h8"/>
                    <path d="M8 15h8"/>
                    <path d="M8 19h5"/>
                </svg>
            </div>

            <div>
                <div class="stat-label">মোট প্রেসক্রিপশন</div>
                <div class="stat-value" id="totalPrescriptions">০</div>
            </div>

        </div>


        <div class="prescription-stat">

            <div class="stat-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>
            </div>

            <div>
                <div class="stat-label">পর্যালোচনার অপেক্ষায়</div>
                <div class="stat-value" id="pendingPrescriptions">০</div>
            </div>

        </div>


        <div class="prescription-stat">

            <div class="stat-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
            </div>

            <div>
                <div class="stat-label">নিশ্চিত করা হয়েছে</div>
                <div class="stat-value" id="confirmedPrescriptions">০</div>
            </div>

        </div>

    </div>


    <!-- =====================================================
         PRESCRIPTION LIST
    ====================================================== -->

    <div class="prescription-card">

        <div class="prescription-card-header">

            <div class="card-heading">

                <div class="card-heading-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M6 2h9l4 4v16H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/>
                        <path d="M14 2v5h5"/>
                        <path d="M8 11h8"/>
                        <path d="M8 15h8"/>
                    </svg>
                </div>

                <div>
                    <div class="card-heading-title">
                        সকল প্রেসক্রিপশন
                    </div>

                    <div class="card-heading-subtitle">
                        রোগী অনুযায়ী প্রেসক্রিপশনের তালিকা
                    </div>
                </div>

            </div>


            <div class="filter-area">

                <div class="search-box">

                    <svg viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="M20 20l-4-4"/>
                    </svg>

                    <input
                        type="text"
                        id="prescriptionSearch"
                        class="search-input"
                        placeholder="প্রেসক্রিপশন খুঁজুন..."
                    >

                </div>

            </div>

        </div>


        <!-- TABLE -->

        <div id="prescriptionTableWrapper" class="prescription-table-wrapper">

            <table class="prescription-table">

                <thead>
                    <tr>
                        <th>রোগী</th>
                        <th>ডাক্তার</th>
                        <th>প্রেসক্রিপশন তারিখ</th>
                        <th>আপলোডের তারিখ</th>
                        <th>স্ট্যাটাস</th>
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>

                <tbody id="prescriptionTableBody">
                </tbody>

            </table>

        </div>


        <!-- EMPTY STATE -->

        <div id="emptyState" class="empty-state">

            <div class="empty-icon">

                <svg viewBox="0 0 24 24">
                    <path d="M6 2h9l4 4v16H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/>
                    <path d="M14 2v5h5"/>
                    <path d="M8 12h8"/>
                    <path d="M8 16h5"/>
                </svg>

            </div>


            <div class="empty-title">
                এখনো কোনো প্রেসক্রিপশন নেই
            </div>


            <div class="empty-text">
                কোনো রোগীর প্রেসক্রিপশন এখনো সংরক্ষণ করা হয়নি।
                নতুন প্রেসক্রিপশন স্ক্যান করে এখান থেকে দেখতে পারবেন।
            </div>


            <a href="/prescriptions/scan" class="empty-action">

                <svg viewBox="0 0 24 24">
                    <path d="M12 5v14"/>
                    <path d="M5 12h14"/>
                </svg>

                প্রেসক্রিপশন স্ক্যান করুন

            </a>

        </div>

    </div>

</div>


@push('scripts')

<script>

    const searchInput =
        document.getElementById('prescriptionSearch');

    const tableWrapper =
        document.getElementById('prescriptionTableWrapper');

    const tableBody =
        document.getElementById('prescriptionTableBody');

    const emptyState =
        document.getElementById('emptyState');

    const totalPrescriptions =
        document.getElementById('totalPrescriptions');

    const pendingPrescriptions =
        document.getElementById('pendingPrescriptions');

    const confirmedPrescriptions =
        document.getElementById('confirmedPrescriptions');


    /*
     * Frontend preparation:
     *
     * Prescription API এখনো তৈরি হয়নি।
     * তাই page বর্তমানে empty state দেখাবে।
     *
     * Backend তৈরি হলে এখানে API data বসানো হবে।
     */


    function showEmptyState() {

        tableWrapper.style.display = 'none';

        emptyState.style.display = 'flex';

        totalPrescriptions.textContent = '০';

        pendingPrescriptions.textContent = '০';

        confirmedPrescriptions.textContent = '০';

    }


    /*
     * Future data renderer.
     *
     * Backend থেকে prescription data এলে
     * এই function ব্যবহার করে table populate করা যাবে।
     */

    function renderPrescriptions(prescriptions) {

        if (!prescriptions || prescriptions.length === 0) {

            showEmptyState();

            return;
        }


        emptyState.style.display = 'none';

        tableWrapper.style.display = 'block';


        tableBody.innerHTML = '';


        let pending = 0;

        let confirmed = 0;


        prescriptions.forEach(function(prescription) {

            if (prescription.status === 'pending') {
                pending++;
            }

            if (prescription.status === 'confirmed') {
                confirmed++;
            }


            const row =
                document.createElement('tr');


            row.innerHTML = `

                <td>
                    <div class="patient-name">
                        ${prescription.patient?.name ?? '—'}
                    </div>
                </td>

                <td>
                    ${prescription.doctor_name ?? '—'}
                </td>

                <td>
                    <span class="date-text">
                        ${prescription.prescription_date ?? '—'}
                    </span>
                </td>

                <td>
                    <span class="date-text">
                        ${prescription.created_at ?? '—'}
                    </span>
                </td>

                <td>

                    ${
                        prescription.status === 'confirmed'

                        ? `
                            <span class="status-badge status-confirmed">
                                নিশ্চিত
                            </span>
                          `

                        : `
                            <span class="status-badge status-pending">
                                অপেক্ষমাণ
                            </span>
                          `
                    }

                </td>

                <td>

                    <a
                        href="/prescriptions/${prescription.id}"
                        class="view-btn"
                    >
                        দেখুন
                    </a>

                </td>

            `;


            tableBody.appendChild(row);

        });


        totalPrescriptions.textContent =
            prescriptions.length.toLocaleString('bn-BD');

        pendingPrescriptions.textContent =
            pending.toLocaleString('bn-BD');

        confirmedPrescriptions.textContent =
            confirmed.toLocaleString('bn-BD');

    }


    /*
     * Search
     *
     * Backend data আসার পরে table filtering
     * এখান থেকেই কাজ করবে।
     */

    searchInput.addEventListener('input', function() {

        const searchTerm =
            this.value.trim().toLowerCase();


        const rows =
            tableBody.querySelectorAll('tr');


        rows.forEach(function(row) {

            const text =
                row.textContent.toLowerCase();


            row.style.display =
                text.includes(searchTerm)
                    ? ''
                    : 'none';

        });

    });


    /*
     * এখন backend API না থাকায়
     * empty state দেখানো হচ্ছে।
     */

    showEmptyState();

</script>

@endpush

@endsection