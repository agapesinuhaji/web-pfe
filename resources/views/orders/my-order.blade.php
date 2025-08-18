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
<body class="min-h-screen flex flex-col">

<div class="bg-white-50">
  @include('layouts.nav')
</div>

  <main class="flex-grow">
    
    <section class=" pt-16 pb-8 mt-14 px-4" id="services">
        <div class="max-w-7xl mx-auto text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Pilih Paket Konseling Anda</h2>
            <p class="text-gray-600 text-lg">Dapatkan layanan terbaik sesuai kebutuhan Anda</p>
        </div>

        <div class="flex flex-col md:flex-row justify-center items-center gap-8">
            <!-- Pricing Card 1 -->
            <div class="w-full max-w-sm p-6 bg-white rounded-xl shadow-lg">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Paket Pelajar</h3>
            <p class="text-gray-600 mb-6">Untuk sesi konseling personal</p>
            <div class="text-4xl font-bold text-gray-900 mb-4">Rp45.000</div>
            <ul class="text-gray-600 mb-6 space-y-2 text-left">
                <li>✔️ 1x sesi (60 menit)</li>
                <li>✔️ Rahasia aman dan tidak akan bocor</li>
                <li>✔️ Psikolog tersertifikasi</li>
            </ul>
            <a href="/checkout"
                class="block w-full bg-blue-600 hover:bg-blue-700 text-center text-white font-medium py-2 rounded-lg transition duration-300">
                Pesan Sekarang
            </a>
            </div>

            <!-- Pricing Card 2 -->
            <div class="w-full max-w-sm p-6 bg-white rounded-xl shadow-lg border-2 border-blue-600">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Paket Umum</h3>
            <p class="text-gray-600 mb-6">Untuk sesi konseling personal</p>
            <div class="text-4xl font-bold text-gray-900 mb-4">85.000</div>
            <ul class="text-gray-600 mb-6 space-y-2 text-left">
                <li>✔️ 1x sesi (60 menit)</li>
                <li>✔️ Rahasia aman dan tidak akan bocor</li>
                <li>✔️ Psikolog tersertifikasi</li>
            </ul>
            <a href="/checkout"
                class="block w-full bg-blue-600 text-center hover:bg-blue-700 text-white font-medium py-2 rounded-lg transition duration-300">
                Pesan Sekarang
            </a>
            </div>
        </div>
    </section>

    <section class="bg-white py-8 pb-16 mb-16 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mx-auto max-w-5xl">
                <div class="gap-4 sm:flex sm:items-center sm:justify-between">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">My orders</h2>
                    <div class="mt-6 gap-4 space-y-4 sm:mt-0 sm:flex sm:items-center sm:justify-end sm:space-y-0">
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