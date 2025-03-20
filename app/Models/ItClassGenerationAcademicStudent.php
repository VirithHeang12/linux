<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItClassGenerationAcademicStudent extends Model
{
    /** @use HasFactory<\Database\Factories\ItClassGenerationAcademicStudentFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'it_class_generation_academic_students';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'it_class_generation_academic_id',
        'student_id',
    ];

    /**
     * Get the it class generation academic that owns the it class generation academic student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function itClassGenerationAcademic(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ItClassGenerationAcademic::class);
    }

    /**
     * Get the student that owns the it class generation academic student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
