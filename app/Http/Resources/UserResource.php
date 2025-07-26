<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public $status;
    public $massages;
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function __construct($status, $massages, $resource)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->massages = $massages;
        $this->resource = $resource;
    }
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'massages' => $this->massages,
            'data' => $this->resource,              
        ];
    }
}
