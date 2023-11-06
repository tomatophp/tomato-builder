<?php

namespace TomatoPHP\TomatoBuilder\Http\Controllers;

use Doctrine\DBAL\Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use TomatoPHP\TomatoBuilder\Services\CRUDGenerator;
use TomatoPHP\TomatoBuilder\Services\FlutterCRUDGenerator;
use TomatoPHP\TomatoBuilder\Settings\BuilderSettings;
use Nwidart\Modules\Facades\Module;
use ProtoneMedia\Splade\Facades\Toast;
use Symfony\Component\Process\Process;
use TomatoPHP\ConsoleHelpers\Traits\HandleStub;
use TomatoPHP\TomatoForms\Models\Form;

class BuilderController extends Controller
{
    use HandleStub;

    private string $stubPath = "";

    public function __construct()
    {
        $this->stubPath = config('tomato-builder.stubs-path');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('tomato-builder::index');
    }

    public function confirm(){
        return view('tomato-builder::builder.confirm');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function form($model)
    {
        $model = Form::where('key', $model)->first();
        if($model){
            return view('tomato-builder::builder.form', [
                "model" => $model,
                "options" => $model->fields
            ]);
        }
        else {
            Toast::danger(__('Save your schema first to preview the form'))->autoDismiss(2);
            return back();
        }

    }

    public function preview($model){
        $model = Form::where('key', $model)->first();
        return view('tomato-builder::builder.preview', [
            "model" => $model,
            "options" => $model->fields
        ]);
    }

    private function getType($field){
        $type = "text";
        $subType = "text";

        if(
            $field->type === 'int' ||
            $field->type === 'bigint' ||
            $field->type === 'flot' ||
            $field->type === 'double'
        ){
            $subType = "number";
        }
        if($field->name === 'email'){
            $subType = "email";
        }
        if($field->name === 'color'){
            $type = "color";
        }
        if($field->type === 'text'){
            $type = "textarea";
        }
        if($field->type === 'longText'){
            $type = "rich";
        }
        if($field->type === 'date'){
            $type = "date";
        }
        if($field->type === 'time'){
            $type = "time";
        }
        if($field->type === 'datetime' || $field->type === 'timestamps'){
            $type = "datetime";
        }
        if(Str::of($field->name)->contains(['phone', 'tel'])){
            $subType = "tel";
        }
        if($field->type === 'boolean'){
            $type = "checkbox";
        }
        if($field->index_type === 'foreign_key'){
            $type = "select";
        }

        return [
            "type" => $type,
            "subType" => $subType
        ];
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            "tables" => "required|string"
        ]);

        $settings = new BuilderSettings();
        $settings->builder_json = $request->get('tables');
        $settings->save();

