<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;

class EmailProvider extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $message,$subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $message, $subject)
    {
        $this->user = $user;
        $this->message = $message;
//        $this->message = $this->sanitiseMessage($message);
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
    public function handle(Mailer $mailer)
    {
        $mailer->send([ 'html' => 'emails.emailProvider'], ['userMessage' => $this->message], function ($m) {
            $m->to($this->user['email'])->subject($this->subject);
        });
    }
}
