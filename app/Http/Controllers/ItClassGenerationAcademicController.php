<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItClassGenerationAcademicResource;
use App\Models\ItClass;
use App\Models\ItClassGeneration;
use App\Models\ItClassGenerationAcademic;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class ItClassGenerationAcademicController extends Controller
{
    /**
     * Display a listing of the academic generations for a specific class.
     *
     *
     *
     * @return \Inertia\Response
     *
     */

    public function index(ItClass $class, ItClassGeneration $generation): \Inertia\Response
    {

        $perPage = request()->query('itemsPerPage', 5);

        $itClassGenerationAcademics = QueryBuilder::for(ItClassGenerationAcademic::class)
            ->where('it_class_generation_id', $generation->id)
            ->with([
                'academic',
                'itClassGeneration',
            ])
            ->paginate($perPage)
            ->appends(request()->query());

        $itClassGenerationAcademics = ItClassGenerationAcademicResource::collection($itClassGenerationAcademics);

        return Inertia::render('Dashboard/Classes/Generations/Academics/Index', [
            'itClassGenerationAcademics' => $itClassGenerationAcademics,
            'itClass'                    => $class,
            'generation'                 => $generation
        ]);

    }
}
