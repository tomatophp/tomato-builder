<?php

namespace TomatoPHP\TomatoBuilder\Services\Concerns;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

trait GenerateModules
{
    private function generateModule(): void
    {
        $check = \Nwidart\Modules\Facades\Module::find($this->moduleName);
        if(!$check){
            Artisan::call("module:make " . $this->moduleName);
        }
    }
}
