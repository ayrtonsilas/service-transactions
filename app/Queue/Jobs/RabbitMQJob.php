<?php

namespace App\Queue\Jobs;

use App\Jobs\NotificationJob;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob as BaseJob;

class RabbitMQJob extends BaseJob
{

    /**
     * Fire the job.
     *
     * @return void
     */
    public function fire()
    {
        $payload = $this->payload();

        $class = NotificationJob::class;
        $method = 'handle';

        ($this->instance = $this->resolve($class))->{$method}($this, $payload);
    }
}