<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class VerificationEmail extends Mailable
{
    public $verificationLink, $displayName;

    public function __construct($verificationLink, $displayName)
    {
        $this->verificationLink = $verificationLink;
        $this->displayName = $displayName;
    }

    public function build()
    {
        $logoUrl = asset('logo/logo.png'); // Generates the public URL for the logo
        return $this->subject('Please Verify Your Email Address')
                    ->view('emails.verify')
                    ->with([
                        'verificationLink' => $this->verificationLink,
                        'displayName' => $this->displayName,
                        'logoUrl' => $logoUrl,
                    ]);
    }
    
}
