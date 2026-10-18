@extends('layouts.app')

@section('title', 'অ্যাপয়েন্টমেন্ট - খেয়াল')

@section('page-title', 'অ্যাপয়েন্টমেন্ট')


@section('content')

                <!-- HEADER ROW -->

                <section class="welcome-section">

                    <div>

                        <h2 class="welcome-title">অ্যাপয়েন্টমেন্টসমূহ</h2>

                        <p class="welcome-subtitle">সব রোগীর ডাক্তারের অ্যাপয়েন্টমেন্ট এক জায়গায়</p>

                    </div>


                    <button
                        type="button"
                        id="addAppointmentBtn"
                        style="height:46px;padding:0 20px;border-radius:10px;border:none;background:var(--coral);color:#fff;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px;"
                    >

                        <svg
                            viewBox="0 0 24 24"
                            style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;"
                        >
                            <path d="M12 5v14M5 12h14" />
                        </svg>

                        নতুন অ্যাপয়েন্টমেন্ট

                    </button>

                </section>


                <!-- APPOINTMENTS LIST -->

                <section>

                    <div id="appointmentsListContainer">

                        <div style="padding:24px;text-align:center;color:var(--muted);">
                            লোড হচ্ছে...
                        </div>

                    </div>

                </section>


@endsection


@push('styles')

