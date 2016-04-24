<?php

namespace App;

use Jarboe\Component\Users\Model\User as JarboeUser;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;


class User extends JarboeUser implements AuthenticatableContract
{
    use Authenticatable;

    public function getFullname()
    {
        return $this->first_name .' '. $this->last_name;
    } // end getFullname
    
    public function getMaximumRequests()
    {
        switch ($this->type) {
            case 'free':
                return 150;
                
            case 'starter':
                return 1000;
                
            case 'growth':
                return 5000;
                
            case 'pro':
                return 20000;
            
            default:
                throw new \Exception('Unknown user subscription type: '. $this->type);
        }
    } // end getMaximumRequests
    
    public function getCurrentRequests()
    {
        return rand(0, 69);
    } // end getCurrentRequests
    
}
