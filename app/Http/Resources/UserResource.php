<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property User $resource
 */
class UserResource extends JsonResource
{
    public function __construct(User $resource)
    {
        parent::__construct($resource);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->resource->uuid,
            'first_name' => $this->resource->first_name,
            'last_name'  => $this->resource->last_name,
            'email'      => $this->resource->email,
        ];
    }
}
