<?php
namespace Tests\Mocks;

use App\Jobs\Contracts\NotificationJobInterface;

class NotificationJobMock implements NotificationJobInterface
{
    public function handle(){}

    public static function dispatch(){
        return new NotificationJobMock();
    }

    public function afterCommit(){
        
    }
}