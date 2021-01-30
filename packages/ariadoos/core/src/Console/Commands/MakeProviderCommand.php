<?php

namespace Modules\Core\Console\Commands;

class MakeProviderCommand extends GenerateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-providers {name} {module} {--plain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the providers file for a module';

    /**
     * Return the path of the file that is to be created
     *
     * @return string
     *
     */
    protected function getSourceFilePath()
    {
        $path = $this->getPath($this->getModuleNamespace($this->argument('module')) . '\\' . parent::PROVIDER_NAMESPACE);

        return $path . '\\'  . $this->getSingularClassName($this->argument('name')) .'ServiceProvider.php';
    }

    /**
     * Return the stub path
     * @return string
     *
     */
    protected function getStubPath()
    {
        if($this->option('plain'))
            return __DIR__. '/../../Stubs/' . 'providers-plain.stub';

        return __DIR__. '/../../Stubs/' . 'providers.stub';
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

        if($this->option('plain'))
            return [
                'NAMESPACE'         => $moduleNamespace . '\\' . parent::PROVIDER_NAMESPACE,
                'CLASS_NAME'        => $className,
            ];

        return [
            'NAMESPACE'         => $moduleNamespace . '\\' . parent::PROVIDER_NAMESPACE,
            'CLASS_NAME'        => $className,
            'REPOSITORY_NAMESPACE' => $moduleNamespace . '\\' . parent::REPOSITORY_NAMESPACE . '\\' .$className.'Repository',
            'INTERFACE_NAMESPACE' => $moduleNamespace . '\\' . parent::INTERFACE_NAMESPACE . '\\' .$className.'RepositoryInterface',
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
