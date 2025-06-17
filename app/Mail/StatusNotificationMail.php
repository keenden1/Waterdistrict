<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $status, $reason;

    public function __construct($name, $status, $reason = null)
    {
        $this->name = $name;
        $this->status = $status;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Status Update Notification')
                    ->view('emails.status_notification')
                    ->with([
                        'name' => $this->name,
                        'status' => $this->status,
                        'reason' => $this->reason,
                    ]);
    }
}
