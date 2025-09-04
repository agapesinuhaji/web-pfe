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
      {{-- Alert pengingat pembayaran --}}
      @if ($order->status === 'pending')
        <div class="mb-6 p-4 rounded-lg bg-yellow-50 border border-yellow-300">
          <div class="flex items-center gap-2 text-yellow-800">
            <svg  fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L4.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="font-medium">Silahkan lakukan pembayaran untuk order ini.</span>
          </div>
          <div class="mt-2">
            <a href="{{ url('checkout/payment/' . $order->order_uuid) }}" 
              class="inline-block text-sm text-blue-600 hover:underline font-medium">
                Lanjutkan Pembayaran →
            </a>
          </div>
        </div>
      @endif

      {{-- Alert pengingat testimoni --}}
      @if ($order->status === 'selesai')
        @if (!$order->testimony)
          <div class="mb-6 p-6 rounded-lg bg-green-50 border border-green-300 text-center">
            <svg fill="currentColor" viewBox="0 0 24 24" class="w-12 h-12 mx-auto text-red-500 mb-3">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5   2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09    C13.09 3.81 14.76 3 16.5 3    19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55    11.54L12 21.35z" />
            </svg>
            <p class="text-green-800 font-medium mb-3">
              Terimakasih sudah mempercayakan konseling anda bersama kami. 
              Kritik dan saran anda sangat berarti bagi kami.
            </p>
            <a data-modal-target="testimoniModal" data-modal-toggle="testimoniModal" class="inline-block px-4 py-2 text-sm font-medium text-green-700  border border-green-600 rounded-lg bg-green-100   hover:bg-green-600 hover:text-white transition">
              Berikan Kritik & Saran
            </a>
          </div>
        @endif
      @endif
    
    <!-- Detail Konseling -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Detail Orderan Anda</h2>
        @php
            use Carbon\Carbon;
            use App\Models\Reschedule;

            $daysDiff = Carbon::now()->diffInDays(Carbon::parse($order->schedule->date), false);
            $hasReschedule = Reschedule::where('order_id', $order->id)->exists();
        @endphp

        @if ($daysDiff >= 2 && !$hasReschedule)
            <a data-modal-target="rescheduleModal" data-modal-toggle="rescheduleModal"
              class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg shadow hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 cursor-pointer">
                Reschedule
            </a>
        @endif


      </div>
      <div class="grid sm:grid-cols-2 gap-4 text-gray-700">
        <div>
          <p class="text-sm text-gray-500">Order ID</p>
          <p class="font-medium">#{{ strtoupper(substr($order->order_uuid, 0, 8)) }}</p>
          <div class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
              {{ $order->created_at->format('d-m-Y H:i:s') }}
          </div>
        </div>
        <div>
          <p class="text-sm text-gray-500">Nama Psikolog</p>
          <a data-modal-target="readConselorModal" data-modal-toggle="readConselorModal" class="font-medium text-blue-500 hover:text-blue-800 hover:underline cursor-pointer">{{ $order->user->profile->name }}</a>
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
                  <div class="mt-1">
                      <a href="{{ url('checkout/payment/' . $order->order_uuid) }}" 
                        class="text-xs text-blue-500 hover:underline">
                          Lanjutkan Pembayaran
                      </a>
                  </div>
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
      @if(in_array($order->status, ['pending', 'payed', 'approved']))
        <h2 class="text-xl font-semibold mb-6 text-gray-800">Tulis keluh kesah dan jawaban kamu disini.</h2>

        <!-- Form Komentar -->
        <form action="{{ route('communications.store') }}" method="POST" class="mb-8" id="post-form">
          @csrf
          <input type="hidden" name="order_id" value="{{ $order->id }}">
          <textarea id="body" name="message" class="hidden"></textarea>
          <!-- Create the editor container -->
          <div id="editor"></div>
          <div class="mt-3 flex justify-end">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg">
              Kirim
            </button>
          </div>
        </form>
      @endif


  
  <!-- Daftar Komentar -->
  <div id="commentBox" class="space-y-6">
    @foreach ($communications as $communication)
      @if ($communication->user->role == "psikolog")
        <!-- Komentar Admin & Psikolog -->
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
      <!-- Komentar Admin & Psikolog -->
        <div class="flex gap-3">
          <img src="{{ asset($communication->user->profile->image) }}" class="w-10 h-10 rounded-full" alt="{{ $communication->user->profile->name }}">
          <div class="flex-1 prose">
            <div class="flex items-center gap-2">
              <span class="font-semibold text-gray-800">Admin</span>
              <span class="text-xs text-gray-500">{{ $communication->created_at->diffForHumans() }}</span>
            </div>
            <div class="text-gray-700 mt-2 prose">
                {!! $communication->message !!}
            </div>
          </div>
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


