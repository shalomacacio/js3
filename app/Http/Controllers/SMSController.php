<?php

namespace App\Http\Controllers;
use App\Entities\SMS;

class SMSController extends Controller
{

    protected $sms;
    
    public function __construct(SMS $sms)
    {
        $this->sms = $sms;
    }


    public function enviar(){
        $this->sms->send("Enviado via JSERVICES", "85987047679");
    }
}
