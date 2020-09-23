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

namespace App\Models\Traits;


trait ActiveTrait
{
    public function getActiveHtml()
    {
        if (!isset($this->active)) return false;
        
        return ajaxCheckboxDisplay($this->{$this->primaryKey}, $this->getTable(), 'active', $this->active);
    }
}