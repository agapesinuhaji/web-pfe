<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>My Profile - Psychology For Everyone</title>
  <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">

<div class="bg-white-50">
  @include('layouts.nav')
</div>

  <main class="flex-grow py-8 mt-12">
    <div class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">My Profile</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Profile Section --}}
        <div class="lg:col-span-1">
            <div class="bg-white shadow-md rounded-2xl p-6">
            <div class="flex flex-col items-center text-center">
                <img 
                src="{{ asset($user->profile->image) }}" 
                alt="Profile Photo" 
                class="w-32 h-32 rounded-full border-4 border-gray-200 object-cover mb-4"
                />

                <h2 class="text-xl font-semibold text-gray-900">{{ $user->profile->name }}</h2>
                @if($user->profile->nickname)
                <p class="text-gray-500">“{{ $user->profile->nickname }}”</p>
                @endif

                <p class="mt-2 text-sm text-gray-600">{{ $user->email }}</p>

                <div class="mt-4 w-full text-left text-sm text-gray-700 space-y-2">
                <p><span class="font-medium">Tanggal Lahir:</span> 
                    {{ $user->profile->date_of_birth ? \Carbon\Carbon::parse($user->profile->date_of_birth)->format('d M Y') : '-' }}
                </p>
                <p><span class="font-medium">Jenis Kelamin:</span> 
                    {{ $user->profile->gender == 'L' ? 'Laki-laki' : ($user->profile->gender == 'P' ? 'Perempuan' : '-') }}
                </p>
                <p><span class="font-medium">Domisili:</span> {{ $user->profile->domicile ?? '-' }}</p>
                <p><span class="font-medium">No. WhatsApp:</span> 
                    <a target="_blank" href="https://wa.me/{{ $user->profile->no_whatsapp }}" class="text-green-600 hover:underline">
                    {{ $user->profile->no_whatsapp ?? '-' }}
                    </a>
                </p>
                </div>

                <div class="flex gap-4 mt-6">
                    <a  data-modal-target="updateProfileModal"  data-modal-toggle="updateProfileModal"  class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition cursor-pointer" >
                        Edit Profile
                    </a>

                    <a  data-modal-target="changePasswordModal"  data-modal-toggle="changePasswordModal"  class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition cursor-pointer" >
                        Ganti Password
                    </a>
                </div>

            </div>
            </div>
        </div>

        {{-- Timeline Section --}}
        <div class="lg:col-span-2">

            @if(in_array(Auth::user()->role, ['psikolog', 'administrator']))
                <div class="bg-white shadow-md rounded-2xl p-6 relative">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">Deskripsi</h2>
                        <a class="text-sm px-3 py-1 text-bold text-blue-600 hover:text-blue-800 hover:underline cursor-pointer">
                            Edit Deskripsi
                        </a>
                    </div>

                    <p>
                        {{ $user->profile->description }}
                    </p>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-2xl p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Riwayat Aktivitas</h2>

                <div class="relative border-l border-gray-300 ml-4">
                    {{-- Loop data riwayat --}}
                    <div class="mb-8 ml-6">
                        <div class="absolute w-3 h-3 bg-blue-600 rounded-full -left-1.5"></div>
                        <time class="block mb-1 text-sm text-gray-500">02 Sep 2025</time>
                        <h3 class="font-semibold text-gray-900">Order #12345</h3>
                        <p class="text-gray-600">Konseling dengan Psikolog A</p>
                    </div>

                    <!-- Item -->
                    <div class="mb-8 ml-6">
                        <div class="absolute w-3 h-3 bg-green-600 rounded-full -left-1.5"></div>
                        <time class="block mb-1 text-sm text-gray-500">28 Agu 2025</time>
                        <h3 class="font-semibold text-gray-900">Top Up Saldo</h3>
                        <p class="text-gray-600">Rp 150.000 berhasil ditambahkan</p>
                    </div>
                </div>
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

<!-- Update modal -->
<div id="updateProfileModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update Profile</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateProfileModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->profile->name) }}" class="w-full p-2.5 border rounded-lg bg-gray-50 text-gray-900">
                    </div>

                    <div>
                        <label for="nickname" class="block mb-2 text-sm font-medium text-gray-900">Nickname</label>
                        <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $user->profile->nickname) }}" class="w-full p-2.5 border rounded-lg bg-gray-50 text-gray-900">
                    </div>

                    <div>
                        <label for="domicile" class="block mb-2 text-sm font-medium text-gray-900">Domisili</label>
                        <input type="text" name="domicile" id="domicile" value="{{ old('domicile', $user->profile->domicile) }}" class="w-full p-2.5 border rounded-lg bg-gray-50 text-gray-900">
                    </div>

                    <div>
                        <label for="no_whatsapp" class="block mb-2 text-sm font-medium text-gray-900">No. WhatsApp</label>
                        <input type="text" name="no_whatsapp" id="no_whatsapp" value="{{ old('no_whatsapp', $user->profile->no_whatsapp) }}" class="w-full p-2.5 border rounded-lg bg-gray-50 text-gray-900">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Foto Profil</label>
                        <input type="file" name="image" id="image" class="w-full text-sm text-gray-900 border rounded-lg cursor-pointer bg-gray-50">
                        
                        @if($user->profile->image)
                            <img src="{{ asset($user->profile->image) }}" class="mt-3 w-24 h-24 rounded-full object-cover border">
                        @endif
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Update Profile</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- Ganti password modal -->
<div id="changePasswordModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ganti Password</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="changePasswordModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
           <form action="{{ route('profile.change-password') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-1">
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password Lama</label>
                        <input type="password" name="password" id="password" class="w-full p-2.5 border rounded-lg bg-gray-50 text-gray-900" required>
                    </div>
                    <div>
                        <label for="password_baru" class="block mb-2 text-sm font-medium text-gray-900">Password Baru</label>
                        <input type="password" name="password_baru" id="password_baru" class="w-full p-2.5 border rounded-lg bg-gray-50 text-gray-900" required>
                    </div>
                    <div>
                        <label for="password_baru_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password</label>
                        <input type="password" name="password_baru_confirmation" id="password_baru_confirmation" class="w-full p-2.5 border rounded-lg bg-gray-50 text-gray-900" required>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Ganti Password</button>
                </div>
            </form>

        </div>

    </div>
</div>


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


</body>
</html>