<?php

namespace TomatoPHP\TomatoBuilder\Services\Concerns;

use Illuminate\Support\Str;
use TomatoPHP\TomatoForms\Models\Form;

trait GenerateJsonResource
{
    private function generateJsonResource(): void
    {
        $folders = [];
        $resourceName = Str::of($this->tableName)->replace('_', ' ')->camel()->ucfirst()->toString() . 'Resource';
        if($this->moduleName){
            $folders[] = module_path($this->moduleName) . "/Transformers";
        }
        else {
            $folders[] = app_path("Transformers");
        }

        $this->generateStubs(
            $this->stubPath . "json.stub",
            $this->moduleName ? module_path($this->moduleName) . "/Transformers/" . $resourceName . '.php' : app_path("Transformers/" . $resourceName . '.php'),
            [
                "namespace" => $this->moduleName ? "Modules\\".$this->moduleName."\\Transformers" : "App\\Transformers",
                "name" => $resourceName,
                "fields" => $this->generateFields(),
                "table" => str_replace('_', '-', $this->tableName),
            ],
            $folders
        );

    }

    private function generateFields(): string
    {
        $rules = "";
        $formCols = Form::where('key', $this->tableName)->with('fields')->first();
        $formCols = $formCols->fields;
        foreach ($formCols as $key => $item) {
            if ($item->name !== 'id') {
                if($key !== 0){
                    $rules .= "            ";
                }

                if($item->is_from_table){
                    $rules .= "'".Str::of($item->name)->remove('_id')->toString()."' => \$this->".Str::of($item->table_name)->replace('-', ' ')->remove('/admin/')->remove('/api')->singular()->camel()->toString() . ',';
                }
                else {
                    $rules .= "'{$item->name}' => \$this->{$item->name},";
                }
            }

            $rules .= "\n";
        }

        return $rules;
    }
}
