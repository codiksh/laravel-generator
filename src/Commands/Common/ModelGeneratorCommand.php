<?php

namespace Codiksh\Generator\Commands\Common;

use Codiksh\Generator\Commands\BaseCommand;
use Codiksh\Generator\Generators\ModelGenerator;

class ModelGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'codiksh:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model command';

    public function handle()
    {
        parent::handle();

        /** @var ModelGenerator $modelGenerator */
        $modelGenerator = app(ModelGenerator::class);
        $modelGenerator->generate();

        $this->performPostActions();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge(parent::getOptions(), []);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array_merge(parent::getArguments(), []);
    }
}
