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
     * Get the classes that belong to the academic year.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentAcademic::class, 'academic_id', 'id');
    }
}
