<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All My Tasks - Psychology For Everyone</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>
<body class="min-h-screen flex flex-col">

  <main class="flex-grow">

    <div class="bg-white-50">
        @include('layouts.nav')
    </div>

    <section class="bg-white py-16 my-8 antialiased dark:bg-gray-900 md:py-16 md:my-8">
        <div class="mx-auto max-w-screen-lg px-4 2xl:px-0">
            <nav class="mb-4 flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/my-task') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                            Tasks Today
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="mx-1 h-4 w-4 flex items-center justify-center text-gray-400">|</span>
                            <a href="{{ route('mytask.all') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white md:ms-2">All Tasks</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold pt-4 text-gray-900 dark:text-white sm:text-2xl md:mb-6">All My Tasks</h2>
                
                {{-- Dropdown Periode --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        Filter Periode
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-56 rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800 z-10">
                        <ul class="p-2" x-data="{ selected: '{{ request('periode') ?? 'all' }}' }">
                            {{-- All --}}
                            <li class="flex items-center gap-2 p-1 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer"
                                @click="window.location.href='{{ route('mytask.all') }}'">
                                <input type="radio" id="all" name="periode" 
                                    class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                    value="all"
                                    x-model="selected"
                                    :checked="selected === 'all'">
                                <label for="all" class="text-gray-700 dark:text-gray-200 text-sm">All</label>
                            </li>

                            {{-- Periode lainnya --}}
                            @foreach($periodes as $periode)
                                <li class="flex items-center gap-2 p-1 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer"
                                    @click="window.location.href='{{ route('mytask.all', ['periode' => $periode->id]) }}'">
                                    <input type="radio" id="periode-{{ $periode->id }}" name="periode"
                                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                        value="{{ $periode->id }}"
                                        x-model="selected"
                                        :checked="selected == '{{ $periode->id }}'">
                                    <label for="periode-{{ $periode->id }}" class="text-gray-700 dark:text-gray-200 text-sm">
                                        {{ $periode->name }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-2 gap-6 border-b border-t border-gray-200 py-4 dark:border-gray-700 md:py-8 lg:grid-cols-3 xl:gap-16">
                <div>
                    <svg class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="5" width="18" height="16" rx="2" ry="2"/>
                        <line x1="3" y1="9" x2="21" y2="9"/>
                        <line x1="7" y1="13" x2="17" y2="13"/>
                        <line x1="7" y1="16" x2="17" y2="16"/>
                        <line x1="7" y1="19" x2="17" y2="19"/>
                    </svg>

                    <h3 class="mb-2 text-gray-500 dark:text-gray-400">Pendapatan</h3>
                    <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
                        Rp 999.999.999 .-
                    </span>
                </div>
                <div>
                    <svg class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 2h6a2 2 0 0 1 2 2v2H7V4a2 2 0 0 1 2-2z"/>
                        <rect x="5" y="6" width="14" height="16" rx="2" ry="2"/>
                        <path d="M9 14h6"/>
                        <path d="M9 18h6"/>
                    </svg>

                    <h3 class="mb-2 text-gray-500 dark:text-gray-400">Tasks Active</h3>
                    <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $activeTasks }}
                    </span>
                </div>
                <div>
                    <svg class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M9 12l2 2 4-4"/>
                    </svg>

                    <h3 class="mb-2 text-gray-500 dark:text-gray-400">Tasks Done</h3>
                    <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $doneTasks }}
                    </span>
                </div>
            </div>
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800 md:p-8">
                <div class="mb-6">
                    <form method="GET" action="{{ route('mytask.all') }}" class="mb-6 flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search tasks..."
                            class="w-full md:w-1/3 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            Search
                        </button>
                    </form>

                </div>
                @forelse ($orders as $order)
                    <div class="flex flex-wrap items-center gap-y-4 border-b border-gray-200 pb-4 dark:border-gray-700 md:pb-5">
                        <!-- Order ID + Date & Time -->
                        <dl class="w-full sm:w-1/4 md:w-1/5">
                            <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Order ID:</dt>
                            <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                                <a href="{{ route('myorder.show', $order->order_uuid) }}" class="hover:underline">#{{ strtoupper(substr($order->order_uuid, 0, 8)) }}</a>
                            </dd>
                            <dd class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($order->schedule->date)->format('d-m-Y') }}, {{ \Carbon\Carbon::parse($order->schedule->time)->format('H:i') }}
                            </dd>
                        </dl>

                        <!-- Nama (flex-grow agar lebih luas) -->
                        <dl class="flex-1 min-w-[150px]">
                            <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Nama:</dt>
                            <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white truncate">
                                {{ $order->user->profile->name }}
                            </dd>
                        </dl>

                        <!-- Price -->
                        <dl class="w-32 sm:w-24 md:w-28 lg:w-auto mr-6">
                            <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Price:</dt>
                            <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">Rp {{ number_format($order->price) }}</dd>
                        </dl>

                        <!-- Status -->
                        <dl class="w-32 sm:w-28 md:w-32 lg:w-auto mr-6">
                            <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Status:</dt>
                            @switch($order->status)
                                @case('approved')
                                    <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        Ready
                                    </dd>
                                    @break

                                @case('progress')
                                    <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 ">
                                        Conselor Finish
                                    </dd>
                                    @break

                                @default
                                    <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Done
                                    </dd>
                            @endswitch
                        </dl>

                        <!-- Actions -->
                        <div class="w-full grid sm:grid-cols-2 lg:flex lg:w-64 lg:items-center lg:justify-end gap-4">
                            <a href="{{ route('mytask.show', $order->order_uuid) }}" class="w-full inline-flex justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 lg:w-auto">View details</a>
                        </div>
                    </div>

                <div class="my-4 mx-4">
                    {{ $orders->links() }}
                </div>

                @empty
                @endforelse

            </div>
        </div>
    </section>

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


<script src="//unpkg.com/alpinejs" defer></script>

</body>
</html>
