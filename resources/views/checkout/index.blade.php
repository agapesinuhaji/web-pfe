<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>
<body>

    <div class="bg-white-50">
  <header class="absolute inset-x-0 top-0 z-50 ">
    <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8 ">
      <div class="flex lg:flex-1 ">
        <a href="#" class="-m-1.5 p-1.5 ">
          <span class="sr-only text-white">Your Company</span>
          <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="" class="h-8 w-auto" />
        </a>
      </div>
      <div class="flex lg:hidden">
        <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
          <span class="sr-only">Open main menu</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <div class="hidden lg:flex lg:gap-x-12">
        <a href="#" class="text-sm/6 font-semibold text-gray-700">Product</a>
        <a href="#" class="text-sm/6 font-semibold text-gray-700">Features</a>
        <a href="#" class="text-sm/6 font-semibold text-gray-700">Marketplace</a>
        <a href="#" class="text-sm/6 font-semibold text-gray-700">Company</a>
        <a href="#" class="text-sm/6 font-semibold text-gray-700">Marketplace</a>
        <a href="#" class="text-sm/6 font-semibold text-gray-700">Company</a>
      </div>
      <div class="hidden lg:flex lg:flex-1 lg:justify-end">
        <a href="/login" class="text-sm/6 font-semibold text-gray-700">Log in <span aria-hidden="true">&rarr;</span></a>
      </div>
    </nav>
    <el-dialog>
      <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
        <div tabindex="0" class="fixed inset-0 focus:outline-none">
          <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
              <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="" class="h-8 w-auto" />
              </a>
              <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                <span class="sr-only">Close menu</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                  <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
            <div class="mt-6 flow-root">
              <div class="-my-6 divide-y divide-gray-500/10">
                <div class="space-y-2 py-6">
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Product</a>
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Features</a>
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Marketplace</a>
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Company</a>
                </div>
                <div class="py-6">
                  <a href="/login" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Log in</a>
                </div>
              </div>
            </div>
          </el-dialog-panel>
        </div>
      </dialog>
    </el-dialog>
  </header>
</div>

<section class="bg-white py-16 antialiased dark:bg-gray-900 md:py-40">
  <form action="{{ route('checkout.store') }}" method="POST" class="mx-auto max-w-screen-xl px-4 2xl:px-0">
    @csrf
    <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12 xl:gap-16">
      <div class="min-w-0 flex-1 space-y-8">
        @guest
        <div class="space-y-4 border-b pb-8 border-gray-300">
          <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Login</h2>
          <p>Silahkan Login terlebih dahulu!</p>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <a href="/login" class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 hover:text-gray-50 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3" />
                </svg>
                Log In
              </a>
            </div>
          </div>
        </div>
        @endguest



        @auth
        <div class="space-y-4">
          <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Pesanan</h2>

          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Nama Lengkap </label>
              <input type="text" id="name" name="name" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" value="{{ old('name', auth()->user()->profile?->name) ?? '' }}" required />
            </div>

            <div>
              <label for="nickname" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Nama Panggilan </label>
              <input type="text" id="nickname" name="nickname" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" value="{{ old('nickname', auth()->user()->profile?->nickname) ?? '' }}" required />
            </div>

            <div>
              <label for="date_of_place" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Tempat Latihr </label>
              <input type="text" id="date_of_place" name="date_of_place" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" value="{{ old('date_of_place', auth()->user()->profile?->date_of_place) ?? '' }}" required />
            </div>

            <div>
              <label for="date_of_birth" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Tanggal Lahir </label>
              <input type="date" id="date_of_birth" name="date_of_birth" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" value="{{ old('date_of_birth', auth()->user()->profile?->date_of_birth) ?? '1960-01-01' }}"  required />
            </div>

            <div>
              <div class="mb-2 flex items-center gap-2">
                <label for="select-country-input-3" class="block text-sm font-medium text-gray-900 dark:text-white"> Jenis Kelamin </label>
              </div>
              <select id="select-country-input-3" name="gender" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                <option selected>--- Jenis Kelamin ---</option>
                <option value="L" {{ auth()->user()->profile?->gender === 'L' ? 'selected' : '' }}>Laki - Laki</option>
                <option value="P" {{ auth()->user()->profile?->gender === 'P' ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>


            <div>
              <label for="phone-input-3" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                Nomor WhatsApp
              </label>
              <div class="flex items-center">
                <!-- Tombol Negara (Indonesia Saja) -->
                <button class="z-10 inline-flex shrink-0 items-center rounded-s-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-center text-sm font-medium text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white" type="button" disabled>
                  <svg fill="none" aria-hidden="true" class="me-2 h-4 w-4" viewBox="0 0 20 15">
                    <!-- Bagian merah -->
                    <rect width="20" height="7.5" fill="#FF0000" />
                    <!-- Bagian putih -->
                    <rect y="7.5" width="20" height="7.5" fill="#FFFFFF" />
                  </svg>
                  +62
                </button>

                <!-- Input Nomor -->
                <div class="relative w-full">
                  <input type="text" id="no_whatsapp" name="no_whatsapp" class="z-20 block w-full rounded-e-lg border border-s-0 border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500" value="{{ old('no_whatsapp', auth()->user()->profile?->no_whatsapp) ?? '' }}" required />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="space-y-6">
          <h3 class="text-2xl font-bold text-gray-900 dark:text-white border-b-2 border-primary-500 pb-2">
            Paket Konseling
          </h3>

          <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
    @foreach ($products as $index => $product)
        <label class="relative rounded-xl border border-gray-200 bg-white p-6 shadow-sm cursor-pointer hover:shadow-lg transition dark:border-gray-700 dark:bg-gray-800 group">
            
            <input type="radio" 
                   name="paket" 
                   value="{{ $product->id }}" 
                   class="absolute opacity-0 peer"
                   {{ $index === 0 ? 'checked' : '' }} />
            
            <div class="flex flex-col items-start">
                <span class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $product->name }}
                </span>
                <span class="mt-3 text-2xl font-bold text-primary-600">
                    {{ 'Rp ' . number_format($product->price, 0, ',', '.') }}
                </span>
            </div>
            
            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-primary-500"></div>
        </label>
    @endforeach
