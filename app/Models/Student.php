<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
    use SoftDeletes;

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
     * The 'booted' method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::created(function ($student) {
            $student->assignRole(RoleEnum::STUDENT);
        });
    }

    /**
     * Get the user that owns the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }
}
