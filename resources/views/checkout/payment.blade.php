<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Payment</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900">

    <div class="bg-white">
        @include('layouts.nav')
    </div>

    @if(session('success_payment'))
<div id="toast-success" 
     class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 mb-4 text-gray-900 bg-green-100 rounded-lg shadow dark:text-gray-200 dark:bg-green-800" 
     role="alert">
    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-green-700 dark:text-green-200" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9 14.5l-4-4 1.5-1.5L9 11.5l4.5-4.5L15 8.5l-6 6Z" />
    </svg>
    <div class="ms-3 text-sm font-normal">
        {{ session('success_payment') }} <br>
        <span id="countdown">3</span> detik lagi...
    </div>
</div>

<script>
    let countdown = 3;
    const countdownEl = document.getElementById('countdown');
    const orderUuid = "{{ session('redirect_order') }}";

    const interval = setInterval(() => {
        countdown--;
        if (countdownEl) countdownEl.innerText = countdown;
        if (countdown <= 0 && orderUuid) {
            clearInterval(interval);
            // Misalnya redirect ke halaman detail order setelah pembayaran
            window.location.href = "/myorder/" + orderUuid;
        }
    }, 1000);
</script>
@endif



    <main class="flex-grow">
        <section class="py-12 pt-24">
            <div class="max-w-5xl mx-auto px-4">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Konfirmasi Pembayaran</h2>

                <form action="{{ route('checkout.update', $order->order_uuid) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    @csrf
                    @method('PUT')

                    {{-- LEFT: Payment Method --}}
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Pilih Metode Pembayaran</h3>

                        {{-- Select --}}
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank / E-Wallet</label>
                            <select id="payment-method-select" name="payment_method_id" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">-- Pilih --</option>
                                @foreach($paymentMethods as $pm)
                                    <option value="{{ $pm->id }}"
                                        data-image="{{ asset('storage/' . $pm->image) }}"
                                        data-number="{{ $pm->number }}"
                                        data-owner="{{ $pm->atas_nama }}">
                                        {{ $pm->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Detail tampil setelah pilih --}}
                        <div id="payment-detail" class="hidden space-y-3">
                            <img id="pm-image" src="" alt="Logo" class="w-40 h-auto">
                            <div>
                                <label class="block text-sm text-gray-900 dark:text-white">Nomor Rekening</label>
                                <div class="flex items-center gap-2">
                                    <span id="pm-number" class="text-gray-800 dark:text-gray-200 font-medium"></span>
                                    <button type="button" onclick="copyNumber()" class="px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">Copy</button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-900 dark:text-white">Atas Nama</label>
                                <p id="pm-owner" class="text-gray-800 dark:text-gray-200 font-medium"></p>
                            </div>
                        </div>

                        {{-- Upload bukti --}}
                        <div class="mt-6">
                            <label for="payment-proof" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Unggah Bukti Pembayaran</label>
                            <input type="file" id="payment-proof" accept="image/*" name="payment_proof" class="block w-full rounded-lg border-gray-300 bg-gray-50 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            @error('payment_proof')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="mt-6 w-full px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Konfirmasi Pembayaran</button>
                    </div>

                    {{-- RIGHT: Order Summary --}}
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Ringkasan Order</h3>
                        <div class="space-y-4">
                            <dl class="flex items-center justify-between gap-4">
                                <div>
                                    <dt class="text-base font-semibold text-gray-900 dark:text-white">{{ $order->product->name }}</dt>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->method->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Bersama Psikolog {{ $order->conselor->profile->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($order->schedule->date)->format('d F Y') }}, {{ $order->schedule->time }}
                                    </p>
                                </div>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">Rp {{ number_format($order->price) }}</dd>
                            </dl>

                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-semibold text-gray-900 dark:text-white">Kode Unik</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">Rp {{ number_format($order->unique_kode) }}</dd>
                            </dl>

                            <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                                <dd class="flex items-center gap-2">
                                    <span id="total-amount" class="text-base font-bold text-gray-900 dark:text-white">Rp {{ number_format($order->total) }}</span>
                                    <button type="button" onclick="copyTotal()" id="copy-total-btn" class="px-2 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">Copy</button>
                                </dd>
                            </dl>
                            <p id="copy-total-msg" class="text-sm text-green-600 mt-1 hidden">Total berhasil disalin!</p>

                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-semibold text-gray-900 dark:text-white">Batas Waktu Bayar</dt>
                                <dd class="text-base font-medium text-red-600 dark:text-red-400" id="countdown-timer"></dd>
                            </dl>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer class="p-4 bg-gray-900 text-center text-white">
        <a href="{{ url('/') }}" class="flex justify-center items-center text-2xl font-semibold">
            <img src="{{ asset('favicon.svg') }}" alt="Logo" class="mr-2 h-8">
            Psychologist For Everyone
        </a>
        <span class="text-sm block mt-2">© 2025 PFE. All Rights Reserved.</span>
    </footer>

    <script>
        const select = document.getElementById('payment-method-select');
        const detail = document.getElementById('payment-detail');
        const img = document.getElementById('pm-image');
        const number = document.getElementById('pm-number');
        const owner = document.getElementById('pm-owner');
        let currentNumber = "";

        select.addEventListener('change', function () {
            const option = this.options[this.selectedIndex];
            if(option.value) {
                detail.classList.remove('hidden');
                img.src = option.getAttribute('data-image');
                number.innerText = option.getAttribute('data-number');
                owner.innerText = option.getAttribute('data-owner');
                currentNumber = option.getAttribute('data-number');
            } else {
                detail.classList.add('hidden');
            }
        });

        function copyNumber() {
            if(currentNumber) {
                navigator.clipboard.writeText(currentNumber);
                alert("Nomor berhasil disalin: " + currentNumber);
            }
        }

        function copyTotal() {
            const totalText = document.getElementById('total-amount').innerText;
            const copyMsg = document.getElementById('copy-total-msg');
            const copyBtn = document.getElementById('copy-total-btn');

            const tempInput = document.createElement('input');
            tempInput.value = totalText.replace(/[^\d]/g, '');
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

            copyMsg.classList.remove('hidden');
            const originalText = copyBtn.innerText;
            copyBtn.innerText = "Copied!";
            setTimeout(() => {
                copyBtn.innerText = originalText;
                copyMsg.classList.add('hidden');
            }, 2000);
        }
    </script>

    <script>
        const expiredAt = "{{ \Carbon\Carbon::parse($order->expired_at)->toIso8601String() }}";
        const orderUuid = "{{ $order->order_uuid }}";
        const countdownEl = document.getElementById("countdown-timer");

        if (countdownEl) {
            const expiredTime = new Date(expiredAt).getTime();
            const timer = setInterval(() => {
                const now = new Date().getTime();
                const distance = expiredTime - now;

                if (distance <= 0) {
                    clearInterval(timer);
                    countdownEl.innerText = "Expired";
                    countdownEl.classList.add("text-gray-500");

                    // 🔹 Update status order ke pay_fail
                    fetch(`/orders/${orderUuid}/expire`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        }
                    }).then(() => {
                        // 🔹 Redirect ke myorder
                        window.location.href = "/my-order";
                    });

                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownEl.innerText =
                    `${hours.toString().padStart(2,'0')}:${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
            }, 1000);
        }
    </script>


</body>
</html>
