<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Jadwal Psikolog ') }}<br>Periode : 26 Juni 2025 - 25 Juli 2025
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="" method="POST">
            @csrf

            <!-- Pilih Konselor -->
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Pilih Konselor</label>
                <input type="hidden" name="counselor_id" id="counselor_id" />

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($psychologists as $c)
                    <div class="counselor-card cursor-pointer p-4 border rounded-xl bg-white shadow hover:border-blue-500 hover:shadow-md transition" data-id="{{ $c->id }}">
                        <div class="flex items-center gap-3">
                            <img src="{{ $c->profile->image }}" class="w-12 h-12 rounded-full object-cover border" alt="{{ $c->profile->name }}">
                            <div>
                                <h3 class="font-semibold text-gray-700">{{ $c->profile->name }}</h3>
                                <p class="text-sm text-gray-500">Psikolog</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Pilih Produk Konseling -->
            <div class="mt-8">
                <label class="block text-sm font-medium mb-2">Pilih Produk Konseling</label>
                <input type="hidden" name="product_id" id="product_id" />

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="product-card cursor-pointer p-4 border rounded-xl bg-white shadow hover:border-green-500 hover:shadow-md transition" data-id="1">
                        <h3 class="font-semibold text-gray-700">Umum</h3>
                        <p class="text-sm text-gray-500">Konseling untuk kebutuhan umum</p>
                    </div>

                    <div class="product-card cursor-pointer p-4 border rounded-xl bg-white shadow hover:border-green-500 hover:shadow-md transition" data-id="2">
                        <h3 class="font-semibold text-gray-700">Pelajar</h3>
                        <p class="text-sm text-gray-500">Konseling khusus untuk pelajar</p>
                    </div>
                </div>
            </div>

            <!-- Generate Tanggal 26 s/d 25 bulan depan -->
            <div class="mt-16 h-[70vh] overflow-y-auto space-y-4 pr-2">
                <label class="block text-sm font-medium mb-2">Jadwal Konseling</label>
                @foreach($dates as $date)
                    <div class="p-3 border rounded-lg bg-gray-50">
                        <h3 class="font-semibold text-gray-700">
                            {{ $date->translatedFormat('l') }}, {{ $date->format('d M Y') }}
                        </h3>
                        <div class="slots space-y-2" data-date="{{ $date->toDateString() }}">
                            <!-- Slot default -->
                            <div class="flex gap-2">
                                <input type="time" name="slots[{{ $date->toDateString() }}][]" class="border p-2 rounded w-1/3">
                                <input type="time" name="slots[{{ $date->toDateString() }}][]" class="border p-2 rounded w-1/3">
                                <button type="button" class="add-slot px-3 py-1 bg-green-500 text-white rounded">+ Tambah</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg">
                Simpan Jadwal
            </button>
            </form>
        </div>
    </div>


{{-- Pilihan Conselor --}}
<script>
  document.querySelectorAll(".counselor-card").forEach(card => {
    card.addEventListener("click", function() {
      // reset semua card
      document.querySelectorAll(".counselor-card").forEach(c => {
        c.classList.remove("ring-2", "ring-blue-500", "bg-blue-50");
      });

      // tandai yang dipilih
      this.classList.add("ring-2", "ring-blue-500", "bg-blue-50");

      // set value ke hidden input
      document.getElementById("counselor_id").value = this.dataset.id;
    });
  });
</script>

{{-- Pilihan Product --}}
<script>
  document.querySelectorAll(".product-card").forEach(card => {
    card.addEventListener("click", function() {
      // reset semua card
      document.querySelectorAll(".product-card").forEach(c => {
        c.classList.remove("ring-2", "ring-green-500", "bg-green-50");
      });

      // tandai yang dipilih
      this.classList.add("ring-2", "ring-green-500", "bg-green-50");

      // set value ke hidden input
      document.getElementById("product_id").value = this.dataset.id;
    });
  });
</script>


{{-- Tambah Jam pada tanggal dan hapus --}}
<script>
  document.addEventListener("click", function(e) {
    if (e.target.classList.contains("add-slot")) {
      let container = e.target.closest(".slots");
      let date = container.getAttribute("data-date");
      let div = document.createElement("div");
      div.classList.add("flex","gap-2","mt-2");
      div.innerHTML = `
        <input type="time" name="slots[${date}][]" class="border p-2 rounded w-1/3">
        <input type="time" name="slots[${date}][]" class="border p-2 rounded w-1/3">
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
