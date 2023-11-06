<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class BuilderSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('builder.builder_json', []);
        $this->migrator->add('builder.builder_form', []);
        $this->migrator->add('builder.builder_table', []);
        $this->migrator->add('builder.builder_plugins', []);
        $this->migrator->add('builder.builder_settings', []);
        $this->migrator->add('builder.builder_module', "");
        $this->migrator->add('builder.builder_app_name', "");
    }
}
