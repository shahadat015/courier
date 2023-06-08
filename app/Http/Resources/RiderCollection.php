<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RiderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "data" => $this->collection->transform(function($rider){
                return [
                    'id' => $rider->id,
                    'name' => $rider->name,
                    'contact' => $rider->phone,
                    'action' => ['show', 'assign']
                ];
            }),
            "columns" => [
                [
                    'label' => 'ID',
                    'name' => 'id'
                ],
                [
                    'label' => 'Rider Name',
                    'name' => 'name'
                ],
                [
                    'label' => 'Contact',
                    'name' => 'contact'
                ],
                [
                    'label' => 'Action',
                    'name' => 'action'
                ],
            ]
        ];
    }
}
