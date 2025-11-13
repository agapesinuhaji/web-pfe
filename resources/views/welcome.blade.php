<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Psychologist For Everyone</title>
  <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="bg-white-50">
  @include('layouts.nav')

  <div class="relative isolate px-6 pt-48 lg:px-8">
    <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75"></div>
    </div>
    <div class="mx-auto max-w-4xl py-32 sm:py-48 lg:py-56">
      <div class="text-center">
        <h1 class="text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">Psychologist For Everyone</h1>
        <p class="mt-8 text-lg font-medium text-pretty text-gray-500 sm:text-xl/12">
          Kami percaya bahwa setiap orang berhak mendapatkan akses pelayanan terhadap kesehatan mental. Psychologist For Everyone hadir untuk menciptakan ruang aman, terjangkau dan mudah diakses agar kamu bisa lebih mengenal, memahami dan memulihkan diri.
        </p>
        <div class="mt-10 flex items-center justify-center gap-x-6">
          <a href="{{ url('/#contact') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Contact Us</a>
        </div>
      </div>
    </div>
    <div aria-hidden="true" class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75"></div>
    </div>
  </div>
</div>



<div class="overflow-hidden py-24 sm:py-32 bg-gray-900">
  <div class="mx-auto max-w-7xl px-6 lg:px-8">
    <div class="text-center">
      
      <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-white sm:text-5xl">
        Mengapa memilih konseling online di PFE?
      </h2>
      <p class="mt-6 text-xl text-gray-400 max-w-4xl mx-auto">
        Dapatkan dukungan profesional yang mudah diakses, terjamin kerahasiaannya, dan dirancang khusus untuk perjalanan kesehatan mental Anda.
      </p>

      <div class="mt-20 grid grid-cols-1 md:grid-cols-2 gap-x-24 gap-y-14 text-base leading-7 text-gray-300 mx-auto max-w-6xl">
        
        <div class="text-start p-4">
          <dt class="inline font-extrabold text-gray-50 flex items-start mb-2">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="size-7 mr-3 mt-1 shrink-0 text-teal-400">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.8"/>
              <path d="M12 2a15.3 15.3 0 0 1 4 10c0 4.2-2 7.7-4 10" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
              <path d="M12 2c-4 0-4 20 0 20M2.5 12h19" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
            </svg>
            <span class="text-xl">Aman, Nyaman, dan Rahasia</span>
          </dt>
          <dd class="text-gray-400 ml-10">
            Kami paham bahwa berbagi cerita pribadi membutuhkan keberanian. Semua sesi di PFE berlangsung di ruang virtual yang aman dan sepenuhnya <span class="font-semibold text-white">terjaga kerahasiaannya</span>. Hanya kamu dan psikolog, tanpa gangguan dan tanpa penilaian.
          </dd>
        </div>

        <div class="text-start p-4">
          <dt class="inline font-extrabold text-gray-50 flex items-start mb-2">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="size-7 mr-3 mt-1 shrink-0 text-teal-400">
              <path d="M12 3l6 2v5.5c0 4.1-2.8 7.8-6 9-3.2-1.2-6-4.9-6-9V5l6-2z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
              <rect x="8.75" y="11.5" width="6.5" height="4" rx="1" stroke="currentColor" stroke-width="1.6"/>
              <path d="M10.3 11.5V9.6a1.7 1.7 0 1 1 3.4 0v1.9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
            <span class="text-xl">Ditangani oleh Psikolog Klinis Berlisensi</span>
          </dt>
          <dd class="text-gray-400 ml-10">
            Setiap psikolog di PFE telah terverifikasi dan berpengalaman. Kamu akan ditangani dengan pendekatan yang <span class="font-semibold text-white">empatik, evidence-based, dan humanis</span>.
          </dd>
        </div>

        <div class="text-start p-4">
          <dt class="inline font-extrabold text-gray-50 flex items-start mb-2">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="size-7 mr-3 mt-1 shrink-0 text-teal-400">
              <circle cx="10" cy="9" r="3" stroke="currentColor" stroke-width="1.8"/>
              <path d="M4.5 18a5.5 5.5 0 0 1 11 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              <circle cx="17.5" cy="16.5" r="3.2" stroke="currentColor" stroke-width="1.6"/>
              <path d="M16.2 16.5l1.1 1.1 2-2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-xl">Pendekatan Personal dan Empatik</span>
          </dt>
          <dd class="text-gray-400 ml-10">
            Kami percaya bahwa setiap individu punya cerita yang unik. Setiap sesi ditujukan supaya kamu <span class="font-semibold text-white">merasa didengar, dipahami, dan diterima</span>, bukan hanya diberi saran cepat.
          </dd>
        </div>

        <div class="text-start p-4">
          <dt class="inline font-extrabold text-gray-50 flex items-start mb-2">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="size-7 mr-3 mt-1 shrink-0 text-teal-400">
                <rect x="3" y="6" width="18" height="13" rx="2" stroke="currentColor" stroke-width="1.8"/>
                <path d="M9 10.5h6M9 13.5h6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="1.5" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            <span class="text-xl">Harga Terjangkau, Akses untuk Semua</span>
          </dt>
          <dd class="text-gray-400 ml-10">
            Kami berkomitmen agar kesehatan mental <span class="font-semibold text-white">tidak menjadi privilese</span>. PFE menyediakan berbagai pilihan biaya konseling dan program untuk pelajar tanpa khawatir biaya.
          </dd>
        </div>

        <div class="text-start p-4">
          <dt class="inline font-extrabold text-gray-50 flex items-start mb-2">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="size-7 mr-3 shrink-0 text-teal-400">
                <circle cx="9" cy="8" r="3.5" stroke="currentColor" stroke-width="1.8"/>
                <path d="M4 20c0-2.8 2.2-5 5-5h0A5 5 0 0 1 14 20M17 12c-1.1 0-2 .9-2 2v4h4v-4c0-1.1-.9-2-2-2zM17 8c1.7 0 3-1.3 3-3s-1.3-3-3-3-3 1.3-3 3 1.3 3 3 3z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
            <span class="text-xl">Terhubung dengan Komunitas yang Peduli</span>
          </dt>
          <dd class="text-gray-400 ml-10">
            PFETalk, workshop art therapy</span>, dan kegiatan komunitas kami (PFEmily). Karena proses pulih akan lebih ringan jika dilakukan bersama-sama.
          </dd>
        </div>

      </div>
    </div>
  </div>
