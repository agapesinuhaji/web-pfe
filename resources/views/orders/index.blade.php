<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Start block -->
                    <section class=" dark:bg-gray-900 p-3 sm:p-5 antialiased">
                        <div class=" px-4 lg:px-12">
                            <!-- Start coding here -->
                            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                                    <div class="w-full md:w-1/2">
                                        <form method="GET" action="{{ route('order.index') }}" class="flex items-center">
                                            <label for="order-search" class="sr-only">Search</label>
                                            <div class="relative w-full">
                                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <input type="text" name="search" id="order-search"
                                                    value="{{ request('search') }}"
                                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                                    placeholder="Cari berdasarkan nama user atau psikolog">
                                            </div>
                                        </form>
                                        

                                    </div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-4 py-4">#</th>
                                                <th scope="col" class="px-4 py-3">User Order</th>
                                                <th scope="col" class="px-4 py-3">Jadwal</th>
                                                <th scope="col" class="px-4 py-3">Conselor</th>
                                                <th scope="col" class="px-4 py-3">total</th>
                                                @php
                                                    $direction = request('direction') === 'asc' ? 'desc' : 'asc';
                                                @endphp
                                                <th scope="col" class="px-4 py-3">
                                                    <a href="{{ route('order.index', array_merge(request()->query(), ['sort' => 'bukti-bayar', 'direction' => $direction])) }}"
                                                    class="flex items-center">
                                                        Bukti Bayar
                                                        @if(request('sort') === 'bukti-bayar')
                                                            @if(request('direction') === 'asc')
                                                                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M5 12l5-5 5 5H5z"/>
                                                                </svg>
                                                            @else
                                                                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M5 8l5 5 5-5H5z"/>
                                                                </svg>
                                                            @endif
                                                        @endif
                                                    </a>
                                                </th>
                                                <th scope="col" class="px-4 py-3">Status</th>
                                                <th scope="col" class="px-4 py-3">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($orders as $order)
                                            <?php $no = $loop->iteration ?>
                                                <tr class="border-b dark:border-gray-700">
                                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $no }}
                                                    </th>
                                                    <td class="px-4 py-3">
                                                        {{ $order->user->profile->name }}
                                                    </td>
                                                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($order->schedule->date)->format('d M Y') }} ({{ $order->schedule->time }})</td>
                                                    <td class="px-4 py-3 ">{{ $order->conselor->profile->name }}</td>
                                                    <td class="px-4 py-3 ">{{ 'Rp ' . number_format($order->total, 0, ',', '.') }}</td>
                                                    <td class="px-4 py-3">
                                                        @if ($order->image) 
                                                            <img src="{{ asset($order->image) }}" 
                                                                alt="Bukti Bayar" 
                                                                class="w-24 h-24 object-cover rounded-lg border" />
                                                        @else
                                                            <span class="text-gray-400">Belum ada</span>
                                                        @endif
                                                    </td>

                                                    <td class="px-4 py-3">
                                                        @php
                                                            $statusClasses = [
                                                                'pending' => 'bg-yellow-500',
                                                                'payed' => 'bg-yellow-500',
                                                                'approved' => 'bg-blue-500',
                                                                'progress' => 'bg-blue-500',
                                                                'selesai' => 'bg-green-500',
                                                                'pay fail' => 'bg-red-500',
                                                            ];
                                                            $color = $statusClasses[$order->status] ?? 'bg-gray-300';
                                                        @endphp

                                                        <span class="{{ $color }} p-2 text-white rounded-2xl">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>

                                                    <td class="px-4 py-3 flex items-center justify-end">
                                                        <button id="user{{ $no }}-dropdown-button" data-dropdown-toggle="user{{ $no }}-dropdown" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" >
                                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg>
                                                        </button>
                                                        <div id="user{{ $no }}-dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                            <ul class="py-1 text-sm" aria-labelledby="user{{ $no }}-dropdown-button">
                                                                <li>
                                                                    <a href="{{ route('order.show', $order) }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                                        <svg class="w-4 h-4 mr-2"  viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" />
                                                                        </svg>
                                                                        Preview
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Delete modal -->
                                                <div id="disabledModal-1" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                                        <!-- Modal content -->
                                                        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                            <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="disabledModal-1">
                                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" >
                                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                            <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" >
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                            <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to change status <span class="underline">Orders</span> ?</p>
                                                            <div class="flex justify-center items-center space-x-4">
                                                                <button data-modal-toggle="disabledModal-1" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                                                                <form action="/user/1" method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">Yes, I'm sure</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <tr>
                                                    <td colspan="4">Data tidak tersedia!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                 <div class="my-4 mx-4">
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        </div>
                    </section>

                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
