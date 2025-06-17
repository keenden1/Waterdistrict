<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class Notification_Message extends Mailable
{
    public $displayName;
    public $type;
    public $startDate;
    public $endDate;

    public function __construct($displayName, $type, $startDate, $endDate)
    {
        $this->displayName = $displayName;
        $this->type = $type;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function build()
    {
        return $this->subject('Application For Leave Credit')
                    ->view('emails.notification')
                    ->with([
                        'displayName' => $this->displayName,
                        'type' => $this->type,
                        'startDate' => $this->startDate,
                        'endDate' => $this->endDate,
                    ]);
    }
}
