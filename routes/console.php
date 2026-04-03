<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('send-mail', function () {
    \Illuminate\Support\Facades\Mail::raw('Congrats! The native Laravel to Mailtrap connection works perfectly!', function ($message) {
        $message->to('john.dogmoc@urios.edu.ph')
                ->subject('You are awesome!');
    });

    $this->info('Test email successfully dispatched to Mailtrap!');
})->purpose('Send Mail');
