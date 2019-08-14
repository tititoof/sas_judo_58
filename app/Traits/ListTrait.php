<?php
namespace App\Traits;
trait ListTrait
{
    
    
    /**
     * Return array
     * 
     */
     public function mapList($information)
     {
         return [ 'label' => $information->name, 'value' => $information->id ];
     }
}