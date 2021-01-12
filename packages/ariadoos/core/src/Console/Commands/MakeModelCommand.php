<?php

namespace Modules\Core\Console\Commands;

class MakeModelCommand extends GenerateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-model {name} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a model for a module';


    /**
     * Return the path of the file that is to be created
     *
     * @return string
     *
     */
    protected function getSourceFilePath()
    {
        $path = $this->getPath($this->getModuleNamespace($this->argument('module')) . '\\' . 'Models');

        return $path . '\\'  . $this->getSingularClassName($this->argument('name')) .'.php';
    }

    /**
     * Return the stub path
     * @return string
     *
     */
    protected function getStubPath()
    {
        return __DIR__. '/../../Stubs/' . 'model.stub';
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
          'NAMESPACE' => $this->getModuleNamespace($this->argument('module') . '\\' . 'Models'),
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

}
