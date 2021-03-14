<?php

namespace App\Jobs;

use App\Jobs\Contracts\NotificationJobInterface;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class NotificationJob implements ShouldQueue, NotificationJobInterface
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if(empty($this->data)){
                throw new \Exception("Error Processing Request");
            }
            
            $response = json_decode(Http::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04')->body(), true);

            if ($response['message'] === 'Enviado') {
                print_r($this->data);
                print_r(app(NotificationService::class)->updateNotification($this->data['id'], 'completed'));
                return true;
            }

            NotificationJob::dispatch($this->data);
        } catch (\Exception $th) {
            NotificationJob::dispatch($this->data);
            echo $th->getMessage();
        }
    }
}
