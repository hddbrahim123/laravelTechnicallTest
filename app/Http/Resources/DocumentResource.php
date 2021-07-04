<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return[
            'id'=>$this->id,
            'Title'=>$this->Title,
            'subtitle'=>$this->subtitle,
            'summary'=>$this->summary,
            'keywords'=>$this->keywords,
            'file'=>new FileResource($this->file),
            'user_id'=>$this->user_id,
            'created_at'=>$this->created_at->format('d/m/y'),
        ];
    }
}
