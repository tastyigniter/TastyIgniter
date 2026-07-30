<?php

declare(strict_types=1);

namespace Igniter\Flame\Scaffold\Console;

use Carbon\Carbon;
use Igniter\Flame\Scaffold\GeneratorCommand;
use Override;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeModel extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:igniter-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new TastyIgniter model.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * A mapping of stub to generated file.
     *
     * @var array
     */
    protected $stubs = [
        'model/model.stub' => 'src/Models/{{studly_name}}.php',
        'model/create_table.stub' => 'database/migrations/{{timestamp}}_create_{{lower_author}}_{{snake_plural_name}}_table.php',
        'model/config.stub' => 'resources/models/{{lower_name}}.php',
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
        $model = $this->argument('model');

        $this->vars = [
            'timestamp' => Carbon::now()->format('Y_m_d_Hmi'),
            'extension' => $extension,
            'lower_extension' => strtolower((string)$extension),
            'title_extension' => title_case($extension),
            'studly_extension' => studly_case($extension),

            'author' => $author,
            'lower_author' => strtolower((string)$author),
            'title_author' => title_case($author),
            'studly_author' => studly_case($author),

            'name' => $model,
            'lower_name' => strtolower($model),
            'title_name' => title_case($model),
            'studly_name' => studly_case($model),
            'plural_name' => str_plural($model),
            'studly_plural_name' => studly_case(str_plural($model)),
            'snake_plural_name' => snake_case(str_plural($model)),
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
            ['model', InputArgument::REQUIRED, 'The name of the model. Eg: Block'],
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
