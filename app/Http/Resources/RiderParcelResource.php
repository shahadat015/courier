<?php

namespace App\Http\Resources;

use App\Http\Resources\RiderResource;
use App\Http\Resources\ParcelCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class RiderParcelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $parcels = request('page') ? $this->parcels()->whereIn('status', ['Assigned', 'Pending'])->get() : $this->parcels;
        
        return [
            'total_parcel' => $this->total_parcel,
            'assigned_date' => $this->created_at,
            'rider' => new RiderResource($this->rider),
            'parcels' => ParcelResource::collection($parcels),
        ];
    }
}
