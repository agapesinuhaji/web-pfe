<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
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
          <p class="font-bold text-lg">{{ $order->conselor->profile->name }}</p>
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
                  <div class="mt-1">
                      <a data-modal-target="konfirmasiPaymentModal" data-modal-toggle="konfirmasiPaymentModal" class="text-xs text-blue-500 hover:underline cursor-pointer">Konfirmasi Pembayaran</a>
                  </div>
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
            </div>
        </div>
    </div>



      
  <!-- Modal -->
  <div id="konfirmasiPaymentModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="relative w-full max-w-2xl p-4">
      <div class="bg-white rounded-lg shadow dark:bg-gray-800">
        <!-- Header -->
        <div class="flex justify-between items-center border-b px-4 py-2">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            Konfirmasi Pembayaran
          </h3>
          <button type="button" class="text-gray-400 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
            data-modal-hide="konfirmasiPaymentModal">
            ✕
          </button>
        </div>

        <!-- Body -->
        <form action="{{ route('order.update', $order->order_uuid) }}" method="POST" class="p-4 space-y-4">
          @csrf
          @method('PUT')
            <input type="hidden" name="status" value="approved">
            <img src="{{ asset($order->image) }}" class="mx-auto object-cover rounded-lg h-150 md:h-200 " alt="">

          <!-- Footer -->
          <div class="flex justify-end gap-3 pt-4">
            <button type="button" data-modal-hide="konfirmasiPaymentModal"
              class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
              Batal
            </button>
            <button type="submit"
              class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
              Konfirmasi Pembayaran
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

    
</x-app-layout>
