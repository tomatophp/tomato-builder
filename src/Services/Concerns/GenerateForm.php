<?php

namespace TomatoPHP\TomatoBuilder\Services\Concerns;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use TomatoPHP\TomatoForms\Models\Form;

trait GenerateForm
{
    private function generateViewItem(string $name,string $value=null, string $type="text"): string
    {
        $text = "";
        if($value){
            $text = $value;
        }
        else {
            $text = $name;
        }

        $form = '<x-tomato-admin-row :label="__(\''.Str::ucfirst(str_replace('_', ' ', $name)).'\')" :value="$model->'.$text.'" type="'.$type.'" />'.PHP_EOL;
        return $form;
    }

    private function generateForm(bool $view=false): string
    {
        $form = "";
        $formCols = Form::where('key', $this->tableName)->with('fields')->first();
        $formCols = $formCols->fields;
        foreach($formCols as $key=>$item){
            $type = $item->validation ? $item->validation['type'] : 'text';

            if($key!== 0){
                $form .= "          ";
            }
            if(
                $item->type === 'text'
            ){
                if($view){
                    $form .= $this->generateViewItem($item->name,null, $type);
                }
                else {
                    $form .= "<x-splade-input :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" name=\"{$item->name}\" type=\"".$type."\"  :placeholder=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" />";
                    if($type === 'password'){
                        $form .= PHP_EOL."          <x-splade-input name=\"{$item->name}_confirmation\" :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))." Confirmation')\" type=\"".$type."\"  :placeholder=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))." Confirmation')\" />";
                    }
                }
            }
            if($item->type === 'textarea'){
                if($view){
                    $form .= $this->generateViewItem($item->name);
                }
                else {
                    $form .= "<x-splade-textarea :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" name=\"{$item->name}\" :placeholder=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" autosize />";
                }
            }
            if($item->type === 'rich'){
                if($view){
                    $form .= $this->generateViewItem($item->name, null, "rich");
                }
                else {
                    $form .= "<x-tomato-admin-rich :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" name=\"{$item->name}\" :placeholder=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" />";
                }
            }
            if($item->type === 'number'){
                if($view){
                    $form .= $this->generateViewItem($item->name, null, "number");
                }
                else {
                    $form .= "<x-splade-input :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" :placeholder=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" type='number' name=\"{$item->name}\" />";
                }
            }
            if($item->type === 'file'){
                if($view){
                    $form .= $this->generateViewItem($item->name, null, "image");
                }
                else {
                    $form .= "<x-splade-file filepond preview :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\"  name=\"{$item->name}\" />";
                }
            }
            if($item->type === 'color'){
                if($view){
                    $form .= $this->generateViewItem($item->name, null, "color");
                }
                else {
                    $form .= "<x-tomato-admin-color :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" :placeholder=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" type='number' name=\"{$item->name}\" />";
                }
            }
            if($item->type === 'select'){
                if($view){
                    $form .= $this->generateViewItem($item->name);
                }
                else {
                    if($item->table_name){
                        $form .= "<x-splade-select :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" :placeholder=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" name=\"".$item->name."\" remote-url=\"$item->table_name\" remote-root=\"data\" option-label=\"name\" option-value=\"id\" choices/>";
                    }
                    else {
                        $form .= "<x-splade-select :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" :placeholder=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" name=\"".$item->name."\" choices> \n";
                        foreach($item->options as $option){
                            $form .= "<option value='".$option->key."'>".$option->{'value_' . app()->getLocale()}."</option> \n";
                        }
                        $form .= "</x-splade-select>";
                    }
                }
            }
            if($item->type === 'date'){
                if($view){
                    $form .= $this->generateViewItem($item->name);
                }
                else {
                    $form .= "<x-splade-input :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" :placeholder=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" name=\"".$item->name."\" date />";
                }
            }
            if($item->type === 'time'){
                if($view){
                    $form .= $this->generateViewItem($item->name);
                }
                else {
                    $form .= "<x-splade-input :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" :placeholder=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" name=\"".$item->name."\" time=\"{ time_24hr: false }\" />";
                }
            }
            if($item->type === 'datetime'){
                if($view){
                    $form .= $this->generateViewItem($item->name);
                }
                else {
                    $form .= "<x-splade-input :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" :placeholder=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" name=\"".$item->name."\" date time=\"{ time_24hr: false }\" />";
                }
            }
            if($item->type === 'checkbox'){
                if($view){
                    $form .= $this->generateViewItem($item->name, null, "bool");
                }
                else {
                    $form .= "<x-splade-checkbox :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" name=\"".$item->name."\"  />";
                }
            }
            if($item->type === 'radio'){
                if($view){
                    $form .= $this->generateViewItem($item->name, null, "bool");
                }
                else {
                    $form .= "<x-splade-radio :label=\"__('".Str::ucfirst(str_replace('_', ' ', $item->name))."')\" name=\"".$item->name."\"  />";
                }
            }

            if($key!== count($this->cols)-1){
                $form .= PHP_EOL;
            }
        }
        return $form;
    }
}
