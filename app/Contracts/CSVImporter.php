<?php

namespace App\Contracts;

/**
 * Interface CSVImporter
 *
 * @package App\Contracts
 */
interface CSVImporter extends Importer
{
    /**
     * Returns the record count inside of the CSV
     *
     * @return int
     */
    public function recordCount(): int;
}