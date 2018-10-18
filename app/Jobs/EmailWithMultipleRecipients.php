<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailWithMultipleRecipients extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $emails;
    protected $message,$subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emails, $message, $subject)
    {
        $this->emails = $emails;
        $this->message = $this->sanitiseMessage($message);
        $this->subject = $subject;
    }

    private function sanitiseMessage($message){
        $list = get_html_translation_table(HTML_ENTITIES);
        unset($list['"']);
        unset($list['<']);
        unset($list['>']);
        unset($list['&']);

        $search = array_keys($list);
        $values = array_values($list);
        $search = array_map('utf8_encode', $search);
        return str_replace($search, $values, $message);

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer){
        $emails = $this->emails;
        $subject = $this->subject;
        $just_emails = array();
        foreach($emails as $email){
            array_push($just_emails,$email->email);
        }


        while(count($just_emails) > 70){

            $a = array_slice($just_emails,0,69);

            Mail::queue('emails.emailProvider', ['userMessage' => $this->message], function ($message) use ($a,$subject){
                $message->bcc($a)->subject($subject);
            });

            $just_emails = array_slice($just_emails, 70);
        }

        Mail::queue('emails.emailProvider', ['userMessage' => $this->message], function ($message) use ($just_emails,$subject){
                $message->bcc($just_emails)->subject($subject);
        });
    }
}