<style>

    .appt-card {
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

    .appt-card.past {
        opacity: 0.6;
    }

    .appt-patient {
        font-weight: 700;
        color: var(--ink);
        font-size: 0.95rem;
        margin-bottom: 4px;
    }

    .appt-detail {
        color: var(--muted);
        font-size: 0.85rem;
        line-height: 1.6;
    }

    .appt-badge {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 999px;
        margin-bottom: 6px;
    }

    .appt-badge.upcoming {
        background: #e8f7ee;
        color: #1f9d55;
    }

    .appt-badge.past {
        background: #eef1f5;
        color: var(--muted);
    }

    .appt-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .appt-actions button {
        border: 1px solid var(--line);
        background: #fff;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.8rem;
        cursor: pointer;
        color: var(--ink);
    }

    .appt-actions button.danger {
        color: var(--danger);
        border-color: #f6c9c9;
    }

</style>

@endpush


@push('modals')

<!-- ADD/EDIT APPOINTMENT MODAL -->

<div
    id="appointmentFormModal"
    style="display:none;position:fixed;inset:0;z-index:1000;background:rgba(15,27,61,0.45);align-items:center;justify-content:center;padding:16px;"
>

    <div
        style="background:#fff;border-radius:16px;width:100%;max-width:460px;max-height:85vh;overflow-y:auto;padding:24px;box-shadow:0 20px 50px rgba(0,0,0,0.2);"
    >

        <h3
            id="appointmentFormTitle"
            style="font-family:'Noto Sans Bengali',sans-serif;font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:16px;"
        >
            নতুন অ্যাপয়েন্টমেন্ট
        </h3>


        <form id="appointmentForm">

            <input
                type="hidden"
                id="appointmentId"
                value=""
            >


            <div style="margin-bottom:12px;">

                <label
                    style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;"
                >
                    রোগী *
                </label>

                <select
                    id="appointmentPatient"
                    required
                    style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;"
                >

                    <option value="">নির্বাচন করুন</option>

                </select>

            </div>


            <div style="margin-bottom:12px;">

                <label
                    style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;"
                >
                    ডাক্তারের নাম
                </label>

                <input
                    type="text"
                    id="appointmentDoctor"
                    style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;"
                >

            </div>


            <div style="margin-bottom:12px;">

                <label
                    style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;"
                >
                    স্থান
                </label>

                <input
                    type="text"
                    id="appointmentLocation"
                    placeholder="যেমন: স্কয়ার হাসপাতাল"
                    style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;"
                >

            </div>


            <div style="margin-bottom:12px;">

                <label
                    style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;"
                >
                    তারিখ ও সময় *
                </label>

                <input
                    type="datetime-local"
                    id="appointmentDate"
                    required
                    style="width:100%;height:44px;padding:0 12px;border:1px solid var(--line);border-radius:10px;outline:none;"
                >

            </div>


            <div style="margin-bottom:16px;">

                <label
                    style="display:block;font-size:0.85rem;font-weight:600;color:var(--ink);margin-bottom:6px;"
                >
                    নোট
                </label>

                <textarea
                    id="appointmentNotes"
                    rows="2"
                    style="width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:10px;outline:none;resize:vertical;"
                ></textarea>

            </div>


            <div
                id="appointmentFormError"
                style="display:none;background:#fff0f0;border:1px solid #f6c9c9;color:var(--danger);border-radius:10px;padding:10px 12px;font-size:0.85rem;margin-bottom:12px;"
            ></div>


            <div style="display:flex;gap:10px;">

                <button
                    type="button"
                    id="cancelAppointmentForm"
                    style="flex:1;height:46px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--ink);font-weight:600;cursor:pointer;"
                >
                    বাতিল
                </button>

                <button
                    type="submit"
                    id="submitAppointmentForm"
                    style="flex:1;height:46px;border-radius:10px;border:none;background:var(--coral);color:#fff;font-weight:600;cursor:pointer;"
                >
                    সংরক্ষণ করুন
                </button>

            </div>

        </form>

    </div>

</div>

@endpush


@push('scripts')


    let patientsCache = [];


    async function loadPatientsForSelect() {

        const res = await apiFetch('/patients');

        if (!res || !res.ok) return;

        patientsCache = await res.json();


        const select = document.getElementById('appointmentPatient');

        select.innerHTML = '<option value="">নির্বাচন করুন</option>';


        patientsCache.forEach(p => {

            const opt = document.createElement('option');

            opt.value = p.id;

            opt.textContent = p.name;

            select.appendChild(opt);

        });

    }


    /*
    =========================================================
    APPOINTMENT DATE/TIME HELPERS
    =========================================================

    Database/API time may be UTC.

    The caregiver interface should always show
    Bangladesh time (Asia/Dhaka).

    datetime-local does not contain timezone information,
    so we explicitly convert the API value to Dhaka time.
    =========================================================
    */


    function getAppointmentDate(value) {

        if (!value) return null;

        /*
         * Laravel may return:
         *
         * 2026-10-08T14:00:00.000000Z
         *
         * or:
         *
         * 2026-10-08 14:00:00
         *
         */

        let normalized = String(value).trim();

        /*
         * If the value is a normal ISO datetime with timezone,
         * let JavaScript parse it normally.
         */

        if (
            normalized.includes('T') &&
            (
                normalized.endsWith('Z') ||
                normalized.includes('+') ||
                /-\d{2}:\d{2}$/.test(normalized)
            )
        ) {

            const d = new Date(normalized);

            return Number.isNaN(d.getTime()) ? null : d;
        }


        /*
         * Laravel/MySQL values without timezone:
         *
         * 2026-10-08 14:00:00
         *
         * Treat these as UTC because the application stores
         * timestamps in UTC.
         */

        normalized = normalized.replace(' ', 'T');

        if (!normalized.endsWith('Z')) {
            normalized += 'Z';
        }

        const d = new Date(normalized);

        return Number.isNaN(d.getTime()) ? null : d;
    }


    function toDatetimeLocalValue(value) {

        if (!value) return '';


        const d = getAppointmentDate(value);

        if (!d) return '';


        /*
         * Convert UTC date/time to Bangladesh time.
         */

        const parts = new Intl.DateTimeFormat('en-CA', {

            timeZone: 'Asia/Dhaka',

            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',

            hour12: false,

        }).formatToParts(d);


        const map = {};


        parts.forEach(part => {

            if (part.type !== 'literal') {

                map[part.type] = part.value;

            }

        });


        return `${map.year}-${map.month}-${map.day}T${map.hour}:${map.minute}`;
    }


    /*
    =========================================================
    DISPLAY DATE/TIME
    =========================================================
    */

    function formatDateTime(value) {

        const d = getAppointmentDate(value);

        if (!d) return 'তারিখ পাওয়া যায়নি';


        return new Intl.DateTimeFormat('bn-BD', {

            timeZone: 'Asia/Dhaka',

            year: 'numeric',
            month: 'long',
            day: 'numeric',

            hour: 'numeric',
            minute: '2-digit',

            hour12: true,

        }).format(d);

    }


    /*
    =========================================================
    APPOINTMENT CARD
    =========================================================
    */

    function buildAppointmentCard(appt) {

        const card = document.createElement('div');


        const appointmentDate = getAppointmentDate(appt.appointment_date);

        const isPast =
            appointmentDate !== null &&
            appointmentDate < new Date();


        card.className = 'appt-card' + (isPast ? ' past' : '');


        const patientName =
            appt.patient?.name || 'অজানা রোগী';


        card.innerHTML = `

            <div>

                <span class="appt-badge ${isPast ? 'past' : 'upcoming'}">
                    ${isPast ? 'সম্পন্ন' : 'আসন্ন'}
                </span>

                <div class="appt-patient">
                    ${esc(patientName)}
                </div>

                <div class="appt-detail">

                    ${
                        appt.doctor_name
                            ? esc(appt.doctor_name) + '<br>'
                            : ''
                    }

                    ${formatDateTime(appt.appointment_date)}

                    ${
                        appt.location
                            ? '<br>স্থান: ' + esc(appt.location)
                            : ''
                    }

                    ${
                        appt.notes
                            ? '<br>নোট: ' + esc(appt.notes)
                            : ''
                    }

                </div>

            </div>


            <div class="appt-actions">

                <button
                    type="button"
                    data-action="edit"
                >
                    সম্পাদনা
                </button>

                <button
                    type="button"
                    data-action="delete"
                    class="danger"
                >
                    মুছুন
                </button>

            </div>

        `;


        card
            .querySelector('[data-action="edit"]')
            .addEventListener(
                'click',
                () => openAppointmentForm(appt)
            );


        card
            .querySelector('[data-action="delete"]')
            .addEventListener(
                'click',
                () => deleteAppointment(appt.id)
            );


        return card;

    }


    /*
    =========================================================
    LOAD APPOINTMENTS
    =========================================================
    */

    async function loadAppointments() {

        const container =
            document.getElementById('appointmentsListContainer');


        const res = await apiFetch('/appointments');


        if (!res || !res.ok) {

            container.innerHTML = `
                <div
                    style="padding:24px;text-align:center;color:var(--danger);"
                >
                    অ্যাপয়েন্টমেন্ট লোড করা যায়নি।
                </div>
            `;

            return;

        }


        const appointments = await res.json();


        if (appointments.length === 0) {

            container.innerHTML = `
                <div
                    style="padding:32px;text-align:center;color:var(--muted);"
                >
                    এখনো কোনো অ্যাপয়েন্টমেন্ট যোগ করা হয়নি।
                </div>
            `;

            return;

        }


        container.innerHTML = '';


        appointments.forEach(a => {

            container.appendChild(
                buildAppointmentCard(a)
            );

        });

    }


    /*
    =========================================================
    APPOINTMENT FORM MODAL
    =========================================================
    */

    const appointmentFormModal =
        document.getElementById('appointmentFormModal');


    const appointmentForm =
        document.getElementById('appointmentForm');


    const appointmentFormError =
        document.getElementById('appointmentFormError');


    function openAppointmentForm(appt = null) {

        appointmentForm.reset();

        appointmentFormError.style.display = 'none';


        const patientSelect =
            document.getElementById('appointmentPatient');


        if (appt) {

            document.getElementById(
                'appointmentFormTitle'
            ).textContent =
                'অ্যাপয়েন্টমেন্ট সম্পাদনা করুন';


            document.getElementById(
                'appointmentId'
            ).value = appt.id;


            patientSelect.value =
                appt.patient_id;


            patientSelect.disabled = true;


            document.getElementById(
                'appointmentDoctor'
            ).value =
                appt.doctor_name || '';


            document.getElementById(
                'appointmentLocation'
            ).value =
                appt.location || '';


            /*
             * IMPORTANT:
             *
             * API/DB time → Bangladesh local time
             *
             * Example:
             *
             * UTC 14:00
             *      ↓
             * Dhaka 20:00
             */

            document.getElementById(
                'appointmentDate'
            ).value =
                toDatetimeLocalValue(
                    appt.appointment_date
                );


            document.getElementById(
                'appointmentNotes'
            ).value =
                appt.notes || '';

        } else {

            document.getElementById(
                'appointmentFormTitle'
            ).textContent =
                'নতুন অ্যাপয়েন্টমেন্ট';


            document.getElementById(
                'appointmentId'
            ).value = '';


            patientSelect.disabled = false;

        }


        appointmentFormModal.style.display = 'flex';

    }


    function closeAppointmentForm() {

        appointmentFormModal.style.display = 'none';

    }


    document
        .getElementById('addAppointmentBtn')
        .addEventListener(
            'click',
            () => openAppointmentForm()
        );


    document
        .getElementById('cancelAppointmentForm')
        .addEventListener(
            'click',
            closeAppointmentForm
        );


    appointmentFormModal.addEventListener(
        'click',
        (e) => {

            if (e.target === appointmentFormModal) {

                closeAppointmentForm();

            }

        }
    );


    /*
    =========================================================
    SAVE APPOINTMENT
    =========================================================
    */

    appointmentForm.addEventListener(
        'submit',
        async (e) => {

            e.preventDefault();

            appointmentFormError.style.display = 'none';


            const submitBtn =
                document.getElementById(
                    'submitAppointmentForm'
                );


            submitBtn.disabled = true;

            submitBtn.textContent =
                'সংরক্ষণ হচ্ছে...';


            const id =
                document.getElementById(
                    'appointmentId'
                ).value;


            const patientId =
                document.getElementById(
                    'appointmentPatient'
                ).value;


            try {

                let res;


                /*
                 * datetime-local value:
                 *
                 * 2026-10-08T20:00
                 *
                 * This represents Bangladesh local time.
                 *
                 * DO NOT use:
                 *
                 * new Date(value).toISOString()
                 *
                 * here because that can cause timezone
                 * conversion before sending to Laravel.
                 */


                const appointmentDate =
                    document.getElementById(
                        'appointmentDate'
                    ).value;


                if (!appointmentDate) {

                    appointmentFormError.textContent =
                        'তারিখ ও সময় নির্বাচন করুন।';

                    appointmentFormError.style.display =
                        'block';

                    return;

                }


                if (id) {

                    const payload = {

                        doctor_name:
                            document.getElementById(
                                'appointmentDoctor'
                            ).value.trim() || null,

                        location:
                            document.getElementById(
                                'appointmentLocation'
                            ).value.trim() || null,

                        appointment_date:
                            appointmentDate,

                        notes:
                            document.getElementById(
                                'appointmentNotes'
                            ).value.trim() || null,

                    };


                    res = await apiFetch(
                        `/appointments/${id}`,
                        {
                            method: 'PUT',

                            body: JSON.stringify(
                                payload
                            ),
                        }
                    );

                } else {

                    if (!patientId) {

                        appointmentFormError.textContent =
                            'রোগী নির্বাচন করুন।';

                        appointmentFormError.style.display =
                            'block';

                        return;

                    }


                    const payload = {

                        doctor_name:
                            document.getElementById(
                                'appointmentDoctor'
                            ).value.trim() || null,

                        location:
                            document.getElementById(
                                'appointmentLocation'
                            ).value.trim() || null,

                        appointment_date:
                            appointmentDate,

                        notes:
                            document.getElementById(
                                'appointmentNotes'
                            ).value.trim() || null,

                    };


                    res = await apiFetch(
                        `/patients/${patientId}/appointments`,
                        {
                            method: 'POST',

                            body: JSON.stringify(
                                payload
                            ),
                        }
                    );

                }


                if (!res) return;


                if (!res.ok) {

                    const data =
                        await res.json()
                            .catch(() => ({}));


                    appointmentFormError.textContent =
                        data.message ||
                        'সংরক্ষণ করা যায়নি। আবার চেষ্টা করুন।';


                    appointmentFormError.style.display =
                        'block';


                    return;

                }


                closeAppointmentForm();

                await loadAppointments();


            } catch (err) {

                appointmentFormError.textContent =
                    'সার্ভারের সাথে সংযোগ করা যায়নি।';


                appointmentFormError.style.display =
                    'block';

            } finally {

                submitBtn.disabled = false;

                submitBtn.textContent =
                    'সংরক্ষণ করুন';

            }

        }
    );


    /*
    =========================================================
    DELETE APPOINTMENT
    =========================================================
    */

    async function deleteAppointment(id) {

        if (
            !confirm(
                'আপনি কি নিশ্চিত এই অ্যাপয়েন্টমেন্ট মুছে ফেলতে চান?'
            )
        ) {
            return;
        }


        const res = await apiFetch(
            `/appointments/${id}`,
            {
                method: 'DELETE'
            }
        );


        if (res && res.ok) {

            await loadAppointments();

        }

    }


    /*
    =========================================================
    INIT
    =========================================================
    */

    if (token) {

        loadProfile();

        loadPatientsForSelect();

        loadAppointments();

    }

@endpush