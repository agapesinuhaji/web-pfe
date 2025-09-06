<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Testimonies') }}
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
                                    <form method="GET" action="{{ route('testimony.index') }}" class="flex items-center">
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
                                                placeholder="Cari berdasarkan #Order ID atau Nama">
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-4 py-4">#</th>
                                            <th scope="col" class="px-4 py-3">Name</th>
                                            <th scope="col" class="px-4 py-3">Rating</th>
                                            <th scope="col" class="px-4 py-3">Testy</th>
                                            <th scope="col" class="px-4 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($testimonies as $testimony)
                                            <tr class="border-b dark:border-gray-700">
                                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">#{{ strtoupper(substr($testimony->order->order_uuid, 0, 8)) }}</th>
                                                <td class="px-4 py-3">{{ $testimony->order->user->profile->name }}</td>
                                                <td class="px-4 py-3">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-5 h-5 inline-block {{ $i <= $testimony->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118L10 13.347l-2.888 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L3.48 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endfor
                                                </td>
                                                <td class="px-4 py-3">{{ $testimony->message }}</td>
                                                <td class="px-4 py-3 flex items-center justify-end">
                                                    <button id="{{ $testimony->id }}-button" data-dropdown-toggle="{{ $testimony->id }}" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" >
                                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        </svg>
                                                    </button>
                                                    <div id="{{ $testimony->id }}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                        <ul class="py-1 text-sm" aria-labelledby="{{ $testimony->id }}-button">
                                                            <li>
                                                                <button type="button" data-modal-target="updatePaymentMethodModal{{ $testimony->id }}" data-modal-toggle="updatePaymentMethodModal{{ $testimony->id }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
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

                                                <!-- Preview modal -->
                                                <div id="updatePaymentMethodModal{{ $testimony->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                        <!-- Modal content -->
                                                        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                            <!-- Modal header -->
                                                            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                                                <div>
                                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                        Testimony order #{{ strtoupper(substr($testimony->order->order_uuid, 0, 8)) }}
                                                                    </h3>
                                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                                        {{ \Carbon\Carbon::parse($testimony->order->schedule->date)->format('d M Y') }}
                                                                        {{ $testimony->order->schedule->time }}
                                                                    </p>
                                                                </div>

                                                                <button type="button"
                                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                                    data-modal-toggle="updatePaymentMethodModal{{ $testimony->id }}">
                                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd"
                                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 
                                                                            111.414 1.414L11.414 10l4.293 4.293a1 1 0 
                                                                            01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 
                                                                            01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 
                                                                            010-1.414z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    <span class="sr-only">Close modal</span>
                                                                </button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <dl>
                                                                <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Conselor</dt>
                                                                <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ $testimony->order->conselor->profile->name }}</dd>
                                                                <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Client</dt>
                                                                <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ $testimony->order->user->profile->name }}</dd>
                                                                <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Rating</dt>
                                                                <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <svg class="w-5 h-5 inline-block {{ $i <= $testimony->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118L10 13.347l-2.888 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L3.48 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                        </svg>
                                                                    @endfor
                                                                </dd>
                                                                <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Testimoni</dt>
                                                                <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ $testimony->message }}</dd>
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
                            <div class="my-4 mx-4">
                                {{ $testimonies->links() }}
                            </div>
                        </div>
                    </div>
                </section>
                <!-- End block -->
                
                
            </div>
        </div>
    </div>

  
</x-app-layout>
