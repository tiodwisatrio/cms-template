<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class MailConfigService
{
    public static function setMailConfig()
    {
        $settings = Setting::getByGroup('email');

        if ($settings->isEmpty()) {
            return;
        }

        // Set default mailer to smtp
        Config::set('mail.default', 'smtp');

        // Set mail configuration dynamically
        Config::set('mail.mailers.smtp.host', $settings->get('smtp_host', env('MAIL_HOST')));
        Config::set('mail.mailers.smtp.port', $settings->get('smtp_port', env('MAIL_PORT')));
        Config::set('mail.mailers.smtp.username', $settings->get('smtp_username', env('MAIL_USERNAME')));
        Config::set('mail.mailers.smtp.password', $settings->get('smtp_password', env('MAIL_PASSWORD')));
        Config::set('mail.mailers.smtp.encryption', $settings->get('smtp_encryption', env('MAIL_ENCRYPTION')));
        Config::set('mail.from.address', $settings->get('mail_from_address', env('MAIL_FROM_ADDRESS')));
        Config::set('mail.from.name', $settings->get('mail_from_name', env('MAIL_FROM_NAME')));
    }
}
