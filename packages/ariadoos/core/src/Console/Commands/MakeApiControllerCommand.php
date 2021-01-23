<?php

namespace Modules\Core\Console\Commands;

class MakeApiControllerCommand extends GenerateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-api-controller {name} {module} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create api controller for module';

    /**
     * Return the path of the file that is to be created
     *
     * @return string
     *
     */
    protected function getSourceFilePath()
    {
        $path = $this->getPath($this->getModuleNamespace($this->argument('module')) . '\\' . parent::API_CONTROLLER_NAMESPACE);

        return $path . '\\'  . $this->getSingularClassName($this->argument('name')) .'Controller.php';
    }

    /**
     * Return the stub path
     * @return string
     *
     */
    protected function getStubPath()
    {
        return __DIR__. '/../../Stubs/' . 'api-controller.stub';
    }

    /**
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    protected function getStubVariables()
    {
        $moduleNamespace = $this->getModuleNamespace($this->argument('module'));
        $className = $this->getSingularClassName($this->argument('name'));

        return [
            'NAMESPACE'         => $moduleNamespace . '\\' . parent::API_CONTROLLER_NAMESPACE,
            'CLASS_NAME'        => $className  ,
            'SERVICE_NAMESPACE' => $moduleNamespace . '\\' . parent::SERVICES_NAMESPACE. '\\' . $className.'Service' ,
            'REQUEST_NAMESPACE' => $moduleNamespace . '\\' . parent::REQUEST_NAMESPACE .'\\' . $className,
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
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

        if (!$this->option('all')) {
            $this->info("File: {$path} created");
        } else {
            $this->callClassesCombo($this->argument('module'), $this->argument('name'), parent::API_CONTROLLER_FILE);
            $this->info("File: {$path} created with other associated files");
        }

    }

}
