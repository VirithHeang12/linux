<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItClassGeneration extends Model
{
    /** @use HasFactory<\Database\Factories\ItClassGenerationFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'it_class_generations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'it_class_id',
        'generation_id',
    ];

    /**
     * Get the it class that owns the it class generation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function itClass(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ItClass::class);
    }

    /**
     * Get the generation that owns the it class generation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function generation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Generation::class);
    }
}
