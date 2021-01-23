<?php

namespace Modules\Core\Console\Commands;

use Faker\Provider\File;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Pluralizer;

abstract class GenerateCommand extends Command
{
    const API_CONTROLLER_NAMESPACE = 'Http\\Controllers\\Api';
    const SERVICES_NAMESPACE = 'Services';
    const REQUEST_NAMESPACE = 'Http\\Requests';
    const WEB_CONTROLLER_NAMESPACE = 'Http\\Controllers\\Web';
    const INTERFACE_NAMESPACE ='Repositories\\Interfaces';
    const REPOSITORY_NAMESPACE = 'Repositories\\Eloquent';

    const SERVICE_FILE = 'serviceFile';
    const API_CONTROLLER_FILE = 'apiControllerFile';
    const WEB_CONTROLLER_FILE = 'webControllerFile';
    const INTERFACE_FILE = 'interfaceFile';
    const REPOSITORY_FILE = 'repositoryFile';
    const MODEL_FILE = 'modelFile';
    const RESOURCE_FILE = 'resourceFile';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    protected $stubFiles;

    protected $moduleFolderStructure;

    /**
     * Stubs folder path
     * @var string
     *
     */
    protected $stubPath;

    protected $modulesContainer;

    protected $moduleName;

    protected $folders;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;

        $this->stubPath = $this->getStubsPath();

        $this->stubFiles = config('core.stubFiles');

        $this->moduleFolderStructure = config('core.folders');

