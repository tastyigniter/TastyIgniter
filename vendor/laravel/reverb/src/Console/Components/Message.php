<?php

namespace Laravel\Reverb\Console\Components;

use Illuminate\Console\View\Components\Component;
use Symfony\Component\Console\Output\OutputInterface;

class Message extends Component
{
    /**
     * Renders the component using the given arguments.
     */
    public function render(string $message, int $verbosity = OutputInterface::VERBOSITY_NORMAL): void
    {
        $this->renderView('message', [
            'message' => $message,
        ], $verbosity);
    }

    /**
     * Compile the given view contents.
     *
     * @param  string  $view
     * @param  array  $data
     * @return void
     */
    protected function compile($view, $data)
    {
        extract($data);

        ob_start();

        include __DIR__."/views/$view.php";

        return tap(ob_get_contents(), function () {
            ob_end_clean();
        });
    }
}
