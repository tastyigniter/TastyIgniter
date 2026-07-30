<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire\Utils;

use Igniter\Flame\Flash\Facades\Flash;
use Igniter\Flame\Flash\Message;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use stdClass;

final class FlashMessage extends Component
{
    public array $messages = [];

    #[On('flashMessageAdded')]
    public function updateMessages($messages): void
    {
        $this->messages = array_merge($this->messages, $messages);
    }

    public function mount(): void
    {
        $this->messages = Flash::all()->map(fn(Message $message): stdClass => (object)$message->toArray())->all();
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.utils.flash-message');
    }
}
