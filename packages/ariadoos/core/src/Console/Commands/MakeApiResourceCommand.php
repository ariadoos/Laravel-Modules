<?php

namespace Modules\Core\Console\Commands;

class MakeApiResourceCommand extends GenerateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-resource {name} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a module api resource file';


    /**
     * Return the path of the file that is to be created
     *
     * @return string
     *
     */
    protected function getSourceFilePath()
    {
        $path = $this->getPath($this->getModuleNamespace($this->argument('module')) . '\\' . 'Http\\Resources');

        return $path . '\\'  . $this->getSingularClassName($this->argument('name')).'.php';
    }

    /**
     * Return the stub path
     * @return string
     *
     */
    protected function getStubPath()
    {
        return __DIR__. '/../../Stubs/' . 'resources.stub';
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
            'NAMESPACE' => $this->getModuleNamespace($this->argument('module'))  . '\\' . 'Http\\Resources',
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
