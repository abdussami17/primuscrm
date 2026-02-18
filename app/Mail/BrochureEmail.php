<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BrochureEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Raw HTML body to send.
     *
     * @var string
     */
    public $body;

    /**
     * Email subject.
     *
     * @var string
     */
    public $subjectLine;

    /**
     * Optional recipient name (available to templates if used).
     *
     * @var string|null
     */
    public $recipientName;

    /**
     * Create a new message instance.
     *
     * @param  string  $htmlBody
     * @param  string|null  $subject
     * @param  string|null  $recipientName
     * @return void
     */
    public function __construct(string $htmlBody, ?string $subject = null, ?string $recipientName = null)
    {
        $this->body = $htmlBody;
        $this->subjectLine = $subject ?? 'Message from our team';
        $this->recipientName = $recipientName;
    }

    /**
     * Build the message.
     *
     * We send the provided HTML as the message body directly.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.wrapper', [
                        'body' => $this->body,
                        'emailConf' => \App\Models\EmailConfiguration::first()
                    ]);
    }
}