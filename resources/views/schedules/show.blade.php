<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Jadwal Psikolog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Step 1: Pilih Periode, Konselor, Produk --}}
            <form id="filterForm" method="GET" action="">
                <div class="space-y-4 bg-white p-6 rounded-xl shadow">
                    <div class="flex justify-between p-4">
                        <a href="{{ route('periode.index') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-gray-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            <svg class="-ms-0.5 me-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>

                    </div>
                    
                    <!-- Periode (readonly) -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Periode</label>
                        <input type="text" class="w-full border rounded p-2 bg-gray-100" 
                               value="{{ $periode->name}}" 
                               readonly>
                        <input type="hidden" name="periode_id" value="{{ $periode->id }}">
                    </div>

                    <!-- Counselor combobox -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Pilih Konselor</label>
                        <select name="counselor_id" class="w-full border rounded p-2">
                            <option value="">-- Pilih Konselor --</option>
                            @foreach($psychologists as $c)
                                <option value="{{ $c->id }}" 
                                    {{ request('counselor_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->profile->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Produk combobox -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Pilih Produk Konseling</label>
                        <select name="product_id" class="w-full border rounded p-2">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" 
                                    {{ request('product_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Button Terapkan -->
                    <div>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Terapkan
                        </button>
                    </div>
                </div>
            </form>

            {{-- Step 2: Tampilkan Form Jadwal jika filter dipilih --}}
            @if(request('counselor_id') && request('product_id'))
                    <form action="{{ route('schedule.store') }}" method="POST" class="mt-8">
                        @csrf

                        <input type="hidden" name="periode_id" value="{{ $periode->id }}">
                        <input type="hidden" name="conselor_id" value="{{ request('counselor_id') }}">
                        <input type="hidden" name="product_id" value="{{ request('product_id') }}">

                        <div class="space-y-4 max-h-[70vh] overflow-y-auto pr-2 bg-white p-6 rounded-xl shadow">
                            @foreach($dates as $date)
                                <div class="p-3 border rounded-lg bg-gray-50">
                                    <h3 class="font-semibold text-gray-700">
                                        {{ $date->translatedFormat('l, d M Y') }}
                                    </h3>

                                    <div class="slots space-y-2" data-date="{{ $date->toDateString() }}">
                                        
                                        

                                        {{-- input kosong untuk tambah baru --}}
                                        <div class="flex gap-2 mt-2">
                                            <input type="time" 
                                                name="slots[{{ $date->toDateString() }}][]" 
                                                class="w-40 rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm 
                                                        shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none" />

                                            <button type="button" 
                                                    class="add-slot px-3 py-1 bg-green-500 text-white rounded">+ Tambah</button>
                                        </div>
                                        {{-- tampilkan schedule lama jika ada --}}
                                        @if(isset($schedules[$date->toDateString()]))
                                            @foreach($schedules[$date->toDateString()] as $sch)
                                                <div class="flex gap-2">
                                                    <input type="time" 
                                                        name="slots[{{ $date->toDateString() }}][]" 
                                                        value="{{ $sch->time }}" 
                                                        class="w-40 rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm 
                                                                shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                                                    <button type="button" 
                                                            class="remove-slot px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg">
                            Simpan Jadwal
                        </button>
                    </form>
            @endif

        </div>
    </div>


{{-- Tambah / Hapus Slot --}}
<script>
  document.addEventListener("click", function(e) {
    if (e.target.classList.contains("add-slot")) {
      let container = e.target.closest(".slots");
      let date = container.getAttribute("data-date");
      let div = document.createElement("div");
      div.classList.add("flex","gap-2","mt-2");
      div.innerHTML = `
        <input type="time" name="slots[${date}][]" class="w-40 rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-150 ease-in-out">
        <button type="button" class="remove-slot px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
      `;
      container.appendChild(div);
    }

    if (e.target.classList.contains("remove-slot")) {
      e.target.parentElement.remove();
    }
  });
</script>

</x-app-layout>
