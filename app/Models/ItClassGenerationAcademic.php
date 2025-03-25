<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItClassGenerationAcademic extends Model
{
    /** @use HasFactory<\Database\Factories\ItClassGenerationAcademicFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'it_class_generation_academics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'it_class_generation_id',
        'academic_id',
        'room_no'
    ];

    /**
     * Get the it class generation that owns the it class generation academic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function itClassGeneration(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ItClassGeneration::class);
    }

    /**
     * Get the academic that owns the it class generation academic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function academic(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Academic::class);
    }

    /**
     * Get the it class generation academic students for the it class generation academic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itClassGenerationAcademicStudents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItClassGenerationAcademicStudent::class);
    }
}