</div>


{{-- Section Psikolog --}}
<section class="bg-white dark:bg-gray-900" id="our-team">
  <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">
      <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
          <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Psikolog Kami</h2>
          <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">Kami hanya menghadirkan para profesional berlisensi yang berdedikasi untuk memberikan dukungan yang empatik dan berdasarkan bukti (evidence-based) dalam setiap sesi.</p>
      </div> 
      <div class="grid gap-8 lg:gap-16 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4" >
          <div class="text-center text-gray-500 dark:text-gray-400">
              <img class="mx-auto mb-4 w-36 h-36 rounded-full" src="{{ asset('psikolog/anette.jpg') }}" alt="Anette Isabella Ginting, M.Psi., Psikolog">
              <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                  <a href="#">Anette Isabella Ginting, M.Psi., Psikolog</a>
              </h3>
              <p>Domisili : Jakarta</p>
              <ul class="flex justify-center mt-4 space-x-4">
                  <li>
                      Pendekatan terapi : Client Centered Therapy, Art Therapy, Cognitive Behavior Therapy
                  </li>

              </ul>
          </div>
          <div class="text-center text-gray-500 dark:text-gray-400">
              <img class="mx-auto mb-4 w-36 h-36 rounded-full" src="{{ asset('psikolog/nida.jpg') }}" alt="Nida Khairunnisaa, M.Psi., Psikolog">
              <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                  <a href="#">Nida Khairunnisaa, M.Psi., Psikolog</a>
              </h3>
              <p>Domisili : Batam, Kepulauan Riau</p>
              <ul class="flex justify-center mt-4 space-x-4">
                  <li>
                      Pendekatan terapi : Client Centered Counseling, Solution Focused Brief Therapy, dan Cognitive Behavior Therapy
                  </li>

              </ul>
          </div>
          <div class="text-center text-gray-500 dark:text-gray-400">
              <img class="mx-auto mb-4 w-36 h-36 rounded-full" src="{{ asset('psikolog/bagas.jpg') }}" alt="Bagas Alam, M.Psi., Psikolog">
              <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                  <a href="#">Bagas Alam, M.Psi., Psikolog</a>
              </h3>
              <p>Domisili : Cilacap, Jawa Tengah</p>
              <ul class="flex justify-center mt-4 space-x-4">
                  <li>
                      Pendekatan terapi : -
                  </li>

              </ul>
          </div>
          <div class="text-center text-gray-500 dark:text-gray-400">
              <img class="mx-auto mb-4 w-36 h-36 rounded-full" src="{{ asset('psikolog/wiwin.jpg') }}" alt="Wiwin Theofany Sekeon, M.Psi., Psikolog">
              <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                  <a href="#">Wiwin Theofany Sekeon, M.Psi., Psikolog</a>
              </h3>
              <p>Domisili : Palu, Sulawesi Tengah</p>
              <ul class="flex justify-center mt-4 space-x-4">
                  <li>
                      Pendekatan terapi : Client Centered Therapy, Solution-Focused Brief Therapy, Art Therapy
                  </li>

              </ul>
          </div>
       
      </div>  
  </div>
