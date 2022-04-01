<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;

class NexmoSMSController extends Controller
{
    public function sendSMS()
    {
        Nexmo::message()->send([
            'to'   => '01752573621',
            'from' => '16105552344',
            'text' => 'Using the facade to send a message.'
        ]);
    }
}
