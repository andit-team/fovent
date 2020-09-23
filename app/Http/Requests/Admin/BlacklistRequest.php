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

use Illuminate\Validation\Rule;

class BlacklistRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'entry' => Rule::unique('blacklist')->where(function ($query) {
				return $query->where('type', $this->type)->where('entry', $this->entry);
			})
        ];
    }
}
