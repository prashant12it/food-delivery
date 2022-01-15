<?php

namespace App\Listener;

use App\Event\BookPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Event\BookPublished  $event
     * @return void
     */
    public function handle(BookPublished $event)
    {
        $data = [
          'email'=>  $event->toEmail,
          'subject'=>  'Mail from food delivery'
        ];
        Mail::send('testmail',array('username'=>$event->receivername,'subject'=>$data['subject']),function ($message) use($data){
            $message->to($data['email'])->subject($data['subject']);
        });
    }
}
