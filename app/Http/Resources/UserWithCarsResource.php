<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserWithCarsResource extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->name,
            'surname'=>$this->surname,
            'apartment_no'=>$this->apartment_no,
           // 'categories'=>CarResource::collection($this->cars)
            'cars'=>CarResource::collection($this->whenLoaded('cars')) //  $data=User::with('cars')->paginate(5); with ile verilmisse bu metot kullanılır.

        ];
    }
}
