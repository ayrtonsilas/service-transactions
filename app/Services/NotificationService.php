<?php

namespace App\Services;

use App\Jobs\Contracts\NotificationJobInterface;
use App\Repositories\Contracts\NotificationRepositoryInterface;
use App\Services\Contracts\NotificationServiceInterface;

class NotificationService implements NotificationServiceInterface
{
    protected $notificationRepository;
    protected $job;

    public function __construct(NotificationRepositoryInterface $notificationRepository, NotificationJobInterface $job)
    {
        $this->notificationRepository = $notificationRepository;
        $this->job = $job;
    }

    /**
     * Get Notification by Id
     * @param int $id
     * @return array
     */
    public function getNotificationById(int $id)
    {
        try {
            $notification = $this->notificationRepository->getNotificationById($id);
            return ['status' => 200, 'result' => $notification];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

    /**
     * Create new Notification
     * @param array $notificationData
     * @return array 
     */
    public function makeNotification(array $notificationData)
    {
        try {
            $notificationData['status'] = 'pending';
            
            $notification = $this->notificationRepository->createNotification($notificationData);
            if (empty($notification->id)) {
                throw new \Exception("Notification Processing Error");
            }

            $notificationData['id'] = $notification->id;
            $this->job::dispatch($notificationData)->afterCommit();

            return ['status' => 201, 'result' => $notification];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

    /**
     * Update one Notification
     * @param int $id
     * @param float $value
     * @param string $operation debit|credit
     * @return array response
     */
    public function updateNotification(int $id, string $status)
    {
        try {
            $notification = $this->notificationRepository->getNotificationById($id);
            if (!$notification) {
                return ['status' => 404, 'errorMessage' => 'Notification Not Found'];
            }

            $this->notificationRepository->updateNotification($notification, ['status' => $status]);
            return ['status' => 200, 'errorMessage' => 'Notification Updated'];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }
}
