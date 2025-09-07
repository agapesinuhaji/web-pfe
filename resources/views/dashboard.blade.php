<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tabel Kiri -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-bold mb-4">Jadwal Konseling Aktif Hari Ini</h3>
                            <div class="">
                                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-4 py-4">#</th>
                                                    <th scope="col" class="px-4 py-3">Conselor</th>
                                                    <th scope="col" class="px-4 py-3">Client</th>
                                                    <th scope="col" class="px-4 py-3">Status</th>
                                                    <th scope="col" class="px-4 py-3">
                                                        <span class="sr-only">Actions</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($todays as $today)
                                                <?php $no = $loop->iteration ?>
                                                <tr class="border-b dark:border-gray-700">
                                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                        #{{ strtoupper(substr($today->order_uuid, 0, 8)) }}
                                                        <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($today->schedule->date . ' ' . $today->schedule->time)->format('d-m-Y H:i') }}</div>
                                                    </th>
                                                    <td class="px-4 py-3">{{ $today->conselor->profile->name }}</td>
                                                    <td class="px-4 py-3">{{ $today->user->profile->name }}</td>
                                                    <td class="px-4 py-3">
                                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                            Progress
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 flex items-center justify-end">
                                                        <button id="{{ $no }}-dropdown-button" data-dropdown-toggle="{{ $no }}-dropdown" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20">
                                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg>
                                                        </button>
                                                        <div id="{{ $no }}-dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                            <ul class="py-1 text-sm" aria-labelledby="{{ $no }}-dropdown-button">
                                                                <li>
                                                                    <button type="button" data-modal-target="readToday{{ $no }}Modal" data-modal-toggle="readToday{{ $no }}Modal" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                                        <svg class="w-4 h-4 mr-2" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" />
                                                                        </svg>
                                                                        Preview
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <div id="readToday{{ $no }}Modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                        <div class="relative p-4 w-full max-w-xl max-h-full">
                                                            <!-- Modal content -->
                                                            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                                <!-- Modal header -->
                                                                <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                                                                    <div class="text-lg text-gray-900 md:text-xl dark:text-white">
                                                                        <h3 class="font-semibold">#{{ strtoupper(substr($today->order_uuid, 0, 8)) }}</h3>
                                                                        <p class="text-base font-bold">{{ \Carbon\Carbon::parse($today->schedule->date . ' ' . $today->schedule->time)->format('d F Y H:i') }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="readToday{{ $no }}Modal">
                                                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                                            </svg>
                                                                            <span class="sr-only">Close modal</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <dl>
                                                                    <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Konselor</dt>
                                                                    <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                                                                        {{ $today->conselor->profile->name }}
                                                                        <div class="text-sm mt-1">
                                                                            <a target="_blank" href="https://wa.me/{{ $today->conselor->profile->no_whatsapp }}" class="text-blue-600 hover:underline">
                                                                                {{ $today->conselor->profile->no_whatsapp }}
                                                                            </a>
                                                                        </div>
                                                                    </dd>
                                                                    <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Klien</dt>
                                                                    <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                                                                        {{ $today->user->profile->name }}
                                                                        <div class="text-sm mt-1">
                                                                            <a target="_blank" href="https://wa.me/{{ $today->user->profile->no_whatsapp }}" class="text-blue-600 hover:underline">
                                                                                {{ $today->user->profile->no_whatsapp }}
                                                                            </a>
                                                                        </div>
                                                                    </dd>
                                                                    <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Metode Konseling {{ $today->method->name }}</dt>
                                                                    <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                                                                        <a target="_blank" href="{{ $today->link }}">{{ $today->link }}</a>
                                                                    </dd>
                                                                </dl>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </tr>
                                                @empty
                                                    
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                    </div>
                </div>

                <!-- Tabel Kanan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-bold mb-4">Menunggu Konfirmasi Selesai</h3>
                        <div class="">
                                <!-- Start coding here -->
                                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-4 py-4">#</th>
                                                    <th scope="col" class="px-4 py-3">Conselor</th>
                                                    <th scope="col" class="px-4 py-3">Client</th>
                                                    <th scope="col" class="px-4 py-3">Status</th>
                                                    <th scope="col" class="px-4 py-3">
                                                        <span class="sr-only">Actions</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($waitings as $waiting)
                                                <?php $no = $loop->iteration ?>
                                                <tr class="border-b dark:border-gray-700">
                                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                        #{{ strtoupper(substr($waiting->order_uuid, 0, 8)) }}
                                                        <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($waiting->schedule->date . ' ' . $waiting->schedule->time)->format('d-m-Y H:i') }}</div>
                                                    </th>
                                                    <td class="px-4 py-3">{{ $waiting->conselor->profile->name }}</td>
                                                    <td class="px-4 py-3">{{ $waiting->user->profile->name }}</td>
                                                    <td class="px-4 py-3">
                                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                            Progress
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 flex items-center justify-end">
                                                        <button id="waiting-{{ $no }}-dropdown-button" data-dropdown-toggle="waiting-{{ $no }}-dropdown" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20">
                                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg>
                                                        </button>
                                                        <div id="waiting-{{ $no }}-dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                            <ul class="py-1 text-sm" aria-labelledby="waiting-{{ $no }}-dropdown-button">
                                                                <li>
                                                                    <a href="{{ route('order.show', $waiting->order_uuid) }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                                        <svg class="w-4 h-4 mr-2" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" />
                                                                        </svg>
                                                                        Preview
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                    
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold mb-4">Orderan Belum Validasi Pembayaran</h3>
                    <div class="">
                        <!-- Start coding here -->
                        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-4 py-4">#</th>
                                            <th scope="col" class="px-4 py-3">Client</th>
                                            <th scope="col" class="px-4 py-3">Total</th>
                                            <th scope="col" class="px-4 py-3">Status</th>
                                            <th scope="col" class="px-4 py-3"></th>
                                            <th scope="col" class="px-4 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($payeds as $payed)
                                        <?php $no = $loop->iteration ?>
                                        <tr class="border-b dark:border-gray-700">
                                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                #{{ strtoupper(substr($payed->order_uuid, 0, 8)) }}
                                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($payed->schedule->date . ' ' . $payed->schedule->time)->format('d f Y H:i') }}</div>
                                            </th>
                                            <td class="px-4 py-3">{{ $payed->user->profile->name }}</td>
                                            <td class="px-4 py-3">Rp {{ number_format($payed->total, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                    Waiting for Payment Confirmation
                                                </span>
                                            </td>
                                            <td class="px-4 py-3"><img src="{{ asset($payed->image) }}" alt="Bukti Bayar" class="h-20 object-cover rounded"></td>
                                            <td class="px-4 py-3 flex items-center justify-end">
                                                <button id="payed{{ $no }}-dropdown-button" data-dropdown-toggle="payed{{ $no }}-dropdown" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                                <div id="payed{{ $no }}-dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                    <ul class="py-1 text-sm" aria-labelledby="payed{{ $no }}-dropdown-button">
                                                        <li>
                                                            <button type="button" data-modal-target="readPayed{{ $no }}Modal" data-modal-toggle="readPayed{{ $no }}Modal" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                                <svg class="w-4 h-4 mr-2" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" />
                                                                </svg>
                                                                Preview
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>

                                            <!-- Read modal -->
                                            <div id="readPayed{{ $no }}Modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative p-4 w-full max-w-xl max-h-full">
                                                    <!-- Modal content -->
                                                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                        <!-- Modal header -->
                                                        <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                                                            <div class="text-lg text-gray-900 md:text-xl dark:text-white">
                                                                <h3 class="font-semibold ">{{ $payed->user->profile->name }}</h3>
                                                                <p class="font-bold">Rp {{ number_format($payed->total, 0, ',', '.') }}</p>
                                                            </div>
                                                            <div>
                                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="readPayed{{ $no }}Modal">
                                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    <span class="sr-only">Close modal</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <form action="{{ route('order.update', $payed->order_uuid) }}" method="POST" class="p-4 space-y-4">
                                                            @csrf
                                                            @method('PUT')
                                                                <input type="hidden" name="status" value="approved">
                                                                <img src="{{ asset($payed->image) }}" class="mx-auto object-cover rounded-lg h-150 md:h-200 " alt="">

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
                                        </tr>
                                            
                                        @empty
                                            
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
