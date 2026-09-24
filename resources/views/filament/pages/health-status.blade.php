<x-filament-panels::page>
    <div class="flex flex-col gap-3">
        @foreach ($checkResults as ['check' => $check, 'result' => $result, 'message' => $message])
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="flex items-start justify-between gap-4 p-6">
                    <div class="min-w-0">
                        <h3 class="text-sm font-semibold text-gray-950 dark:text-white">
                            {{ $check->getLabel() }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $message }}</p>
                    </div>
                    @php
                        $color = match ($result->status) {
                            \Spatie\Health\Enums\Status::ok() => 'success',
                            \Spatie\Health\Enums\Status::warning() => 'warning',
                            \Spatie\Health\Enums\Status::skipped() => 'info',
                            default => 'danger',
                        };
                        $statusLabel = match ($result->status) {
                            \Spatie\Health\Enums\Status::ok() => 'Correcto',
                            \Spatie\Health\Enums\Status::warning() => 'Precaución',
                            \Spatie\Health\Enums\Status::skipped() => 'Omitido',
                            default => 'Falló',
                        };
                    @endphp
                    <x-filament::badge :color="$color">
                        {{ $statusLabel }}
                    </x-filament::badge>
                </div>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>