<?php

namespace App\Imports;

use App\Imports\Dto\CoursData;
use App\Imports\Dto\InscriptionData;
use Exception;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use Rap2hpoutre\FastExcel\FastExcel;

class InscriptionsImport
{
    public function __construct(
        private readonly string  $anneeId,
        private readonly ?string $classeId
    )
    {
        //
    }

    // build
    public static function build(string $anneeId, ?string $classeId): self
    {
        return new self(anneeId: $anneeId, classeId: $classeId);
    }

    /**
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws ReaderNotOpenedException
     * @throws Exception
     */
    public function import(string $file): void
    {
        (new FastExcel)->import($file, function ($line) {
            $data = (object)(array_change_key_case($line));
            if (optional($data)?->nom) {
                InscriptionData::fromRow(data: $data, anneeId: $this->anneeId, classeId: $this->classeId);
            }
        });
    }
}
