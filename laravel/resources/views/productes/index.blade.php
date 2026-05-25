<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catàleg de Productes') }}
        </h2>
    </x-slot>

<div class="py-12 bg-gray-50 w-full">
    <div class="w-full px-10">

        <div class="flex flex-wrap justify-center gap-8">

            <div style="display:flex; gap:20px; flex-wrap:wrap;">

            @foreach ($products as $producte)

                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden flex flex-col w-72">

                    <img src="{{ asset('storage/' . $producte->image) }}"
                         alt="{{ $producte->name }}"
                         class="w-full h-64 object-cover">

                    <div class="p-5 flex flex-col flex-grow">

                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            {{ $producte->name }}
                        </h3>

                        <p class="text-gray-600 text-sm mb-4 flex-grow">
                            {{ Str::limit($producte->description, 100) }}
                        </p>

                        <div class="flex items-center justify-between mt-auto">

                            <span class="text-2xl font-bold text-gray-800">
                                {{ number_format($producte->price, 2) }} €
                            </span>

                            <a href="{{ route('productes.show', $producte->id) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                                Veure més
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach
            </div>
        </div>

    </div>
</div>
</x-app-layout>