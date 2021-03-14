<?php

namespace App\Services\Contracts;

interface NotificationServiceInterface
{
    public function getNotificationById(int $id);
    public function makeNotification(array $notificationData);
    public function updateNotification(int $id, string $status);
}