</div>
        </div>

        <div class="pt-4">
                <label for="conseling_method" class="block mb-2 font-semibold">Konseling Via</label>
                <Select id="method" name="method" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                    @foreach ($methods as $method)
                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                    @endforeach
                </Select>
            </div>


        
        <div x-data="checkoutApp()" x-init="init()" class="mx-auto bg-white rounded space-y-4">
            <!-- Pilih Konselor -->
            <div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Pilih Konselor</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                    @foreach ($conselors as $c)
                    <label 
                        class="relative cursor-pointer rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-500 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800"
                    >
                        <input 
                            type="radio" 
                            name="konselor" 
                            :value="{{ $c->id }}" 
                            @change="selectConselor({{ $c->id }})"
                            class="absolute opacity-0 peer"
                        >
                        <div class="flex flex-col items-center text-center p-2 rounded-lg">
                            <img 
                                src="https://randomuser.me/api/portraits/women/44.jpg" 
                                alt="{{ $c->profile->name }}" 
                                class="w-16 h-16 rounded-full mb-2"
                            >
                            <h4 class="font-medium text-gray-900 dark:text-white">
                                {{ $c->profile->name }}
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Psikolog Klinis
                            </p>
                        </div>
                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-500"></div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Pilih Tanggal -->
            <div x-show="selectedConselor" x-transition>
                <label class="block mb-2 font-semibold">Pilih Tanggal</label>
                <input 
                    type="text" 
                    id="datePicker" 
                    name="date"
                    placeholder="Pilih tanggal" 
                    class="w-full border rounded p-2"
                >
            </div>

            <!-- Pilih Jam -->
            <div x-show="times.length > 0" x-transition>
              <label class="block mb-2 font-semibold">Pilih Jam</label>
              <div class="flex flex-wrap gap-2">
                  <template x-for="(time, index) in times" :key="index">
                      <label class="cursor-pointer pt-2">
                          <input 
                              type="radio" 
                              name="selectedTime"
                              class="hidden peer" 
                              :value="time" 
                              @change="selectedTime = time"
                          >
                          <span class="px-4 py-2 rounded border border-gray-300 
                              peer-checked:bg-blue-600 peer-checked:text-white 
                              peer-checked:border-blue-600
                              hover:bg-blue-700 hover:text-gray-50 transition">
                              <span x-text="time"></span>
                          </span>
                      </label>
                  </template>
              </div>
          </div>


            <div class="pt-8">
              <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                Lanjut Ke Pembayaran  
              </button>
            </div>

            
            
        </div>

        @endauth
      </div>
    </div>
  </form>
</section>




<script>
function checkoutApp() {
    return {
        selectedConselor: '',
        selectedDate: '',
        selectedTime: '',
        times: [],
        flatpickrInstance: null,

        init() {
            this.flatpickrInstance = flatpickr("#datePicker", {
                dateFormat: "Y-m-d",
                disable: [], // nanti diisi dari DB
                onChange: (selectedDates, dateStr) => {
                    this.selectedDate = dateStr;
                    this.fetchSchedules();
                }
            });
        },

        async selectConselor(id) {
            this.selectedConselor = id;
            this.resetSelection();

            // Ambil tanggal ready untuk konselor ini
            try {
                let res = await fetch(`/available-dates/${id}`);
                let availableDates = await res.json();

                // Enable hanya tanggal yang tersedia
                this.flatpickrInstance.set("enable", availableDates);
            } catch (error) {
                console.error('Gagal ambil tanggal ready', error);
            }
        },

        resetSelection() {
            this.selectedDate = '';
            this.selectedTime = '';
            this.times = [];
            this.flatpickrInstance.clear();
        },

        async fetchSchedules() {
            if (!this.selectedConselor || !this.selectedDate) return;

            try {
                let url = `/schedules/${this.selectedConselor}/${this.selectedDate}`;
                let res = await fetch(url);
                this.times = await res.json();
                this.selectedTime = '';
            } catch (error) {
                console.error('Gagal mengambil jam', error);
            }
        }
    }
}
</script>

<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>
</html>
