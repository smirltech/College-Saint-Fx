<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Sammyjo20\Saloon\Http\SaloonResponse;

trait SaloonSerializer
{
    public static function fromSaloonResponse(SaloonResponse $response): self
    {
        $data = $response->json()['data'];

        return self::serialize($data);

    }

    abstract static function serialize(mixed $data): mixed;

    public static function fromSaloonResponseCollection(SaloonResponse $response, bool $meta = false): Collection
    {
        $data = collect($response->json()['data'])->map(fn($datum) => self::serialize($datum));

        if (!$meta) {
            return $data;
        } else {
            return collect([
                'data' => $data,
                'meta' => (object)self::meta($response->json()['meta']),
            ]);
        }
    }

    private static function meta(array $meta): array
    {
        return [
            'current_page' => $meta['current_page'],
            'from' => $meta['from'],
            'last_page' => $meta['last_page'],
            // 'path' => $meta['path'],
            'per_page' => $meta['per_page'],
            'to' => $meta['to'],
            'total' => $meta['total'],
        ];
    }

    abstract function toArray(): array;

    // toArray

}
