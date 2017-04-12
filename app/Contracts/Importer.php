<?php

namespace App\Contracts;

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
     * @return bool
     */
    public function import(): bool;
}