</section>


{{-- Section Product --}}

<section class="bg-gray-100 py-16 px-4" id="services">
  <div class="max-w-7xl mx-auto text-center mb-12">
    <h2 class="text-4xl font-bold text-gray-800 mb-4">Pilih Paket Konseling Anda</h2>
    <p class="text-gray-600 text-lg">Kami memahami bahwa tidak semua pelajar memiliki akses mudah ke layanan psikologis. Karena itu, PFE menyediakan sesi khusus dengan <span class="font-bold">biaya yang lebih terjangkau</span> bagi pelajar yang ingin mendapatkan bantuan profesional.</p>
  </div>

  <div class="flex flex-col md:flex-row justify-center items-center gap-8">
    <!-- Pricing Card 1 -->
    <div class="w-full max-w-sm p-6 bg-white rounded-xl shadow-lg">
      <h3 class="text-2xl font-semibold text-gray-800 mb-4">Paket Pelajar</h3>
      <p class="text-gray-600 mb-6">Untuk pelajar dengan minimal usia 15 tahun dan maksimal 24 tahun.</p>
      <div class="text-4xl font-bold text-gray-900 mb-4">Rp45.000</div>
      <ul class="text-gray-600 mb-6 space-y-2 text-left">
        <li>✔️ 1x sesi (60 menit)</li>
        <li>✔️ Via chat, voice call atau video call (menyesuaikan kenyamananmu)</li>
        <li>✔️ Didampingi oleh Psikolog Klinis</li>
      </ul>
      <a href="/checkout"
        class="block w-full bg-blue-600 hover:bg-blue-700 text-center text-white font-medium py-2 rounded-lg transition duration-300">
        Pesan Sekarang
      </a>
    </div>

    <!-- Pricing Card 2 -->
    <div class="w-full max-w-sm p-6 bg-white rounded-xl shadow-lg border-2 border-blue-600">
      <h3 class="text-2xl font-semibold text-gray-800 mb-4">Paket Umum</h3>
      <p class="text-gray-600 mb-6">Untuk kalangan umum dengan minimal usia 15 tahun.</p>
      <div class="text-4xl font-bold text-gray-900 mb-4">85.000</div>
      <ul class="text-gray-600 mb-6 space-y-2 text-left">
        <li>✔️ 1x sesi (60 menit)</li>
        <li>✔️ Via chat, voice call atau video call (menyesuaikan kenyamananmu)</li>
        <li>✔️ Didampingi oleh Psikolog Klinis</li>
      </ul>
      <a href="/checkout"
        class="block w-full bg-blue-600 text-center hover:bg-blue-700 text-white font-medium py-2 rounded-lg transition duration-300">
        Pesan Sekarang
      </a>
    </div>
  </div>
</section>



