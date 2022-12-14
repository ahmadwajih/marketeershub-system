<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $id
 * @property $offer_id
 * @property $type
 * @property $status
 * @property mixed $team
 * @property mixed $column
 */
final class Request extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
