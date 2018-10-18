<?php

namespace App\Jobs;

use App\User;
use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewMessageReminderEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $message, $username;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $message, $username)
    {
        $this->user = $user;
        $this->message = $message;
        $this->username = $username;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailer->send('emails.newMessageReminder', ['user' => $this->username, 'userMessage' => $this->message], function ($m) {
            $m->to($this->user['email'])->subject('New message from ' . $this->username);
        });
    }
}