        $tables = json_decode($request->get('tables'));
        foreach ($tables as $table){
            if(!$table->isEdge){
                $form = Form::where('key', $table->data->table)->first();
                if(!$form){
                    $form = new Form();
                    $form->type = "modal";
                    $form->name = $table->data->table;
                    $form->key = $table->data->table;
                    $form->endpoint = "/admin/".$table->data->table;
                    $form->method = "POST";
                    $form->title = "Create ". Str::of($table->data->table)->ucfirst()->toString();
                    $form->is_active = true;
                    $form->save();

                    foreach ($table->data->fields as $key=>$field){
                        if(
                            $field->name !== 'id' &&
                            $field->name !== 'created_at' &&
                            $field->name !== 'updated_at' &&
                            $field->name !== 'deleted_at'
                        ){

                            $getTypeArray = $this->getType($field);
                            $type = $getTypeArray['type'];
                            $subType = $getTypeArray['subType'];
                            $form->fields()->create([
                                'type' => $type,
                                'label' => [
                                    "ar" => Str::of($field->name)->replace('_', ' ')->ucfirst()->remove('id')->toString(),
                                    "en" => Str::of($field->name)->replace('_', ' ')->ucfirst()->remove('id')->toString()
                                ],
                                'name' => $field->name,
                                'placeholder' => [
                                    "ar" => Str::of($field->name)->replace('_', ' ')->ucfirst()->remove('id')->toString(),
                                    "en" => Str::of($field->name)->replace('_', ' ')->ucfirst()->remove('id')->toString()
                                ],
                                'default' => $field->default,
                                'is_required' => !$field->nullable,
                                'is_from_table' => $field->index_type === 'foreign_key',
                                'table_name' => $field->index_type === 'foreign_key' ? '/admin/'.Str::of($field->linked_to_table->data->table)->replace('_', '-')->toString() .'/api': null,
                                'validation' => [
                                    "max" => $field->length,
                                    "min" => "1",
                                    "type" => $subType,
                                    "unique" => $field->index_type === 'unique'
                                ],
                                'order' => $key,
                            ]);
                        }
                    }
                }
                else {
                    $form->fields()->delete();
                    foreach ($table->data->fields as $key=>$field){
                        if(
                            $field->name !== 'id' &&
                            $field->name !== 'created_at' &&
                            $field->name !== 'updated_at' &&
                            $field->name !== 'deleted_at'
                        ) {
                            $getTypeArray = $this->getType($field);
                            $type = $getTypeArray['type'];
                            $subType = $getTypeArray['subType'];
                            $form->fields()->create([
                                'type' => $type,
                                'label' => [
                                    "ar" => Str::of($field->name)->replace('_', ' ')->ucfirst()->remove('id')->toString(),
                                    "en" => Str::of($field->name)->replace('_', ' ')->ucfirst()->remove('id')->toString()
                                ],
                                'name' => $field->name,
                                'placeholder' => [
                                    "ar" => Str::of($field->name)->replace('_', ' ')->ucfirst()->remove('id')->toString(),
                                    "en" => Str::of($field->name)->replace('_', ' ')->ucfirst()->remove('id')->toString()
                                ],
                                'default' => $field->default,
                                'is_required' => !$field->nullable,
                                'is_from_table' => $field->index_type === 'foreign_key',
                                'table_name' => $field->index_type === 'foreign_key' ? '/admin/' . Str::of($field->linked_to_table->data->table)->replace('_', '-')->toString() . '/api' : null,
                                'validation' => [
                                    "max" => $field->length,
                                    "min" => "1",
                                    "type" => $subType,
                                    "unique" => $field->index_type === 'unique'
                                ],
                                'order' => $key,
                            ]);
                        }
                    }
                }
            }
        }

