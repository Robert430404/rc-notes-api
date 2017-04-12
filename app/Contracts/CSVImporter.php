<?php

namespace App\Contracts;

use Generator;

/**
 * Interface CSVImporter
 *
 * @package App\Contracts
 */
interface CSVImporter extends Importer
{
    /**
     * Yields the row for use or verification
     *
     * @return Generator
     */
    public function yieldRow(): Generator;
}