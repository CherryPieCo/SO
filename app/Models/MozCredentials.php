<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MozCredentials extends Model
{
    
    protected $table = 'mozapi_accounts';
    public $timestamps = false;
    
    public function scopeAvailable($query)
    {
        $cooldown = 10 + 2; // +2 seconds to be sure
        
        return $query->where('last_used_at', '<', time() - $cooldown)->where('status', 'ok');
    } // end available
    
    public function markAsUsed()
    {
        $this->last_used_at = time();
        $this->save();
    } // end markAsUsed
    
    public function addError($response)
    {
        $this->error  = $response;
        $this->status = 'error';
        $this->save();
    } // end addError
    
}


