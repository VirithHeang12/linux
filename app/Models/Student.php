<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'address',
        'email',
        'phone',
    ];

    /**
     * Get the user that owns the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    /**
     * Get the image associated with the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Get the it class generation academic students for the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itClassGenerationAcademicStudents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItClassGenerationAcademicStudent::class);
    }
}
