<?php

namespace App\Models;

use App\Settings\GeneralSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class BaseModel extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected function serializeDate(\DateTimeInterface $date)
    {
        if (app()->runningInConsole()) {
            // In console mode (php artisan), we can use a different format or disable it altogether
            return $date->format('Y-m-d H:i:s');
        }

        $this->setDateFormatFromSettings();

        return $date->format($this->dateFormat);

    }

    protected function setDateFormatFromSettings() : void
    {
        try {
            $settings = app(GeneralSettings::class);

            // Replace 'datetime_format' with the key you use to store the date format
            $this->dateFormat = $settings->datetime_format ?? 'j M Y G:i';

        } catch (\Exception $e) {

            // You can ignore this or handle it as you need.
        }
    }
}
