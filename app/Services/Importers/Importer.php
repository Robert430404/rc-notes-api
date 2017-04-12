<?php

namespace App\Services\Importers;

use Generator;
use App\Contracts\CSVImporter;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImportFromCSV
 *
 * @package App\Services\Importers
 */
class ImportFromCSV implements CSVImporter
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
     * ImportFromCSV constructor.
     *
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file   = $file;
        $this->stream = fopen($this->file->getRealPath(), 'r');
    }

    /**
     * Imports the uploaded file
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function import(): bool
    {
        // TODO: create generic implementation of an importer for
    }

    /**
     * Yields a row for use by the importer or any other validation
     *
     * @return Generator
     */
    public function yieldRow(): Generator
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
    protected function persistRow(Model $model, array $labels, array $row): bool
    {
        $record = array_combine($labels, $row);

        foreach ($record as $field => $data) {
            $model->$field = $data;
        }

        return $model->save();
    }
}