<?php

namespace App\Http\Controllers\TwoCheckout;

use App\Http\Controllers\Controller;
use Input;


class RecurringController extends Controller
{
    
    public function success()
    {
        dr(Input::all());
    } // end success
    
    public function failed()
    {
        dr(Input::all());
    } // end failed
    
    public function stopped()
    {
        dr(Input::all());
    } // end stopped
    
    public function complete()
    {
        dr(Input::all());
    } // end complete
    
    public function restarted()
    {
        dr(Input::all());
    } // end restarted
    
}