        Toast::success(__('Table Saved To Database Success'))->autoDismiss(2);
        return back();
    }

    public function clear(){
        $tables = json_decode(setting('builder_json'));
        foreach ($tables as $table) {
            if (!$table->isEdge) {
                $form = Form::where('key', $table->data->table)->first();
                $form->fields()->delete();
                $form->delete();
            }
        }
        $setting = new BuilderSettings();

        $setting->builder_module = "";
        $setting->builder_app_name = "";
        $setting->save();

        Toast::success(__('Builder Has Been Reset Success'))->autoDismiss(2);
        return back();

    }

    /**
     * @throws Exception
     */
    private function generateModule(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",
        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->save();

        $generator = new CRUDGenerator(
            moduleName: $request->get('module'),
            module: true,
            migration: false,
            controllers: false,
            models: false,
            views: false,
            tables: false,
            routes: false,
        );
        $generator->generate();


        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();

    }

    /**
     * @throws Exception
     */
    private function generateRequest(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",
        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->save();

        foreach($tables as $table){
            if(!$table->isEdge){
                $generator = new CRUDGenerator(
                    tableName: $table->data->table,
                    moduleName: $request->get('module'),
                    isBuilder: 'file',
                    fields: $table->data->fields,
                    module: false,
                    migration: false,
                    controllers: false,
                    request: true,
                    models: false,
                    views: false,
                    tables: false,
                    routes: false,
                );
                $generator->generate();
            }
        }


        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();

    }


    /**
     * @throws Exception
     */
    private function generateResource(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",
        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->save();

        foreach($tables as $table){
            if(!$table->isEdge){
                $generator = new CRUDGenerator(
                    tableName: $table->data->table,
                    moduleName: $request->get('module'),
                    isBuilder: 'file',
                    fields: $table->data->fields,
                    module: false,
                    migration: false,
                    controllers: false,
                    request: false,
                    models: false,
                    views: false,
                    tables: false,
                    routes: false,
                    apiRoutes: false,
                    json: true,
                );
                $generator->generate();
            }
        }


        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();

    }

    /**
     * @throws Exception
     */
    private function generateAPIRoutes(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",
        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->save();

        foreach($tables as $table){
            if(!$table->isEdge){
                $generator = new CRUDGenerator(
                    tableName: $table->data->table,
                    moduleName: $request->get('module'),
                    isBuilder: 'file',
                    fields: $table->data->fields,
                    module: false,
                    migration: false,
                    controllers: false,
                    request: false,
                    models: false,
                    views: false,
                    tables: false,
                    routes: false,
                    apiRoutes: true,
                );
                $generator->generate();
            }
        }


        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();

    }

    /**
     * @throws Exception
     */
    private function generateMigrations(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",

        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->save();

        foreach($tables as $table){
            if(!$table->isEdge){
                $generator = new CRUDGenerator(
                    tableName: $table->data->table,
                    moduleName: $request->get('module'),
                    isBuilder: 'file',
                    fields: $table->data->fields,
                    module: false,
                    migration: true,
                    controllers: false,
                    models: false,
                    views: false,
                    tables: false,
                    routes: false,
                );
                $generator->generate();
            }
        }

        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();
    }
    /**
     * @throws Exception
     */
    private function generateViews(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",

        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->save();

        foreach($tables as $table){
            if(!$table->isEdge){
                $generator = new CRUDGenerator(
                    tableName: $table->data->table,
                    moduleName: $request->get('module'),
                    isBuilder: 'file',
                    fields: $table->data->fields,
                    module: false,
                    migration: false,
                    controllers: false,
                    models: false,
                    views: true,
                    tables: false,
                    routes: false,
                );
                $generator->generate();
            }
        }

        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();
    }

    /**
     * @throws Exception
     */
    private function generateControllers(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",

        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->save();

        foreach($tables as $table){
            if(!$table->isEdge){
                $generator = new CRUDGenerator(
                    tableName: $table->data->table,
                    moduleName: $request->get('module'),
                    isBuilder: 'file',
                    fields: $table->data->fields,
                    module: false,
                    migration: false,
                    controllers: true,
                    models: false,
                    views: false,
                    tables: false,
                    routes: false,
                );
                $generator->generate();
            }
        }

        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();
    }

    /**
     * @throws Exception
     */
    private function generateTables(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",

        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->save();

        foreach($tables as $table){
            if(!$table->isEdge){
                $generator = new CRUDGenerator(
                    tableName: $table->data->table,
                    moduleName: $request->get('module'),
                    isBuilder: 'file',
                    fields: $table->data->fields,
                    module: false,
                    migration: false,
                    controllers: false,
                    models: false,
                    views: false,
                    tables: true,
                    routes: false,
                );
                $generator->generate();
            }
        }

        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();
    }

    /**
     * @throws Exception
     */
    private function generateRoutes(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",

        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->save();

        foreach($tables as $table){
            if(!$table->isEdge){
                $generator = new CRUDGenerator(
                    tableName: $table->data->table,
                    moduleName: $request->get('module'),
                    isBuilder: 'file',
                    fields: $table->data->fields,
                    module: false,
                    migration: false,
                    controllers: false,
                    models: false,
                    views: false,
                    tables: false,
                    routes: true,
                );
                $generator->generate();
            }
        }

        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();
    }

    /**
     * @throws Exception
     */
    private function generateModels(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",

        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->save();

        foreach($tables as $table){
            if(!$table->isEdge){
                $generator = new CRUDGenerator(
                    tableName: $table->data->table,
                    moduleName: $request->get('module'),
                    isBuilder: 'file',
                    fields: $table->data->fields,
                    module: false,
                    migration: false,
                    controllers: false,
                    models: true,
                    views: false,
                    tables: false,
                    routes: false,
                );
                $generator->generate();
            }
        }

        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();
    }

    /**
     * @throws Exception
     */
    private function generateCRUD(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",

        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->save();

        foreach($tables as $table){
            if(!$table->isEdge){
                $generator = new CRUDGenerator(
                    tableName: $table->data->table,
                    moduleName: $request->get('module'),
                    isBuilder: 'file',
                    fields: $table->data->fields,
                    module: false,
                    migration: false,
                    controllers: true,
                    models: true,
                    views: true,
                    tables: true,
                    routes: true,
                );
                $generator->generate();
            }
        }

        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();
    }

    /**
     * @throws Exception
     */
    private function generateFlutterApp(Request $request,array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "app_name" => "required|string|max:255",
            "form_type" => "required|string|max:255",

        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->builder_app_name = $request->get('app_name');
        $setting->save();

        $checkIfFlutterExists = File::exists(base_path('/flutter'));
        if(!$checkIfFlutterExists){
            File::makeDirectory(base_path('/flutter'));
        }

        $name = $request->get('app_name');

        $process = new Process([
            'flutter',
            'create',
            $name
        ]);

        $process->setWorkingDirectory(base_path('/flutter'));
        $process->run();

        $assetsFolder = base_path('/flutter/' . $name .'/assets');
        $libFolder = base_path('/flutter/' . $name .'/lib');
        $testFolder = base_path('/flutter/' . $name .'/test');
        $packagesFolder = base_path('/flutter/' . $name .'/packages');
        $pubspecFile = base_path('/flutter/' . $name .'/pubspec.yaml');

        if(!File::exists($assetsFolder)){
            File::copyDirectory(__DIR__.'/../../share/assets', $assetsFolder);
        }
        if(!File::exists($libFolder)){
            File::copyDirectory(__DIR__.'/../../share/lib', $libFolder);
        }
        if(!File::exists($testFolder)){
            File::copyDirectory(__DIR__.'/../../share/test', $testFolder);
        }
        if(!File::exists($packagesFolder)){
            File::copyDirectory(__DIR__.'/../../share/packages', $packagesFolder);
        }
        if(!File::exists($pubspecFile)){
            $this->generateStubs(
                $this->stubPath . '/flutter/pubspec.stub',
                base_path('/flutter/' . $name .'/pubspec.yaml'),
                [
                    'name' => $name,
                ]
            );
        }

        $appConfigPath = base_path('/flutter/' . $name . '/lib/config/Config.dart');

        //Delete App Service If Exists
        if (File::exists($appConfigPath)) {
            File::delete($appConfigPath);
        }
        //Create App Service
        $this->generateStubs(
            $this->stubPath .  '/flutter/config/Config.stub',
            $appConfigPath,
            [
                "app_name" => $name,
                "url" => url('/api'),
            ]
        );


        Toast::success(__('Operation Has Been Run Success, Please run flutter pub get inside app folder'))->autoDismiss(10);
        return redirect()->back();
    }

    /**
     * @throws Exception
     */
    private function generateFlutterCRUD(Request $request, array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "app_name" => "required|string|max:255",
            "form_type" => "required|string|max:255",
        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->builder_app_name = $request->get('app_name');
        $setting->save();



        foreach($tables as $table){
            if(!$table->isEdge){
                $checkIfModuleExists = File::exists(base_path('/flutter/' . $request->get('app_name') . '/lib/app/modules/' . Str::of($table->data->table)->replace('_', ' ')->camel()->ucfirst()->toString()));

                if(!$checkIfModuleExists){
                    Toast::danger(__('Please Generate Flutter Module First!'))->autoDismiss(2);
                    return redirect()->back();
                }

                $generator = new FlutterCRUDGenerator(
                    appName: $request->get('app_name'),
                    appModuleName: Str::of($table->data->table)->replace('_', ' ')->camel()->ucfirst()->toString(),
                    tableName: $table->data->table,
                );
                $generator->generate();
            }
        }

        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();
    }

    /**
     * @throws Exception
     */
    private function generateFlutterModule(Request $request, array $tables){
        $request->validate([
            "module" => "required|string|max:255",
            "app_name" => "required|string|max:255",
            "form_type" => "required|string|max:255",
        ]);

        $setting = new BuilderSettings();
        $setting->builder_module = $request->get('module');
        $setting->builder_app_name = $request->get('app_name');
        $setting->save();

        $checkIfFlutterExists = File::exists(base_path('/flutter/' . $request->get('app_name')));
        if(!$checkIfFlutterExists){
            Toast::danger(__('Please Generate Flutter App First!'))->autoDismiss(2);
            return redirect()->back();
        }
        else {
            foreach($tables as $table){
                if(!$table->isEdge){
                    $modulePath = base_path('/flutter/' . $request->get('app_name') . '/lib/app/modules/' . Str::of($table->data->table)->replace('_', ' ')->camel()->ucfirst()->toString());
                    $checkIfModuleExists = File::exists($modulePath);
                    if(!$checkIfModuleExists){
                        $folders = [
                            $modulePath,
                            $modulePath . '/controllers',
                            $modulePath . '/routes',
                            $modulePath . '/services',
                            $modulePath . '/views',
                        ];

                        foreach ($folders as $folder){
                            if(!File::exists($folder)){
                                File::makeDirectory($folder);
                            }
                        }
                    }
                }
            }
        }

        Toast::success(__('Operation Has Been Run Success'))->autoDismiss(2);
        return redirect()->back();
    }



    private function checkIfModuleExists(): bool
    {
        $checkIfModuleExists = Module::find(setting('builder_module'));
        return (bool)$checkIfModuleExists;
    }

    private function checkIfTableExists(): bool
    {
        $tables = json_decode(setting('builder_json'));
        foreach($tables as $table){
            if(!$table->isEdge){
               if(!Schema::hasTable($table->data->table)){
                   return false;
               }
            }
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function generate(Request $request){
        $request->validate([
            "module" => "required|string|max:255",
            "form_type" => "required|string|max:255",
        ]);

        $tables = json_decode(setting('builder_json'));
        if(!count($tables)){
            Toast::danger(__('Please save your schema before generate files'))->autoDismiss(2);
            return redirect()->back();
        }
        else {
            if ($request->get('form_type') === 'module') {
                if($this->checkIfModuleExists()){
                    Toast::danger(__('Sorry the module is exists'))->autoDismiss(2);
                    return redirect()->back();
                }
                else {
                    return $this->generateModule($request, $tables);
                }
            }
            if(
                $request->get('form_type') === 'migrations' ||
                $request->get('form_type') === 'crud' ||
                $request->get('form_type') === 'models' ||
                $request->get('form_type') === 'controllers' ||
                $request->get('form_type') === 'form-request' ||
                $request->get('form_type') === 'views' ||
                $request->get('form_type') === 'tables' ||
                $request->get('form_type') === 'routes' ||
                $request->get('form_type') === 'api-routes' ||
                $request->get('form_type') === 'json-resource' ||
                $request->get('form_type') === 'flutter-app' ||
                $request->get('form_type') === 'flutter-module' ||
                $request->get('form_type') === 'flutter-crud'
            ){
                if(!$this->checkIfModuleExists()){
                    Toast::danger(__('Sorry you need to generate a module first'))->autoDismiss(2);
                    return redirect()->back();
                }
            }
            if(
                $request->get('form_type') === 'crud' ||
                $request->get('form_type') === 'controllers' ||
                $request->get('form_type') === 'form-request' ||
                $request->get('form_type') === 'models' ||
                $request->get('form_type') === 'views' ||
                $request->get('form_type') === 'tables' ||
                $request->get('form_type') === 'routes' ||
                $request->get('form_type') === 'api-routes' ||
                $request->get('form_type') === 'json-resource' ||
                $request->get('form_type') === 'flutter-app' ||
                $request->get('form_type') === 'flutter-module' ||
                $request->get('form_type') === 'flutter-crud'
            ){
                if(!$this->checkIfTableExists()){
                    Toast::danger(__('Sorry you need to generate a migrations first'))->autoDismiss(2);
                    return redirect()->back();
                }
            }
            if ($request->get('form_type') === 'migrations') {
                if($this->checkIfTableExists()){
                    Toast::danger(__('Sorry This table is migrated success!'))->autoDismiss(2);
                    return redirect()->back();
                }
                else {
                    return $this->generateMigrations($request, $tables);
                }
            }
            if ($request->get('form_type') === 'models') {
                return $this->generateModels($request, $tables);
            }
            if ($request->get('form_type') === 'flutter-module') {
                return $this->generateFlutterModule($request, $tables);
            }
            if ($request->get('form_type') === 'json-resource') {
                return $this->generateResource($request, $tables);
            }
            if ($request->get('form_type') === 'api-routes') {
                return $this->generateAPIRoutes($request, $tables);
            }
            if ($request->get('form_type') === 'form-request') {
                return $this->generateRequest($request, $tables);
            }
            if ($request->get('form_type') === 'controllers') {
                return $this->generateControllers($request, $tables);
            }
            if ($request->get('form_type') === 'routes') {
                return $this->generateRoutes($request, $tables);
            }
            if ($request->get('form_type') === 'tables') {
                return $this->generateTables($request, $tables);
            }
            if ($request->get('form_type') === 'views') {
                return $this->generateViews($request, $tables);
            }
            if ($request->get('form_type') === 'crud') {
                return $this->generateCRUD($request, $tables);
            }
            if ($request->get('form_type') === 'flutter-app') {
                return $this->generateFlutterApp($request, $tables);
            }
            if ($request->get('form_type') === 'flutter-crud') {
                return $this->generateFlutterCRUD($request, $tables);
            }
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('tomato-builder::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('tomato-builder::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
