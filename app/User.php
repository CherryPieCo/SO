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
    
}
