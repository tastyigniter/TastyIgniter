<?php

declare(strict_types=1);

namespace Igniter\Flame\Scaffold\Console;

use Igniter\Flame\Scaffold\GeneratorCommand;
use Override;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeComponent extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:igniter-component';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new TastyIgniter extension component.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Component';

    /**
     * A mapping of stub to generated file.
     *
     * @var array
     */
    protected $stubs = [
        'component/component.stub' => 'src/Components/{{studly_name}}.php',
        'component/default.stub' => 'resources/views/_components/{{lower_name}}/default.blade.php',
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
        $component = $this->argument('component');

        $this->vars = [
            'extension' => $extension,
            'lower_extension' => strtolower((string)$extension),
            'title_extension' => title_case($extension),
            'studly_extension' => studly_case($extension),

            'author' => $author,
            'lower_author' => strtolower((string)$author),
            'title_author' => title_case($author),
            'studly_author' => studly_case($author),

            'name' => $component,
            'lower_name' => strtolower($component),
            'title_name' => title_case($component),
            'studly_name' => studly_case($component),
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
            ['component', InputArgument::REQUIRED, 'The name of the component. Eg: Block'],
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
