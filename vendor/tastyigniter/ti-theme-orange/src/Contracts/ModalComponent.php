<?php

declare(strict_types=1);

namespace Igniter\Orange\Contracts;

use InvalidArgumentException;
use Livewire\Component;

abstract class ModalComponent extends Component implements ModalComponentInterface
{
    public bool $forceClose = false;

    public int $skipModals = 0;

    public bool $destroySkipped = false;

    protected static array $maxWidths = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-md md:max-w-lg',
        'xl' => 'sm:max-w-md md:max-w-xl',
        '2xl' => 'sm:max-w-md md:max-w-xl lg:max-w-2xl',
        '3xl' => 'sm:max-w-md md:max-w-xl lg:max-w-3xl',
        '4xl' => 'sm:max-w-md md:max-w-xl lg:max-w-3xl xl:max-w-4xl',
        '5xl' => 'sm:max-w-md md:max-w-xl lg:max-w-3xl xl:max-w-5xl',
        '6xl' => 'sm:max-w-md md:max-w-xl lg:max-w-3xl xl:max-w-5xl 2xl:max-w-6xl',
        '7xl' => 'sm:max-w-md md:max-w-xl lg:max-w-3xl xl:max-w-5xl 2xl:max-w-7xl',
    ];

    public function destroySkippedModals(): self
    {
        $this->destroySkipped = true;

        return $this;
    }

    public function skipPreviousModals(int $count = 1, bool $destroy = false): self
    {
        $this->skipPreviousModal($count, $destroy);

        return $this;
    }

    public function skipPreviousModal(int $count = 1, bool $destroy = false): self
    {
        $this->skipModals = $count;
        $this->destroySkipped = $destroy;

        return $this;
    }

    public function forceClose(): self
    {
        $this->forceClose = true;

        return $this;
    }

    public function closeModal(): void
    {
        $this->dispatch('closeModal', force: $this->forceClose, skipPreviousModals: $this->skipModals, destroySkipped: $this->destroySkipped);
    }

    public function closeModalWithEvents(array $events): void
    {
        $this->emitModalEvents($events);
        $this->closeModal();
    }

    public static function modalMaxWidth(): string
    {
        return config('igniter-orange.modal_defaults.modal_max_width', '2xl');
    }

    public static function modalMaxWidthClass(): string
    {
        if (!array_key_exists(static::modalMaxWidth(), static::$maxWidths)) {
            throw new InvalidArgumentException(
                sprintf('Modal max width [%s] is invalid. The width must be one of the following [%s].',
                    static::modalMaxWidth(), implode(', ', array_keys(static::$maxWidths))),
            );
        }

        return static::$maxWidths[static::modalMaxWidth()];
    }

    public static function closeModalOnClickAway(): bool
    {
        return config('igniter-orange.modal_defaults.close_modal_on_click_away', true);
    }

    public static function closeModalOnEscape(): bool
    {
        return config('igniter-orange.modal_defaults.close_modal_on_escape', true);
    }

    public static function closeModalOnEscapeIsForceful(): bool
    {
        return config('igniter-orange.modal_defaults.close_modal_on_escape_is_forceful', true);
    }

    public static function dispatchCloseEvent(): bool
    {
        return config('igniter-orange.modal_defaults.dispatch_close_event', false);
    }

    public static function destroyOnClose(): bool
    {
        return config('igniter-orange.modal_defaults.destroy_on_close', false);
    }

    private function emitModalEvents(array $events): void
    {
        foreach ($events as $component => $event) {
            if (is_array($event)) {
                [$event, $params] = $event;
            }

            if (is_numeric($component)) {
                $this->dispatch($event, ...$params ?? []);
            } else {
                $this->dispatch($event, ...$params ?? [])->to($component);
            }
        }
    }
}
