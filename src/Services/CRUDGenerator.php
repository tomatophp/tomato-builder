<?php

namespace TomatoPHP\TomatoBuilder\Services;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateJsonResource;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateMigrations;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateModules;
use TomatoPHP\TomatoBuilder\Settings\BuilderSettings;
use TomatoPHP\ConsoleHelpers\Traits\HandleStub;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateCols;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateController;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateCreateView;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateEditView;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateFolders;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateForm;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateFormView;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateIndexView;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateModel;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateRoutes;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateShowView;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateTable;
use TomatoPHP\TomatoBuilder\Services\Concerns\GenerateRequest;
use TomatoPHP\TomatoForms\Models\Form;

class CRUDGenerator
{
    private string $modelName;
    private string $stubPath;
    private array $cols;

    //Handler
    use HandleStub;

    //Generate Classes
    use GenerateFolders;
    use GenerateModules;
    use GenerateMigrations;
    use GenerateCols;
    use GenerateModel;
    use GenerateTable;
    use GenerateController;
    use GenerateRequest;
    use GenerateRoutes;
    use GenerateJsonResource;

    //Generate From & View
    use GenerateForm;

    //Generate Views
    use GenerateIndexView;
    use GenerateShowView;
    use GenerateCreateView;
    use GenerateFormView;
    use GenerateEditView;

    private Connection $connection;

    /**
     * @param string $tableName
     * @param string|bool|null $moduleName
     * @throws Exception
     */
    public function __construct(
        private string | null $tableName = null,
        private string | bool | null $moduleName = null,
        private string $isBuilder = 'file',
        private array $fields =[],
        private bool $module = true,
        private bool $migration = true,
        private bool $controllers = true,
        private bool $request = true,
        private bool $models  = true,
        private bool $views  = true,
        private bool $tables  = true,
        private bool $routes  = true,
        private bool $apiRoutes  = true,
        private bool $json  = true,
    ){
        $connectionParams = [
            'dbname' => config('database.connections.mysql.database'),
            'user' => config('database.connections.mysql.username'),
            'password' => config('database.connections.mysql.password'),
            'host' => config('database.connections.mysql.host'),
            'driver' => 'pdo_mysql',
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
        $this->modelName = Str::ucfirst(Str::singular(Str::camel($this->tableName)));
        $this->stubPath = base_path(config('tomato-builder.stubs-path'));
        if($this->tableName){
            $this->cols = $this->getCols();
        }
    }

    /**
     * @return void
     */
    public function generate(): bool
    {
        if($this->module){
            $this->generateModule();
        }
        if($this->migration){
            $this->generateMigrations();
        }
        if(Schema::hasTable($this->tableName)){
            $this->generateFolders();
            sleep(3);
            if($this->models){
                $this->generateModel();
            }
            if($this->tables){
                $this->generateTable();
            }
            if($this->request){
                $this->generateRequest();
                $this->generateControllerForRequest();
            }
            else {
                if($this->controllers) {
                    ($this->isBuilder == 'form') ? $this->generateControllerForBuilder() : $this->generateController();
                }
            }
            if($this->json){
                $this->generateJsonResource();
            }
            if($this->routes || $this->apiRoutes){
                $this->generateRoutes();
            }
            if($this->views){
                $this->generateIndexView();
                if ($this->isBuilder == 'form'){
                    $this->generateFormView();
                    $this->generateFormBuilderClass();

                }else{
                    $this->generateCreateView();
                    $this->generateEditView();
                }
                $this->generateShowView();
            }

            return true;
        }
        else {
            return false;
        }

    }

}
