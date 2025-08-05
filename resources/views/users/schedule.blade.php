<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Jadwal Counseling || {{ $user->profile->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-8">
                    <div class="flex justify-end p-4">
                        <button class="inline-flex items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 sm:w-auto" data-modal-target="accountInformationModal2" data-modal-toggle="accountInformationModal2" >
                            <svg class="-ms-0.5 me-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"></path>
                            </svg>
                            Edit data
                        </button>

                        @if ($user->role == 'psikolog')
                            <a href="{{ route('user.show', $user->id) }}"
                                class="inline-flex items-center ml-2 justify-center rounded-lg bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                                Back
                            </a>
                        @endif
                            
                    </div>

                    <div class="mx-auto max-w-screen-lg px-4 2xl:px-0">
                        <div class="py-4 md:py-8">
                            <div class="mb-4 grid gap-4 sm:grid-cols-2 sm:gap-8 lg:gap-16">
                                <div class="space-y-4">
                                    <div class="flex space-x-4">
                                        <img class="h-16 w-16 rounded-lg" src="{{ asset('storage/' . $user->profile->image) }}" alt="{{ $user->profile->name }}" />
                                        <div>
                                            <span class="mb-2 inline-block rounded bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-800 dark:bg-primary-900 dark:text-primary-300"> {{ $user->role }} </span>
                                            <h2 class="flex items-center text-xl font-bold leading-none text-gray-900 dark:text-white sm:text-2xl">
                                                {{ $user->profile->name }}
                                            </h2>
                                        </div>
                                    </div>
                                    <dl class="">
                                        <dt class="font-semibold text-gray-900 dark:text-white">Email Address</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">{{ $user->email }}</dd>
                                    </dl>
                                    <dl>
                                        <dt class="font-semibold text-gray-900 dark:text-white">Nickname</dt>
                                        <dd class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                                            {{ $user->profile->nickname }}
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt class="font-semibold text-gray-900 dark:text-white">Place and Birth of Birth</dt>
                                        <dd class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                                            {{ $user->profile->date_of_place }}, {{ $user->profile->date_of_birth }}
                                        </dd>
                                    </dl>
                                </div>
                                <div class="space-y-4">
                                    <dl>
                                        <dt class="font-semibold text-gray-900 dark:text-white">Phone Number</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">{{ $user->profile->no_whatsapp }}</dd>
                                    </dl>
                                    <dl>
                                        <dt class="font-semibold text-gray-900 dark:text-white">Gender</dt>
                                        <dd class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                                            @if ($user->profile->gender == 'L')
                                                Laki - Laki
                                            @elseif ($user->profile->gender == 'P')
                                                Perempuan
                                            @else
                                                -
                                            @endif
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt class="font-semibold text-gray-900 dark:text-white">Status</dt>
                                        <dd>
                                            @if ($user->is_active)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                                    Nonactive
                                                </span>
                                            @endif
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        @if ($user->role == 'psikolog')
                            
                        <div x-data="{ open: false, selectedDate: '', schedulesForDate: [], rawDate: '' }" class="bg-white shadow rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4 border-b pb-2">
                                <h3 class="text-xl font-bold text-gray-800">📅 Jadwal Terdaftar</h3>
                                <a  data-modal-target="scheduleModal" data-modal-toggle="scheduleModal"
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-white bg-green-600 rounded hover:bg-green-700 shadow">
                                    ➕ Tambah Jadwal Baru
                                </a>
                            </div>

                            @php
                                $grouped = $schedules->groupBy('date');
                            @endphp

                            @if($grouped->count())
                                <table class="w-full text-sm text-left text-gray-700">
                                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                                        <tr>
                                            <th class="px-4 py-3">Tanggal</th>
                                            <th class="px-4 py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($grouped as $date => $items)
                                            <tr>
                                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</td>
                                                <td class="px-4 py-2">
                                                    <button
                                                        @click="
                                                            open = true;
                                                            selectedDate = '{{ \Carbon\Carbon::parse($date)->format('d M Y') }}';
                                                            rawDate = '{{ $date }}';
                                                            schedulesForDate = {{ $items->map(fn($item) => [
                                                                'id' => $item->id,
                                                                'time' => $item->time,
                                                                'name' => $item->user->profile->name
                                                            ])->toJson() }};
                                                        "
                                                        class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1.5 rounded shadow"
                                                    >
                                                        Lihat Jam
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-500 italic">Belum ada jadwal.</p>
                            @endif

                            <!-- Modal -->
                            <div x-show="open" x-cloak class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center">
                                <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative" @click.away="open = false">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">🕒 Jadwal: <span x-text="selectedDate"></span></h3>

                                    <ul class="space-y-3 max-h-60 overflow-y-auto pr-2">
                                        <template x-for="(item, index) in schedulesForDate" :key="item.id">
                                            <li class="flex justify-between items-center border-b pb-2 text-sm">
                                                <span class="text-gray-700">
                                                    <span x-text="item.time" class="font-medium"></span> - 
                                                    <span x-text="item.name" class="text-gray-500"></span>
                                                </span>
                                                <form method="POST" :action="'/schedule/' + item.id" @submit.prevent="$event.target.submit()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-red-600 hover:underline text-xs">Hapus</button>
                                                </form>
                                            </li>
                                        </template>
                                    </ul>

                                    <div class="mt-6 flex justify-between items-center">
                                        <form :action="'/schedules/day/' + rawDate" method="POST" class="inline-block">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="text-red-700 hover:text-red-900 text-sm font-semibold">
                                                ❌ Hapus Semua
                                            </button>
                                        </form>
                                        <button @click="open = false" class="text-gray-500 hover:text-gray-700 text-sm">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Account Information Modal -->
                    <div id="accountInformationModal2" tabindex="-1" aria-hidden="true" class="max-h-auto fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden antialiased md:inset-0">
                        <div class="max-h-auto relative max-h-full w-full max-w-lg p-4">
                        <!-- Modal content -->
                            <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 dark:border-gray-700 md:p-5">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Data || {{ $user->profile->name }}</h3>
                                    <button type="button" class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="accountInformationModal2">
                                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <form class="p-4 md:p-5" method="POST" action="/user/{{ $user->id }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-span-2 mb-4 sm:col-span-1">
                                        <div class="mb-2 flex items-center gap-2">
                                            <label for="role" class="block text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                        </div>
                                        <select id="role" name="role" class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                            <option {{ $user->role == 'user' ? 'selected' : '' }} value="user">User</option>
                                            <option {{ $user->role == 'psikolog' ? 'selected' : '' }} value="psikolog">Psikolog</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', $user->is_active == 1 ? 'checked' : '') }}>
                                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600 dark:peer-checked:bg-green-600"></div>
                                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Active </span>
                                            </label>
                                    </div>
                                    <div class="border-t border-gray-200 pt-4 dark:border-gray-700 md:pt-5">
                                        <button type="submit" class="me-2 inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Save Change Data</button>
                                        <button type="button" data-modal-toggle="accountInformationModal2" class="me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <!-- Schedule Modal -->
                    <div id="scheduleModal" tabindex="-1" aria-hidden="true" class="max-h-auto fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden antialiased md:inset-0">
                        <div class="max-h-auto relative max-h-full w-full max-w-lg p-4">
                        <!-- Modal content -->
                            <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 dark:border-gray-700 md:p-5">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Schedule</h3>
                                    <button type="button" class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="scheduleModal">
                                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <form class="p-4 md:p-5" method="POST" action="{{ route('schedule.store') }}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <div class="mb-6">
                                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
                                            Tanggal Konseling
                                        </label>
                                        <input type="date" name="date" id="date" required class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700">
                                    </div>
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Jam Konseling</label>
                                        <div class="grid grid-cols-3 gap-3">
                                            @foreach (['07:00', '09:00', '11:00', '13:00', '15:00', '17:00'] as $time)
                                                <label class="flex items-center">
                                                    <input 
                                                        type="checkbox" 
                                                        name="times[]" 
                                                        value="{{ $time }}" 
                                                        class="peer hidden"
                                                    >
                                                    <div class="w-full text-center cursor-pointer rounded-full border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 
                                                                peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600
                                                                hover:bg-blue-50 hover:border-blue-400 hover:text-blue-600">
                                                        {{ $time }}
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="border-t border-gray-200 pt-4 dark:border-gray-700 md:pt-5">
                                        <button type="submit" class="me-2 inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Save Change Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                


                    



                </section>
            </div>
        </div>
    </div>
</x-app-layout>
