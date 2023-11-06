<?php

namespace TomatoPHP\TomatoBuilder\Services\Concerns;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait GenerateMigrations
{
    /**
     * @return array
     */
    private function generateMigrations(): void
    {
        $migrationsPath = module_path($this->moduleName) ."/Database/Migrations/";
        $checkIfMigrationExists = File::files($migrationsPath);
        $migrationExists = false;
        foreach ($checkIfMigrationExists as $migration){
            if(Str::of($migration->getFilename())->contains('_create_' . $this->tableName . '_table')){
                $migrationExists = true;
            }
        }

        if(!$migrationExists){
            Schema::dropIfExists($this->tableName);

            $this->generateStubs(
                $this->stubPath . 'migration.stub',
                module_path($this->moduleName) ."/Database/Migrations/". date('Y_m_d_h_mm_ss') . '_create_' . $this->tableName . '_table.php',
                [
                    "table" => $this->tableName,
                    "fields" => $this->getFields($this->fields)
                ]
            );
        }

        Artisan::call('migrate');
    }

    /**
     * @param $fields
     * @return string
     */
    private function getFields($fields): string
    {
        $finalFields = "";
        foreach ($fields as $key=>$field){
            $empty = false;
            if($key !== 0){
                $finalFields .= "            ";
            }
            if($field->name === 'id'){
                $finalFields .= '$table->id()';
            }
            else if($field->name === 'created_at' || $field->name === 'updated_at'){
                if(!Str::of($finalFields)->contains('$table->timestamps()')){
                    $finalFields .= '$table->timestamps()';
                }
                else {
                    $empty = true;
                }
            }
            else if($field->name === 'deleted_at'){
                $finalFields .= '$table->softDeletes()';
            }
            else if($field->type === 'bigint'){
                if($field->index_type === 'foreign_key'){
                    $finalFields .= '$table->foreignId("'.$field->name.'")';
                }
                else {
                    $finalFields .= '$table->bigInteger("'.$field->name.'")';
                }
            }
            else {
                $finalFields .= '$table->'. ($field->type == 'varchar' ? 'string' : $field->type) .'("'.$field->name.'")';
            }


            if($field->default){
                if($field->type === 'boolean' || $field->type === 'float' || $field->type === 'int' || $field->type === 'double'){
                    $finalFields .= "->default(".$field->default.")";
                }
                else {
                    $finalFields .= "->default('".$field->default."')";
                }
            }

            if($field->nullable){
                $finalFields .= "->nullable()";
            }

            if($field->index_type === 'foreign_key'){
                $finalFields .= "->references('".$field->linked_to_field->name."')->on('".$field->linked_to_table->data->table."')";
                if($field->on_delete->id){
                    $finalFields .= "->onDelete('".$field->on_delete->id."')";
                }
            }
            if($field->index_type === 'unique'){
                $finalFields .= "->unique()";
            }

            if($field->unsigned && $field->name !== 'id'){
                $finalFields .= "->unsigned()";
            }

            if($field->comment){
                $finalFields .= "->comment('".$field->comment."')";
            }

            if($field->index_type === 'primary_key' && $field->name !== 'id'){
                $finalFields .= "->primary()";
            }

            if($field->index_type === 'index'){
                $finalFields .= "->index()";
            }

            if(!$empty){
                $finalFields .= ";";
                $finalFields .= "\n";
            }

        }
        return $finalFields;
    }
}
