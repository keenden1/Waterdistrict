<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class Notification_Message extends Mailable
{
    public $verificationLink, $displayName;

    public function __construct( $displayName)
    {
        $this->displayName = $displayName;
    }

    public function build()
    {
        return $this->subject('Application For Leave Credit')
                    ->view('emails.notification')
                    ->with([
                        'displayName' => $this->displayName,
                    ]);
    }
}
