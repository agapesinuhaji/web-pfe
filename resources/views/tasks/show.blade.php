<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>My Order - Psychology For Everyone</title>
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
          <p class="font-medium">{{ $order->user->profile->name }}</p>
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

              @default
                  <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                      Done
                  </dd>
          @endswitch
        </div>
      </div>
    </div>

    <!-- Komentar Konseling -->
<div class="bg-white rounded-2xl shadow p-6">
  {{-- <h2 class="text-xl font-semibold mb-6 text-gray-800">Tulis Jawaban anda disini.</h2> --}}

  <!-- Form Komentar -->
  {{-- <form action="{{ route('communications.store') }}" method="POST" class="mb-8" id="post-form">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <textarea id="body" name="message" class="hidden"></textarea>
    <div id="editor"></div>
    <div class="mt-3 flex justify-end">
      <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg">
        Kirim
      </button>
    </div>
  </form> --}}

  
  <!-- Button Modal -->
  <div class="flex justify-end mt-4">
    <button data-modal-target="finishSessionModal" data-modal-toggle="finishSessionModal"
      class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg">
      Menyelesaikan Sesi
    </button>
  </div>



  
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
        <form action="" method="POST" class="p-4 space-y-4">
          @csrf
          <input type="hidden" name="order_id" value="{{ $order->id }}">

          <div>
            <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan Hasil</label>
            <textarea id="catatan" name="catatan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
          </div>

          <div>
            <label for="dugaan" class="block text-sm font-medium text-gray-700">Dugaan Sementara</label>
            <input type="text" id="dugaan" name="dugaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          </div>

          <div>
            <label for="rekomendasi" class="block text-sm font-medium text-gray-700">Rekomendasi</label>
            <textarea id="rekomendasi" name="rekomendasi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
          </div>

          <div>
            <label for="overtime" class="block text-sm font-medium text-gray-700">Over Time</label>
            <select id="overtime" name="overtime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
              <option value="" selected disabled></option>
              <option value="15">15 Menit</option>
              <option value="30">30 Menit</option>
              <option value="45">45 Menit</option>
              <option value="60">60 Menit</option>
            </select>
          </div>

          <!-- Footer -->
          <div class="flex justify-end gap-3 pt-4">
            <button type="button" data-modal-hide="finishSessionModal"
              class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
              Batal
            </button>
            <button type="submit"
              class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
              Selesai
            </button>
          </div>
        </form>
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
  const quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Tulis keluh kesah kamu disini'
  });

  const postForm = document.querySelector('#post-form');
  const postBody = document.querySelector('#body');
  const quillEditor = document.querySelector('#editor');

  postForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const content = quillEditor.children[0].innerHTML;
    // console.log(content);
    postBody.value = content;
    postForm.submit();

  });
</script>

</body>
</html>