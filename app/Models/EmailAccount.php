<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailAccount extends Model
{
    protected $table = 'email_accounts';

    protected $fillable = [
        'name',
        'smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_enc',
        'smtp_from', 'smtp_from_name',
        'imap_host', 'imap_port', 'imap_encryption',
        'imap_username', 'imap_password', 'imap_mailbox',
        'is_active',
        'data',
    ];

    protected $hidden = ['smtp_pass', 'imap_password'];

    protected $casts = [
        'data'      => 'array',
        'smtp_port' => 'integer',
        'imap_port' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * The active account used for sending & receiving.
     */
    public static function active(): ?self
    {
        return static::where('is_active', true)->latest()->first();
    }

    /**
     * Build a Laravel mailer config array from this account's SMTP settings.
     * Used to override the default mailer on-the-fly.
     */
    public function toSmtpConfig(): array
    {
        return [
            'transport'   => 'smtp',
            'host'        => $this->smtp_host,
            'port'        => $this->smtp_port ?? 587,
            'encryption'  => $this->smtp_enc ?? 'tls',
            'username'    => $this->smtp_user,
            'password'    => $this->smtp_pass,
            'timeout'     => 30,
        ];
    }

    /**
     * Build the IMAP DSN string for imap_open().
     * Works for Gmail, Outlook, Yahoo, custom — any IMAP-capable provider.
     */
    public function toImapDsn(string $hostOverride = null, string $mailbox = null): string
    {
        $host      = $hostOverride ?? $this->imap_host;
        $port      = $this->imap_port ?? 993;
        $enc       = strtolower($this->imap_encryption ?? 'ssl');
        $box       = $mailbox ?? $this->imap_mailbox ?? 'INBOX';

        $flags = match ($enc) {
            'ssl'  => '/imap/ssl/novalidate-cert',
            'tls'  => '/imap/tls/novalidate-cert',
            'none' => '/imap/notls',
            default=> '/imap/ssl/novalidate-cert',
        };

        return "{{$host}:{$port}{$flags}}{$box}";
    }
}

