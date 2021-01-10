<?php

namespace Modules\Core\Console\Commands;

class CreateModuleCommand extends GenerateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the Module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $moduleName = $this->getModuleName($this->argument('name'));

        $this->generate($moduleName);

        $this->info(ucwords($this->argument('name'))." Module Created Successfully");

    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string|null
     *
     */
    public function getSourceFile()
    {
       return null;
    }






}
