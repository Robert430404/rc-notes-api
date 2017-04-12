<?php

namespace App\Services\Importers;

use App\Type;
use App\Contracts\CSVImporter;

/**
 * Class ImportTypesFromCSV
 *
 * @package App\Services\Importers
 */
class ImportTypesFromCSV extends BaseImporter implements CSVImporter
{
    /**
     * Returns the record count from the CSV
     *
     * @return int
     */
    public function recordCount(): int
    {
        $total = 0;

        while (!feof($this->stream)) {
            $line  = fgets($this->stream, 4096);
            $total = $total + substr_count($line, PHP_EOL);
        }

        rewind($this->stream);

        return $total;
    }

    /**
     * Imports the note data into the database
     *
     * @return bool
     */
    public function import(): bool
    {
        $successes = 0;
        $labels    = fgetcsv($this->stream);

        foreach ($this->yieldRecord() as $row) {
            if (!is_array($row)) {
                continue;
            }

            $success   = $this->persistRecord(new Type(), $labels, $row);
            $successes = $success ? $successes + 1 : $successes;
        }

        return ($successes > 0) ? true : false;
    }
}