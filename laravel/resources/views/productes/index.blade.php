<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catàleg de Productes') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="h-48 bg-gray-200 flex items-center justify-center overflow-hidden">
                        @if($product->image)
                          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-cover h-full w-full">
                        @else
                            <span class="text-gray-400">Sense Imatge</span>
                        @endif
                    </div>

                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $product->sku }}</p>
                            </div>
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                {{ $product->stock }} un.
                            </span>
                        </div>
                        
                        <p class="mt-2 text-gray-600 text-sm line-clamp-2">
                            {{ $product->description }}
                        </p>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xl font-bold text-gray-900">{{ $product->price }} €</span>
                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700 transition">
                                Afegir
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>