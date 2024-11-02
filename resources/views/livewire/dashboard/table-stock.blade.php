<div>
    <div class="px-4 pt-4 sm:py-4 rounded-lg sm:px-6 lg:px-8 bg-white mt-4">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">
                    Estoque
                </h1>
                <p class="mt-2 text-sm text-gray-700">
                    Produtos com estoque a baixo do limite.
                </p>
            </div>
        </div>
        <div class="px-1 py-4 sm:grid sm:grid-cols-1 sm:gap-4 sm:px-0">
            <div class="overflow-hidden dark:ring-dark-600 rounded-lg shadow ring-1 ring-gray-300">
                <div class="relative soft-scrollbar overflow-auto">
                    <table class="w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Produto
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                    Qtd miníma
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                    Qtd Estoque
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stockLow as $product)
                                <tr>
                                    <td class="relative py-4 pl-4 pr-3 text-sm sm:pl-6">
                                        <div class="font-medium text-gray-900">
                                            {{ $product->name }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-3.5 text-sm text-gray-500 lg:table-cell">
                                        {{ $product->qtd_min }} {{ $product->unit_type }}
                                    </td>
                                    <td class="px-3 py-3.5 text-sm text-gray-500 lg:table-cell">
                                        {{ $product->qtd_stock }} {{ $product->unit_type }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="italic p-3 text-center text-xs md:text-sm">
                                        Nenhum produto com estoque baixo.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
