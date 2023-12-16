<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up() : void
    {
        $this->migrator->add('general.site_name', 'Laravel');
        $this->migrator->add('general.site_description', 'This is a description of the site.');
        $this->migrator->add('general.site_keywords', []);
        $this->migrator->add('general.time_zone', 'UTC');
        $this->migrator->add('general.datetime_format', 'Y-m-d H:i:s');
        $this->migrator->add('general.display_cookie_notification_bar', true);
        $this->migrator->add('general.site_active', true);
    }
};
