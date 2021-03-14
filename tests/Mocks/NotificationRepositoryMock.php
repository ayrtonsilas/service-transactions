<?php
namespace Tests\Mocks;

use App\Models\Notification;
use App\Models\Transaction;
use App\Repositories\Contracts\NotificationRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class NotificationRepositoryMock implements NotificationRepositoryInterface
{
    const MOCK = [
        'status' => 'pending',
        'reference_type' => 'transaction',
        'reference_value' => 1,
        'message' => '{}',
    ];

    public function getAllNotifications(){
        
    }

    public function getNotificationById(int $id){

    }

    public function createNotification(array $notification){
        $notificationInstance = new Notification();
        $notificationInstance->id = 1;
        return $notificationInstance;
    }

    public function updateNotification(object $notification, array $notificationData){

    }
}