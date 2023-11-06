<?php

namespace TomatoPHP\TomatoBuilder\Services\Concerns;

use Illuminate\Support\Str;
use TomatoPHP\TomatoForms\Models\Form;

trait GenerateController
{
    private function generateController()
    {
        $this->generateStubs(
            $this->stubPath . "controller.stub",
            $this->moduleName ? module_path($this->moduleName) ."/Http/Controllers/{$this->modelName}Controller.php" : app_path("Http/Controllers/Admin/{$this->modelName}Controller.php"),
            [
                "name" => "{$this->modelName}Controller",
                "model" => $this->moduleName ? "\\Modules\\".$this->moduleName."\\Entities\\".$this->modelName : "\\App\\Models\\".$this->modelName,
                "title" => $this->modelName,
                "table" => str_replace('_', '-', $this->tableName),
                "validation" => $this->generateRules(),
                "validationEdit" => $this->generateRules(true),
                "requestNamespace" => $this->moduleName ? "\\Modules\\".$this->moduleName."\\Http\\Requests\\{$this->modelName}\\" : "\\App\\Http\\Requests\\Admin\\{$this->modelName}\\",
                "tableClass" => $this->moduleName ? "\\Modules\\".$this->moduleName."\\Tables\\".$this->modelName."Table" : "\\App\\Tables\\".$this->modelName."Table",
                "namespace" => $this->moduleName ? "Modules\\".$this->moduleName."\\Http\\Controllers": "App\\Http\\Controllers\\Admin",
                "modulePath" => $this->moduleName ? Str::replace('_', '-', Str::lower($this->moduleName))."::" : "admin."
            ],
            [
                $this->moduleName ? module_path($this->moduleName) ."/Http/Controllers/" : app_path("Http/Controllers/Admin")
            ]
        );

        \Laravel\Prompts\info("Controller Generate Success");
    }

    private function generateControllerForRequest()
    {
        $this->generateStubs(
            $this->stubPath . "controller-request.stub",
            $this->moduleName ? module_path($this->moduleName) ."/Http/Controllers/{$this->modelName}Controller.php" : app_path("Http/Controllers/Admin/{$this->modelName}Controller.php"),
            [
                "name" => "{$this->modelName}Controller",
                "model" => $this->moduleName ? "\\Modules\\".$this->moduleName."\\Entities\\".$this->modelName : "\\App\\Models\\".$this->modelName,
                "title" => $this->modelName,
                "table" => str_replace('_', '-', $this->tableName),
                "requestNamespace" => $this->moduleName ? "\\Modules\\".$this->moduleName."\\Http\\Requests\\{$this->modelName}\\" : "\\App\\Http\\Requests\\Admin\\{$this->modelName}\\",
                "tableClass" => $this->moduleName ? "\\Modules\\".$this->moduleName."\\Tables\\".$this->modelName."Table" : "\\App\\Tables\\".$this->modelName."Table",
                "namespace" => $this->moduleName ? "Modules\\".$this->moduleName."\\Http\\Controllers": "App\\Http\\Controllers\\Admin",
                "modulePath" => $this->moduleName ? Str::replace('_', '-', Str::lower($this->moduleName))."::" : "admin."
            ],
            [
                $this->moduleName ? module_path($this->moduleName) ."/Http/Controllers/" : app_path("Http/Controllers/Admin")
            ]
        );

        \Laravel\Prompts\info("Controller Generate Success");
    }

    private function generateControllerForBuilder()
    {
        $this->generateStubs(
             "vendor/tomatophp/tomato-php/stubs/FormBuilder/BuilderController.stub",
            $this->moduleName ? module_path($this->moduleName) ."/Http/Controllers/{$this->modelName}Controller.php" : app_path("Http/Controllers/Admin/{$this->modelName}Controller.php"),
            [
                "name" => "{$this->modelName}Controller",
                "model" => $this->moduleName ? "\\Modules\\".$this->moduleName."\\Entities\\".$this->modelName : "\\App\\Models\\".$this->modelName,
                "title" => $this->modelName,
                "table" => str_replace('_', '-', $this->tableName),
                "validation" => $this->generateRules(),
                "validationEdit" => $this->generateRules(true),
                "requestNamespace" => $this->moduleName ? "\\Modules\\".$this->moduleName."\\Http\\Requests\\{$this->modelName}\\" : "\\App\\Http\\Requests\\Admin\\{$this->modelName}\\",
                "FormNamespace" => $this->moduleName ? "Modules\\".$this->moduleName."\\Forms\\{$this->modelName}Form" : "App\\Forms\\{$this->modelName}Form",
                "tableClass" => $this->moduleName ? "\\Modules\\".$this->moduleName."\\Tables\\".$this->modelName."Table" : "\\App\\Tables\\".$this->modelName."Table",
                "namespace" => $this->moduleName ? "Modules\\".$this->moduleName."\\Http\\Controllers": "App\\Http\\Controllers\\Admin",
                "modulePath" => $this->moduleName ? Str::replace('_', '-', Str::lower($this->moduleName))."::" : "admin."
            ],
            [
                $this->moduleName ? module_path($this->moduleName) ."/Http/Controllers/" : app_path("Http/Controllers/Admin")
            ]
        );

        \Laravel\Prompts\info("Controller Generate Success");
    }


    private function generateRules(bool $edit = false): string
    {
        $rules = "";
        $formCols = Form::where('key', $this->tableName)->with('fields')->first();
        $formCols = $formCols->fields;
        foreach ($formCols as $key => $item) {
            if ($item->name !== 'id') {
                if($key !== 0){
                    $rules .= "            ";
                }
                $rules .= "'{$item->name}' => ";
                $rules .= "'";
                if($item->is_required){
                    if($edit){
                        $rules .= 'sometimes';
                    }
                    else {
                        $rules .= 'required';
                    }

                }
                else {
                    $rules .= 'nullable';
                }

                if($item->validation['max']){
                    $rules .= '|max:'.$item->validation['max'];
                }
                if($item->validation['min']){
                    $rules .= '|min:'.$item->validation['min'];
                }
                if($item->validation['type'] === 'string' || $item->validation['type'] === 'email' || $item->validation['type'] === 'phone'){
                    $rules .= '|string';
                }
                if($item->validation['type'] === 'email'){
                    $rules .= '|email';
                }
                if($item->validation['type'] === 'tel'){
                    $rules .= '|min:12';
                }

                if($item->validation['type'] === 'password'){
                    $rules .= '|confirmed|min:6';
                }
                if($item->is_from_table){
                    $rules .= '|exists:'.Str::of($item->table_name)->replace('-', '_')->remove('/admin/')->remove('/api')->toString().',id';
                }

                if($item->validation['unique']){
                    if($edit){
                        $rules .= '|unique:'. $this->tableName . ',' . $item->name . ',';
                    }
                    else {
                        $rules .= '|unique:'. $this->tableName . ',' . $item->name;
                    }
                }

                $rules .= "'";

                if($item->validation['unique'] && $edit){
                    $rules .= '. $this->route("model")->id';
                }
                if (($key !== count($this->cols) - 1)) {
                    $rules .= ",".PHP_EOL;
                }
            }
        }

        return $rules;
    }
}
