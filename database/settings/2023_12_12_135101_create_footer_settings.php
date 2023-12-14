<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('footer.copyright', '© '.date('Y').' My Company. All rights reserved.');
        $this->migrator->add('footer.show_copyright', true);
        $this->migrator->add('footer.links', []);
        $this->migrator->add('footer.social_links', []);
    }
};
