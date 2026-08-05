<?php

declare(strict_types=1);

namespace Lockally\Laravel;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Lockally\SDK\Api\SendApi;
use Lockally\SDK\Configuration;

final class LockallyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/lockally.php', 'lockally');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/lockally.php' => $this->app->configPath('lockally.php'),
        ], 'lockally-config');

        // Register the `lockally` mail transport. Point a mailer at it in
        // config/mail.php:  'lockally' => ['transport' => 'lockally'],
        // then set MAIL_MAILER=lockally (or Mail::mailer('lockally')).
        Mail::extend('lockally', function (array $config = []) {
            $apiKey = $config['api_key'] ?? config('lockally.api_key');
            $baseUrl = $config['base_url'] ?? config('lockally.base_url');

            $cfg = Configuration::getDefaultConfiguration()->setAccessToken((string) $apiKey);
            if ($baseUrl) {
                $cfg->setHost(rtrim((string) $baseUrl, '/'));
            }

            return new LockallyTransport(new SendApi(new GuzzleClient(), $cfg));
        });
    }
}