        $this->folders = config('core.folders');
    }

    /**
     * Execute the console command.
     *
     *
     */
    public function handle()
    {
        $path = $this->getSourceFilePath();
        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
        } else {
            $this->info("File : {$path} already exits");
        }

        $this->info("File: {$path} created");

    }

    public function generate($moduleName)
    {
        $this->moduleName = $moduleName;

        $moduleContainer = $this->getPath($this->getSourceFilePath());
        $this->makeDirectory($moduleContainer);

        $this->createFolders();

        $this->callClasses();

    }

    abstract function getSourceFile();


    protected function getSourceFilePath()
    {
        $path = $this->getRootContainerNamespace(). '\\' . $this->moduleName;

        return $path;
    }

    protected function getModuleNamespace($module)
    {
        $namespace = $this->getRootContainerNamespace() . '\\' . $this->getModuleName($module);

        return $this->getNamespace($namespace);
    }

    /**
     * Return Stubs Folder Path
     *
     * @return string
     *
     */
    public function getStubsPath()
    {
        return __DIR__. '/../../Stubs/';
    }

    protected function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('$'.$search.'$' , $replace, $contents);
        }

        return $contents;

    }

    public function createFolders()
    {
        $folders = $this->folders;

        foreach ($folders as $folderName => $folderContain) {
            $parent = $folderContain['parent'];
            $generate = $folderContain['generate'];

            if (!$generate)
                continue;

            if (isset($parent) && $parent) {
                $path = $this->getPath($this->getSourceFilePath(). '\\' . $this->getNamespace($parent) . '\\' . $folderName);
            } else {
                $path = $this->getPath($this->getSourceFilePath() . '\\' . $folderName);

            }

            $this->makeDirectory($path);
        }

    }


    public function callClasses()
    {
        //create web route file
        Artisan::call('make:module-route', [
            'module' => $this->moduleName
        ]);

        //create api route file
        Artisan::call('make:module-api', [
            'module' => $this->moduleName
        ]);

        //create model file
        $this->modelArtisanCall($this->moduleName, $this->moduleName);

        //create request file
        $this->requestArtisanCall($this->moduleName, $this->moduleName, true);

        //create a api resource file
        $this->resourceArtisanCall($this->moduleName, $this->moduleName);

        //create a interface class file
        $this->interfaceArtisanCall($this->moduleName, $this->moduleName);

        //create a repository class file
        $this->repositoryArtisanCall($this->moduleName, $this->moduleName);

        //create a web controller class file
        $this->serviceArtisanCall($this->moduleName, $this->moduleName);

        //create a api controller class file
        $this->apiControllerArtisanCall($this->moduleName, $this->moduleName);

        //create a web controller class file
        $this->webControllerArtisanCall($this->moduleName, $this->moduleName);

    }

    /**
     * Create the Grouped Classes
     * @param $moduleName
     * @param $fileBaseName
     * @param $exceptFile
     */
    public function callClassesCombo($moduleName, $fileBaseName, $exceptFile)
    {
        $this->requestArtisanCall($moduleName, $fileBaseName, true);

        if($exceptFile != self::RESOURCE_FILE)
            $this->resourceArtisanCall($moduleName, $fileBaseName);

        if ($exceptFile != self::MODEL_FILE)
            $this->modelArtisanCall($moduleName, $fileBaseName);

        if ($exceptFile != self::INTERFACE_FILE)
            $this->interfaceArtisanCall($moduleName, $fileBaseName);

        if ($exceptFile != self::REPOSITORY_FILE)
            $this->repositoryArtisanCall($moduleName, $fileBaseName);

        if ($exceptFile != self::SERVICE_FILE)
            $this->serviceArtisanCall($moduleName, $fileBaseName);

        if ($exceptFile != self::API_CONTROLLER_FILE)
            $this->apiControllerArtisanCall($moduleName, $fileBaseName);

        if ($exceptFile != self::WEB_CONTROLLER_FILE)
            $this->webControllerArtisanCall($moduleName, $fileBaseName);

        return;
    }

    /**
     * Create Interface File
     * @param $module
     * @param $name
     */
    public function interfaceArtisanCall($module, $name)
    {
        Artisan::call('make:module-interface', [
            'module' => $module,
            'name'   => $name
        ]);
    }

    /**
     * Create Repository File
     * @param $module
     * @param $name
     */
    public function repositoryArtisanCall($module, $name)
    {
        Artisan::call('make:module-repository', [
            'module' => $module,
            'name'   => $name
        ]);
    }

    /**
     * Create Service File
     * @param $module
     * @param $name
     */
    public function serviceArtisanCall($module, $name)
    {
        Artisan::call('make:module-service', [
            'module' => $module,
            'name'   => $name
        ]);
    }

    /**
     * Create API Controller File
     * @param $module
     * @param $name
     */
    public function apiControllerArtisanCall($module, $name)
    {
        Artisan::call('make:module-api-controller', [
            'module' => $module,
            'name'   => $name
        ]);
    }

    /**
     * Create Web Controller File
     * @param $module
     * @param $name
     */
    public function webControllerArtisanCall($module, $name)
    {
        Artisan::call('make:module-web-controller', [
            'module' => $module,
            'name'   => $name
        ]);
    }

    /**
     * Create Request File
     * @param $module
     * @param $name
     * @param $all
     */
    public function requestArtisanCall($module, $name, $all)
    {
        Artisan::call('make:module-request', [
            'module' => $module,
            'name'   => $name,
            '--r'    => $all
        ]);
    }

    /**
     * Create Model File
     * @param $module
     * @param $name
     */
    public function modelArtisanCall($module, $name)
    {
        Artisan::call('make:module-model', [
            'module' => $module,
            'name'   => $name
        ]);
    }

    /**
     * Create Resources File
     * @param $module
     * @param $name
     */
    public function resourceArtisanCall($module, $name)
    {
        Artisan::call('make:module-resource', [
            'module' => $module,
            'name'   => $name
        ]);
    }


    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Return NameSpace
     *
     * @param $name
     * @return mixed
     */
    public function getNamespace($name)
    {
        return str_replace('/', '\\', $name);
    }

    public function getPath($name)
    {
        return base_path($name);
    }


    public function getRootContainerNamespace()
    {
        $packageNamespace = config('core.package.namespace');

        $vendorNamespace = config('core.vendor.namespace');

        if( !empty($vendorNamespace) ) {
            return $vendorNamespace;
        }

        return $packageNamespace;
    }

    public function getModuleName($name)
    {
        return $this->capitalize($this->getPlural($name));
    }

    public function getSingular($name)
    {
        return Pluralizer::singular($name);
    }

    public  function getPlural($name)
    {
        return Pluralizer::plural($name);
    }

    public function capitalize($name)
    {
        return ucwords($name);
    }

    public function toLowerCase($name)
    {
        return strtolower($name);
    }

    public function getSingularClassName($name)
    {
        return $this->capitalize($this->getSingular($name));
    }


}
