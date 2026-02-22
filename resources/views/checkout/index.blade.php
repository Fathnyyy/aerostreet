<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - KICKSLAB</title>
    <meta name="description" content="Secure checkout at KICKSLAB. Choose your payment method and complete your order.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .brand-font { font-family: 'Oswald', sans-serif; }
        .logo-font { font-family: 'Instrument Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        /* ====================== */
        /* ANIMATIONS */
        /* ====================== */
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

        /* ====================== */
        /* PAYMENT METHOD CARDS */
        /* ====================== */
        .payment-card {
            border: 2px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .payment-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.03) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.25s;
        }
        .payment-card:hover {
            border-color: #9ca3af;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        .payment-card:hover::before { opacity: 1; }
        .payment-card.selected {
            border-color: #000;
            background: #fafafa;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }

        /* Radio custom */
        .payment-radio:checked + .payment-card {
            border-color: #000;
        }

        /* ====================== */
        /* STEP INDICATOR */
        /* ====================== */
        .step-active { color: #000; font-weight: 700; }
        .step-done { color: #6b7280; text-decoration: line-through; }
        .step-upcoming { color: #d1d5db; }

        /* ====================== */
        /* ORDER ITEM PREVIEW */
        /* ====================== */
        .order-item-preview {
            transition: background 0.2s;
        }
        .order-item-preview:hover {
            background: #f9fafb;
        }

        /* ====================== */
        /* SUBMIT BUTTON */
        /* ====================== */
        .submit-btn {
            position: relative;
            overflow: hidden;
        }
        .submit-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }
        .submit-btn:hover::after { left: 100%; }

        /* ====================== */
        /* TOAST */
        /* ====================== */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-100%); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-black selection:bg-black selection:text-white">

    {{-- ============================================================ --}}
    {{-- NAVBAR --}}
    {{-- ============================================================ --}}
    <nav class="fixed w-full z-[100] bg-white/95 backdrop-blur-md border-b border-gray-200" x-data="{ mobileMenu: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0">
                    <a href="/" class="text-3xl font-black italic uppercase tracking-tighter logo-font">KICKSLAB</a>
                </div>

                <!-- Breadcrumb steps -->
                <div class="hidden md:flex items-center gap-2 text-xs font-bold uppercase tracking-widest">
                    <span class="text-gray-300">Cart</span>
                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-black">Checkout</span>
                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-300">Payment</span>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('cart.index') }}" class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-black transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Back to Cart
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ============================================================ --}}
    {{-- FLASH MESSAGES --}}
    {{-- ============================================================ --}}
    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="fixed top-24 left-1/2 -translate-x-1/2 z-[200] max-w-md w-full px-4" x-cloak>
        <div class="flex items-center gap-3 px-5 py-4 shadow-2xl border bg-red-600 text-white border-red-700">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm font-bold uppercase tracking-wide">{{ session('error') }}</p>
            <button @click="show = false" class="ml-auto hover:opacity-70 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
    @endif

    {{-- ============================================================ --}}
    {{-- MAIN CONTENT --}}
    {{-- ============================================================ --}}
    <main class="pt-20 min-h-screen">

        {{-- Hero Banner Strip --}}
        <div class="bg-black text-white py-10 border-b border-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="fade-up">
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-500 mb-2">Step 2 of 3</p>
                    <h1 class="text-4xl md:text-6xl font-black italic uppercase tracking-tighter brand-font">
                        CHECKOUT
                    </h1>
                    <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">
                        Select your payment method to complete your order
                    </p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
            <div class="flex flex-col lg:flex-row gap-10 lg:gap-14">

                {{-- ======================================== --}}
                {{-- LEFT — Payment Method Form --}}
                {{-- ======================================== --}}
                <div class="w-full lg:w-3/5 fade-up" style="animation-delay: 0.1s">

                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" x-data="{ method: '' }">
                        @csrf

                        {{-- Section Title --}}
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-7 h-7 bg-black text-white flex items-center justify-center text-xs font-bold rounded-full">01</div>
                            <h2 class="text-xl font-black uppercase tracking-tight brand-font">Payment Method</h2>
                        </div>

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="mb-6 bg-red-50 border border-red-200 p-4">
                                <p class="text-red-700 text-sm font-bold uppercase tracking-wide">{{ $errors->first() }}</p>
                            </div>
                        @endif

                        <div class="space-y-4 mb-8">

                            {{-- OPTION 1: Midtrans --}}
                            <label class="block cursor-pointer" for="method_midtrans">
                                <input type="radio"
                                       id="method_midtrans"
                                       name="payment_method"
                                       value="midtrans"
                                       class="sr-only"
                                       x-model="method"
                                       @change="document.getElementById('checkout-form').querySelectorAll('.payment-card').forEach(c => c.classList.remove('selected')); $el.closest('label').querySelector('.payment-card').classList.add('selected')">
                                <div class="payment-card p-5 sm:p-6 bg-white" :class="method === 'midtrans' ? 'selected' : ''">
                                    <div class="flex items-start gap-4">
                                        {{-- Icon --}}
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center flex-shrink-0 rounded-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                        </div>
                                        {{-- Content --}}
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h3 class="font-bold text-base uppercase tracking-tight brand-font">Midtrans Gateway</h3>
                                                    <p class="text-xs text-gray-500 mt-0.5">QRIS · Virtual Account · Credit Card · GoPay · OVO</p>
                                                </div>
                                                {{-- Custom Radio Circle --}}
                                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all duration-200"
                                                     :class="method === 'midtrans' ? 'border-black bg-black' : 'border-gray-300'">
                                                    <div class="w-2 h-2 bg-white rounded-full" x-show="method === 'midtrans'" x-cloak></div>
                                                </div>
                                            </div>
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                <span class="text-[10px] px-2 py-1 bg-blue-50 text-blue-700 font-bold uppercase tracking-wider border border-blue-100">QRIS</span>
                                                <span class="text-[10px] px-2 py-1 bg-green-50 text-green-700 font-bold uppercase tracking-wider border border-green-100">Virtual Account</span>
                                                <span class="text-[10px] px-2 py-1 bg-orange-50 text-orange-700 font-bold uppercase tracking-wider border border-orange-100">GoPay</span>
                                                <span class="text-[10px] px-2 py-1 bg-purple-50 text-purple-700 font-bold uppercase tracking-wider border border-purple-100">OVO</span>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Instant badge --}}
                                    <div x-show="method === 'midtrans'" x-transition class="mt-4 pt-4 border-t border-gray-100" x-cloak>
                                        <div class="flex items-center gap-2 text-xs text-green-700 bg-green-50 px-3 py-2 border border-green-100">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            <span class="font-bold uppercase tracking-wider">Instant confirmation — payment verified automatically</span>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            {{-- OPTION 2: Manual Transfer --}}
                            <label class="block cursor-pointer" for="method_manual">
                                <input type="radio"
                                       id="method_manual"
                                       name="payment_method"
                                       value="manual"
                                       class="sr-only"
                                       x-model="method"
                                       @change="document.getElementById('checkout-form').querySelectorAll('.payment-card').forEach(c => c.classList.remove('selected')); $el.closest('label').querySelector('.payment-card').classList.add('selected')">
                                <div class="payment-card p-5 sm:p-6 bg-white" :class="method === 'manual' ? 'selected' : ''">
                                    <div class="flex items-start gap-4">
                                        {{-- Icon --}}
                                        <div class="w-12 h-12 bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center flex-shrink-0 rounded-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                            </svg>
                                        </div>
                                        {{-- Content --}}
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h3 class="font-bold text-base uppercase tracking-tight brand-font">Manual Bank Transfer</h3>
                                                    <p class="text-xs text-gray-500 mt-0.5">BCA · Mandiri · BNI · BRI Transfer</p>
                                                </div>
                                                {{-- Custom Radio Circle --}}
                                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all duration-200"
                                                     :class="method === 'manual' ? 'border-black bg-black' : 'border-gray-300'">
                                                    <div class="w-2 h-2 bg-white rounded-full" x-show="method === 'manual'" x-cloak></div>
                                                </div>
                                            </div>
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                <span class="text-[10px] px-2 py-1 bg-blue-50 text-blue-800 font-bold uppercase tracking-wider border border-blue-100">BCA</span>
                                                <span class="text-[10px] px-2 py-1 bg-yellow-50 text-yellow-700 font-bold uppercase tracking-wider border border-yellow-100">Mandiri</span>
                                                <span class="text-[10px] px-2 py-1 bg-orange-50 text-orange-700 font-bold uppercase tracking-wider border border-orange-100">BNI</span>
                                                <span class="text-[10px] px-2 py-1 bg-blue-50 text-blue-600 font-bold uppercase tracking-wider border border-blue-100">BRI</span>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Note badge --}}
                                    <div x-show="method === 'manual'" x-transition class="mt-4 pt-4 border-t border-gray-100" x-cloak>
                                        <div class="flex items-center gap-2 text-xs text-amber-700 bg-amber-50 px-3 py-2 border border-amber-100">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span class="font-bold uppercase tracking-wider">Manual verification within 1×24 hours after proof uploaded</span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit"
                                id="place-order-btn"
                                :disabled="!method"
                                :class="method ? 'bg-black hover:bg-gray-900 cursor-pointer' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                                class="submit-btn w-full py-4 text-white font-bold uppercase tracking-[0.15em] text-sm transition-all duration-300 active:scale-[0.98] flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span x-text="method === 'midtrans' ? 'PROCEED TO PAYMENT' : method === 'manual' ? 'CONFIRM & GET BANK DETAILS' : 'SELECT A PAYMENT METHOD'"></span>
                        </button>

                        {{-- Security Note --}}
                        <div class="mt-5 flex items-center justify-center gap-2 text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span class="text-[10px] uppercase font-bold tracking-[0.15em]">256-bit SSL Encrypted & Secure</span>
                        </div>
                    </form>
                </div>

                {{-- ======================================== --}}
                {{-- RIGHT — Order Summary --}}
                {{-- ======================================== --}}
                <div class="w-full lg:w-2/5 slide-right" style="animation-delay: 0.2s">
                    <div class="sticky top-24">

                        {{-- Order Items Card --}}
                        <div class="bg-white border border-gray-200 mb-4">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 bg-black text-white flex items-center justify-center text-xs font-bold rounded-full">02</div>
                                    <h2 class="text-lg font-black uppercase tracking-tight brand-font">Your Order</h2>
                                </div>
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-widest">
                                    {{ $carts->sum('quantity') }} {{ $carts->sum('quantity') === 1 ? 'item' : 'items' }}
                                </span>
                            </div>

                            {{-- Cart Items List --}}
                            <div class="divide-y divide-gray-50 max-h-72 overflow-y-auto">
                                @foreach($carts as $cart)
                                <div class="order-item-preview flex items-center gap-3 px-5 py-3">
                                    <div class="w-14 h-14 bg-gray-100 overflow-hidden flex-shrink-0">
                                        <img src="{{ $cart->product->thumbnail }}"
                                             alt="{{ $cart->product->name }}"
                                             class="w-full h-full object-cover object-center">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $cart->product->brand }}</p>
                                        <p class="text-sm font-bold uppercase truncate brand-font">{{ $cart->product->name }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Size: <span class="font-bold text-gray-600">{{ $cart->size }}</span> × {{ $cart->quantity }}</p>
                                    </div>
                                    <p class="text-sm font-bold brand-font flex-shrink-0">
                                        Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                                    </p>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Price Breakdown --}}
                        <div class="bg-white border border-gray-200 p-6">
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">Subtotal</span>
                                    <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">Tax (PPN 11%)</span>
                                    <span class="font-semibold">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">Shipping</span>
                                    <span class="text-xs font-bold text-green-600 uppercase tracking-wider bg-green-50 px-2 py-0.5">Free</span>
                                </div>
                            </div>

                            <div class="border-t border-dashed border-gray-200 my-4"></div>

                            <div class="flex justify-between items-end">
                                <div>
                                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Payment</span>
                                    <span class="text-xs text-gray-400">Including tax</span>
                                </div>
                                <span class="text-3xl font-black brand-font tracking-tight">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Customer Info --}}
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3">Order For</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-black text-white rounded-full flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    {{-- Footer strip --}}
    <footer class="bg-black text-white py-8 mt-10 border-t border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-xl font-black italic brand-font">KICKSLAB.</p>
            <div class="flex items-center gap-6 text-xs text-gray-400">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    SSL Secured
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    100% Authentic
                </span>
                <span>© {{ date('Y') }} KICKSLAB</span>
            </div>
        </div>
    </footer>

</body>
</html>
