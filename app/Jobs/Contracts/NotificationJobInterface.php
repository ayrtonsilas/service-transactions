<?php

namespace App\Jobs\Contracts;

interface NotificationJobInterface
{
    
    public function handle();
    public static function dispatch();
}
