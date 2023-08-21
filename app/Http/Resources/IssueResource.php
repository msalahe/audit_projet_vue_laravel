<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IssueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'attack_scenario' => $this->attack_scenario,
            'recommendation' => $this->recommendation,
            'likelihood' => $this->likelihood,
            'impact' => $this->impact,
            'severity' => $this->whenAppended('severity'),
            //'category' => new CategoryResource($this->whenLoaded('category'))
            'category' => new CategoryResource($this->category)
        ];
    }
}
