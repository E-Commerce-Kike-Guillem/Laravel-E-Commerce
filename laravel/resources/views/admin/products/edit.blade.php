<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar: {{ $product->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-4">
                        <x-input-label for="name" :value="__('Nom')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$product->name" required />
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="price" :value="__('Preu (€)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="$product->price" required />
                        </div>
                        <div>
                            <x-input-label for="stock" :value="__('Estoc')" />
                            <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="$product->stock" required />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Descripció')" />
                        <textarea id="description" name="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full h-32">{{ $product->description }}</textarea>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('admin.products.index') }}" class="text-gray-600 underline mr-4">Cancel·lar</a>
                        <x-primary-button>
                            {{ __('Guardar Canvis') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>