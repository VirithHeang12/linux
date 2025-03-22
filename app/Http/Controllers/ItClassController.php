<?php

namespace App\Http\Controllers;

use App\Models\ItClass;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class ItClassController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     *
     *
     */

    public function index()
    {


        $perPage = request()->query('itemsPerPage', 5);

        $it_classes = QueryBuilder::for(ItClass::class)
            ->allowedFilters([
                'name',
            ])
            ->paginate($perPage)
            ->appends(request()->query());


        return Inertia::render('Dashboard/Classes/Index', [
            'itClasses'     => $it_classes,
        ]);
    }
}
