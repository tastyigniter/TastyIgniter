<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Reservation\Classes\BookingManager;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

final class ReservationPreview extends Component
{
    use ConfigurableComponent;

    public string $hashParamName = 'hash';

    public ?string $hash = null;

    public bool $showCancelButton = false;

    /**
     * @var BookingManager
     */
    protected $manager;

    protected ?Reservation $reservation = null;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::reservation-preview',
            'name' => 'igniter.orange::default.component_reservation_preview_title',
            'description' => 'igniter.orange::default.component_reservation_preview_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'hashParamName' => [
                'label' => 'URL routing parameter that holds the code used for displaying the reservation confirmation page.',
                'type' => 'text',
                'validationRule' => 'required|alpha',
            ],
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.reservation-preview', [
            'reservation' => $this->getReservation(),
        ]);
    }

    public function boot(): void
    {
        $this->manager = resolve(BookingManager::class);
    }

    public function mount(?string $hash = null): void
    {
        $this->hash = $hash ?? request()->route()->parameter($this->hashParamName);
        $this->showCancelButton = $this->showCancelButton();
    }

    public function onCancel(): void
    {
        throw_unless($reservation = $this->getReservation(), ValidationException::withMessages([
            'onCancel' => lang('igniter.reservation::default.alert_cancel_failed'),
        ]));

        throw_unless($this->showCancelButton(), ValidationException::withMessages([
            'onCancel' => lang('igniter.reservation::default.alert_cancel_failed'),
        ]));

        throw_unless($reservation->markAsCanceled(), ValidationException::withMessages([
            'onCancel' => lang('igniter.reservation::default.alert_cancel_failed'),
        ]));

        flash()->success(lang('igniter.reservation::default.alert_cancel_success'));
    }

    protected function showCancelButton(): bool
    {
        return $this->getReservation() && !$this->getReservation()->isCanceled() && $this->getReservation()->isCancelable();
    }

    protected function getReservation()
    {
        return tap($this->reservation ??= $this->manager->getReservationByHash($this->hash, Auth::customer()), function($reservation): void {
            if ($reservation) {
                $this->manager->useLocation($reservation->location);
            }
        });
    }
}
