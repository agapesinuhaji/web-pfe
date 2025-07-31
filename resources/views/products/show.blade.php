<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section class="bg-white dark:bg-gray-900">
                        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                            <h2 class="mb-2 text-xl font-semibold leading-none text-gray-900 md:text-2xl dark:text-white">{{ $product->name }}</h2>
                            <p class="mb-4 text-xl font-extrabold leading-none text-gray-900 md:text-xl dark:text-white">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                            <dl>
                                <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Details</dt>
                                <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ $product->description }}</dd>
                            </dl>
                            <dl class="">
                                <div>
                                    <dt class="mt-7 font-semibold leading-none text-gray-900 dark:text-white">Conselor</dt>
                                    <dd class="font-light text-gray-500 sm:mb-2 dark:text-gray-400">
                                        <div class="mx-auto max-w-5xl">
                                            {{-- <div class="gap-4 lg:flex lg:items-center lg:justify-between">
                                                <div class="mt-6 gap-4 space-y-4 sm:flex sm:items-center sm:space-y-0 lg:mt-0 lg:justify-end">
                                                    <button type="button" class="w-full rounded-lg bg-primary-700 px-5 py-1 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 sm:w-auto">Add Conselor</button>
                                                </div>
                                            </div> --}}

                                            <div class="">
                                                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                                    <div class="flex items-center gap-4 py-6">
                                                        <img src="https://via.placeholder.com/64" alt="Foto Konselor" class="h-16 w-16 rounded-full object-cover">
                                                        <div>
                                                            <a href="#" class="block text-base font-semibold text-gray-900 hover:underline dark:text-white">
                                                                Psikolog Agape Manase Sinuhaji S.Psi,
                                                            </a>
                                                            <span class="inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                                                Active
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
