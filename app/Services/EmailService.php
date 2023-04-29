<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Models\Employee;
use App\Services\EmailService;

class EmailService
{
    public static function sendValidateProfileEmail(Employee $employee, $url)
    {
        Mail::send('emails.validate-profile', ['employee' => $employee, 'url' => $url], function ($message) use ($employee) {
            $message->to($employee->email);
            $message->subject('Validate your profile');
        });
    }
}