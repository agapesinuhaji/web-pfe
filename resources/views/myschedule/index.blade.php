<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Schedule - Psychology For Everyone</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="min-h-screen flex flex-col">

  <main class="flex-grow">

    <div class="bg-white-50">
        @include('layouts.nav')
    </div>

    <div class="py-12 mt-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Jadwal Konselor</h2>

    @forelse($schedules as $date => $items)
        <div class="mb-8 ">
                <!-- Header tanggal -->
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                    {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                </h3>

                <!-- List jam pada tanggal tsb -->
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($items as $schedule)
                        <div class="flex justify-between items-center p-4 border rounded-lg shadow-sm bg-white dark:bg-gray-800">
                            <!-- Jam -->
                            <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}
                            </p>

                            <!-- Status / Produk -->
                            <span class="inline-block text-xs font-medium px-2 py-1 rounded
                                {{ $schedule->product->name == "Konseling Umum" ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                {{ $schedule->is_booked ? 'Terisi' : $schedule->product->name }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada jadwal tersedia.</p>
        @endforelse
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


</body>
</html>
