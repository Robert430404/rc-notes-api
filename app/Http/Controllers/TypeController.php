<?php

namespace App\Http\Controllers;

use App\Contracts\CSVImporter;
use App\Services\Importers\ImportTypesFromCSV;
use App\Type;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class TypeController
 *
 * @package App\Http\Controllers
 */
class TypeController extends Controller
{
    /**
     * @var Type
     */
    private $type;

    /**
     * @var ImportTypesFromCSV
     */
    private $importer;

    /**
     * TypeController constructor.
     *
     * @param Type $type
     */
    public function __construct(Type $type, CSVImporter $CSVImporter)
    {
        $this->middleware('auth');
        $this->type     = $type;
        $this->importer = $CSVImporter;
    }

    /**
     * Gets a list of types currently in the system
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $types = $this->type->all();

        return response()->json($types);
    }

    /**
     * Inserts a single type from the provided data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function put(Request $request): JsonResponse
    {
        $type             = new Type();
        $type->name       = $request->get('name');
        $type->created_at = Carbon::now();
        $save             = $type->save();

        return response()->json([
            'success' => $save ? true : false
        ]);
    }

    /**
     * Inserts types in bulk from the data provided
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function post(Request $request): JsonResponse
    {
        $resource = $this->importer->source($request->file('import.csv'));
        $count    = $resource->recordCount();
        $import   = $resource->import();

        return response()->json([
            'success' => $import,
            'count'   => $count,
        ]);
    }

    /**
     * Updates a selected type based upon the sent id
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function patch(Request $request): JsonResponse
    {
        $type             = $this->type->find($request->get('id'));
        $type->name       = $request->get('name');
        $type->updated_at = Carbon::now();
        $save             = $type->save();

        return response()->json([
            'success' => $save ? true : false,
            'type'    => $this->type->find($request->get('id'))
        ]);
    }

    /**
     * Deletes a type based upon the sent id
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $type   = $this->type->find($request->get('id'));
        $delete = $type->delete();

        return response()->json([
            'success' => $delete ? true : false
        ]);
    }
}
