<?php

namespace App\Http\Controllers;

use App\Models\EmailAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Mail\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;

class EmailAccountController extends Controller
{
    public function show()
    {
        $account = EmailAccount::first();
        if (! $account) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $data = [
            'smtp_host' => $account->smtp_host,
            'smtp_port' => $account->smtp_port,
            'smtp_user' => $account->smtp_user,
            'smtp_pass' => $account->smtp_pass,
            'smtp_enc' => $account->smtp_enc,
            'smtp_from' => $account->smtp_from,
        ];

        // merge any extra json data
        if (is_array($account->data)) {
            $data = array_merge($data, $account->data);
        }

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function update(Request $request)
    {
        $allowed = [
            'smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_enc', 'smtp_from',
            'host', 'port', 'username', 'password', 'encryption', 'from_name'
        ];

        $sanitized = [];
        foreach ($allowed as $k) {
            if ($request->has($k)) {
                $sanitized[$k] = $request->input($k);
            }
        }

        // prefer sanitized keys; if none provided, take all request payload
        $emailPayload = count($sanitized) ? $sanitized : $request->all();

        $account = EmailAccount::first();
        if (! $account) {
            $account = EmailAccount::create([
                'smtp_host' => $emailPayload['smtp_host'] ?? ($emailPayload['host'] ?? null),
                'smtp_port' => $emailPayload['smtp_port'] ?? ($emailPayload['port'] ?? null),
                'smtp_user' => $emailPayload['smtp_user'] ?? ($emailPayload['username'] ?? null),
                'smtp_pass' => $emailPayload['smtp_pass'] ?? ($emailPayload['password'] ?? null),
                'smtp_enc'  => $emailPayload['smtp_enc'] ?? ($emailPayload['encryption'] ?? null),
                'smtp_from' => $emailPayload['smtp_from'] ?? ($emailPayload['from_name'] ?? null),
                'data' => []
            ]);
        } else {
            $account->smtp_host = $emailPayload['smtp_host'] ?? ($emailPayload['host'] ?? $account->smtp_host);
            $account->smtp_port = $emailPayload['smtp_port'] ?? ($emailPayload['port'] ?? $account->smtp_port);
            $account->smtp_user = $emailPayload['smtp_user'] ?? ($emailPayload['username'] ?? $account->smtp_user);
            $account->smtp_pass = $emailPayload['smtp_pass'] ?? ($emailPayload['password'] ?? $account->smtp_pass);
            $account->smtp_enc  = $emailPayload['smtp_enc'] ?? ($emailPayload['encryption'] ?? $account->smtp_enc);
            $account->smtp_from = $emailPayload['smtp_from'] ?? ($emailPayload['from_name'] ?? $account->smtp_from);

            // keep any extra keys in json data
            $extra = is_array($account->data) ? $account->data : [];
            foreach ($emailPayload as $k => $v) {
                if (! in_array($k, ['smtp_host','smtp_port','smtp_user','smtp_pass','smtp_enc','smtp_from'])) {
                    $extra[$k] = $v;
                }
            }
            $account->data = $extra;
            $account->save();
        }

        // Persist SMTP settings into environment file so they apply across requests.
        try {
            $this->setEnvValue('MAIL_MAILER', 'smtp');
            $this->setEnvValue('MAIL_HOST', $account->smtp_host);
            $this->setEnvValue('MAIL_PORT', $account->smtp_port);
            $this->setEnvValue('MAIL_USERNAME', $account->smtp_user);
            // strip spaces from stored app-passwords (users sometimes copy with spaces)
            $this->setEnvValue('MAIL_PASSWORD', str_replace(' ', '', $account->smtp_pass));
            $this->setEnvValue('MAIL_ENCRYPTION', strtolower($account->smtp_enc));
            $this->setEnvValue('MAIL_FROM_ADDRESS', $account->smtp_user);
            $this->setEnvValue('MAIL_FROM_NAME', $account->smtp_from ?? config('mail.from.name'));

            // Clear config cache so new env values take effect on subsequent requests
            try {
                Artisan::call('config:clear');
            } catch (\Throwable $e) {
                logger()->warning('Failed to call config:clear after writing .env', ['err' => $e->getMessage()]);
            }
        } catch (\Throwable $e) {
            logger()->error('Failed to persist SMTP settings to .env', ['err' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'data' => [
            'smtp_host'=>$account->smtp_host,
            'smtp_port'=>$account->smtp_port,
            'smtp_user'=>$account->smtp_user,
            'smtp_pass'=>$account->smtp_pass,
            'smtp_enc'=>$account->smtp_enc,
            'smtp_from'=>$account->smtp_from,
        ]]);
    }

    /**
     * Helper to set or append an environment value in the .env file.
     */
    protected function setEnvValue(string $key, $value): bool
    {
        $envPath = base_path('.env');
        if (! file_exists($envPath) || ! is_writable($envPath)) {
            logger()->warning('.env file missing or not writable', ['path' => $envPath]);
            return false;
        }

        $escaped = str_replace('"', '\\"', (string) $value);
        $line = $key . '="' . $escaped . '"';

        $contents = file_get_contents($envPath);
        if (preg_match('/^' . preg_quote($key, '/') . '=.*/m', $contents)) {
            $contents = preg_replace('/^' . preg_quote($key, '/') . '=.*/m', $line, $contents);
        } else {
            $contents = rtrim($contents, "\n") . "\n" . $line . "\n";
        }

        try {
            file_put_contents($envPath, $contents, LOCK_EX);
            return true;
        } catch (\Throwable $e) {
            logger()->error('Failed writing .env file', ['err' => $e->getMessage()]);
            return false;
        }
    }

    public function test(Request $request)
    {
        $account = EmailAccount::first();
        if (! $account) {
            return response()->json(['success' => false, 'message' => 'No email account configured'], 422);
        }

        // $to = $request->input('to') ?: (Auth::check() ? Auth::user()->email : null);
        $to = 'yousiftheking2001@gmail.com';
        if (! $to) {
            return response()->json(['success' => false, 'message' => 'No recipient specified'], 422);
        }

        // Temporarily configure mailer
        config(['mail.mailers.smtp.host' => $account->smtp_host]);
        config(['mail.mailers.smtp.port' => $account->smtp_port]);
        config(['mail.mailers.smtp.encryption' => $account->smtp_enc]);
        config(['mail.mailers.smtp.username' => $account->smtp_user]);
        config(['mail.mailers.smtp.password' => $account->smtp_pass]);
        config(['mail.from.address' => $account->smtp_user ?? config('mail.from.address')]);
        config(['mail.from.name' => $account->smtp_from ?? config('mail.from.name')]);

        // dd([
        //     'mail.mailers.smtp.host' => config('mail.mailers.smtp.host'),
        //     'mail.mailers.smtp.port' => config('mail.mailers.smtp.port'),
        //     'mail.mailers.smtp.encryption' => config('mail.mailers.smtp.encryption'),
        //     'mail.mailers.smtp.username' => config('mail.mailers.smtp.username'),
        //     'mail.mailers.smtp.password' => config('mail.mailers.smtp.password'),
        //     'mail.from.address' => config('mail.from.address'),
        //     'mail.from.name' => config('mail.from.name'),
        // ]);

        try {
            Mail::raw('This is a test email from Primus CRM. If you received this, SMTP is configured correctly.', function ($message) use ($to) {
                $message->to($to)->subject('Primus CRM SMTP Test');
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

        return response()->json(['success' => true, 'message' => 'Test email sent to ' . $to]);
    }
}
