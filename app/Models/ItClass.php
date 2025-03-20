<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItClass extends Model
{
    /** @use HasFactory<\Database\Factories\ItClassFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'it_classes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
    ];

    /**
     * Get the it class generation for the it class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itClassGenerations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItClassGeneration::class);
    }
}
