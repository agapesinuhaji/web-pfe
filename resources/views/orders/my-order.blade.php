<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>My Order - Psychology For Everyone</title>
  <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col" x-data="{ openModal: false }">

<div class="bg-white-50">
  @include('layouts.nav')
</div>

  <main class="flex-grow">


    <!-- Modal -->
    <div x-show="openModal" x-transition.opacity class="fixed inset-0 flex items-center justify-center z-50 bg-black/30">
    <div class="bg-white dark:bg-gray-800 w-full max-w-4xl mx-4 md:mx-6 rounded-2xl shadow-lg relative overflow-hidden" @click.away="openModal = false">
        <div class="max-h-[90vh] overflow-y-auto p-6">
        <button
            @click="openModal = false"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 dark:hover:text-white"
        >
            ✖
        </button>

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white mb-2">
            Pilih Paket Konseling Anda
            </h2>
            <p class="text-gray-600 dark:text-gray-300 text-base md:text-lg">
            Dapatkan layanan terbaik sesuai kebutuhan Anda
            </p>
        </div>

        <!-- Konten Paket Konseling -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Card Paket Pelajar -->
            <div class="p-6 bg-white dark:bg-gray-700 rounded-xl shadow-md border border-gray-200 dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Paket Pelajar</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">Untuk sesi konseling personal</p>
            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Rp45.000</div>
            <ul class="text-gray-600 dark:text-gray-300 mb-6 space-y-2 text-sm">
                <li>✔️ 1x sesi (60 menit)</li>
                <li>✔️ Rahasia aman</li>
                <li>✔️ Psikolog tersertifikasi</li>
            </ul>
            <a href="/checkout"
                class="block w-full bg-blue-600 hover:bg-blue-700 text-center text-white font-medium py-2 rounded-lg transition">
                Pesan Sekarang
            </a>
            </div>

            <!-- Card Paket Umum -->
            <div class="p-6 bg-white dark:bg-gray-700 rounded-xl shadow-md border-2 border-blue-600">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Paket Umum</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">Untuk sesi konseling personal</p>
            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Rp85.000</div>
            <ul class="text-gray-600 dark:text-gray-300 mb-6 space-y-2 text-sm">
                <li>✔️ 1x sesi (60 menit)</li>
                <li>✔️ Rahasia aman</li>
                <li>✔️ Psikolog tersertifikasi</li>
            </ul>
            <a href="/checkout"
                class="block w-full bg-blue-600 hover:bg-blue-700 text-center text-white font-medium py-2 rounded-lg transition">
                Pesan Sekarang
            </a>
            </div>

        </div>
        </div>
    </div>
    </div>


    <section class="bg-white py-8 pb-16 mb-16 antialiased dark:bg-gray-900 md:py-25">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mx-auto max-w-5xl">
                <div class="gap-4 sm:flex sm:items-center sm:justify-between">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">My orders</h2>
                    @php
                        $activeStatuses = ['pending', 'payed', 'approved', 'progress'];
                        $activeOrders = $orders->whereIn('status', $activeStatuses);
                    @endphp

                    @if ($activeOrders->count() < 2)
                        <button @click="openModal = true" 
                            class="mt-4 sm:mt-0 px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition flex items-center gap-2">
                            <span class="text-lg font-bold">+</span> Konseling Baru
                        </button>
                    @endif
                </div>
            </div>

            <div class="mt-6 flow-root sm:mt-8">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($orders as $order)
                        <div class="flex flex-wrap items-center gap-y-4 py-12">
                            <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Order ID:</dt>
                                <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                                    <a href="{{ route('myorder.show', $order->order_uuid) }}" class="hover:underline">#{{ strtoupper(substr($order->order_uuid, 0, 8)) }}</a>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $order->created_at->format('d-m-Y H:i:s') }}
                                    </div>
                                </dd>
                            </dl>

                            <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Date:</dt>
                                <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($order->schedule->date)->format('d F Y') }}, {{ $order->schedule->time }}
                                </dd>
                            </dl>

                            <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Price:</dt>
                                <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">Rp {{ number_format($order->price) }}</dd>
                            </dl>

                            <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Status:</dt>
                                @switch($order->status)
                                    @case('pending')
                                        <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            Waiting Payment
                                        </dd>
                                        @break

                                    @case('payed')
                                        <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            Payment Checked
                                        </dd>
                                        @break

                                    @case('approved')
                                        <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            Payment Success
                                        </dd>
                                        @break

                                    @case('pay fail')
                                        <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                            Payment Failed
                                        </dd>
                                        @break

                                    @default
                                        <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                            Done
                                        </dd>
                                @endswitch

                            </dl>

                            <div class="w-full grid sm:grid-cols-2 lg:flex lg:w-64 lg:items-center lg:justify-end gap-4">
                                <a href="{{ route('myorder.show', $order->order_uuid) }}" class="w-full inline-flex justify-center rounded-lg  border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 lg:w-auto">View details</a>
                            </div>
                        </div>
                        
                    @empty
                        <h3>Belum ada order!</h3> 
                    @endforelse

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





<script src="//unpkg.com/alpinejs" defer></script>


<!-- Floating WhatsApp Button -->
<a 
  href="https://wa.me/6281234567890" 
  target="_blank" 
  class="fixed bottom-5 right-5 flex items-center gap-2 bg-green-500 text-white px-4 py-3 rounded-full shadow-lg hover:bg-green-700 transition group"
  aria-label="Chat WhatsApp"
>
  <!-- WhatsApp Icon (Image) -->
  <img 
    src="{{ asset('img/whatsapp.png') }}" 
    alt="WhatsApp" 
    class="w-6 h-6"
  />

  <!-- Text (muncul di desktop, disembunyikan di mobile) -->
  <span class="hidden sm:inline-block text-sm font-medium">
    Chat Kami
  </span>
</a>



</body>
</html>