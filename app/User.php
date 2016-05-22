<?php

namespace App;

use Jarboe\Component\Users\Model\User as JarboeUser;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use App\Models\RequestLog;
use App\Models\Pack;
use Carbon\Carbon;
use Log;


class User extends JarboeUser implements AuthenticatableContract
{
    use Authenticatable;

    public function getFullname()
    {
        return $this->first_name .' '. $this->last_name;
    } // end getFullname
    
    public function mailchimpSubscribe(\Mailchimp $mailchimp)
    {
        try {
            $mailchimp->lists->subscribe(
                '25a788b707',
                ['email' => $this->email]
            );
        } catch (\Mailchimp_List_AlreadySubscribed $e) {
            // 
        } catch (\Mailchimp_Error $e) {
            Log::error($e);
        }
    } // end mailchimpSubscribe
    
    public function isCampaignAllowed($campaign)
    {
        if (!$this->isRequestsAvailable() || $this->countCurrentActiveBulks() > 2) {
            return false;
        }
        
        // TODO:
        switch ($campaign) {
            case 'emails':
                
                break;
            case 'not_found':
                
                break;
            case 'backlinks':
                
                break;
            
            default:
                throw new \RuntimeException(sprintf('Unknown campaign: [%s]', $campaign));
        }
        
        return true;
    } // end isCampaignAllowed
    
    public function countCurrentActiveBulks()
    {
        return Pack::byUser()->where('status', '!=', 'complete')->count();
    } // end countCurrentActiveBulks
    
    public function getMaximumRequests()
    {
        switch ($this->type) {
            case 'free':
                return 150;
                
            case 'starter':
                return 2000;
                
            case 'pro':
                return PHP_INT_MAX; // unlimited
            
            default:
                throw new \RuntimeException('Unknown user subscription type: '. $this->type);
        }
    } // end getMaximumRequests
    
    public function isRequestsAvailable()
    {
        return $this->getCurrentRequests() < $this->getMaximumRequests();
    } // end isRequestsAvailable
    
    public function getCurrentRequests()
    {
        return RequestLog::byUser($this->id)->whereBetween('logged_at', [
            Carbon::now()->subMonth(),
            Carbon::now(),
        ])->count();
    } // end getCurrentRequests
    
    public function logRequest($type)
    {
        RequestLog::insert([
            'type' => $type,
            'id_user' => $this->id,
            'logged_at' => Carbon::now(), 
        ]);
    } // end logRequest
    
    public function isProType()
    {
        return $this->type == 'pro';
    } // end isProType
    
}
