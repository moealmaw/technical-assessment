<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class OfferSearchRequest
 *
 * @package App\Http\Requests
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class OfferSearchRequest extends FormRequest
{
    /**
     * The request/url params the request can handle and/or read data from
     *
     * @var array
     */
    protected $params = [
        "trip_date",
        "flexibility",
        "destination_name",
        "length_of_stay",
        "max_star_rating",
        "min_star_rating",
        "max_total_rate",
        "min_total_rate",
        "max_guest_rating",
        "min_guest_rating",
    ];

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge($this->all($this->params));
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trip_date'      => sprintf('nullable|after_or_equal:%s', Carbon::now()->toDateString()),
            'flexibility'    => ['nullable', Rule::in([0, 3, 5, 7])],
            'length_of_stay' => ['nullable', 'integer', 'max:29'],
        ];
    }
}
