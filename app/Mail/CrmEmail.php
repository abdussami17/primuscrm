<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CrmEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public string $emailBody;
    public string $messageId;
    public ?string $inReplyTo;
    public array  $ccAddresses;
    public array  $bccAddresses;
    public array  $attachmentPaths;

    public function __construct(
        string  $subject,
        string  $body,
        string  $messageId,
        ?string $inReplyTo       = null,
        array   $cc              = [],
        array   $bcc             = [],
        array   $attachmentPaths = []
    ) {
        $this->emailSubject    = $subject;
        $this->emailBody       = $body;
        $this->messageId       = $messageId;
        $this->inReplyTo       = $inReplyTo;
        $this->ccAddresses     = array_filter($cc);
        $this->bccAddresses    = array_filter($bcc);
        $this->attachmentPaths = $attachmentPaths;
    }

    public function envelope(): Envelope
    {
        $envelope = new Envelope(subject: $this->emailSubject);

        foreach ($this->ccAddresses as $addr) {
            $envelope->cc($addr);
        }
        foreach ($this->bccAddresses as $addr) {
            $envelope->bcc($addr);
        }

        return $envelope;
    }

    public function content(): Content
    {
        return new Content(view: 'emails.crm-email-template');
    }

    public function attachments(): array
    {
        $list = [];
        foreach ($this->attachmentPaths as $path) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                $list[] = \Illuminate\Mail\Mailables\Attachment::fromStorageDisk('public', $path);
            }
        }
        return $list;
    }

    /**
     * Override build to inject custom SMTP Message-ID and threading headers.
     * withSymfonyMessage gives us direct access to the underlying Symfony Email object.
     */
    public function build(): static
    {
        $msgId = '<' . $this->messageId . '>';

        $this->withSymfonyMessage(function (\Symfony\Component\Mime\Email $message) use ($msgId) {
            // Set our own Message-ID so customer replies include it in In-Reply-To
            $message->getHeaders()->remove('Message-ID');
            $message->getHeaders()->addIdHeader('Message-ID', $this->messageId);

            // CRM tracking header
            $message->getHeaders()->addTextHeader('X-CRM-Email-ID', $this->messageId);

            // Threading headers for replies
            if ($this->inReplyTo) {
                $message->getHeaders()->addTextHeader('In-Reply-To', '<' . $this->inReplyTo . '>');
                $message->getHeaders()->addTextHeader('References',  '<' . $this->inReplyTo . '>');
            }
        });

        return $this;
    }
}

