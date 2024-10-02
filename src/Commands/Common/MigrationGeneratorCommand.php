<?php

namespace Codiksh\Generator\Commands\Common;

use Codiksh\Generator\Commands\BaseCommand;
use Codiksh\Generator\Generators\MigrationGenerator;

class MigrationGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'codiksh:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create migration command';

    public function handle()
    {
        parent::handle();

        if ($this->option('fromTable')) {
            $this->error('fromTable option is not allowed to use with migration generator');

            return;
        }

        /** @var MigrationGenerator $migrationGenerator */
        $migrationGenerator = app(MigrationGenerator::class);
        $migrationGenerator->generate();

        $this->performPostActionsWithMigration();
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
