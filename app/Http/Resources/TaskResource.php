<?php

namespace App\Http\Resources;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'title' => $this->title,
            'completed' => $this->completed,
            'parent_id' => $this->parent_id,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'user' => UserResource::make($this->whenLoaded('user'))


        ];
    }
}
