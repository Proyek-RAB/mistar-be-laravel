<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $successMessage = $this->successMessage ?? 'User created successfully';

        return [
            'success' => true,
            'message' => $successMessage,
            'data' => [
                'full_name' => $this->full_name,
                'email' => $this->email,
                'zip_code' => $this->zip_code,
                'role' => $this->role,
                // Add other properties as needed
            ],
        ];
    }

    /**
     * Additional method to handle error response.
     *
     * @param string $errorMessage
     * @return array
     */
    public static function errorResponse($errorMessage)
    {
        return [
            'success' => false,
            'message' => $errorMessage,
            'data' => [],
        ];
    }
}
