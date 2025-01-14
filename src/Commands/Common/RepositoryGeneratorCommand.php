<?php

namespace Codiksh\Generator\Commands\Common;

use Codiksh\Generator\Commands\BaseCommand;
use Codiksh\Generator\Generators\RepositoryGenerator;

class RepositoryGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'codiksh:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository command';

    public function handle()
    {
        parent::handle();

        /** @var RepositoryGenerator $repositoryGenerator */
        $repositoryGenerator = app(RepositoryGenerator::class);
        $repositoryGenerator->generate();

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
