<?php

declare(strict_types=1);

namespace Igniter\Flame\Scaffold\Console;

use Igniter\Flame\Scaffold\GeneratorCommand;
use Override;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeExtension extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:igniter-extension';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new TastyIgniter extension.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Extension';

    /**
     * A mapping of stub to generated file.
     *
     * @var array
     */
    protected $stubs = [
        'extension.stub' => 'src/Extension.php',
        'composer.stub' => 'composer.json',
    ];

    #[Override]
    protected function prepareVars(): ?bool
    {
        if (!$code = $this->getExtensionInput()) {
            $this->error('Invalid extension name, Example name: AuthorName.ExtensionName');

            return false;
        }

        [$author, $name] = $code;

        $this->vars = [
            'name' => $name,
            'lower_name' => strtolower((string)$name),
            'title_name' => title_case($name),
            'studly_name' => studly_case($name),

            'author' => $author,
            'lower_author' => strtolower((string)$author),
            'title_author' => title_case($author),
            'studly_author' => studly_case($author),
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
