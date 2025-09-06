<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Overtime') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
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
                                                    #{{ strtoupper(substr($order->order_uuid, 0, 8)) }}
                                                </th>
                                                <td class="px-4 py-3">{{ $item->overtime->name }}</td>
                                                <td class="px-4 py-3">
                                                    Rp {{ number_format($item->overtime->biaya, 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3">{{ $item->image}}</td>
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
                                                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                                                    </svg>
                                                                    Edit
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Update modal -->
                                            <div id="updateItemModal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                    <!-- Modal content -->
                                                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                        <!-- Modal header -->
                                                        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update Data Overtime</h3>
                                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateItemModal{{ $item->id }}">
                                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" >
                                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <form action="{{ route('overtimeData.update', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                                                <div>
                                                                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bukti Bayar</label>
                                                                    <input type="file" name="image" id="image" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                                                                </div>
                                                                <div>
                                                                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                                        Status
                                                                    </label>
                                                                    <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                                                        <option value="payed" {{ $item->status == 'payed' ? 'selected' : '' }}>Payed</option>
                                                                        <option value="waiting" {{ $item->status == 'waiting' ? 'selected' : '' }}>Waiting</option>
                                                                        <option value="status" {{ $item->status == 'status' ? 'selected' : '' }}>Status</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="flex items-center space-x-4">
                                                                <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Update Item</button>
                                                            </div>
                                                        </form>
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
