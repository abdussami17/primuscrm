<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaign;

class CampaignMail extends Mailable
{
    use SerializesModels;

    public $campaign;
    public $recipientName;

    public function __construct(Campaign $campaign, $recipientName = null)
    {
        $this->campaign = $campaign;
        $this->recipientName = $recipientName;
    }

    public function build()
    {
        $subject = $this->campaign->subject ?: 'Message from our team';
        // Use raw html body so UI remains unchanged; campaign body is expected to be HTML
        // wrap body with configured header/footer via a blade wrapper
        return $this->subject($subject)
                    ->view('emails.wrapper', [
                        'body' => $this->campaign->body ?? '',
                        'emailConf' => \App\Models\EmailConfiguration::first()
                    ]);
    }
}
