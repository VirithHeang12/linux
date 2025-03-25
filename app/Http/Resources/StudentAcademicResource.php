<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;

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
            'start_date'        => Date::make($this->itClassGenerationAcademic?->academic?->start_date)->format('d M Y'),
            'end_date'          => Date::make($this->itClassGenerationAcademic?->academic?->end_date)->format('d M Y'),
            'room_no'           => $this->itClassGenerationAcademic?->room_no,
            'class'             => $this->itClassGenerationAcademic?->itClassGeneration?->itClass?->name,
            'generation'        => $this->itClassGenerationAcademic?->itClassGeneration?->generation?->name,
        ];
    }
}
