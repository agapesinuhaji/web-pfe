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
                        <div class="mb-4">
                            <label for="user_id">Pilih Psikolog</label>
                            <select name="user_id" class="w-full border rounded">
                                @foreach ($psychologists as $psych)
                                    <option value="{{ $psych->id }}">{{ $psych->profile->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="date">Tanggal</label>
                            <input type="date" name="date" class="w-full border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label>Jam</label>
                            <div class="grid grid-cols-3 gap-2 mt-2">
                                @foreach (['07:00', '09:00', '11:00', '13:00', '15:00', '17:00'] as $time)
                                    <label><input type="checkbox" name="times[]" value="{{ $time }}"> {{ $time }}</label>
                                @endforeach
                            </div>
                        </div>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                    </form>
                </div>

                {{-- Table --}}
                <div 
                    x-data="{ open: false, selectedDate: '', schedulesForDate: [], rawDate: '' }" 
                    class="bg-white overflow-hidden shadow sm:rounded-lg p-6"
                >
                    <h3 class="text-lg font-semibold mb-4">Jadwal Terdaftar</h3>

                    @php
                        $grouped = $schedules->groupBy('date');
                    @endphp

                    @if($grouped->count())
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Tanggal</th>
                                    <th class="px-4 py-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                                class="text-blue-600 hover:underline"
                                            >
                                                Lihat Jam
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Belum ada jadwal.</p>
                    @endif

                    {{-- Modal --}}
                    <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white p-6 rounded-lg w-full max-w-md" @click.away="open = false">
                            <h3 class="text-lg font-semibold mb-2">Jadwal: <span x-text="selectedDate"></span></h3>

                            <ul class="space-y-2">
                                <template x-for="(item, index) in schedulesForDate" :key="item.id">
                                    <li class="flex justify-between items-center border-b pb-1">
                                        <span>
                                            <span x-text="item.time"></span> -
                                            <span x-text="item.name"></span>
                                        </span>
                                        <form method="POST" :action="'/schedule/' + item.id" @submit.prevent="$event.target.submit()">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </li>
                                </template>
                            </ul>

                            <div class="mt-4 flex justify-between">
                                <form :action="'/schedules/day/' + rawDate" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-700 hover:underline">Hapus Semua</button>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
