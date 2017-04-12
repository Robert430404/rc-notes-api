<?php

namespace App\Providers;

use App\Contracts\CSVImporter;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TypeController;
use App\Services\Importers\ImportNotesFromCSV;
use App\Services\Importers\ImportTypesFromCSV;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this
            ->app
            ->when(NoteController::class)
            ->needs(CSVImporter::class)
            ->give(function () {
                return new ImportNotesFromCSV();
            });

        $this
            ->app
            ->when(TypeController::class)
            ->needs(CSVImporter::class)
            ->give(function () {
                return new ImportTypesFromCSV();
            });
    }
}
