<?php

namespace App;

use Jarboe\Component\Users\Model\User as JarboeUser;


class User extends JarboeUser
{

    public function getFullame()
    {
        return $this->first_name .' '. $this->last_name;
    } // end getFullame
    
}
