@php
    use App\Enums\FraisType;
    use App\Enums\MinervalMonth;
    use App\Enums\Devise;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Http;


    $exchange = Cache::remember(
        'usd_cdf_rate',
        now()->addHours(12),
        function () {
            try {
                $response = Http::timeout(5)
                    ->get('https://open.er-api.com/v6/latest/USD');

                $rate = $response->json('rates.CDF');

                if (
                    $response->successful()
                    && $response->json('result') === 'success'
                    && is_numeric($rate)
                    && (float) $rate > 0
                ) {
                    $data = [
                        'rate' => round((float) $rate, 2),
                    ];

                    Cache::forever('usd_cdf_rate_last', $data);

                    return $data;
                }
            } catch (\Throwable $e) {

            }

            return null;
        }
    );


    $exchange = $exchange ?? Cache::get('usd_cdf_rate_last');


    $autoRate = $exchange['rate'] ?? 2850.00;


    if ($perception->devise == Devise::CDF && empty($perception->taux)) {
        $perception->taux = $autoRate;
    }
@endphp

<x-modals::form title="Perception de {{ $inscription->eleve->nom }}">

    <div class="row mb-3">


        <div class="col-md-12 mb-3">
            <x-form::select
                    label="Frais"
                    required
                    wire:change="feeSelected"
                    wire:model="perception.frais_id"
                    class="form-control"
            >
                @foreach ($frais as $f)
                    <option value="{{ $f->id }}">
                        {{ $f->label }}
                    </option>
                @endforeach
            </x-form::select>
        </div>


        @if ($fee?->type?->properties())
            <div class="col-md-12 mb-3">
                <x-form::select
                        required
                        :change="true"
                        label="{{ __('Mois') }}"
                        class="form-select"
                        :options="$fee?->type?->properties()"
                        wire:model="perception.custom_property"
                />
            </div>
        @endif


        <div class="col-md-12 mb-3">
            <x-form::input
                    label="Montant à Payer - {{ $fee?->devise }}"
                    disabled
                    type="number"
                    wire:model="perception.frais_montant"
            />
        </div>


        <div class="col-md-12 mb-3">
            <x-form::select
                    change
                    label="Payé en devise"
                    :options="Devise::cases()"
                    wire:model="perception.devise"
            />
        </div>


        @if ($perception->devise == Devise::CDF)
            <div class="col-md-12 mb-3">
                <x-form::input
                        required
                        label="Taux du $ (CDF)"
                        type="number"
                        step="0.01"
                        min="0.01"
                        wire:model="perception.taux"
                />

                <small class="text-muted">
                    Taux du jour :
                    1 USD = {{ number_format($autoRate, 2, ',', ' ') }} CDF.
                </small>
            </div>
        @endif


        <div class="col-md-12 mb-3">
            <x-form::input
                    label="Montant Payé"
                    step="0.01"
                    required
                    type="number"
                    wire:model="perception.montant"
            />
        </div>

        {{-- Payé par
        <div class="col-md-12 mb-3">
            <x-form::input
                label="Payé Par"
                wire:model="perception.paid_by"
            />
        </div>
        --}}

    </div>
</x-modals::form>