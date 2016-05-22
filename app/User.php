<?php

namespace App;

use Jarboe\Component\Users\Model\User as JarboeUser;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use App\Models\RequestLog;
use App\Models\Pack;
use Carbon\Carbon;
use Log;
use Mail;


class User extends JarboeUser implements AuthenticatableContract
{
    use Authenticatable;

    public function getFullname()
    {
        return $this->first_name .' '. $this->last_name;
    } // end getFullname
    
    public function mailchimpSubscribe()
    {
        try {
            app('Mailchimp')->lists->subscribe(
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
        if (!$this->isSubscriptionActive()) {
            return false;
        }
        if ($this->isFreeType() && $this->getTotalBulksCount() >= 50) {
            return false;
        }
        if (!$this->isRequestsAvailable() || $this->getCurrentActiveBulksCount() > 2) {
            return false;
        }
        
        // TODO:
        switch ($campaign) {
            case 'emails':
                
                break;
            case 'not_found':
                if ($this->isStarterType()) {
                    return false;
                }
                break;
            case 'backlinks':
                if ($this->isStarterType()) {
                    return false;
                }
                break;
            
            default:
                throw new \RuntimeException(sprintf('Unknown campaign: [%s]', $campaign));
        }
        
        return true;
    } // end isCampaignAllowed
    
    public function sendResetPasswordMail()
    {
        $this->confirmation_code = str_random(64);
        $this->save();
        
        $user = $this;
        
        Mail::send('emails.reset_password', ['user' => $user], function($message) use($user) {
            $message->to($user->email, $user->getFullname());
            $message->subject('Password Recover Confirmation');
        });
    } // end sendResetPasswordMail
    
    public function isSubscriptionActive()
    {
        if ($this->type == 'free') {
            return (bool) $this->getTrialDaysLeftCount();
        }
        
        $subscriptionDate = new Carbon($this->last_subscription_at);
        $monthAgoDate = Carbon::now()->subMonth();
        
        return $monthAgoDate->lte($subscriptionDate);
    } // end isSubscriptionActive
    
    public function getTrialDaysLeftCount()
    {
        $created = new Carbon($this->created_at);
        $now = Carbon::now();
        
        $days = $created->diff($now)->days;
        if ($days > 14) {
            return 0;
        }
        return $days;
    } // end getTrialDaysLeftCount
    
    public function getCurrentActiveBulksCount()
    {
        return Pack::byUser()->where('status', '!=', 'complete')->count();
    } // end getCurrentActiveBulksCount
    
    public function getTotalBulksCount()
    {
        return Pack::byUser()->count();
    } // end getTotalBulksCount
    
    public function getMaximumRequests()
    {
        switch ($this->type) {
            case 'free':
                return 150;
                
            case 'starter':
                return 3000;
                
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
    
    public function isStarterType()
    {
        return $this->type == 'starter';
    } // end isStarterType
    
    public function isFreeType()
    {
        return $this->type == 'free';
    } // end isFreeType
    
}
