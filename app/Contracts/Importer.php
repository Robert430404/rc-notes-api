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
     * Sets the source file for the importer, and opens the stream
     * for use by the class.
     *
     * @param UploadedFile $file
     * @return Importer
     */
    public function source(UploadedFile $file): Importer;

    /**
     * Imports the uploaded file
     *
     * @return bool
     */
    public function import(): bool;
}