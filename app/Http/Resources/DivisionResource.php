<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) // Perbaikan: Menghapus return type hint ": array"
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
