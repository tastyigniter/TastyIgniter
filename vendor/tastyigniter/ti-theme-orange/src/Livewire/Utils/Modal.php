<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire\Utils;

use Igniter\System\Facades\Assets;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Modal extends Component
{
    public ?string $component = null;

    public array $arguments = [];

    public ?string $activeModal = null;

    public function mount(): void
    {
        Assets::addJs('igniter-orange::/js/modal.js', 'modal-js');
    }

    #[On('showModal')]
    public function showModal(?string $component, array $arguments = []): void
    {
        $this->component = $component;
        $this->arguments = $arguments;

        $this->activeModal = 'orange-modal-'.md5($component.serialize($arguments));

        $this->dispatch('showActiveModal', id: $this->activeModal);
    }

    #[On('resetModal')]
    public function resetModal(): void
    {
        $this->reset();
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.utils.modal');
    }
}
