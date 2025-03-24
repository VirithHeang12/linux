<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItClassGenerationResource;
use App\Models\ItClass;
use App\Models\ItClassGeneration;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ItClassGenerationController extends Controller
{
    /**
     * Display a listing of the it class generations
     *
     * @param ItClass $class
     *
     * @return \Inertia\Response
     */
    public function index(ItClass $class): \Inertia\Response
    {

        $perPage = request()->query('itemsPerPage', 5);

        $itClassGenerations = QueryBuilder::for(ItClassGeneration::class)
            ->where('it_class_id', $class->id)
            ->allowedFilters([
                AllowedFilter::callback('generation', function ($query, $value) {
                    $query->whereHas('generation', function ($query) use ($value) {
                        $query->where('name', $value);
                    });
                }),
            ])
            ->with([
                'itClass',
                'generation',
            ])
            ->paginate($perPage)
            ->appends(request()->query());

        $itClassGenerations = ItClassGenerationResource::collection($itClassGenerations);

        return Inertia::render('Dashboard/Classes/Generations/Index', [
            'itClassGenerations'        => $itClassGenerations,
            'itClass'                   => $class,
        ]);
    }
}
