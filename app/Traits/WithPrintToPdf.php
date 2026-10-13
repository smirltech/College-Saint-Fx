<?php

namespace App\Traits;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait WithPrintToPdf
{
    /**
     * @param string $view the view in which data will be displayed
     * @param array $data the data that is required to populate the view
     * @param string $filename the name of the file that will be downloaded
     * @return StreamedResponse the response
     */
    public function printToPdf(string $view, array $data, string $filename): StreamedResponse
    {
        $pdf = PDF::loadView($view, $data)->output();
        return response()->streamDownload(static fn()=>print ($pdf), $filename);
    }
}
