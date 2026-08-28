<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>লগইন - খেয়াল</title>
    @vite('resources/css/app.css')
    <style>
        * {
            box-sizing: border-box;
        }
    </style>
</head>

<body class="min-h-screen lg:h-[100dvh] lg:overflow-hidden bg-[#F8FAFC] font-body">

    <div class="w-full min-h-screen lg:h-[100dvh] overflow-y-auto lg:overflow-hidden grid grid-cols-1 lg:grid-cols-[1.05fr_0.95fr]">

        {{-- =====================================================
             LEFT SIDE — BRANDING (DESKTOP ONLY)
        ====================================================== --}}
        <section class="relative hidden lg:flex h-[100dvh] overflow-hidden bg-[#0F1B3D] px-8 py-7 xl:px-16 xl:py-10 flex-col justify-between">

            {{-- Background --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-[#172554] via-[#0F1B3D] to-[#080F24]"></div>
                <div class="absolute -top-40 -right-40 w-[32rem] h-[32rem] rounded-full bg-[#FF5C5C]/10 blur-3xl"></div>
                <div class="absolute -bottom-40 -left-32 w-[28rem] h-[28rem] rounded-full bg-[#FF5C5C]/10 blur-3xl"></div>
                <div class="absolute top-12 right-10 w-80 h-80 rounded-full border border-white/[0.04]"></div>
                <div class="absolute top-24 right-22 w-56 h-56 rounded-full border border-white/[0.04]"></div>
                <div class="absolute bottom-24 right-24 w-3 h-3 rounded-full bg-[#FF5C5C]/40"></div>
                <div class="absolute bottom-36 right-40 w-2 h-2 rounded-full bg-white/20"></div>
            </div>

            <div class="relative z-10">
                <img src="{{ asset('images/logo.png') }}" alt="খেয়াল" class="w-64 xl:w-72 h-auto object-contain">
            </div>

            {{-- MAIN CONTENT --}}
            <div class="relative z-10 max-w-xl -mt-4">
                {{-- Status badge --}}
                <div class="inline-flex items-center gap-2 px-4 py-2 mb-5 xl:mb-7 rounded-full bg-white/[0.06] border border-white/[0.10] backdrop-blur-sm text-white/65 text-sm">
                    <span class="relative flex w-2.5 h-2.5">
                        <span class="absolute inline-flex w-full h-full rounded-full bg-[#FF5C5C] opacity-75 animate-ping"></span>
                        <span class="relative inline-flex w-2.5 h-2.5 rounded-full bg-[#FF5C5C]"></span>
                    </span>
                    আপনার প্রিয়জনের যত্নে, সবসময় পাশে
                </div>

                {{-- Main heading --}}
                <h1 class="font-heading font-extrabold text-white tracking-tight leading-[1.08] text-[clamp(3rem,5vw,5rem)] mb-8">
                    যত্ন থাকে <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF5C5C] via-[#FF7168] to-[#FF9B91]">
                        খেয়ালে।
                    </span>
                </h1>

                {{-- Feature cards --}}
                <div class="grid grid-cols-3 gap-3 max-w-xl">
                    {{-- Medicine --}}
                    <div class="p-3 xl:p-4 rounded-2xl bg-white/[0.06] border border-white/[0.10] backdrop-blur-sm transition duration-300 hover:bg-white/[0.10] hover:-translate-y-1">
                        <div class="w-10 h-10 xl:w-11 xl:h-11 mb-3 rounded-xl bg-[#FF5C5C]/15 text-[#FF6B63] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 3.75L20.25 13.5a4.243 4.243 0 01-6 6L4.5 9.75a4.243 4.243 0 016-6z" />
                            </svg>
                        </div>
                        <p class="text-xs xl:text-sm font-medium text-white/85">ওষুধ স্মরণিকা</p>
                    </div>

                    {{-- Check-in --}}
                    <div class="p-3 xl:p-4 rounded-2xl bg-white/[0.06] border border-white/[0.10] backdrop-blur-sm transition duration-300 hover:bg-white/[0.10] hover:-translate-y-1">
                        <div class="w-10 h-10 xl:w-11 xl:h-11 mb-3 rounded-xl bg-[#FF5C5C]/15 text-[#FF6B63] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 a9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-xs xl:text-sm font-medium text-white/85">দৈনিক চেক-ইন</p>
                    </div>

                    {{-- SOS --}}
                    <div class="p-3 xl:p-4 rounded-2xl bg-white/[0.06] border border-white/[0.10] backdrop-blur-sm transition duration-300 hover:bg-white/[0.10] hover:-translate-y-1">
                        <div class="w-10 h-10 xl:w-11 xl:h-11 mb-3 rounded-xl bg-[#FF5C5C]/15 text-[#FF6B63] flex items-center justify-center font-bold">
                            SOS
                        </div>
                        <p class="text-xs xl:text-sm font-medium text-white/85">জরুরি সহায়তা</p>
                    </div>
                </div>
            </div>

            {{-- Bottom text --}}
            <div class="relative z-10 flex items-center gap-3 text-sm text-white/35">
                <div class="h-px w-10 bg-white/20"></div>
                দূরে থেকেও থাকুন পাশে
            </div>

        </section>

        {{-- =====================================================
             RIGHT SIDE — LOGIN FORM
        ====================================================== --}}
        <main class="relative min-h-screen lg:h-[100dvh] overflow-y-auto lg:overflow-hidden flex flex-col items-center justify-center px-6 py-10 sm:px-10 lg:px-12 xl:px-20">

            {{-- Mobile background glow --}}
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-[#FF5C5C]/5 rounded-full blur-3xl lg:hidden pointer-events-none"></div>

            <div class="relative z-10 w-full max-w-md my-auto">

                {{-- Mobile Brand Header --}}
                <div class="flex justify-center mb-6 lg:hidden">
                    <img
                        src="{{ asset('images/banano-logo.png') }}"
                        alt="খেয়াল"
                        class="w-44 sm:w-52 h-auto object-contain"
                    >
                </div>

                {{-- Heading --}}
                <div class="mb-6 xl:mb-8 text-center sm:text-left">
                    

                    <h2 class="text-3xl font-heading font-bold text-[#0F1B3D] tracking-tight mb-2">
                        স্বাগতম ফিরে এসেছেন
                    </h2>

                    <p class="text-slate-500 leading-relaxed">
                        আপনার অ্যাকাউন্টে লগইন করুন
                    </p>
                </div>

                {{-- LOGIN FORM --}}
                <form id="loginForm" class="space-y-4">

                    {{-- Email --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-[#0F1B3D]">
                            ইমেইল ঠিকানা
                        </label>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-.966 1.855l-7.5 5.25a2.25 2.25 0 01-2.568 0l-7.5-5.25A2.25 2.25 0 012.25 6.993" />
                                </svg>
                            </span>

                            <input
                                type="email"
                                id="email"
                                required
                                autocomplete="email"
                                placeholder="you@example.com"
                                class="w-full h-[52px] xl:h-[56px] pl-12 pr-4 rounded-xl bg-white border border-slate-200 text-slate-800 placeholder:text-slate-400 shadow-sm outline-none transition-all duration-200 focus:border-[#FF5C5C] focus:ring-4 focus:ring-[#FF5C5C]/10"
                            >
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-semibold text-[#0F1B3D]">
                                পাসওয়ার্ড
                            </label>

                            <a href="#" class="text-xs font-medium text-[#FF5C5C] hover:text-[#E64B4B] transition">
                                পাসওয়ার্ড ভুলে গেছেন?
                            </a>
                        </div>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.8" />
                                    <path d="M8 10V7a4 4 0 018 0v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                </svg>
                            </span>

                            <input
                                type="password"
                                id="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full h-[52px] xl:h-[56px] pl-12 pr-12 rounded-xl bg-white border border-slate-200 text-slate-800 placeholder:text-slate-400 shadow-sm outline-none transition-all duration-200 focus:border-[#FF5C5C] focus:ring-4 focus:ring-[#FF5C5C]/10"
                            >

                            {{-- Show / Hide Password --}}
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#0F1B3D] transition"
                                aria-label="পাসওয়ার্ড দেখুন"
                            >
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 12S5.25 5.25 12 5.25 21.75 12 21.75 12 18.75 18.75 12 18.75 2.25 12 2.25 12Z" />
                                    <circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.8" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Error Message --}}
                    <div id="errorMsg" class="hidden rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-600"></div>

                    {{-- Login Button --}}
                    <button
                        type="submit"
                        id="loginButton"
                        class="group w-full h-[52px] xl:h-[56px] mt-1 rounded-xl bg-[#FF5C5C] hover:bg-[#EF5050] text-white font-semibold shadow-lg shadow-[#FF5C5C]/20 hover:shadow-xl hover:shadow-[#FF5C5C]/25 transition-all duration-200 active:scale-[0.99] flex items-center justify-center gap-2"
                    >
                        <span>লগইন করুন</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>

                </form>

                {{-- Register --}}
                <div class="mt-6 text-center">
                    <p class="text-sm text-slate-500">
                        নতুন ব্যবহারকারী?
                        <a href="/register" class="ml-1 font-semibold text-[#0F1B3D] hover:text-[#FF5C5C] transition">
                            অ্যাকাউন্ট তৈরি করুন
                        </a>
                    </p>
                </div>

                {{-- Security --}}
                <div class="mt-6 xl:mt-8 flex items-center justify-center gap-2 text-xs text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m6.364-9.364a9 9 0 11-12.728 0 a9 9 0 0112.728 0z" />
                    </svg>
                    আপনার তথ্য নিরাপদ ও সুরক্ষিত
                </div>

            </div>

        </main>

    </div>

    <script>
        /* ==========================================
           PASSWORD SHOW / HIDE WITH SVG TOGGLE
        =========================================== */
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        const eyeOpenSVG = `
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 12S5.25 5.25 12 5.25 21.75 12 21.75 12 18.75 18.75 12 18.75 2.25 12 2.25 12Z"/>
                <circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.8"/>
            </svg>`;

        const eyeOffSVG = `
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
            </svg>`;

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            this.innerHTML = isPassword ? eyeOffSVG : eyeOpenSVG;
        });

        /* ==========================================
           LOGIN WITH FORM ERROR STYLING
        =========================================== */
        const emailInput = document.getElementById('email');

        function clearErrors() {
            const errorMsg = document.getElementById('errorMsg');
            errorMsg.textContent = '';
            errorMsg.classList.add('hidden');

            [emailInput, passwordInput].forEach(input => {
                input.classList.remove('border-red-500', 'focus:ring-red-500/10');
            });
        }

        [emailInput, passwordInput].forEach(input => {
            input.addEventListener('input', clearErrors);
        });

        document.getElementById('loginForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const email = emailInput.value.trim();
            const password = passwordInput.value;
            const errorMsg = document.getElementById('errorMsg');
            const loginButton = document.getElementById('loginButton');

            clearErrors();

            /* Loading state */
            loginButton.disabled = true;
            loginButton.classList.add('opacity-80', 'cursor-not-allowed');
            loginButton.innerHTML = `
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span>লগইন হচ্ছে...</span>
            `;

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ email, password }),
                });

                let data = {};
                try {
                    data = await response.json();
                } catch (jsonError) {
                    data = {};
                }

                if (!response.ok) {
                    errorMsg.textContent = data.message || 'লগইন ব্যর্থ হয়েছে। আবার চেষ্টা করুন।';
                    errorMsg.classList.remove('hidden');

                    emailInput.classList.add('border-red-500', 'focus:ring-red-500/10');
                    passwordInput.classList.add('border-red-500', 'focus:ring-red-500/10');
                    return;
                }

                if (data.token) {
                    localStorage.setItem('token', data.token);
                }

                window.location.href = '/dashboard';

            } catch (err) {
                errorMsg.textContent = 'সার্ভারের সাথে সংযোগ করা যায়নি। আবার চেষ্টা করুন।';
                errorMsg.classList.remove('hidden');
            } finally {
                loginButton.disabled = false;
                loginButton.classList.remove('opacity-80', 'cursor-not-allowed');
                loginButton.innerHTML = `
                    <span>লগইন করুন</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                `;
            }
        });
    </script>
</body>
</html>