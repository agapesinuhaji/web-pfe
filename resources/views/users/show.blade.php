<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit {{ __('User') }} || {{ $user->profile->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <main class="flex-grow">
                    <div class="max-w-6xl mx-auto px-4 py-10">
                        <h1 class="text-2xl font-bold text-gray-800 mb-6">My Profile</h1>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            {{-- Profile Section --}}
                            <div class="lg:col-span-1">
                                <div class="bg-white shadow-md rounded-2xl p-6">
                                    <div class="flex flex-col items-center text-center">
                                        <img src="{{ asset($user->profile->image) }}" alt="Profile Photo" class="w-32 h-32 rounded-full border-4 border-gray-200 object-cover mb-4"/>
                                        <h2 class="text-xl font-semibold text-gray-900">{{ $user->profile->name }}</h2>
                                            <p class="text-gray-500">“{{ $user->role }}”</p>
                                        <p class="mt-2 text-sm text-gray-600">{{ $user->email }}</p>
                                        <div class="mt-4 w-full text-left text-sm text-gray-700 space-y-2">
                                            <p>
                                                <span class="font-medium">Nama Panggilan:</span> 
                                                {{ $user->profile->nickname  ?? '-'}}
                                            </p>
                                            <p>
                                                <span class="font-medium">Tanggal Lahir:</span> 
                                                {{ $user->profile->date_of_birth ? \Carbon\Carbon::parse($user->profile->date_of_birth)->format('d M Y') : '-' }}
                                            </p>
                                            <p>
                                                <span class="font-medium">Jenis Kelamin:</span> 
                                                {{ $user->profile->gender == 'L' ? 'Laki-laki' : ($user->profile->gender == 'P' ? 'Perempuan' : '-') }}
                                            </p>
                                            <p><span class="font-medium">Domisili:</span> {{ $user->profile->domicile ?? '-' }}</p>
                                            <p>
                                                <span class="font-medium">No. WhatsApp:</span> 
                                                <a target="_blank" href="https://wa.me/{{ $user->profile->no_whatsapp }}" class="text-green-600 hover:underline">
                                                    {{ $user->profile->no_whatsapp ?? '-' }}
                                                </a>
                                            </p>
                                        </div>

                                        <div class="flex gap-4 mt-6">
                                            <a  data-modal-target="accountInformationModal2" data-modal-toggle="accountInformationModal2"  class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition cursor-pointer" >
                                                Edit Data
                                            </a>
                                        </div>

                                        {{-- Modal Edit Data --}}
                                        <div id="accountInformationModal2" tabindex="-1" aria-hidden="true" class="max-h-auto fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden antialiased md:inset-0">
                                            <div class="max-h-auto relative max-h-full w-full max-w-lg p-4">
                                            <!-- Modal content -->
                                                <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
                                                    <!-- Modal header -->
                                                    <div class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 dark:border-gray-700 md:p-5">
                                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Data || {{ $user->profile->name }}</h3>
                                                        <button type="button" class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="accountInformationModal2">
                                                            <svg class="h-3 w-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <form class="p-4 md:p-5 text-left" method="POST" action="/user/{{ $user->id }}">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="col-span-2 mb-4 sm:col-span-1">
                                                            <div class="mb-2 flex items-center gap-2">
                                                                <label for="role" class="block text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                                            </div>
                                                            <select id="role" name="role"
                                                                class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 
                                                                    focus:border-primary-500 focus:ring-primary-500 
                                                                    dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 
                                                                    dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                                                <option {{ $user->role == 'user' ? 'selected' : '' }} value="user">User</option>
                                                                <option {{ $user->role == 'psikolog' ? 'selected' : '' }} value="psikolog">Psikolog</option>
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input type="checkbox" name="status" value="1" 
                                                                    class="sr-only peer" 
                                                                    {{ old('status', $user->is_active == 1 ? 'checked' : '') }}>
                                                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                                                            peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer 
                                                                            dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                                                                            peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] 
                                                                            after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full 
                                                                            after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600 
                                                                            dark:peer-checked:bg-green-600"></div>
                                                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Active </span>
                                                            </label>
                                                        </div>

                                                        <div class="border-t border-gray-200 pt-4 dark:border-gray-700 md:pt-5">
                                                            <button type="submit"
                                                                class="me-2 inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 
                                                                    text-sm font-medium text-white hover:bg-primary-800 focus:outline-none 
                                                                    focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 
                                                                    dark:focus:ring-primary-800">
                                                                Save Change Data
                                                            </button>
                                                            <button type="button" data-modal-toggle="accountInformationModal2"
                                                                class="me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 
                                                                    text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 
                                                                    focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 
                                                                    dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 
                                                                    dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
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
                                        <p>{{ $user->profile->description }}</p>
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
                    {{-- Conseling Metode --}}
                     <div class="relative rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800 md:p-8">
                        <button class="absolute top-4 right-4 bg-green-600 text-white px-4 py-2 text-sm rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800" data-modal-target="addMethodModal" data-modal-toggle="addMethodModal">
                            Add Method
                        </button>
                        <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Conseling Method</h3>
                        @forelse ($methods as $method)
                            <div class="flex flex-wrap items-center gap-y-4 border-b border-gray-200 pb-4 dark:border-gray-700 md:pb-5">
                                <dl class="sm:w-128 md:w-86">
                                    <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Method</dt>
                                    <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $method->name }}
                                    </dd>
                                </dl>
                                <dl class="w-1/2 sm:w-1/4 sm:flex-1 lg:w-auto">
                                    <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Status:</dt>
                                    <dd class="me-2 mt-1.5 inline-flex shrink-0 items-center rounded  {{ $method->status == 1 ? 'bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ $method->status == 1 ? 'Active' : 'Nonactive' }}
                                    </dd>
                                </dl>
                                <div class="w-full sm:flex sm:w-32 sm:items-center sm:justify-end sm:gap-4">
                                    <button id="actionsMenuDropdownModal10" data-dropdown-toggle="dropdownOrderModal{{ $method->id }}" type="button" class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 md:w-auto">
                                        Actions
                                        <svg class="-me-0.5 ms-1.5 h-4 w-4" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div id="dropdownOrderModal{{ $method->id }}" class="z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
                                        <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400" aria-labelledby="actionsMenuDropdown10">
                                            <li>
                                                @if ($method->status)
                                                    <button type="button" data-modal-target="disabledModal-{{ $method->id }}" data-modal-toggle="disabledModal-{{ $method->id }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400">
                                                        <svg class="w-4 h-4 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                        Disable
                                                    </button>
                                                @else
                                                    <button type="button" data-modal-target="disabledModal-{{ $method->id }}" data-modal-toggle="disabledModal-{{ $method->id }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-green-600 dark:hover:text-green-400">
                                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                        Enable
                                                    </button>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div id="disabledModal-{{ $method->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                        <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="disabledModal-{{ $method->id }}">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <p class="mb-4 text-gray-500 dark:text-gray-300">
                                            Are you sure you want to change status 
                                            <span class="underline">{{ $method->name }}</span> 
                                            ?
                                        </p>
                                        <div class="flex justify-center items-center space-x-4">
                                            <button data-modal-toggle="disabledModal-{{ $method->id }}" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                                            <form action="/method/{{ $method->id }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">Yes, I'm sure</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            NULL
                        @endforelse
                    </div>
                        {{-- Add Method Modal --}}
                    <div id="addMethodModal" tabindex="-1" aria-hidden="true" class="max-h-auto fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden antialiased md:inset-0">
                        <div class="max-h-auto relative max-h-full w-full max-w-lg p-4">
                        <!-- Modal content -->
                            <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 dark:border-gray-700 md:p-5">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add new method</h3>
                                    <button type="button" class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="addMethodModal">
                                        <svg class="h-3 w-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <form class="p-4 md:p-5" method="POST" action="{{ route('method.store') }}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <div class="col-span-2 mb-4 sm:col-span-1">
                                        <div class="mb-2 flex items-center gap-2">
                                            <label for="method" class="block text-sm font-medium text-gray-900 dark:text-white">Name Methode</label>
                                        </div>
                                        <input type="text" name="method" id="method" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                    </div>
                                    <div class="border-t border-gray-200 pt-4 dark:border-gray-700 md:pt-5">
                                        <button type="submit" class="me-2 inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Add New</button>
                                        <button type="button" data-modal-toggle="accountInformationModal2" class="me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
