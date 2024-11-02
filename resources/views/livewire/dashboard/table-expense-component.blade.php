<div>
    <div class="px-4 pt-4 sm:py-4 rounded-lg sm:px-6 lg:px-8 bg-white mt-4">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">
                    Despesas
                </h1>
                <p class="mt-2 text-sm text-gray-700">
                    Próximos boletos a vencer.
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
                                    Despesa
                                </th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                    Valor
                                </th>
                                <th scope="col"
                                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                    Vencimento
                                </th>
                                <th scope="col"
                                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                                    Descrição
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dueExpensesToday as $expense)
                                <tr>
                                    <td class="relative py-4 pl-4 pr-3 text-sm sm:pl-6">
                                        <div class="font-medium text-gray-900">
                                            {{ $expense['name'] }}
                                        </div>
                                        <div class="mt-1 flex flex-col text-gray-500 sm:block lg:hidden">
                                            <span>
                                                {{ \Carbon\Carbon::parse($expense['due_date'])->format('d/m/Y') }}
                                            </span>
                                            <span class="hidden sm:inline"> - </span>
                                            <span>
                                                {{ 'R$ ' . number_format($expense['value'], 2, ',', '.') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3.5 text-sm text-gray-500 lg:table-cell">
                                        {{ 'R$ ' . number_format($expense['value'], 2, ',', '.') }}
                                    </td>
                                    <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell">
                                        {{ \Carbon\Carbon::parse($expense['due_date'])->format('d/m/Y') }}
                                    </td>
                                    <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell">
                                        {{ $expense['description'] ? $expense['description'] : 'Sem descrição' }}
                                    </td>
                                    <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell">

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="italic p-3 text-center text-xs md:text-sm">
                                        Nenhuma despesa não paga com vencimento hoje.
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
