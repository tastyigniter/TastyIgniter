<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use DateTime;
use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Local\Models\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Concerns\SearchesNearby;
use Igniter\System\Facades\Assets;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\Livewire;

final class FulfillmentModal extends Component
{
    use ConfigurableComponent;
    use SearchesNearby;

    public array $timeslotDates = [];

    public array $timeslotTimes = [];

    public string $orderType = '';

    public bool $isAsap = true;

    public string $orderDate = '';

    public string $orderTime = '';

    public string $defaultOrderType = Location::DELIVERY;

    public bool $showAddressPicker = false;

    public ?bool $hideDeliveryAddress = null;

    public ?bool $previewMode = false;

    #[Session]
    public ?string $newSearchQuery = null;

    /**
     * @var \Igniter\Local\Classes\Location
     */
    protected $location;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::fulfillment-modal',
            'name' => 'igniter.orange::default.component_fulfillment_modal_title',
            'description' => 'igniter.orange::default.component_fulfillment_modal_desc',
        ];
    }

    public function defineProperties(): array
    {
        return array_merge([
            'previewMode' => [
                'label' => 'Render the component in preview mode to avoid making changes to order fulfillment.',
                'type' => 'switch',
            ],
            'defaultOrderType' => [
                'label' => 'The default selected order type.',
                'type' => 'select',
                'options' => [Location::class, 'getOrderTypeOptions'],
            ],
        ], $this->definePropertiesSearchNearby());
    }

    public function render(): View
    {
        $hasLocation = $this->location->current() !== null;

        return view('igniter-orange::livewire.fulfillment-modal', [
            'orderTypes' => $this->location->getActiveOrderTypes(),
            'showAsapOption' => $hasLocation ? $this->location->hasAsapSchedule() : true,
            'showLaterOption' => $hasLocation ? $this->location->hasLaterSchedule() : true,
        ]);
    }

    public function mount(): void
    {
        Assets::addJs('igniter-orange::/js/fulfillment.js', 'fulfillment-js');

        $this->parseTimeslot($this->location->scheduleTimeslot());

        $this->orderType = $this->location->orderType();
        $this->isAsap = $this->location->orderTimeIsAsap();
        $this->orderDate = $this->location->orderDateTime()->format('Y-m-d');
        $this->orderTime = $this->location->orderDateTime()->format('H:i');
        $this->hideDeliveryAddress = !$this->location->orderTypeIsDelivery();

        $this->updateCurrentOrderType();
    }

    public function boot(): void
    {
        $this->location = resolve('location');
    }

    public function updating($name, string $value): void
    {
        throw_unless($this->location->current(), ValidationException::withMessages([
            'orderType' => lang('igniter.local::default.alert_location_required'),
        ]));

        throw_if($this->previewMode, ValidationException::withMessages([
            'orderType' => lang('igniter.orange::default.alert_preview_mode'),
        ]));

        if ($name == 'orderType') {
            $this->orderType = $value;
            $this->updateOrderType();
            $this->mount();
        }
    }

    public function onConfirm()
    {
        $this->validate([
            'orderType' => ['required', 'string'],
            'isAsap' => ['required', 'boolean'],
            'orderDate' => ['required_if:isAsap,0'],
            'orderTime' => ['required_if:isAsap,0'],
            'searchQuery' => ['required_if:showAddressPicker,1'],
        ]);

        throw_if($this->previewMode, ValidationException::withMessages([
            'orderType' => lang('igniter.orange::default.alert_preview_mode'),
        ]));

        throw_unless($this->location->current(), ValidationException::withMessages([
            'orderType' => lang('igniter.local::default.alert_location_required'),
        ]));

        $this->updateOrderType();

        $this->updateTimeslot();

        if ($this->searchQuery && $this->showAddressPicker) {
            $userLocation = $this->geocodeSearchQuery($this->searchQuery);
            if ($area = $this->location->current()->searchDeliveryArea($userLocation->getCoordinates())) {
                $this->location->updateUserPosition($userLocation);
                $this->location->updateNearbyArea($area);
                $this->location->putSession('searchQuery', $this->searchQuery);
            } else {
                throw ValidationException::withMessages([
                    'searchQuery' => lang('igniter.local::default.alert_delivery_area_unavailable'),
                ]);
            }
        }

        $this->showAddressPicker = false;

        Event::dispatch('igniter.orange.fulfilmentUpdated');

        return $this->redirect(Livewire::originalUrl());
    }

    protected function parseTimeslot(Collection $timeslot): void
    {
        $this->timeslotDates = [];
        $this->timeslotTimes = [];

        $timeslot->collapse()->each(function(DateTime $slot): void {
            $dateKey = $slot->format('Y-m-d');
            $hourKey = $slot->format('H:i');
            $dateValue = make_carbon($slot)->isoFormat(lang('system::lang.moment.day_format'));
            $hourValue = make_carbon($slot)->isoFormat(lang('system::lang.moment.time_format'));

            $this->timeslotDates[$dateKey] = $dateValue;
            $this->timeslotTimes[$dateKey][$hourKey] = $hourValue;
        });
    }

    protected function updateCurrentOrderType(): void
    {
        if (!$this->location->current() || $this->location->getActiveOrderTypes()->isEmpty()) {
            return;
        }

        $sessionOrderType = $this->location->getSession('orderType');
        if ($sessionOrderType && $this->location->hasOrderType($sessionOrderType)) {
            return;
        }

        $orderType = $this->defaultOrderType;
        if (!$this->location->hasOrderType($orderType)) {
            $orderType = optional($this->location->getActiveOrderTypes()->first())->getCode();
        }

        if ($orderType !== $this->orderType) {
            $this->location->updateOrderType($orderType);
            $this->redirect(Livewire::originalUrl());
        }
    }

    protected function updateOrderType(): void
    {
        throw_unless($orderType = $this->location->getOrderType($this->orderType), ValidationException::withMessages([
            'orderType' => lang('igniter.local::default.alert_order_type_required'),
        ]));

        throw_if($orderType->isDisabled(), ValidationException::withMessages([
            'orderType' => $orderType->getDisabledDescription(),
        ]));

        $this->location->updateOrderType($orderType->getCode());
    }

    protected function updateTimeslot(): void
    {
        throw_unless($this->checkScheduleRestriction($this->isAsap), ValidationException::withMessages([
            'isAsap' => sprintf(lang('igniter.local::default.alert_order_is_unavailable'), $this->location->getOrderType()->getLabel()),
        ]));

        $timeSlotDateTime = $this->isAsap ? now() : make_carbon($this->orderDate.' '.$this->orderTime);
        throw_unless($this->location->checkOrderTime($timeSlotDateTime), ValidationException::withMessages([
            'isAsap' => sprintf(lang('igniter.local::default.alert_order_is_unavailable'), $this->location->getOrderType()->getLabel()),
        ]));

        $this->location->updateScheduleTimeSlot($timeSlotDateTime, $this->isAsap);
    }

    protected function checkScheduleRestriction(?bool $isAsap = null): bool
    {
        $restriction = $this->location->getOrderType()->getScheduleRestriction();

        if ($isAsap === false && $restriction === AbstractOrderType::ASAP_ONLY) {
            return false;
        }

        return !$isAsap || $restriction !== AbstractOrderType::LATER_ONLY;
    }
}
