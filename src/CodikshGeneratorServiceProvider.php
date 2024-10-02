<?php

namespace Codiksh\Generator;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Codiksh\Generator\Commands\API\APIControllerGeneratorCommand;
use Codiksh\Generator\Commands\API\APIGeneratorCommand;
use Codiksh\Generator\Commands\API\APIRequestsGeneratorCommand;
use Codiksh\Generator\Commands\API\TestsGeneratorCommand;
use Codiksh\Generator\Commands\APIScaffoldGeneratorCommand;
use Codiksh\Generator\Commands\Common\MigrationGeneratorCommand;
use Codiksh\Generator\Commands\Common\ModelGeneratorCommand;
use Codiksh\Generator\Commands\Common\RepositoryGeneratorCommand;
use Codiksh\Generator\Commands\Publish\GeneratorPublishCommand;
use Codiksh\Generator\Commands\Publish\PublishTablesCommand;
use Codiksh\Generator\Commands\Publish\PublishUserCommand;
use Codiksh\Generator\Commands\RollbackGeneratorCommand;
use Codiksh\Generator\Commands\Scaffold\ControllerGeneratorCommand;
use Codiksh\Generator\Commands\Scaffold\RequestsGeneratorCommand;
use Codiksh\Generator\Commands\Scaffold\ScaffoldGeneratorCommand;
use Codiksh\Generator\Commands\Scaffold\ViewsGeneratorCommand;
use Codiksh\Generator\Common\FileSystem;
use Codiksh\Generator\Common\GeneratorConfig;
use Codiksh\Generator\Generators\API\APIControllerGenerator;
use Codiksh\Generator\Generators\API\APIRequestGenerator;
use Codiksh\Generator\Generators\API\APIRoutesGenerator;
use Codiksh\Generator\Generators\API\APITestGenerator;
use Codiksh\Generator\Generators\FactoryGenerator;
use Codiksh\Generator\Generators\MigrationGenerator;
use Codiksh\Generator\Generators\ModelGenerator;
use Codiksh\Generator\Generators\RepositoryGenerator;
use Codiksh\Generator\Generators\RepositoryTestGenerator;
use Codiksh\Generator\Generators\Scaffold\ControllerGenerator;
use Codiksh\Generator\Generators\Scaffold\MenuGenerator;
use Codiksh\Generator\Generators\Scaffold\RequestGenerator;
use Codiksh\Generator\Generators\Scaffold\RoutesGenerator;
use Codiksh\Generator\Generators\Scaffold\ViewGenerator;
use Codiksh\Generator\Generators\SeederGenerator;

class CodikshGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $configPath = __DIR__.'/../config/laravel_generator.php';
            $this->publishes([
                $configPath => config_path('laravel_generator.php'),
            ], 'laravel-generator-config');

            $this->publishes([
                __DIR__.'/../views' => resource_path('views/vendor/laravel-generator'),
            ], 'laravel-generator-templates');
        }

        $this->registerCommands();
        $this->loadViewsFrom(__DIR__.'/../views', 'laravel-generator');

        View::composer('*', function ($view) {
            $view->with(['config' => app(GeneratorConfig::class)]);
        });

        Blade::directive('tab', function () {
            return '<?php echo infy_tab() ?>';
        });

        Blade::directive('tabs', function ($count) {
            return "<?php echo infy_tabs($count) ?>";
        });

        Blade::directive('nl', function () {
            return '<?php echo infy_nl() ?>';
        });

        Blade::directive('nls', function ($count) {
            return "<?php echo infy_nls($count) ?>";
        });
    }

    private function registerCommands()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            APIScaffoldGeneratorCommand::class,

            APIGeneratorCommand::class,
            APIControllerGeneratorCommand::class,
            APIRequestsGeneratorCommand::class,
            TestsGeneratorCommand::class,

            MigrationGeneratorCommand::class,
            ModelGeneratorCommand::class,
            RepositoryGeneratorCommand::class,

            GeneratorPublishCommand::class,
            PublishTablesCommand::class,
            PublishUserCommand::class,

            ControllerGeneratorCommand::class,
            RequestsGeneratorCommand::class,
            ScaffoldGeneratorCommand::class,
            ViewsGeneratorCommand::class,

            RollbackGeneratorCommand::class,
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel_generator.php', 'laravel_generator');

        $this->app->singleton(GeneratorConfig::class, function () {
            return new GeneratorConfig();
        });

        $this->app->singleton(FileSystem::class, function () {
            return new FileSystem();
        });

        $this->app->singleton(MigrationGenerator::class);
        $this->app->singleton(ModelGenerator::class);
        $this->app->singleton(RepositoryGenerator::class);

        $this->app->singleton(APIRequestGenerator::class);
        $this->app->singleton(APIControllerGenerator::class);
        $this->app->singleton(APIRoutesGenerator::class);

        $this->app->singleton(RequestGenerator::class);
        $this->app->singleton(ControllerGenerator::class);
        $this->app->singleton(ViewGenerator::class);
        $this->app->singleton(RoutesGenerator::class);
        $this->app->singleton(MenuGenerator::class);

        $this->app->singleton(RepositoryTestGenerator::class);
        $this->app->singleton(APITestGenerator::class);

        $this->app->singleton(FactoryGenerator::class);
        $this->app->singleton(SeederGenerator::class);
    }
}
