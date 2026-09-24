<?php

declare(strict_types=1);

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public ?string $site_tagline;

    public ?string $site_description;

    public ?string $contact_email;

    public ?string $contact_phone;

    public ?string $address;

    public ?string $logo;

    public ?string $logo_dark;

    public ?string $favicon;

    public ?string $og_image;

    public ?string $meta_title;

    public ?string $meta_description;

    public ?string $meta_keywords;

    public ?string $meta_author;

    public ?string $meta_robots;

    public ?string $canonical_url;

    public ?string $og_title;

    public ?string $og_description;

    public ?string $og_type;

    public ?string $google_analytics_id;

    public ?string $google_tag_manager_id;

    public ?string $facebook_pixel_id;

    public static function group(): string
    {
        return 'general';
    }
}
