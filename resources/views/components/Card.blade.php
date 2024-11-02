@props([
    'title' => '',
    'buttonText' => '',
    'link' => '',
    'secondBtn' => '',
    'linkSecondBtn' => '',
    'secondBtnText' => '',
    'secondIcon' => '',
    'secondBtnColor' => '',
    'secondBtnAction' => '',
])

<div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-md mb-4">
    <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap pr-4">
        <div class="ml-4 mt-2">
            <h3 class="text-base font-semibold leading-6 text-gray-900">
                {{ $title }}
            </h3>
        </div>
        <div class="flex flex-col w-full sm:flex-row sm:w-auto">
            <div class="ml-4 mt-2 flex-shrink-0 w-full sm:w-auto">
                <x-button icon="plus"
                          class="w-full sm:w-auto"
                          position="left"
                          href="/{{ $link }}"
                          wire:navigate>
                    {{ $buttonText }}
                </x-button>
            </div>
            <div class="ml-4 mt-2 flex-shrink-0 w-full sm:w-auto">
                @if ($secondBtn)
                    <x-button icon="{{ $secondIcon }}"
                              class="w-full sm:w-auto"
                              position="left"
                              color="{{ $secondBtnColor }}"
                              wire:click="{{ $secondBtnAction }}"
                              wire:navigate>
                        {{ $secondBtnText }}
                    </x-button>
                @endif
            </div>
        </div>


    </div>
</div>
