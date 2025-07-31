<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit {{ __('User') }} || {{ $user->profile->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="/user/{{ $user->id }}" method="POST" id="post-form">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly value="{{ $user->profile->name }}">
                            </div>
                            <div>
                                <label for="nickname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nickname</label>
                                <input type="text" name="nickname" id="nickname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly value="{{ $user->profile->nickname }}">
                            </div>
                            <div>
                                <label for="place_of_birth" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Place Of Birth</label>
                                <input type="text" name="place_of_birth" id="place_of_birth" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly value="{{ $user->profile->place_of_birth }}">
                            </div>
                            <div>
                                <label for="date_of_birth" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date Of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly value="{{ $user->profile->date_of_birth }}">
                            </div>
                            <div>
                                <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                                <select id="gender" name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" disabled>
                                    <option selected="">Select category</option>
                                    <option value="L">Laki - Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label for="no_whatsapp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No Whatsapp</label>
                                <input type="telp" name="no_whatsapp" id="no_whatsapp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly value="{{ $user->profile->no_whatsapp }}">
                            </div>
                            <div>
                                <label for="saldo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Saldo</label>
                                <input type="money" name="saldo" id="saldo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly value="{{ $user->profile->saldo }}">
                            </div>
                            <div>
                                <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image</label>
                                <input type="file" name="image" id="image" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly>
                            </div>
                            <div>
                                <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                <select id="role" name="role" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option {{ $user->role == 'user' ?  'selected' : '' }} value="user">User</option>
                                    <option {{ $user->role == 'psikolog' ? 'selected' : '' }} value="psikolog">Psikolog</option>
                                </select>
                            </div>
                           <div>
                                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', $user->is_active == 1 ? 'checked' : '') }}>
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600 dark:peer-checked:bg-green-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Active</span>
                                    </label>
                            </div>
                        </div>
                        <button type="submit" class="text-gray-50 inline-flex items-center bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L6 11.172V14h2.828l8.586-8.586a2 2 0 000-2.828zM5 16h10a1 1 0 100-2H5a1 1 0 100 2z" />
                            </svg>
                            Update User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
