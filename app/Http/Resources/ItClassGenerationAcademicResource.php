<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItClassGenerationAcademicResource extends JsonResource
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
            'room'              => $this->room_no,
            'year'              => $this->academic?->year,
            'start_date'        => $this->academic?->start_date,
            'end_date'          => $this->academic?->end_date,
        ];
    }
}
