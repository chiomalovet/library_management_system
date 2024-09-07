<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'isbn' => $this->isbn,
            'published_date' => $this->published_date,
            'author_id' => $this->author_id,
            'status' => $this->status,
            'created_at' => $this->created_at,

        ];
    }
}
