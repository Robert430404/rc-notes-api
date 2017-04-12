<?php

namespace App\Services\Importers;

use App\Note;

/**
 * Class ImportNotesFromCSV
 *
 * @package App\Services\Importers
 */
class ImportNotesFromCSV extends Importer
{
    /**
     * Imports the note data into the database
     *
     * @return bool
     */
    public function import(): bool
    {
        $successes = 0;
        $labels    = fgetcsv($this->stream);

        foreach ($this->yieldRow() as $row) {
            if (!is_array($row)) {
                continue;
            }

            $success   = $this->persistRow(new Note(), $labels, $row);
            $successes = $success ? $successes + 1 : $successes;
        }

        return ($successes > 0) ? true : false;
    }
}