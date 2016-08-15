<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Settings;
use Mail;


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
        $this->error  = print_r($response, true);
        $this->status = 'error';
        $this->save();
        
        Mail::send('emails.moz_error', ['moz' => $this->toArray()], function($m) {
            $emails = array_map(
                'trim', 
                explode(',', Settings::get('moz_notify_error_emails'))
            );
            $m->to($emails)->subject('MOZ account problem');
        });
    } // end addError
    
}


