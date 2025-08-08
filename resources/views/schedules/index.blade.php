<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Jadwal Psikolog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Form Jadwal --}}
                <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Buat Jadwal Baru</h3>
                    <form action="{{ route('schedule.store') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Pilih Psikolog
                            </label>
                            <div class="relative">
                                <select name="user_id" id="user_id"
                                    class="block w-full appearance-none border border-gray-300 rounded-lg bg-white px-4 py-2 pr-10 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700">
                                    @foreach ($psychologists as $psych)
                                        <option value="{{ $psych->id }}">{{ $psych->profile->name }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

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


                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                    </form>
                </div>

                {{-- Table --}}
                <div x-data="{ open: false, selectedDate: '', schedulesForDate: [], rawDate: '' }" class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">📅 Jadwal Terdaftar</h3>

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

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const input = document.getElementById('date');

            // Hari ini
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = today.getMonth(); // 0-indexed

            // Akhir bulan depan
            const endOfNextMonth = new Date(yyyy, mm + 2, 0); // 0 = hari terakhir bulan sebelumnya

            // Format ke YYYY-MM-DD
            const formatDate = (date) => {
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${date.getFullYear()}-${month}-${day}`;
            };

            input.min = formatDate(today);
            input.max = formatDate(endOfNextMonth);
        });
    </script>
</x-app-layout>
