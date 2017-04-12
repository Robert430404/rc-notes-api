<?php

namespace App\Services\Importers;

use App\Note;
use App\Contracts\CSVImporter;

/**
 * Class ImportNotesFromCSV
 *
 * @package App\Services\Importers
 */
class ImportNotesFromCSV extends BaseImporter implements CSVImporter
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

            $success   = $this->persistRecord(new Note(), $labels, $row);
            $successes = $success ? $successes + 1 : $successes;
        }

        return ($successes > 0) ? true : false;
    }
}