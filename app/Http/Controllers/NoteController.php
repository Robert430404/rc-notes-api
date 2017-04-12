<?php

namespace App\Http\Controllers;

use App\Contracts\CSVImporter;
use App\Note;
use App\Services\Importers\ImportNotesFromCSV;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class NoteController
 *
 * @package App\Http\Controllers
 */
class NoteController extends Controller
{
    /**
     * @var Note
     */
    private $note;

    /**
     * @var ImportNotesFromCSV
     */
    private $importer;

    /**
     * NoteController constructor.
     *
     * @param Note $note
     */
    public function __construct(Note $note, CSVImporter $CSVImporter)
    {
        $this->middleware('auth');
        $this->note     = $note;
        $this->importer = $CSVImporter;
    }

    /**
     * Returns a list of all notes
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $notes = $this->note->all();

        return response()->json($notes);
    }

    /**
     * Inserts a single note from the provided data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function put(Request $request): JsonResponse
    {
        $note             = new Note();
        $note->name       = $request->get('name');
        $note->content    = $request->get('content');
        $note->type       = $request->get('type');
        $note->created_at = Carbon::now();
        $save             = $note->save();

        return response()->json([
            'success' => $save ? true : false
        ]);
    }

    /**
     * Inserts notes in bulk from the data provided
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function post(Request $request): JsonResponse
    {
        $resource = $this->importer->source($request->file('import'));
        $count    = $resource->recordCount();
        $import   = $resource->import();

        return response()->json([
            'success' => $import,
            'count'   => $count,
        ]);
    }

    /**
     * Updates a selected note based upon the sent id
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function patch(Request $request): JsonResponse
    {
        $note             = $this->note->find($request->get('id'));
        $note->name       = $request->get('name');
        $note->content    = $request->get('content');
        $note->type       = $request->get('type');
        $note->updated_at = Carbon::now();
        $save             = $note->save();

        return response()->json([
            'success' => $save ? true : false,
            'note'    => $this->note->find($request->get('id'))
        ]);
    }

    /**
     * Deletes a note based upon the sent id
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $note   = $this->note->find($request->get('id'));
        $delete = $note->delete();

        return response()->json([
            'success' => $delete ? true : false
        ]);
    }
}
