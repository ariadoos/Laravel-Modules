<?php

namespace Modules\Core\Console\Commands;

class MakeRequestCommand extends GenerateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-request {name} {module} {--r}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a request class for a module';

    /**
     * Return the path of the file that is to be created
     *
     * @return string
     *
     */
    protected function getSourceFilePath()
    {
        $path = $this->getPath($this->getModuleNamespace($this->argument('module')) . '\\' . 'Http\\Requests');

        return $path . '\\'  . $this->getSingularClassName($this->argument('name')). 'Request' .'.php';
    }

    /**
     * Return the stub path
     * @return string
     *
     */
    protected function getStubPath()
    {
        return __DIR__. '/../../Stubs/' . 'request.stub';
    }

    /**
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    protected function getStubVariables()
    {
        return [
            'NAMESPACE' => $this->getModuleNamespace($this->argument('module')) . '\\' . 'Http\\Requests\\' . $this->getSingularClassName($this->argument('name')),
            'CLASS_NAME'    =>  $this->getSingularClassName($this->argument('name')),
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
     * Return a resource file stub path
     * @param $key
     * @return mixed
     *
     */
    public function findStubPath($key)
    {
        $stubsPaths = [
          'index' =>  __DIR__. '/../../Stubs/' . 'request.stub',
          'create' =>  __DIR__. '/../../Stubs/' . 'create-request.stub',
          'update' =>  __DIR__. '/../../Stubs/' . 'update-request.stub',
          'delete' =>  __DIR__. '/../../Stubs/' . 'delete-request.stub',
        ];

        return $stubsPaths[$key];
    }

    /**
     * Get all the resources files to be created
     * @return array
     */
    public function getAllSourceFilePath()
    {
        $path = $this->getPath($this->getModuleNamespace($this->argument('module')) . '\\' . 'Http\\Requests');

        $fileBaseName = $this->getSingularClassName($this->argument('name'));

        return [
          'index' => $path . '\\'. $fileBaseName . '\\'  . $this->getSingularClassName($this->argument('name')). 'Request' .'.php',
          'create' => $path . '\\'. $fileBaseName . '\\' . $this->getSingularClassName($this->argument('name')). 'CreateRequest' .'.php',
          'update' => $path . '\\'. $fileBaseName . '\\' . $this->getSingularClassName($this->argument('name')). 'UpdateRequest' .'.php',
          'delete' => $path . '\\'. $fileBaseName . '\\' . $this->getSingularClassName($this->argument('name')). 'DeleteRequest' .'.php',
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('r')) {

            $paths = $this->getAllSourceFilePath();

            foreach ($paths as $file => $path) {

                $this->makeDirectory(dirname($path));

                $contents = $this->getStubContents($this->findStubPath($file), $this->getStubVariables());

                if (!$this->files->exists($path)) {
                    $this->files->put($path, $contents);
                } else {
                    $this->info("File : {$path} already exits");
                }

            }

            $this->info("Resources Request File created");

        } else {

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

    }

}
