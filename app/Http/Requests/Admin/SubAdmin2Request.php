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

class SubAdmin2Request extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'      => ['required', 'min:2', 'max:20'],
            'name'      => ['required', 'min:2', 'max:255'],
            'asciiname' => ['required', 'min:2', 'max:255'],
        ];
    }
}
