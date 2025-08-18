<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>
<body class="min-h-screen flex flex-col">

    <div class="bg-white-50">
        @include('layouts.nav')
    </div>

    <main class="flex-grow">

    
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16 md:my-8 pt-20">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mx-auto max-w-5xl">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Payment</h2>

            <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12">
                <form action="#" method="POST" enctype="multipart/form-data"
    class="w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6 lg:max-w-xl lg:p-8">

    @csrf

    <div class="mb-6 grid grid-cols-2 gap-4">
        <!-- Logo DANA -->
        <div class="col-span-2 flex items-center">
            <img src="{{ asset('img/logo-dana.png') }}" alt="Logo DANA" class="w-60 h-auto">
        </div>

        <!-- Nomor Rekening -->
        <div class="col-span-2">
            <label for="dana-number" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                Nomor DANA
            </label>
            <div class="flex items-center gap-2">
                <input type="text" id="dana-number" value="081234" readonly
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 
                        focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 
                        dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                <button type="button" onclick="copyDanaNumber()" 
                    class="px-3 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Copy
                </button>
            </div>
        </div>

        <!-- Nama Pemilik -->
        <div class="col-span-2 sm:col-span-1">
            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                Nama Pemilik
            </label>
            <input type="text" value="Psikology For Everyone" readonly
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 
                    focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 
                    dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
        </div>

        <!-- Upload Bukti Pembayaran -->
        <div class="col-span-2">
            <label for="payment-proof" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                Unggah Bukti Pembayaran
            </label>
            <input type="file" id="payment-proof" accept="image/*" name="payment_proof" class="block w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500">
        </div>
    </div>
    <button type="submit" class="flex w-full items-center mt-6 justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Konfirmasi Pembayaran</button>

</form>



                <div class="mt-6 grow sm:mt-8 lg:mt-0">
                <div class="space-y-4 rounded-lg border border-gray-100 bg-gray-50 p-6 dark:border-gray-700 dark:bg-gray-800">
                    <div class="space-y-2">
                    <dl class="flex items-center justify-between gap-4">
                        <div>
                            <dt class="text-base font-semibold text-gray-900">{{ $order->product->name }}</dt>
                            <p class="text-xs text-gray-500 dark:text-gray-500">{{ $order->method->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500">Bersama Psikolog {{ $order->conselor->profile->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500">{{ \Carbon\Carbon::parse($order->schedule->date)->format('d F Y') }}, {{ $order->schedule->time }}</p>
                        </div>
                        <dd class="text-base font-medium text-gray-900 dark:text-white">Rp {{ number_format($order->price) }}</dd>
                    </dl>
                    
                    <dl class="flex items-center justify-between gap-4">
                        <dt class="text-base font-semibold text-gray-900">Kode Unik</dt>
                        <dd class="text-base font-medium text-gray-900 dark:text-white">Rp {{ number_format($order->unique_kode) }}</dd>
                    </dl>
                </div>
                {{-- 
                                    <dl class="flex items-center justify-between gap-4">
                                        <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Savings</dt>
                                        <dd class="text-base font-medium text-green-500">-$299.00</dd>
                                    </dl> --}}

                    <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                        <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                        <dd class="flex items-center gap-2">
                            <span id="total-amount" class="text-base font-bold text-gray-900 dark:text-white">Rp {{ number_format($order->total) }}</span>
                            <button onclick="copyTotal()" id="copy-total-btn" 
                                class="px-2 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                                Copy
                            </button>
                        </dd>
                    </dl>

                    <p id="copy-total-msg" class="text-sm text-green-600 mt-1 hidden">Total transaksi berhasil disalin!</p>

                    

                </div>
                </div>
            </div>

            </div>

        </div>
        </section>


        </main>


    {{-- Section Footer --}}
<footer class="p-4 bg-gray-900 md:p-8 lg:p-10 ">
  <div class="mx-auto max-w-screen-xl text-center">
      <a href="{{ url('/') }}" class="flex justify-center items-center text-2xl pt-4 font-semibold text-white">
           <img src="{{ asset('favicon.svg') }}" alt="Logo" class="mr-2 h-8" />
         
          Psychologist For Everyone  
      </a>
    </div>
    <span class="text-sm flex justify-center pt-2 text-gray-100 sm:text-center dark:text-gray-400">© 2025 &nbsp; <a href="{{ url('/') }}" class="hover:underline">PFE <!--™ --></a>. All Rights Reserved.</span>
</footer>




{{--  No Rekening --}}
<script>
    function copyDanaNumber() {
        const danaInput = document.getElementById('dana-number');
        const copyMsg = document.getElementById('copy-msg');
        const copyBtn = document.getElementById('copy-btn');

        danaInput.select();
        danaInput.setSelectionRange(0, 99999); // untuk mobile
        document.execCommand('copy');

        // Tampilkan pesan tanpa alert
        copyMsg.classList.remove('hidden');

        // Ubah teks tombol sementara
        const originalText = copyBtn.innerText;
        copyBtn.innerText = "Copied!";
        setTimeout(() => {
            copyBtn.innerText = originalText;
            copyMsg.classList.add('hidden');
        }, 2000);
    }
</script>



{{-- total --}}
<script>
    function copyTotal() {
        const totalText = document.getElementById('total-amount').innerText;
        const copyMsg = document.getElementById('copy-total-msg');
        const copyBtn = document.getElementById('copy-total-btn');

        // Buat elemen input sementara untuk menyalin teks
        const tempInput = document.createElement('input');
        tempInput.value = totalText.replace(/[^\d]/g, ''); // hanya angka kalau mau
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        // Feedback UI
        copyMsg.classList.remove('hidden');
        const originalText = copyBtn.innerText;
        copyBtn.innerText = "Copied!";
        setTimeout(() => {
            copyBtn.innerText = originalText;
            copyMsg.classList.add('hidden');
        }, 2000);
    }
</script>

{{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

</body>
</html>
