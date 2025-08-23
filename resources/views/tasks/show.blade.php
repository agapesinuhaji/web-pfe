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

  <main class="flex-grow bg-gray-50 py-16 my-8 ">
  <div class="max-w-4xl mx-auto px-4">
    
    <!-- Detail Konseling -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
      <h2 class="text-xl font-semibold mb-4 text-gray-800">Detail Orderan</h2>
      <div class="grid sm:grid-cols-2 gap-4 text-gray-700">
        <div>
          <p class="text-sm text-gray-500">Order ID</p>
          <p class="font-medium">#{{ strtoupper(substr($order->order_uuid, 0, 8)) }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Nama Client</p>
          <p class="font-medium">{{ $order->user->profile->name }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Nama Panggilan</p>
          <p class="font-medium">{{ $order->user->profile->nickname }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
          <p class="font-medium">{{ $order->user->profile->date_of_place }}, {{ \Carbon\Carbon::parse($order->user->profile->date_of_birth)->format('d F Y') }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Waktu Konselng</p>
          <p class="font-medium">{{ \Carbon\Carbon::parse($order->schedule->date)->format('d F Y') }}, {{ $order->schedule->time }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Metode</p>
          <p class="font-medium">{{ $order->method->name }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Status</p>
            @switch($order->status)
                @case('pending')
                    <p class="me-2 mt-1.5 inline-flex items-center rounded bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                        Waiting Payment
                    </p>

                    @break

                @case('approved')
                    <p class="me-2 mt-1.5 inline-flex items-center rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                        Payment Success
                    </p>
                    @break

                @case('pay fail')
                    <p class="me-2 mt-1.5 inline-flex items-center rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                        Payment Failed
                    </p>
                    @break

                @default
                    <p class="me-2 mt-1.5 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                        Done
                    </p>
            @endswitch
        </div>
      </div>
    </div>

    <!-- Komentar Konseling -->
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-6 text-gray-800">Tulis Jawaban anda disini.</h2>

  <!-- Form Komentar -->
  <form id="commentForm" class="mb-8">
    <textarea 
      name="message" 
      rows="3" 
      placeholder="Tulis keluh kesah dan jawaban kamu disini" 
      class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
    ></textarea>
    <div class="mt-3 flex justify-end">
      <button 
        type="submit" 
        class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg"
      >
        Kirim
      </button>
    </div>
  </form>

  <!-- Daftar Komentar -->
  <div id="commentBox" class="space-y-6">
    
    <!-- Komentar User -->
    <div class="flex gap-3">
      <img src="{{ asset('img/user.png') }}" class="w-10 h-10 rounded-full" alt="User">
      <div class="flex-1">
        <div class="flex items-center gap-2">
          <span class="font-semibold text-gray-800">Nama Client</span>
          <span class="text-xs text-gray-500">20 Agustus 2025, 10:02 AM</span>
        </div>
            <p class="text-gray-700 mt-2">
            Akhir-akhir ini saya sering merasa tidak bersemangat untuk melakukan apapun. Bahkan aktivitas sederhana seperti bangun pagi dan menyiapkan sarapan terasa sangat berat. Pikiran saya sering kacau, ada rasa takut gagal yang terus menghantui. Saya jadi sering menunda pekerjaan, lalu merasa bersalah setelahnya. Kadang saya iri melihat teman-teman yang terlihat bahagia dan lancar dengan hidup mereka, sementara saya merasa jalan di tempat. Saya bingung harus mulai dari mana untuk memperbaiki keadaan ini.
            </p>
      </div>
    </div>
    
    <div class="flex gap-3">
      <img src="{{ asset('img/user.png') }}" class="w-10 h-10 rounded-full" alt="User">
      <div class="flex-1">
        <div class="flex items-center gap-2">
          <span class="font-semibold text-gray-800">Nama Client</span>
          <span class="text-xs text-gray-500">20 Agustus 2025, 10:02 AM</span>
        </div>
            <p class="text-gray-700 mt-2">
            Akhir-akhir ini saya sering merasa tidak bersemangat untuk melakukan apapun. Bahkan aktivitas sederhana seperti bangun pagi dan menyiapkan sarapan terasa sangat berat. Pikiran saya sering kacau, ada rasa takut gagal yang terus menghantui. Saya jadi sering menunda pekerjaan, lalu merasa bersalah setelahnya. Kadang saya iri melihat teman-teman yang terlihat bahagia dan lancar dengan hidup mereka, sementara saya merasa jalan di tempat. Saya bingung harus mulai dari mana untuk memperbaiki keadaan ini.
            </p>
      </div>
    </div>

    <!-- Komentar Dokter (posisi kanan) -->
    <div class="flex gap-3 justify-end text-right">
      <div class="flex-1">
        <div class="flex items-center justify-end gap-2">
          <span class="text-xs text-gray-500">20 Agustus 2025, 10:05 AM</span>
          <span class="font-semibold text-green-700">Kamu</span>
        </div>
        <p class="text-gray-700 mt-2">
          Tenang, itu wajar sekali. Mari kita bahas lebih dalam apa pemicu kecemasanmu.
        </p>
      </div>
      <img src="{{ asset('img/psikolog.png') }}" class="w-10 h-10 rounded-full" alt="Psikolog">
    </div>

  </div>
</div>




  </div>
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