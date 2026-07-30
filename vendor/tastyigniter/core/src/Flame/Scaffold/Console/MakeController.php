<?php

declare(strict_types=1);

namespace Igniter\Flame\Scaffold\Console;

use Igniter\Flame\Scaffold\GeneratorCommand;
use Override;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeController extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:igniter-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new TastyIgniter admin controller.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * A mapping of stub to generated file.
     *
     * @var array
     */
    protected $stubs = [
        'controller/controller.stub' => 'src/Http/Controllers/{{studly_name}}.php',
    ];

    /**
     * Prepare variables for stubs.
     *
     * return @array
     */
    #[Override]
    protected function prepareVars(): ?bool
    {
        if (!$code = $this->getExtensionInput()) {
            $this->error('Invalid extension name, Example name: AuthorName.ExtensionName');

            return false;
        }

        [$author, $extension] = $code;
        $controller = $this->argument('controller');

        $this->vars = [
            'extension' => $extension,
            'lower_extension' => strtolower((string)$extension),
            'title_extension' => title_case($extension),
            'studly_extension' => studly_case($extension),

            'author' => $author,
            'lower_author' => strtolower((string)$author),
            'title_author' => title_case($author),
            'studly_author' => studly_case($author),

            'name' => $controller,
            'lower_name' => strtolower($controller),
            'title_name' => title_case($controller),
            'studly_name' => studly_case($controller),
            'singular_name' => str_singular($controller),
            'studly_singular_name' => studly_case(str_singular($controller)),
            'snake_singular_name' => snake_case(str_singular($controller)),
            'plural_name' => str_plural($controller),
            'studly_plural_name' => studly_case(str_plural($controller)),
            'snake_plural_name' => snake_case(str_plural($controller)),
        ];

        return null;
    }

    /**
     * Get the console command arguments.
     */
    #[Override]
    protected function getArguments(): array
    {
        return [
            ['extension', InputArgument::REQUIRED, 'The name of the extension to create. Eg: IgniterLab.Demo'],
            ['controller', InputArgument::REQUIRED, 'The name of the model. Eg: Blocks'],
        ];
    }

    /**
     * Get the console command options.
     */
    #[Override]
    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Overwrite existing files with generated ones.'],
        ];
    }
}
