<?php

namespace App\Http\Controllers;

use Jarboe;


class TableAdminController extends \App\Http\Controllers\Controller
{
    
    public function settings()
    {
        $options = array(
            'url'      => '/admin/settings',
            'def_name' => 'settings',
        );
        return Jarboe::table($options);
    } // end settings
    
    public function showPacks()
    {
        $options = array(
            'def_name' => 'packs',
        );
        return Jarboe::table($options);
    } // end showPacks
    
    public function showLinks()
    {
        $options = array(
            'def_name' => 'links',
        );
        return Jarboe::table($options);
    } // end showLinks
    
    public function showMozapiAccounts()
    {
        $options = array(
            'def_name' => 'mozapi_accounts',
        );
        return Jarboe::table($options);
    } // end showshowMozapiAccounts
        
}

