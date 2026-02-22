<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bank Transfer Payment - {{ $order->order_number }} | KICKSLAB</title>
    <meta name="description" content="Complete your manual bank transfer payment for order {{ $order->order_number }}.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .brand-font { font-family: 'Oswald', sans-serif; }
        .logo-font { font-family: 'Instrument Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(24px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .fade-up { animation: fadeInUp 0.5s ease-out both; }
        .slide-right { animation: slideInRight 0.5s ease-out both; }

        /* Copy button flash */
        .copy-btn { transition: all 0.2s; }
        .copy-btn.copied {
            background: #000 !important;
            color: white !important;
        }

        /* Bank card hover */
        .bank-card {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .bank-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            border-color: #6b7280;
        }
        .bank-card.active {
            border-color: #000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }

        /* Upload zone */
        .upload-zone {
            transition: all 0.25s;
            border: 2px dashed #d1d5db;
        }
        .upload-zone:hover, .upload-zone.dragover {
            border-color: #000;
            background: #f9fafb;
        }

        /* File preview */
        @keyframes bounceIn {
            0% { opacity: 0; transform: scale(0.8); }
            70% { transform: scale(1.04); }
            100% { opacity: 1; transform: scale(1); }
        }
        .preview-enter { animation: bounceIn 0.35s ease-out both; }

        /* Step bubbles */
        .step-num {
            width: 28px; height: 28px;
            background: #000; color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700; flex-shrink: 0;
        }
        .step-line { width: 2px; background: #e5e7eb; flex-grow: 1; min-height: 20px; }

        /* Submit button shine */
        .submit-btn { position: relative; overflow: hidden; }
        .submit-btn::after {
            content: ''; position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }
        .submit-btn:hover::after { left: 100%; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-black">

    {{-- NAVBAR --}}
    <nav class="fixed w-full z-[100] bg-white/95 backdrop-blur-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="/" class="text-3xl font-black italic uppercase tracking-tighter logo-font">KICKSLAB</a>

                <!-- Breadcrumb -->
                <div class="hidden md:flex items-center gap-2 text-xs font-bold uppercase tracking-widest">
                    <span class="text-gray-300">Cart</span>
                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-300">Checkout</span>
                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-black">Bank Transfer</span>
                </div>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-black transition">
                    My Orders
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </nav>

    {{-- Flash --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="fixed top-24 left-1/2 -translate-x-1/2 z-[200] max-w-md w-full px-4" x-cloak>
        <div class="flex items-center gap-3 px-5 py-4 shadow-2xl border bg-black text-white border-gray-800">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <p class="text-sm font-bold uppercase tracking-wide">{{ session('success') }}</p>
            <button @click="show = false" class="ml-auto hover:opacity-70">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
    @endif

    <main class="pt-20 min-h-screen">

        {{-- Hero Strip --}}
        <div class="bg-black text-white py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="fade-up">
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-500 mb-2">Step 3 of 3 · Manual Transfer</p>
                    <h1 class="text-4xl md:text-6xl font-black italic uppercase tracking-tighter brand-font">
                        TRANSFER<br>DETAILS
                    </h1>
                    <div class="flex items-center gap-3 mt-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Order</span>
                        <span class="text-sm font-bold text-white font-mono tracking-[0.15em] bg-gray-900 px-3 py-1">{{ $order->order_number }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
            <div class="flex flex-col lg:flex-row gap-10 lg:gap-14" x-data="{ selectedBank: 'bca', copied: null }">

                {{-- ======================================== --}}
                {{-- LEFT — Bank Info + Upload Form --}}
                {{-- ======================================== --}}
                <div class="w-full lg:w-3/5 space-y-8 fade-up" style="animation-delay: 0.1s">

                    {{-- HOW TO PAY: Steps --}}
                    <div class="bg-white border border-gray-200 p-6">
                        <h2 class="text-lg font-black uppercase tracking-tight brand-font mb-6">How to Pay</h2>
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="step-num">1</div>
                                <div class="step-line my-2"></div>
                                <div class="step-num">2</div>
                                <div class="step-line my-2"></div>
                                <div class="step-num">3</div>
                            </div>
                            <div class="flex-1 space-y-6">
                                <div class="pb-6 border-b border-gray-50">
                                    <p class="font-bold text-sm uppercase tracking-wide mb-1">Choose a Bank</p>
                                    <p class="text-sm text-gray-500">Select the bank account you want to transfer to below.</p>
                                </div>
                                <div class="pb-6 border-b border-gray-50">
                                    <p class="font-bold text-sm uppercase tracking-wide mb-1">Complete the Transfer</p>
                                    <p class="text-sm text-gray-500">Transfer the <strong>exact amount</strong> to the account number. Include the last 3 digits of your order number as a unique code.</p>
                                </div>
                                <div>
                                    <p class="font-bold text-sm uppercase tracking-wide mb-1">Upload Your Proof</p>
                                    <p class="text-sm text-gray-500">Upload a screenshot or photo of your transfer receipt using the form below. We'll verify within 1×24 hours.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BANK ACCOUNT CARDS --}}
                    <div class="bg-white border border-gray-200 p-6">
                        <h2 class="text-lg font-black uppercase tracking-tight brand-font mb-5">Bank Accounts</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">

                            {{-- BCA --}}
                            <div class="bank-card border border-gray-200 p-4 bg-white"
                                 :class="selectedBank === 'bca' ? 'active' : ''"
                                 @click="selectedBank = 'bca'">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold uppercase tracking-widest text-blue-700 bg-blue-50 px-2 py-1 border border-blue-100">BCA</span>
                                    <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-all"
                                         :class="selectedBank === 'bca' ? 'border-black bg-black' : 'border-gray-300'">
                                        <div class="w-1.5 h-1.5 bg-white rounded-full" x-show="selectedBank === 'bca'" x-cloak></div>
                                    </div>
                                </div>
                                <p class="text-lg font-bold font-mono tracking-wider">1234 5678 90</p>
                                <p class="text-xs text-gray-500 mt-1">a.n. <span class="font-bold text-gray-700">KICKSLAB STORE</span></p>
                            </div>

                            {{-- Mandiri --}}
                            <div class="bank-card border border-gray-200 p-4 bg-white"
                                 :class="selectedBank === 'mandiri' ? 'active' : ''"
                                 @click="selectedBank = 'mandiri'">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold uppercase tracking-widest text-yellow-700 bg-yellow-50 px-2 py-1 border border-yellow-100">Mandiri</span>
                                    <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-all"
                                         :class="selectedBank === 'mandiri' ? 'border-black bg-black' : 'border-gray-300'">
                                        <div class="w-1.5 h-1.5 bg-white rounded-full" x-show="selectedBank === 'mandiri'" x-cloak></div>
                                    </div>
                                </div>
                                <p class="text-lg font-bold font-mono tracking-wider">1370 0098 7654</p>
                                <p class="text-xs text-gray-500 mt-1">a.n. <span class="font-bold text-gray-700">KICKSLAB STORE</span></p>
                            </div>

                            {{-- BNI --}}
                            <div class="bank-card border border-gray-200 p-4 bg-white"
                                 :class="selectedBank === 'bni' ? 'active' : ''"
                                 @click="selectedBank = 'bni'">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold uppercase tracking-widest text-orange-700 bg-orange-50 px-2 py-1 border border-orange-100">BNI</span>
                                    <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-all"
                                         :class="selectedBank === 'bni' ? 'border-black bg-black' : 'border-gray-300'">
                                        <div class="w-1.5 h-1.5 bg-white rounded-full" x-show="selectedBank === 'bni'" x-cloak></div>
                                    </div>
                                </div>
                                <p class="text-lg font-bold font-mono tracking-wider">0901 2345 6789</p>
                                <p class="text-xs text-gray-500 mt-1">a.n. <span class="font-bold text-gray-700">KICKSLAB STORE</span></p>
                            </div>

                            {{-- BRI --}}
                            <div class="bank-card border border-gray-200 p-4 bg-white"
                                 :class="selectedBank === 'bri' ? 'active' : ''"
                                 @click="selectedBank = 'bri'">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold uppercase tracking-widest text-blue-600 bg-blue-50 px-2 py-1 border border-blue-100">BRI</span>
                                    <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-all"
                                         :class="selectedBank === 'bri' ? 'border-black bg-black' : 'border-gray-300'">
                                        <div class="w-1.5 h-1.5 bg-white rounded-full" x-show="selectedBank === 'bri'" x-cloak></div>
                                    </div>
                                </div>
                                <p class="text-lg font-bold font-mono tracking-wider">0012 3456 7890</p>
                                <p class="text-xs text-gray-500 mt-1">a.n. <span class="font-bold text-gray-700">KICKSLAB STORE</span></p>
                            </div>
                        </div>

                        {{-- Active Bank Detail + Copy Button --}}
                        <div class="bg-gray-50 border border-gray-200 p-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-3">Selected Account</p>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold mb-1" x-text="selectedBank.toUpperCase()"></p>
                                    <p class="text-2xl font-bold font-mono tracking-wider" id="account-number"
                                       x-text="selectedBank === 'bca' ? '1234 5678 90' : selectedBank === 'mandiri' ? '1370 0098 7654' : selectedBank === 'bni' ? '0901 2345 6789' : '0012 3456 7890'"></p>
                                </div>
                                <button type="button"
                                        id="copy-btn"
                                        @click="
                                            const num = document.getElementById('account-number').textContent.replace(/\s/g, '');
                                            navigator.clipboard.writeText(num);
                                            copied = 'account';
                                            setTimeout(() => copied = null, 2000);
                                        "
                                        class="copy-btn flex items-center gap-2 border border-black px-4 py-2 text-xs font-bold uppercase tracking-wider hover:bg-black hover:text-white transition-all"
                                        :class="copied === 'account' ? 'copied' : ''">
                                    <svg x-show="copied !== 'account'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    <svg x-show="copied === 'account'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span x-text="copied === 'account' ? 'Copied!' : 'Copy'"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- UPLOAD PROOF FORM --}}
                    <div class="bg-white border border-gray-200 p-6">
                        <h2 class="text-lg font-black uppercase tracking-tight brand-font mb-5">Upload Transfer Proof</h2>

                        <form action="{{ route('checkout.upload-proof', $order) }}" method="POST" enctype="multipart/form-data"
                              x-data="uploadForm()" @submit.prevent="submitForm">
                            @csrf

                            {{-- Validation Errors --}}
                            @if ($errors->any())
                            <div class="mb-5 bg-red-50 border border-red-200 p-4">
                                <p class="text-red-700 text-sm font-bold">{{ $errors->first() }}</p>
                            </div>
                            @endif

                            {{-- Drop Zone --}}
                            <div class="upload-zone rounded-none p-8 text-center mb-5 cursor-pointer"
                                 id="upload-zone"
                                 @click="$refs.fileInput.click()"
                                 @dragover.prevent="isDragging = true; $el.classList.add('dragover')"
                                 @dragleave="isDragging = false; $el.classList.remove('dragover')"
                                 @drop.prevent="handleDrop($event)">

                                <!-- Preview -->
                                <div x-show="previewUrl" class="preview-enter" x-cloak>
                                    <img :src="previewUrl" class="max-h-48 mx-auto object-contain mb-3 border border-gray-200">
                                    <p class="text-xs font-bold text-green-700 uppercase tracking-wider flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span x-text="fileName"></span>
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">Click to change</p>
                                </div>

                                <!-- Default State -->
                                <div x-show="!previewUrl">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-bold uppercase tracking-wider mb-1">Drop your file here</p>
                                    <p class="text-xs text-gray-400">or click to browse</p>
                                    <p class="text-[10px] text-gray-300 mt-3 uppercase tracking-wider">JPG, PNG — Max 5MB</p>
                                </div>
                            </div>

                            <input type="file"
                                   name="payment_proof"
                                   id="payment_proof"
                                   accept="image/jpeg,image/jpg,image/png"
                                   class="hidden"
                                   x-ref="fileInput"
                                   @change="handleFile($event)">

                            <button type="submit"
                                    :disabled="!previewUrl || isSubmitting"
                                    :class="previewUrl && !isSubmitting ? 'bg-black hover:bg-gray-900 cursor-pointer' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                                    class="submit-btn w-full py-4 text-white font-bold uppercase tracking-[0.15em] text-sm transition-all duration-300 active:scale-[0.98] flex items-center justify-center gap-3">
                                <svg x-show="!isSubmitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <svg x-show="isSubmitting" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <span x-text="isSubmitting ? 'Uploading...' : 'Submit Payment Proof'"></span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- ======================================== --}}
                {{-- RIGHT — Order Summary Sidebar --}}
                {{-- ======================================== --}}
                <div class="w-full lg:w-2/5 slide-right" style="animation-delay: 0.15s">
                    <div class="sticky top-24 space-y-4">

                        {{-- Amount to Pay (highlighted) --}}
                        <div class="bg-black text-white p-6">
                            <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-gray-400 mb-2">Exact Amount to Transfer</p>
                            <p class="text-4xl font-black brand-font tracking-tight">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </p>
                            <div class="mt-4 flex items-center gap-2">
                                <button type="button"
                                        @click="
                                            navigator.clipboard.writeText('{{ (int)$order->total_price }}');
                                            copied = 'amount';
                                            setTimeout(() => copied = null, 2000);
                                        "
                                        class="copy-btn flex items-center gap-2 border border-gray-700 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider hover:border-white transition-all"
                                        :class="copied === 'amount' ? 'bg-white text-black' : 'text-gray-300'">
                                    <svg x-show="copied !== 'amount'" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    <svg x-show="copied === 'amount'" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span x-text="copied === 'amount' ? 'Copied!' : 'Copy Amount'"></span>
                                </button>
                            </div>
                        </div>

                        {{-- Order Info --}}
                        <div class="bg-white border border-gray-200 p-6">
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-4">Order Details</p>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Order Number</span>
                                    <span class="font-bold font-mono text-xs tracking-widest">{{ $order->order_number }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Date</span>
                                    <span class="font-bold">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Items</span>
                                    <span class="font-bold">{{ $order->items->sum('quantity') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Status</span>
                                    <span class="text-xs font-bold uppercase tracking-wider px-2 py-0.5 bg-yellow-100 text-yellow-700 border border-yellow-200">
                                        Awaiting Transfer
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Items list --}}
                        <div class="bg-white border border-gray-200">
                            <div class="px-5 py-3 border-b border-gray-100">
                                <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Items in Order</p>
                            </div>
                            <div class="divide-y divide-gray-50 max-h-60 overflow-y-auto">
                                @foreach($order->items as $item)
                                <div class="flex items-center gap-3 px-5 py-3">
                                    <div class="w-12 h-12 bg-gray-100 overflow-hidden flex-shrink-0">
                                        <img src="{{ $item->product->thumbnail }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold uppercase truncate brand-font">{{ $item->product->name }}</p>
                                        <p class="text-[10px] text-gray-400">Size {{ $item->size }} · Qty {{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-xs font-bold flex-shrink-0">
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </p>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Warning --}}
                        <div class="bg-amber-50 border border-amber-200 p-4">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-amber-700 mb-1">Important</p>
                                    <p class="text-xs text-amber-600 leading-relaxed">Transfer the <strong>exact amount</strong> above. Wrong amount may delay verification. Order will be cancelled if no proof uploaded within 24 hours.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-black text-white py-8 mt-10 border-t border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <p class="text-xl font-black italic brand-font">KICKSLAB.</p>
            <p class="text-xs text-gray-500">© {{ date('Y') }} KICKSLAB. All rights reserved.</p>
        </div>
    </footer>

    <script>
    function uploadForm() {
        return {
            previewUrl: null,
            fileName: '',
            isDragging: false,
            isSubmitting: false,

            handleFile(event) {
                const file = event.target.files[0];
                if (file) this.processFile(file);
            },

            handleDrop(event) {
                this.isDragging = false;
                document.getElementById('upload-zone').classList.remove('dragover');
                const file = event.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    // Set to the input
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    this.$refs.fileInput.files = dt.files;
                    this.processFile(file);
                }
            },

            processFile(file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('File too large. Maximum size is 5MB.');
                    return;
                }
                this.fileName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => { this.previewUrl = e.target.result; };
                reader.readAsDataURL(file);
            },

            submitForm() {
                if (!this.previewUrl) return;
                this.isSubmitting = true;
                this.$el.submit();
            }
        }
    }
    </script>

</body>
</html>
