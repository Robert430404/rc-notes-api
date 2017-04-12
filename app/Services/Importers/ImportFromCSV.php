<?php

namespace App\Services\Importers;

use App\Contracts\Importer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImportFromCSV
 *
 * @package App\Services\Importers
 */
class ImportFromCSV implements Importer
{
    /**
     * Imports the uploaded file
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function import(UploadedFile $file): bool
    {
        // TODO: Implement import() method.
    }

    private function yieldRow()
    {

    }
}