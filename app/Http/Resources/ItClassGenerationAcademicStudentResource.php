<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItClassGenerationAcademicStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->student?->student_id,
            'first_name'       => $this->student?->first_name,
            'last_name'   => $this->student?->last_name,
            'date_of_birth' => $this->student?->date_of_birth,
            'email'   => $this->student?->email,
        ];
    }
}
