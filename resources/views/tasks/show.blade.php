<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>My Order - Psychologist For Everyone</title>
  <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
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
          <p class="font-medium">
            <a data-modal-target="userModal" data-modal-toggle="userModal" class=" font-semibold text-blue-600 hover:text-blue-800 hover:underline cursor-pointer">
              {{ $order->user->profile->name }}
            </a>
              
          </p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Nama Panggilan</p>
          <p class="font-medium">{{ $order->user->profile->nickname }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Domisili</p>
          <p class="font-medium">{{ $order->user->profile->domicile }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Tanggal Lahir</p>
          <p class="font-medium">{{ \Carbon\Carbon::parse($order->user->profile->date_of_birth)->format('d F Y') }} ( {{ \Carbon\Carbon::parse($order->user->profile->date_of_birth)->age }} Tahun )</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Waktu Konselng</p>
          <p class="font-medium">{{ \Carbon\Carbon::parse($order->schedule->date)->format('d F Y') }}, {{ $order->schedule->time }}</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Metode</p>
          <p class="font-medium">{{ $order->method->name }}</p>
          <a href="{{ $order->link }}" target="_blank" class="text-blue-600 hover:underline text-sm cursor-pointer">
            {{ $order->link }}
          </a>
        </div>
        <div>
          <p class="text-sm text-gray-500">Status</p>
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

              @case('progress')
                  <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                      Waiting Approved Admin
                  </dd>
                  @break

              @default
                  <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                      Done
                  </dd>
          @endswitch
        </div>
      </div>
    </div>

<div class="bg-white rounded-2xl shadow p-6">
 
<!-- Button Modal -->
@if (!$order->counselingResult)
  <div class="flex justify-end mt-4">
    <button data-modal-target="finishSessionModal" data-modal-toggle="finishSessionModal"
      class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg">
      Menyelesaikan Sesi
    </button>
  </div>
@endif



  
  <!-- Modal -->
  <div id="finishSessionModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="relative w-full max-w-5xl p-4">
      <div class="bg-white rounded-lg shadow dark:bg-gray-800">
        <!-- Header -->
        <div class="flex justify-between items-center border-b px-4 py-2">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            Form Menyelesaikan Sesi
          </h3>
          <button type="button" class="text-gray-400 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
            data-modal-hide="finishSessionModal">
            ✕
          </button>
        </div>

        <!-- Body -->
        <form action="{{ route('result.store') }}" method="POST" class="p-4 space-y-4" id="post-form">
          @csrf
          <input type="hidden" name="order_id" value="{{ $order->id }}">

          <div>
            <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan Hasil</label>
            <textarea id="catatan" name="catatan" class="hidden"></textarea>
            <div id="catatanquill"></div>
          </div>
                    
          <div>
            <label for="dugaan" class="block text-sm font-medium text-gray-700">Dugaan Sementara</label>
            <input type="text" id="dugaan" name="dugaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          </div>

          <div>
            <label for="rekomendasi" class="block text-sm font-medium text-gray-700">Rekomendasi</label>
            <textarea id="rekomendasi" name="rekomendasi" class="hidden"></textarea>
            <div id="rekomendasiquill"></div>
          </div>

          <div>
              <label for="overtime_id" class="block text-sm font-medium text-gray-700">Over Time</label>
              <select id="overtime_id" name="overtime_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                  @foreach($overtimes as $overtime)
                      <option value="{{ $overtime->id }}">
                          {{ $overtime->name }}
                      </option>
                  @endforeach
              </select>
          </div>

          <!-- Footer -->
          <div class="flex justify-end gap-3 pt-4">
            <button type="submit"
              class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
              Selesai
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>





  <!-- Modal Riwayat User -->
  <div id="userModal" tabindex="-1" aria-hidden="true"
      class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
      <div class="relative w-full max-w-4xl p-4">
          <div class="bg-white rounded-2xl shadow-lg overflow-hidden dark:bg-gray-900 transition-all duration-300">

              <!-- Header -->
              <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      🕓 Riwayat Aktivitas User
                  </h3>
                  <button type="button"
                      class="text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 rounded-full text-lg w-8 h-8 flex items-center justify-center"
                      data-modal-hide="userModal">
                      ✕
                  </button>
              </div>

              <div class="p-6 mb-6 pb-6 max-h-[70vh] overflow-y-auto">
                <div class="space-y-8 relative border-l-2 border-gray-200 dark:border-gray-700 ml-4 pl-6">
                  <div class="bg-white shadow-md rounded-2xl p-6">
                    <div class="flex flex-col items-center text-center">
                        <img src="{{ asset($order->user->profile->image) }}" alt="Profile Photo" class="w-32 h-32 rounded-full border-4 border-gray-200 object-cover mb-4"/>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $order->user->profile->name }}</h2>
                        @if($order->user->profile->nickname)
                            <p class="text-gray-500">“{{ $order->user->profile->nickname }}”</p>
                        @endif
                        <p class="mt-2 text-sm text-gray-600">{{ $order->user->email }}</p>
                        <div class="mt-4 w-full text-left text-sm text-gray-700 space-y-2">
                            <p>
                                <span class="font-medium">Tanggal Lahir:</span> 
                                {{ \Carbon\Carbon::parse($order->user->profile->date_of_birth)->format('d F Y') }} ( {{ \Carbon\Carbon::parse($order->user->profile->date_of_birth)->age }} Tahun )
                            </p>
                            <p>
                                <span class="font-medium">Jenis Kelamin:</span> 
                                {{ $order->user->profile->gender == 'L' ? 'Laki-laki' : ($order->user->profile->gender == 'P' ? 'Perempuan' : '-') }}
                            </p>
                            <p><span class="font-medium">Domisili:</span> {{ $order->user->profile->domicile ?? '-' }}</p>
                            <p>
                                <span class="font-medium">No. WhatsApp:</span> 
                                {{ $order->user->profile->no_whatsapp ?? '-' }}
                            </p>
                        </div>
                    </div>
                  </div>
                </div>

                <div class="space-y-8 relative border-l-2 border-gray-200 dark:border-gray-700 ml-4 pl-6">
                  <div class="bg-white shadow-md rounded-2xl p-6">
                    <div class="flex flex-col items-center text-center">
                        <h2 class="text-xl font-semibold text-gray-900">Riwayat Konseling</h2>
                        <div class="mt-4 w-full text-left text-sm text-gray-700 space-y-2">
                          @foreach ($hpps as $hpp)
                            <div class="flex items-center gap-2">

                                <!-- Logo PDF -->
                                <img src="{{ asset('pdf-icon.png') }}" 
                                    alt="PDF"
                                    class="w-5 h-5">

                                <!-- Nomor + Link PDF -->
                                <a href="{{ asset($hpp->hpp_file) }}" 
                                  target="_blank"
                                  class="text-blue-600 hover:underline">
                                    {{ $loop->iteration }}. {{ basename($hpp->hpp_file) }}
                                </a>

                            </div>
                        @endforeach

                      </div>

                    </div>
                  </div>
                </div>
            
                  {{-- Timeline Section --}}
                  <div class="space-y-8 mt-6 relative border-l-2 border-gray-200 dark:border-gray-700 ml-4 pl-6">
                      @foreach ($activities as $activity)
                          @php
                              $colors = [
                                  1 => 'bg-blue-600',     // primary
                                  2 => 'bg-gray-500',     // secondary
                                  3 => 'bg-green-600',    // success
                                  4 => 'bg-yellow-500',   // warning
                                  5 => 'bg-red-600',      // danger
                              ];
                              $color = $colors[$activity->code] ?? 'bg-gray-400';
                          @endphp

                          <div class="relative">
                              <!-- Dot -->
                              <div
                                  class="absolute w-4 h-4 {{ $color }} rounded-full -left-[1.15rem] top-1.5 border-2 border-white dark:border-gray-900 shadow">
                              </div>

                              <!-- Content -->
                              <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                                  <div class="flex items-center justify-between mb-1">
                                      <h4 class="font-semibold text-gray-800 dark:text-gray-100 text-base">
                                          {{ $activity->title }}
                                      </h4>
                                      <time class="text-sm text-gray-500">
                                          {{ $activity->created_at->diffForHumans() }}
                                      </time>
                                  </div>
                                  <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                                      {{ $activity->description }}
                                  </p>
                              </div>
                          </div>
                      @endforeach
                  </div>
              </div>

              <!-- Footer -->
              <div class="flex justify-end border-t border-gray-200 dark:border-gray-700 px-6 py-3">
                  <button data-modal-hide="userModal"
                      class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200">
                      Tutup
                  </button>
              </div>
          </div>
      </div>
  </div>




  <!-- Daftar Komentar -->
  <div id="commentBox" class="space-y-6">
    
    @foreach ($communications as $communication)
      @if ($communication->user->role == "user")
        <!-- Komentar User -->
        <div class="flex gap-3">
          <img src="{{ asset($communication->user->profile->image) }}" class="w-10 h-10 rounded-full" alt="{{ $communication->user->profile->name }}">
          <div class="flex-1 prose">
            <div class="flex items-center gap-2">
              <span class="font-semibold text-gray-800">{{ $communication->user->profile->name }}</span>
              <span class="text-xs text-gray-500">{{ $communication->created_at->diffForHumans() }}</span>
            </div>
            <div class="text-gray-700 mt-2 prose">
                {!! $communication->message !!}
            </div>
          </div>
        </div>
      
      @elseif ($communication->user->role == "administrator")
        <!-- Komentar Admin -->
        <div class="flex gap-3 justify-end text-right">
          <div class="flex-1">
            <div class="flex items-center justify-end gap-2">
              <span class="text-xs text-gray-500">{{ $communication->created_at->diffForHumans() }}</span>
              <span class="font-semibold text-green-700">Admin</span>
            </div>
            <div class="text-gray-700 mt-2 prose">
                {!! $communication->message !!}
            </div>
          </div>
          <img src="{{ asset($communication->user->profile->image) }}" class="w-10 h-10 rounded-full" alt="Admin">
        </div>
      @else
        <!-- Komentar Admin -->
        <div class="flex gap-3 justify-end text-right">
          <div class="flex-1">
            <div class="flex items-center justify-end gap-2">
              <span class="text-xs text-gray-500">{{ $communication->created_at->diffForHumans() }}</span>
              <span class="font-semibold text-green-700">{{ $communication->user->profile->name }}</span>
            </div>
            <div class="text-gray-700 mt-2 prose">
                {!! $communication->message !!}
            </div>
          </div>
          <img src="{{ asset($communication->user->profile->image) }}" class="w-10 h-10 rounded-full" alt="{{ $communication->user->profile->name }}">
        </div>
      @endif
    @endforeach

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

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<!-- Include the Quill library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
  const quill = new Quill('#catatanquill', {
    theme: 'snow',
  });

  const quill2 = new Quill('#rekomendasiquill', {
    theme: 'snow',
  });

  

  const postForm = document.querySelector('#post-form');
  const postCatatan = document.querySelector('#catatan');
  const postRekomendasi = document.querySelector('#rekomendasi');
  const quillCatatanQuill = document.querySelector('#catatanquill');
  const quillRekomendasiQuill = document.querySelector('#rekomendasiquill');

  postForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const catatan = quillCatatanQuill.children[0].innerHTML;
    const rekomendasi = quillRekomendasiQuill.children[0].innerHTML;
    // console.log(content);
    postCatatan.value = catatan;
    postRekomendasi.value = rekomendasi;
    postForm.submit();

  });
</script>

</body>
</html>