<!-- Read modal -->
<div id="readConselorModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
      <!-- Modal content -->
      <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
          <!-- Modal header -->
          <div class="flex justify-between mb-4 rounded-t sm:mb-5">
              <div class="text-lg text-gray-900 md:text-xl dark:text-white">
                  <h3 class="font-semibold ">{{ $order->conselor->profile->name }}</h3>
              </div>
              <div>
                  <button type="button"
                      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex dark:hover:bg-gray-600 dark:hover:text-white"
                      data-modal-toggle="readConselorModal">
                      <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                          >
                          <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd" />
                      </svg>
                      <span class="sr-only">Close modal</span>
                  </button>
              </div>
          </div>

          <!-- grid: mobile 1 kolom, desktop 2 kolom -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <!-- Foto Konselor -->
              <div class="flex justify-center">
                  <img src="{{ asset($order->conselor->profile->image) }}"
                      alt="{{ $order->conselor->profile->name }}"
                      class="w-40 h-40 rounded-full object-cover">
              </div>

              <!-- Deskripsi -->
              <div>
                  <dl>
                      <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">About Conselor</dt>
                      <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                          {{ $order->conselor->profile->description }}
                      </dd>
                  </dl>
              </div>
          </div>

          <!-- Footer -->
          <div class="flex justify-end mt-4">
              <button type="button"
                  class="inline-flex items-center text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                  data-modal-toggle="readConselorModal">
                  Close
              </button>
          </div>
      </div>
  </div>
</div>

<!-- Modal Reschedule -->
<div id="rescheduleModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Form Reschedule</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-target="rescheduleModal" data-modal-toggle="rescheduleModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" >
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="#">
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">
                    </div>
                    <div>
                        <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                        <input type="text" name="brand" id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Product brand" required="">
                    </div>
                    <div>
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input type="number" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="$2999" required="">
                    </div>
                    <div><label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label><select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"><option selected="">Select category</option><option value="TV">TV/Monitors</option><option value="PC">PC</option><option value="GA">Gaming/Console</option><option value="PH">Phones</option></select></div>
                    <div class="sm:col-span-2"><label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label><textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Write product description here"></textarea></div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewbox="0 0 20 20" >
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add new product
                </button>
            </form>
        </div>
    </div>
</div>



<!-- Modal Testimoni -->
<div id="testimoniModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Berikan Kritik dan Saran Anda</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-target="testimoniModal" data-modal-toggle="testimoniModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" >
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('testimony.store') }}" method="POST">
              @csrf
              <input type="hidden" name="order_id" value="{{ $order->id }}">
              <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <!-- Rating -->
                <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Rating
                  </label>

                  <div id="star-rating" class="flex space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                      <svg data-value="{{ $i }}" 
                          class="w-8 h-8 cursor-pointer text-gray-300 hover:text-yellow-400 transition-colors duration-200"
                          fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 
                                3.292a1 1 0 00.95.69h3.462c.969 0 
                                1.371 1.24.588 1.81l-2.8 2.034a1 
                                1 0 00-.364 1.118l1.07 3.292c.3.921-.755 
                                1.688-1.54 1.118L10 13.347l-2.888 
                                2.034c-.784.57-1.838-.197-1.539-1.118l1.07-
                                3.292a1 1 0 00-.364-1.118L3.48 
                                8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 
                                1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                    @endfor
                  </div>

                  <input type="hidden" name="rating" id="rating-input" required>

                </div>

                <!-- Message -->
                <div class="sm:col-span-2">
                  <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Testimoni
                  </label>
                  <textarea id="message" name="message" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg 
                          border border-gray-300 focus:ring-primary-500 focus:border-primary-500 
                          dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                          dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Tuliskan pengalaman anda di sini..." required></textarea>
                </div>
              </div>

              <!-- Submit -->
              <button type="submit"
                class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 
                      focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg 
                      text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 
                      dark:focus:ring-primary-800">
                <svg class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M10 5a1 1 0 011 1v3h3a1 1 0 
                      110 2h-3v3a1 1 0 11-2 0v-3H6a1 
                      1 0 110-2h3V6a1 1 0 011-1z"
                    clip-rule="evenodd" />
                </svg>
                Tambah Testimoni
              </button>
            </form>


        </div>
    </div>
</div>


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

{{-- Rating --}}
<script>
  const stars = document.querySelectorAll('#star-rating svg');
  const ratingInput = document.getElementById('rating-input');

  stars.forEach(star => {
    star.addEventListener('click', () => {
      let value = star.getAttribute('data-value');
      ratingInput.value = value;

      // Reset semua bintang ke abu-abu
      stars.forEach(s => s.classList.remove('text-yellow-400'));
      stars.forEach(s => s.classList.add('text-gray-300'));

      // Warnai semua bintang sampai yg dipilih
      for (let i = 0; i < value; i++) {
        stars[i].classList.remove('text-gray-300');
        stars[i].classList.add('text-yellow-400');
      }
    });
  });
</script>

</body>
</html>