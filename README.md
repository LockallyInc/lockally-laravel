# Lockally for Laravel

Official Lockally mail driver for Laravel. Send transactional email through
[Lockally](https://lockally.com) using Laravel's native `Mail` — mailables,
notifications, and queued mail all work unchanged.

## Install

```bash
composer require lockally/laravel
```

The service provider is auto-discovered. Publish the config (optional):

```bash
php artisan vendor:publish --tag=lockally-config
```

## Configure

Set your API key:

```dotenv
LOCKALLY_API_KEY=lk_live_xxx        # lk_test_xxx runs in sandbox (no real send)
MAIL_MAILER=lockally
```

Add the mailer in `config/mail.php`:

```php
'mailers' => [
    'lockally' => ['transport' => 'lockally'],
],
```

## Use

Nothing else changes — use Laravel's `Mail` as usual:

```php
use Illuminate\Support\Facades\Mail;

Mail::mailer('lockally')->raw('Your code is 847291.', function ($m) {
    $m->from('alerts@yourdomain.com')
      ->to('user@example.com')
      ->subject('Your OTP code');
});
```

Mailables, `Notification` mail channel, and queued mail route through Lockally
automatically once `MAIL_MAILER=lockally`.

## Notes

- **Reply-To** is delivered via the message headers (Lockally has no separate
  `reply_to` field).
- **Attachments** are sent inline as base64 (10 MB per attachment). Inline/CID
  images are sent as regular attachments.
- Each send carries a generated `Idempotency-Key`.

Built on the official [`lockally/sdk`](https://packagist.org/packages/lockally/sdk)
PHP client.

## License

MIT
