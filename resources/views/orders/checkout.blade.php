<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
  <form action="#" class="mx-auto max-w-screen-xl px-4 2xl:px-0">

    <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12 xl:gap-16">
      <div class="min-w-0 flex-1 space-y-8">
        <div class="space-y-4 border-b pb-8 border-gray-300">
          <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Login</h2>
          <p>Silahkan Login terlebih dahulu!</p>

          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div class="sm:col-span-2">
              <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 hover:text-gray-50 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
                      width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3" />
                </svg>

                Log In
              </button>
            </div>
          </div>
        </div>
        <div class="space-y-4">
          <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Pesanan</h2>

          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Nama Lengkap </label>
              <input type="text" id="name" name="name" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Bonnie Green" required />
            </div>

            <div>
              <label for="nickname" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Nama Panggilan </label>
              <input type="text" id="nickname" name="nickname" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="aji" required />
            </div>

            <div>
              <label for="date-of-place" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Tempat Latihr </label>
              <input type="text" id="date-of-place" name="date-of-place" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Jakarta" required />
            </div>

            <div>
              <label for="date-of-birth" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Tanggal Lahir </label>
              <input type="date" id="date-of-birth" name="date-of-birth" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"  required />
            </div>

            <div>
              <div class="mb-2 flex items-center gap-2">
                <label for="select-country-input-3" class="block text-sm font-medium text-gray-900 dark:text-white"> Jenis Kelamin </label>
              </div>
              <select id="select-country-input-3" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                <option selected>--- Jenis Kelamin ---</option>
                <option value="L">Laki - Laki</option>
                <option value="P">Perempuan</option>
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
                  <input type="text" id="phone-input" class="z-20 block w-full rounded-e-lg border border-s-0 border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500" placeholder="81234567890" required />
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
            <!-- Paket 1 -->
            <label class="relative rounded-xl border border-gray-200 bg-white p-6 shadow-sm cursor-pointer hover:shadow-lg transition dark:border-gray-700 dark:bg-gray-800 group">
              <input type="radio" name="paket" class="absolute opacity-0 peer" checked />
              <div class="flex flex-col items-start">
                <span class="text-lg font-semibold text-gray-900 dark:text-white">Konseling 1x Sesi</span>
                <span class="mt-1 text-sm text-gray-500 dark:text-gray-400">Durasi 60 menit</span>
                <span class="mt-3 text-2xl font-bold text-primary-600">Rp150.000</span>
              </div>
              <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-primary-500"></div>
            </label>

            <!-- Paket 2 -->
            <label class="relative rounded-xl border border-gray-200 bg-white p-6 shadow-sm cursor-pointer hover:shadow-lg transition dark:border-gray-700 dark:bg-gray-800 group">
              <input type="radio" name="paket" class="absolute opacity-0 peer" />
              <div class="flex flex-col items-start">
                <span class="text-lg font-semibold text-gray-900 dark:text-white">Konseling 4x Sesi</span>
                <span class="mt-1 text-sm text-gray-500 dark:text-gray-400">Hemat 10%</span>
                <span class="mt-3 text-2xl font-bold text-primary-600">Rp540.000</span>
              </div>
              <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-primary-500"></div>
            </label>

            <!-- Paket 3 -->
            <label class="relative rounded-xl border border-gray-200 bg-white p-6 shadow-sm cursor-pointer hover:shadow-lg transition dark:border-gray-700 dark:bg-gray-800 group">
              <input type="radio" name="paket" class="absolute opacity-0 peer" />
              <div class="flex flex-col items-start">
                <span class="text-lg font-semibold text-gray-900 dark:text-white">Konseling 8x Sesi</span>
                <span class="mt-1 text-sm text-gray-500 dark:text-gray-400">Hemat 20%</span>
                <span class="mt-3 text-2xl font-bold text-primary-600">Rp960.000</span>
              </div>
              <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-primary-500"></div>
            </label>
          </div>
        </div>

        <div class="space-y-4">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Pilih Konselor</h3>

          <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            <!-- Konselor 1 -->
            <label class="block cursor-pointer rounded-lg border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-500 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 transition">
              <input type="radio" name="konselor" value="psikolog1" class="hidden peer" checked>
              <div class="flex flex-col items-center text-center peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-500 p-2 rounded-lg">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Psikolog A" class="w-16 h-16 rounded-full mb-2">
                <h4 class="font-medium text-gray-900 dark:text-white">Dr. Andini</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Psikolog Klinis</p>
              </div>
            </label>

            <!-- Konselor 2 -->
            <label class="block cursor-pointer rounded-lg border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-500 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 transition peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-500">
              <input type="radio" name="konselor" value="psikolog2" class="hidden peer">
              <div class="flex flex-col items-center text-center peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-500 p-2 rounded-lg">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Psikolog B" class="w-16 h-16 rounded-full mb-2">
                <h4 class="font-medium text-gray-900 dark:text-white">Dr. Bima</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Psikolog Pendidikan</p>
              </div>
            </label>

            <!-- Konselor 3 -->
            <label class="block cursor-pointer rounded-lg border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-500 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 transition">
              <input type="radio" name="konselor" value="psikolog3" class="hidden peer">
              <div class="flex flex-col items-center text-center peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-500 p-2 rounded-lg">
                <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Psikolog C" class="w-16 h-16 rounded-full mb-2">
                <h4 class="font-medium text-gray-900 dark:text-white">Dr. Clara</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Psikolog Anak</p>
              </div>
            </label>

            <!-- Konselor 4 -->
            <label class="block cursor-pointer rounded-lg border border-gray-200 bg-white p-4 shadow-sm hover:border-blue-500 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 transition">
              <input type="radio" name="konselor" value="psikolog4" class="hidden peer">
              <div class="flex flex-col items-center text-center peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-500 p-2 rounded-lg">
                <img src="https://randomuser.me/api/portraits/men/55.jpg" alt="Psikolog D" class="w-16 h-16 rounded-full mb-2">
                <h4 class="font-medium text-gray-900 dark:text-white">Dr. Dimas</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Psikolog Industri</p>
              </div>
            </label>
          </div>
        </div>

        <div class="space-y-4">
  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Pilih Tanggal & Jam Konseling</h3>

  <form class="space-y-6">
    <!-- Pilih Tanggal -->
    <div>
      <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Konseling</label>
      <input type="date" id="tanggal" name="tanggal" class="w-full rounded-lg border border-gray-300 p-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Pilih Jam -->
    <div>
      <label for="jam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Konseling</label>
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <label class="block cursor-pointer rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm hover:border-blue-500 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 transition">
          <input type="radio" name="jam" value="09:00" class="hidden peer">
          <span class="peer-checked:text-white peer-checked:bg-blue-500 block rounded-md p-1">09:00</span>
        </label>
        <label class="block cursor-pointer rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm hover:border-blue-500 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 transition">
          <input type="radio" name="jam" value="10:30" class="hidden peer">
          <span class="peer-checked:text-white peer-checked:bg-blue-500 block rounded-md p-1">10:30</span>
        </label>
        <label class="block cursor-pointer rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm hover:border-blue-500 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 transition">
          <input type="radio" name="jam" value="13:00" class="hidden peer">
          <span class="peer-checked:text-white peer-checked:bg-blue-500 block rounded-md p-1">13:00</span>
        </label>
        <label class="block cursor-pointer rounded-lg border border-gray-200 bg-white p-3 text-center shadow-sm hover:border-blue-500 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 transition">
          <input type="radio" name="jam" value="15:30" class="hidden peer">
          <span class="peer-checked:text-white peer-checked:bg-blue-500 block rounded-md p-1">15:30</span>
        </label>
      </div>
    </div>

    <!-- Tombol Submit -->
    <div>
      <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
        Lanjut Ke Pembayaran  
      </button>
    </div>
  </form>
