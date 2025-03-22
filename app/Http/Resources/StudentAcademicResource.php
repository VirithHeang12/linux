<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentAcademicResource extends JsonResource
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
            'year'              => $this->itClassGenerationAcademic?->academic?->year,
            'start_date'        => $this->itClassGenerationAcademic?->academic?->start_date,
            'end_date'          => $this->itClassGenerationAcademic?->academic?->end_date,
            'room_no'           => $this->itClassGenerationAcademic?->room_no,
            'class'             => $this->itClassGenerationAcademic?->itClassGeneration?->class?->name,
            'generation'        => $this->itClassGenerationAcademic?->itClassGeneration?->generation?->name,
        ];
    }
}
