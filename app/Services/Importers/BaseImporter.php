<?php

namespace App\Services\Importers;

use Generator;
use App\Contracts\Importer;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class BaseImporter
 *
 * @package App\Services\Importers
 */
abstract class BaseImporter implements Importer
{
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var bool|resource
     */
    protected $stream;

    /**
     * Imports the uploaded file
     *
     * @return bool
     */
    abstract public function import(): bool;

    /**
     * Returns the record count
     *
     * @return int
     */
    abstract public function recordCount(): int;

    /**
     * Sets the source file for the importer, and opens the stream
     * for use by the class.
     *
     * @param UploadedFile $file
     * @return BaseImporter
     */
    public function source(UploadedFile $file): Importer
    {
        $this->file   = $file;
        $this->stream = fopen($this->file->getRealPath(), 'r');

        return $this;
    }

    /**
     * Yields a row for use by the importer or any other validation
     *
     * @return Generator
     */
    protected function yieldRecord(): Generator
    {
        while (!feof($this->stream)) {
            yield fgetcsv($this->stream);
        }
    }

    /**
     * Persists the row into the database using the provided model,
     * labels, and row data.
     *
     * @param array $labels
     * @param array $row
     * @return bool
     */
    protected function persistRecord(Model $model, array $labels, array $row): bool
    {
        $record = array_combine($labels, $row);

        foreach ($record as $field => $data) {
            $model->$field = $data;
        }

        return $model->save();
    }
}