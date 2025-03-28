<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'student_id'        => $this->student_id,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'gender'            => $this->gender,
            'date_of_birth'     => $this->date_of_birth,
            'address'           => $this->address,
            'academics'         => StudentAcademicResource::collection($this->whenLoaded('itClassGenerationAcademicStudents')),
            'image'             => new ImageResource($this->image),
        ];
    }
}
