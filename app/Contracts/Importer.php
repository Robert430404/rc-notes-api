<?php

namespace App\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface Importer
 *
 * @package App\Contracts
 */
interface Importer
{
    /**
     * Imports the uploaded file
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function import(UploadedFile $file): bool;
}