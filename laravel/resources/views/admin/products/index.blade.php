<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administració de Productes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">ID</th>
                                <th scope="col" class="px-6 py-4">SKU</th>
                                <th scope="col" class="px-6 py-4">Nom</th>
                                <th scope="col" class="px-6 py-4">Preu</th>
                                <th scope="col" class="px-6 py-4">Stock</th> <th scope="col" class="px-6 py-4">Accions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr class="border-b dark:border-neutral-500 hover:bg-gray-100">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $product->id }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $product->sku }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $product->name }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $product->price }} €</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $product->stock }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Editar</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>