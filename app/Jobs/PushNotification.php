<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $firebaseToken;
    private $body;
    private $title;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($firebaseToken,$body,$title)
    {

        $this->firebaseToken=$firebaseToken;
        $this->body=$body;
        $this->title=$title;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $SERVER_API_KEY = 'AAAAt7BVyrM:APA91bEsKXBsy0l7FNDs8t073Qfk2pxGvUBAHbdx7dy2erdXjeLgnywxLUqt2Yt1UshoY6WAgon05Yz3xSPfj2fv4K7syBuhjfiAymmUFQ3xw_erN0vwpLStlVEgNroVVe9o09jwaEO0';
        $data = [
            "registration_ids" => $this->firebaseToken,
            "notification" => [
                "title" => $this->title,
                "body" => $this->body,  
            ]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);    
        $response = curl_exec($ch);
        return true;
    }
}
