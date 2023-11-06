<?php

namespace TomatoPHP\TomatoBuilder\Settings;

use Spatie\LaravelSettings\Settings;

class BuilderSettings extends Settings
{
    public mixed $builder_json;
    public mixed $builder_form;
    public mixed $builder_table;
    public mixed $builder_plugins;
    public mixed $builder_settings;
    public string $builder_module;
    public string $builder_app_name;

    public static function group(): string
    {
        return 'builder';
    }
}
