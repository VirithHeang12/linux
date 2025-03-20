<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    /** @use HasFactory<\Database\Factories\GenerationFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'generations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the it classes generation for the generation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itClassGenerations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItClassGeneration::class);
    }
}
