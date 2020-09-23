<?php
/**
 * Laravel Classified
 *  All Rights Reserved
 *
 * 
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice
 * 
 */

namespace App\Http\Requests\Admin;

class TimeZoneRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country_code' => ['required'],
            'time_zone_id' => ['required'],
            'gmt'          => ['required'],
            'dst'          => ['required'],
        ];
    }
}