{{-- Section Testimoni --}}
<section x-data="{
    testimonials: [
      { name: 'Rina Andini', role: 'Mahasiswi', img: 'https://i.pravatar.cc/100?img=1', rating: 5, text: 'Sesi konseling sangat membantu. Psikolognya sangat profesional dan membuat saya nyaman untuk bercerita.' },
      { name: 'Budi Prasetyo', role: 'Karyawan Swasta', img: 'https://i.pravatar.cc/100?img=2', rating: 4, text: 'Saya merasa lebih tenang setelah menjalani sesi konseling. Sangat direkomendasikan!' },
      { name: 'Melati Putri', role: 'Ibu Rumah Tangga', img: 'https://i.pravatar.cc/100?img=3', rating: 5, text: 'Platform ini sangat membantu saya menemukan bantuan profesional saat saya membutuhkannya.' },
      { name: 'Fajar Nugraha', role: 'Guru', img: 'https://i.pravatar.cc/100?img=4', rating: 5, text: 'Sangat puas dengan layanan konselingnya, jelas dan penuh empati.' },
      { name: 'Dewi Lestari', role: 'Mahasiswi', img: 'https://i.pravatar.cc/100?img=5', rating: 4, text: 'Pengalaman pertama konseling saya sangat positif, terima kasih banyak!' },
      { name: 'Andi Wijaya', role: 'Freelancer', img: 'https://i.pravatar.cc/100?img=6', rating: 5, text: 'Saya merasa lebih percaya diri dan terbantu secara emosional.' },
      { name: 'Sarah Maulida', role: 'Psikolog', img: 'https://i.pravatar.cc/100?img=7', rating: 5, text: 'Sangat bermanfaat untuk menjaga kesehatan mental saya.' },
      { name: 'Raka Surya', role: 'Pelajar', img: 'https://i.pravatar.cc/100?img=8', rating: 4, text: 'Konseling online-nya sangat fleksibel dan membantu.' },
      { name: 'Nina Larasati', role: 'Ibu Rumah Tangga', img: 'https://i.pravatar.cc/100?img=9', rating: 5, text: 'Saya jadi lebih tenang setelah konsultasi di sini.' },
      { name: 'Galang Aditya', role: 'Pengusaha', img: 'https://i.pravatar.cc/100?img=10', rating: 5, text: 'Layanan konseling ini sangat profesional dan aman.' }
    ],
    current: 0,
    next() {
        this.current = (this.current + 1) % Math.ceil(this.testimonials.length / 3);
    },
    prev() {
        this.current = (this.current - 1 + Math.ceil(this.testimonials.length / 3)) % Math.ceil(this.testimonials.length / 3);
    },
    start() {
        setInterval(() => this.next(), 7000);
    }
}" x-init="start" class="bg-white py-20 px-4">
  <div class="max-w-6xl mx-auto text-center">
    <h2 class="text-4xl font-bold text-gray-800 mb-4">Apa Kata Klien Kami</h2>
    <p class="text-gray-600 mb-12">Testimoni dari klien yang telah merasakan manfaat layanan kami</p>

    <!-- Carousel -->
    <div class="relative">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 transition-all duration-500">
        <template x-for="(item, index) in testimonials.slice(current * 3, current * 3 + 3)" :key="index">
          <div class="bg-gray-50 p-6 rounded-lg shadow-md text-left">
            <div class="flex items-center mb-4">
              <img class="w-12 h-12 rounded-full mr-4" :src="item.img" alt="User">
              <div>
                <h4 class="text-lg font-semibold text-gray-800" x-text="item.name"></h4>
                <p class="text-sm text-gray-500" x-text="item.role"></p>
              </div>
            </div>
            <div class="flex items-center text-yellow-400 mb-2">
              <template x-for="i in 5">
                <svg class="w-5 h-5 fill-current" :class="i <= item.rating ? 'text-yellow-400' : 'text-gray-300'" viewBox="0 0 20 20">
                  <path d="M10 15l-5.878 3.09L5.854 12.5 1 8.91l6.061-.87L10 3l2.939 5.04 6.061.87-4.854 3.59 1.732 5.59z"/>
                </svg>
              </template>
            </div>
            <p class="text-gray-600" x-text="`&quot;${item.text}&quot;`"></p>
          </div>
        </template>
      </div>

      <!-- Navigasi tombol -->
      <div class="flex justify-center mt-10 space-x-4">
        <button @click="prev" class="bg-gray-200 hover:bg-gray-300 text-gray-600 px-4 py-2 rounded-full">
          &larr;
        </button>
        <button @click="next" class="bg-gray-200 hover:bg-gray-300 text-gray-600 px-4 py-2 rounded-full">
          &rarr;
        </button>
      </div>
    </div>
  </div>
</section>


{{-- Section Contact --}}
<section class=" py-20 px-4" id="contact">
  <div class="max-w-4xl mx-auto text-center text-gray-600">
    <h2 class="text-4xl font-bold mb-4">Butuh Bantuan atau Ingin Konsultasi?</h2>
    <p class="text-lg mb-8">Kami siap membantu Anda. Hubungi kami untuk pertanyaan atau buat janji konsultasi sekarang juga.</p>

    <div class="flex flex-col sm:flex-row justify-center gap-4">
      
      <a href="https://wa.me/62882008677682" target="_blank" class="bg-green-600 text-white hover:bg-green-700 font-semibold py-3 px-6 rounded-full transition duration-300">
       
        Chat via WhatsApp
      </a>
   </div>
  </div>
</section>



{{-- Section Footer --}}
<footer class="p-4 bg-gray-900 md:p-8 lg:p-10 ">
  <div class="mx-auto max-w-screen-xl text-center">
      <a href="{{ url('/') }}" class="flex justify-center items-center text-2xl pt-4 font-semibold text-white">
           <img src="{{ asset('favicon-darkmode.svg') }}" alt="Logo" class="mr-2 h-8" />
         
          Psychologist For Everyone  
      </a>
    </div>
    <span class="text-sm flex justify-center pt-2 text-gray-100 sm:text-center dark:text-gray-400">© 2025 &nbsp; <a href="{{ url('/') }}" class="hover:underline">PFE <!--™ --></a>. All Rights Reserved.</span>
</footer>





<script src="//unpkg.com/alpinejs" defer></script>


<!-- Floating WhatsApp Button -->
<a 
  href="https://wa.me/62882008677682" 
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