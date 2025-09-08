<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Overtime') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">

                <div 
                    x-data="{ show: true }" 
                    x-show="show" 
                    x-transition 
                    x-init="setTimeout(() => show = false, 7000)" 
                    class="mb-4"
                >
                    @if(session('success'))
                        <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                            <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V7h2v2h-2zm0 2h2v4h-2v-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400 dark:border-yellow-800" role="alert">
                            <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V7h2v2h-2zm0 2h2v4h-2v-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">{{ session('warning') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                            <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zM9 8h2v5H9V8zm0 6h2v2H9v-2z"></path>
                            </svg>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    @endif
                </div>


                <!-- Start block -->
                <section class=" dark:bg-gray-900 p-3 sm:p-5 antialiased">
                    <div class="mx-auto max-w-screen-xl px-4 lg:px-4">
                        <!-- Start coding here -->
                        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                                <div class="w-full md:w-1/2">
                                    <form method="GET" action="{{ route('overtimeData.index') }}" class="flex items-center">
                                        <label for="simple-search" class="sr-only">Search</label>
                                        <div class="relative w-full">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <input type="text" name="search" id="simple-search"
                                                value="{{ request('search') }}"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2
                                                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                placeholder="Cari berdasarkan #Order ID atau Overtime">
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-4 py-4">#</th>
                                            <th scope="col" class="px-4 py-3">Overtime</th>
                                            <th scope="col" class="px-4 py-3">Biaya</th>
                                            <th scope="col" class="px-4 py-3">image</th>
                                            <th scope="col" class="px-4 py-3">Status</th>
                                            <th scope="col" class="px-4 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($overtimeData as $item)
                                            <tr class="border-b dark:border-gray-700">
                                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    <a href="{{ route('order.show', $item->order->order_uuid) }}" class="hover:underline">#{{ strtoupper(substr($item->order->order_uuid, 0, 8)) }}</a>
                                                </th>
                                                <td class="px-4 py-3">{{ $item->overtime->name }}</td>
                                                <td class="px-4 py-3">
                                                    Rp {{ number_format($item->overtime->biaya, 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3"><img src="{{ $item->image}}" alt="Bukti Bayar" class="h-32 object-cover rounded-lg shadow"></td>
                                                <td class="px-4 py-3">
                                                     @if($item->status == 'payed')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Payed Success
                                                        </span>
                                                    @elseif($item->status == 'cancel')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Gagal
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Waiting Payment
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 flex items-center justify-end">
                                                    <button id="{{ $item->id }}-button" data-dropdown-toggle="{{ $item->id }}" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" >
                                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        </svg>
                                                    </button>
                                                    <div id="{{ $item->id }}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                        <ul class="py-1 text-sm" aria-labelledby="{{ $item->id }}-button">
                                                            <li>
                                                                <button type="button" data-modal-target="updateItemModal{{ $item->id }}" data-modal-toggle="updateItemModal{{ $item->id }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                                    <svg class="w-4 h-4 mr-2"  viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" />
                                                                        </svg>
                                                                    Preview
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Update modal -->
                                            <div id="updateItemModal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                                                <div class="relative w-full max-w-2xl p-4">
                                                    <!-- Modal content -->
                                                    <div class="relative bg-white rounded-2xl shadow-lg dark:bg-gray-800 max-h-[90vh] overflow-y-auto">

                                                        <!-- Modal header -->
                                                        <div class="flex justify-between items-center p-4 border-b dark:border-gray-600">
                                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                Detail Overtime
                                                            </h3>
                                                            <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-white" data-modal-toggle="updateItemModal{{ $item->id }}">✕</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="p-6 space-y-4">
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <div>
                                                                    <p class="text-sm text-gray-500">Order ID</p>
                                                                    <p class="font-medium text-gray-900 dark:text-white">#{{ strtoupper(substr($item->order->order_uuid, 0, 8)) }}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm text-gray-500">User</p>
                                                                    <p class="font-medium text-gray-900 dark:text-white">{{ $item->order->user->profile->name }}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm text-gray-500">Konselor</p>
                                                                    <p class="font-medium text-gray-900 dark:text-white">{{ $item->order->conselor->profile->name }}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm text-gray-500">Waktu Konseling</p>
                                                                    <p class="font-medium text-gray-900 dark:text-white">
                                                                        {{ \Carbon\Carbon::parse($item->order->schedule->date)->format('d M Y') }}
                                                                        {{ $item->order->schedule->time }}
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm text-gray-500">Overtime</p>
                                                                    <p class="font-medium text-gray-900 dark:text-white">{{ $item->overtime->name }}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm text-gray-500">Biaya</p>
                                                                    <p class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($item->overtime->biaya ?? 0, 0, ',', '.') }}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm text-gray-500">Terbayarkan</p>
                                                                    <p class="font-medium text-green-600 dark:text-green-400">Rp {{ number_format($item->paid ?? 0, 0, ',', '.') }}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm text-gray-500">Status</p>
                                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                                        {{ $item->status == 'payed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                                        {{ ucfirst($item->status) }}
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <p class="text-sm text-gray-500 mb-2">Bukti Bayar</p>
                                                                @if($item->image)
                                                                    <img src="{{ asset($item->image) }}" 
                                                                        alt="Bukti Bayar" 
                                                                        class="h-200 rounded-lg">
                                                                @else
                                                                    <p class="text-gray-400 italic">Belum ada bukti bayar</p>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="flex justify-end gap-3 p-4 border-t dark:border-gray-600">
                                                            <button type="button"
                                                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg"
                                                                    data-modal-toggle="updateItemModal{{ $item->id }}">
                                                                Tutup
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        @empty
                                            
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="my-4 mx-4">
                                {{ $overtimeData->links() }}
                            </div>
                        </div>
                    </div>
                </section>
                <!-- End block -->
               
            </div>
        </div>
    </div>

  
</x-app-layout>
