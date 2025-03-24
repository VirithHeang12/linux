<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    /** @use HasFactory<\Database\Factories\AcademicFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'academics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     *
     */
    protected $fillable = [
        'year',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date'            => 'date',
        'end_date'              => 'date',
    ];

    /**
     * Get IT class generation academics for the academic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itClassGenerationAcademics(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItClassGenerationAcademic::class);
    }
}
