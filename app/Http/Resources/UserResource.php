<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'full_name' => $this->full_name,
            'email' => $this->email,
            'role' => new RoleResource($this->role),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'stats' => $this->stats,
            'socialLinks' => SocialLinkResource::collection($this->whenLoaded('socialLinks')),
            'leadProjects' => AuditProjectResource::collection($this->whenLoaded('leadProjects')),
            'nonLeadProjects' => AuditProjectResource::collection($this->whenLoaded('nonLeadProjects')),
        ];
    }
}
