<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up() : void
    {
        $this->migrator->add('footer.copyright', '© ' . date('Y') . ' My Company. All rights reserved.');
        $this->migrator->add('footer.show_copyright', true);
        $this->migrator->add('footer.links', [
            [
                'url' => 'https://example.com/terms',
                'label' => 'terms',
            ],
            [
                'url' => 'https://example.com/privacy',
                'label' => 'privacy',
            ],
        ]);
        $this->migrator->add('footer.social_links', [
            [
                'name' => 'twitter',
                'icon' => 'twitter',
                'url' => 'https://twitter.com',
            ],
            [
                'name' => 'facebook',
                'icon' => 'facebook',
                'url' => 'https://facebook.com',
            ],
            [
                'name' => 'instagram',
                'icon' => 'instagram',
                'url' => 'https://instagram.com',
            ],
            [
                'name' => 'linkedin',
                'icon' => 'linkedin',
                'url' => 'https://linkedin.com',
            ],
            [
                'name' => 'youtube',
                'icon' => 'youtube',
                'url' => 'https://youtube.com',
            ],
            [
                'name' => 'github',
                'icon' => 'github',
                'url' => 'https://github.com',
            ],
        ]);
    }
};
