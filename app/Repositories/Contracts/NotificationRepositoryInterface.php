<?php

namespace App\Repositories\Contracts;

interface NotificationRepositoryInterface
{
    public function getAllNotifications();
    public function getNotificationById(int $id);
    public function createNotification(array $notification);
    public function updateNotification(object $notification, array $notificationData);
}