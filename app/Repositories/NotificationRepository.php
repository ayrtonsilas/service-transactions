<?php

namespace App\Repositories;

use App\Repositories\Contracts\NotificationRepositoryInterface;
use App\Models\Notification;


class NotificationRepository implements NotificationRepositoryInterface
{

    protected $entity;

    public function __construct(Notification $notification)
    {
        $this->entity = $notification;
    }

    /**
     * Get all Notifications
     * @return array
     */
    public function getAllNotifications()
    {
        return $this->entity->paginate();
    }

    /**
     * Get Notification by ID
     * @param int $id
     * @return object
     */
    public function getNotificationById(int $id)
    {
        return $this->entity->find($id);
    }

    /**
     * Create new Notification
     * @param array $notification
     * @return object
     */
    public function createNotification(array $notification)
    {
        $notification['message'] = json_encode($notification['message']);
        return $this->entity->create($notification);
    }

    /**
     * Update exists Notification
     * @param object $notification
     * @param array $NotificationData
     * @return object
     */
    public function updateNotification(object $notification, array $NotificationData)
    {
        return $notification->update($NotificationData);
    }
}