</div>

  


        {{-- <div>
          <label for="voucher" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Enter a gift card, voucher or promotional code </label>
          <div class="flex max-w-md items-center gap-4">
            <input type="text" id="voucher" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="" required />
            <button type="button" class="flex items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Apply</button>
          </div>
        </div> --}}
      </div>




      







      {{-- <div class="mt-6 w-full space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md">
        <div class="flow-root">
          <div class="-my-3 divide-y divide-gray-200 dark:divide-gray-800">
            <dl class="flex items-center justify-between gap-4 py-3">
              <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Subtotal</dt>
              <dd class="text-base font-medium text-gray-900 dark:text-white">$8,094.00</dd>
            </dl>

            <dl class="flex items-center justify-between gap-4 py-3">
              <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Savings</dt>
              <dd class="text-base font-medium text-green-500">0</dd>
            </dl>

            <dl class="flex items-center justify-between gap-4 py-3">
              <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Store Pickup</dt>
              <dd class="text-base font-medium text-gray-900 dark:text-white">$99</dd>
            </dl>

            <dl class="flex items-center justify-between gap-4 py-3">
              <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Tax</dt>
              <dd class="text-base font-medium text-gray-900 dark:text-white">$199</dd>
            </dl>

            <dl class="flex items-center justify-between gap-4 py-3">
              <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
              <dd class="text-base font-bold text-gray-900 dark:text-white">$8,392.00</dd>
            </dl>
          </div>
        </div>

        <div class="space-y-3">
          <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Proceed to Payment</button>

          <p class="text-sm font-normal text-gray-500 dark:text-gray-400">One or more items in your cart require an account. <a href="#" title="" class="font-medium text-primary-700 underline hover:no-underline dark:text-primary-500">Sign in or create an account now.</a>.</p>
        </div>
      </div> --}}
    </div>
  </form>
</section>
    

<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>