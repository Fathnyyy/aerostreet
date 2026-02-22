<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Complete Payment - {{ $order->order_number }} | KICKSLAB</title>
    <meta name="description" content="Complete your Midtrans payment for order {{ $order->order_number }}.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Midtrans Snap.js (Sandbox) --}}
    <script src="{{ config('midtrans.snap_url') }}"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .brand-font { font-family: 'Oswald', sans-serif; }
        .logo-font { font-family: 'Instrument Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-ring {
            0%   { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(0,0,0,0.4); }
            70%  { transform: scale(1);    box-shadow: 0 0 0 15px rgba(0,0,0,0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(0,0,0,0); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .fade-up { animation: fadeInUp 0.5s ease-out both; }

        /* Pay Now Button */
        .pay-btn {
            animation: pulse-ring 2s infinite;
            position: relative; overflow: hidden;
        }
        .pay-btn::after {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .pay-btn:hover::after { left: 100%; }
        .pay-btn:hover { animation-play-state: paused; }

        /* Loading shimmer skeleton */
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        /* Countdown badge */
        .countdown-badge {
            font-variant-numeric: tabular-nums;
        }

        /* Order detail row */
        .detail-row {
            transition: background 0.15s;
        }
        .detail-row:hover { background: #f9fafb; }
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
                    <span class="text-black">Payment</span>
                </div>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-black transition">
                    My Orders
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </nav>

    <main class="pt-20 min-h-screen" x-data="midtransPayment()">

        {{-- Hero Strip --}}
        <div class="bg-black text-white py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="fade-up">
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-500 mb-2">Step 3 of 3 · Midtrans Secure Payment</p>
                    <h1 class="text-4xl md:text-6xl font-black italic uppercase tracking-tighter brand-font">
                        COMPLETE<br>PAYMENT
                    </h1>
                    <div class="flex flex-wrap items-center gap-3 mt-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Order</span>
                        <span class="text-sm font-bold text-white font-mono tracking-[0.15em] bg-gray-900 px-3 py-1">{{ $order->order_number }}</span>
                        <span class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-green-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            SSL Secured by Midtrans
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
            <div class="flex flex-col lg:flex-row gap-10">

                {{-- ======================================== --}}
                {{-- LEFT — Pay Now CTA --}}
                {{-- ======================================== --}}
                <div class="w-full lg:w-1/2 fade-up" style="animation-delay: 0.1s">

                    {{-- Status Message --}}
                    <div x-show="paymentStatus" x-transition x-cloak
                         class="mb-6 p-4 border"
                         :class="{
                             'bg-green-50 border-green-200 text-green-800': paymentStatus === 'success',
                             'bg-red-50 border-red-200 text-red-800': paymentStatus === 'error',
                             'bg-yellow-50 border-yellow-200 text-yellow-800': paymentStatus === 'pending'
                         }">
                        <div class="flex items-center gap-3">
                            <svg x-show="paymentStatus === 'success'" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <svg x-show="paymentStatus === 'error'" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <svg x-show="paymentStatus === 'pending'" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm font-bold uppercase tracking-wide" x-text="statusMessage"></p>
                        </div>
                    </div>

                    {{-- Main Pay Card --}}
                    <div class="bg-white border border-gray-200 p-8 text-center">

                        {{-- Amount --}}
                        <div class="mb-8">
                            <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-gray-400 mb-2">Total Payment</p>
                            <p class="text-4xl sm:text-5xl font-black brand-font tracking-tight">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-400 mt-2 uppercase tracking-wider">Including 11% PPN Tax</p>
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-dashed border-gray-200 mb-8"></div>

                        {{-- Payment Methods Preview --}}
                        <div class="mb-8">
                            <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-gray-400 mb-4">Available Methods</p>
                            <div class="flex flex-wrap gap-2 justify-center">
                                <span class="text-[10px] px-3 py-1.5 bg-blue-50 text-blue-700 font-bold uppercase tracking-wider border border-blue-100">QRIS</span>
                                <span class="text-[10px] px-3 py-1.5 bg-green-50 text-green-700 font-bold uppercase tracking-wider border border-green-100">Virtual Account</span>
                                <span class="text-[10px] px-3 py-1.5 bg-orange-50 text-orange-700 font-bold uppercase tracking-wider border border-orange-100">GoPay</span>
                                <span class="text-[10px] px-3 py-1.5 bg-purple-50 text-purple-700 font-bold uppercase tracking-wider border border-purple-100">OVO</span>
                                <span class="text-[10px] px-3 py-1.5 bg-gray-50 text-gray-600 font-bold uppercase tracking-wider border border-gray-200">Credit Card</span>
                                <span class="text-[10px] px-3 py-1.5 bg-yellow-50 text-yellow-700 font-bold uppercase tracking-wider border border-yellow-100">ShopeePay</span>
                            </div>
                        </div>

                        {{-- PAY NOW BUTTON --}}
                        <button
                            id="pay-now-btn"
                            @click="openSnap"
                            :disabled="isLoading || paymentStatus === 'success'"
                            :class="(isLoading || paymentStatus === 'success') ? 'bg-gray-300 cursor-not-allowed' : 'pay-btn bg-black hover:bg-gray-900'"
                            class="w-full py-5 text-white font-black uppercase tracking-[0.2em] text-base transition-all duration-300 active:scale-[0.98] flex items-center justify-center gap-3">

                            <!-- Default state -->
                            <template x-if="!isLoading && paymentStatus !== 'success'">
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    <span>PAY NOW</span>
                                </div>
                            </template>

                            <!-- Loading state -->
                            <template x-if="isLoading">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    <span>Opening Payment...</span>
                                </div>
                            </template>

                            <!-- Success state -->
                            <template x-if="paymentStatus === 'success'">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Payment Successful!</span>
                                </div>
                            </template>
                        </button>

                        {{-- Security Note --}}
                        <div class="mt-5 flex items-center justify-center gap-2 text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span class="text-[10px] uppercase font-bold tracking-[0.15em]">Powered by Midtrans · PCI DSS Certified</span>
                        </div>

                        {{-- Redirect note after success --}}
                        <div x-show="paymentStatus === 'success'" x-transition class="mt-4" x-cloak>
                            <p class="text-xs text-gray-400">
                                Redirecting to dashboard in <strong x-text="countdown"></strong>s...
                            </p>
                        </div>
                    </div>

                    {{-- Support Note --}}
                    <div class="mt-4 bg-blue-50 border border-blue-100 p-4">
                        <div class="flex gap-3">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-xs text-blue-700 leading-relaxed">
                                <strong class="uppercase tracking-wider">Sandbox Mode Active.</strong> Use test credentials from Midtrans docs. No real money will be charged.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ======================================== --}}
                {{-- RIGHT — Order Summary --}}
                {{-- ======================================== --}}
                <div class="w-full lg:w-1/2">
                    <div class="sticky top-24 space-y-4">

                        {{-- Your Order --}}
                        <div class="bg-white border border-gray-200">
                            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 bg-black text-white flex items-center justify-center text-[10px] font-bold rounded-full">✓</div>
                                    <h2 class="text-base font-black uppercase tracking-tight brand-font">Order Summary</h2>
                                </div>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                    {{ $order->items->sum('quantity') }} items
                                </span>
                            </div>

                            <div class="divide-y divide-gray-50 max-h-64 overflow-y-auto">
                                @foreach($order->items as $item)
                                <div class="detail-row flex items-center gap-3 px-5 py-3">
                                    <div class="w-12 h-12 bg-gray-100 overflow-hidden flex-shrink-0">
                                        <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $item->product->brand }}</p>
                                        <p class="text-sm font-bold uppercase truncate brand-font">{{ $item->product->name }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">Size {{ $item->size }} × {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p class="text-sm font-bold brand-font">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                        @if($item->quantity > 1)
                                        <p class="text-[10px] text-gray-400">Rp {{ number_format($item->price, 0, ',', '.') }} ea</p>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="px-5 py-4 border-t border-gray-100 space-y-2">
                                @php
                                    $subtotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
                                    $tax = $order->total_price - $subtotal;
                                @endphp
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Subtotal</span>
                                    <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Tax (PPN 11%)</span>
                                    <span class="font-semibold">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Shipping</span>
                                    <span class="text-xs font-bold text-green-600 uppercase px-2 py-0.5 bg-green-50">Free</span>
                                </div>
                                <div class="border-t border-dashed border-gray-200 pt-3 mt-3 flex justify-between">
                                    <span class="font-bold uppercase text-sm tracking-wider">Total</span>
                                    <span class="text-xl font-black brand-font">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Powered by Midtrans Badge --}}
                        <div class="border border-gray-200 bg-white p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider">Secured by Midtrans</p>
                                    <p class="text-[10px] text-gray-400">PCI DSS Level 1 Certified · 256-bit SSL</p>
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

    {{-- Midtrans Snap Script --}}
    <script>
    function midtransPayment() {
        return {
            snapToken: '{{ $order->snap_token }}',
            isLoading: false,
            paymentStatus: null,
            statusMessage: '',
            countdown: 5,

            openSnap() {
                if (!this.snapToken) {
                    alert('Payment token not found. Please try again.');
                    return;
                }

                this.isLoading = true;

                // Give it a moment for loading state to show
                setTimeout(() => {
                    window.snap.pay(this.snapToken, {
                        onSuccess: (result) => {
                            this.isLoading = false;
                            this.paymentStatus = 'success';
                            this.statusMessage = '✓ Payment successful! Your order is being processed.';
                            this.startCountdown();
                        },
                        onPending: (result) => {
                            this.isLoading = false;
                            this.paymentStatus = 'pending';
                            this.statusMessage = 'Payment pending. Please complete your payment as instructed.';
                        },
                        onError: (result) => {
                            this.isLoading = false;
                            this.paymentStatus = 'error';
                            this.statusMessage = 'Payment failed. Please try again or choose another method.';
                        },
                        onClose: () => {
                            this.isLoading = false;
                            if (!this.paymentStatus) {
                                // User closed without paying
                            }
                        }
                    });
                }, 300);
            },

            startCountdown() {
                const interval = setInterval(() => {
                    this.countdown--;
                    if (this.countdown <= 0) {
                        clearInterval(interval);
                        window.location.href = '{{ route('dashboard') }}';
                    }
                }, 1000);
            }
        }
    }
    </script>

</body>
</html>
