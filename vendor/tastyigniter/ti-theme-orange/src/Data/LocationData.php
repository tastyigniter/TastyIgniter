<?php

declare(strict_types=1);

namespace Igniter\Orange\Data;

use Carbon\Carbon;
use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Cart\Classes\OrderTypes;
use Igniter\Cart\Models\Concerns\LocationAction;
use Igniter\Local\Classes\CoveredArea;
use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\Review;
use Igniter\Local\Models\WorkingHour;
use Illuminate\Support\Collection;

final class LocationData
{
    public int $id;

    public string $name;

    public string $description;

    public string $permalink;

    public array $address;

    public bool $hasDelivery;

    public bool $hasCollection;

    public WorkingSchedule $openingSchedule;

    protected ?array $payments = null;

    public function __construct(public LocationModel|LocationAction $model)
    {
        $this->id = $model->getKey();
        $this->name = $model->getName();
        $this->description = $model->getDescription() ?? '';
        $this->permalink = $model->permalink_slug;
        $this->address = $model->getAddress();
        $this->hasDelivery = $model->hasDelivery();
        $this->hasCollection = $model->hasCollection();
        $this->openingSchedule = $model->newWorkingSchedule(LocationModel::OPENING);
    }

    public static function current(): self
    {
        $current = Location::current();

        return new self($current);
    }

    public function url(string $page): string
    {
        return page_url($page, ['location' => $this->model->permalink_slug]);
    }

    public function distance()
    {
        return $this->model->distance;
    }

    public function gallery(): Collection
    {
        return $this->model->getGallery();
    }

    public function hasGallery(): bool
    {
        return $this->model->hasGallery();
    }

    public function hasThumb(): bool
    {
        return $this->model->hasMedia('thumb');
    }

    public function getThumb(array $options = [], ?string $tag = null): ?string
    {
        return $this->model->getThumbOrBlank($options, $tag);
    }

    public function orderType(): ?AbstractOrderType
    {
        return Location::getOrderType();
    }

    public function lastOrderTime(): Carbon
    {
        return Carbon::parse($this->orderType()->getSchedule()->getCloseTime());
    }

    public function orderTypes(): Collection
    {
        return $this->model->availableOrderTypes();
    }

    public function reviewsScore(): float
    {
        return Review::calculateScoreForLocation($this->model);
    }

    public function reviewsCount(): int
    {
        return (int)($this->model?->reviews_count ?: 0);
    }

    public function deliveryAreas(): Collection
    {
        return $this->model->listDeliveryAreas()->mapInto(CoveredArea::class);
    }

    public function payments(): array
    {
        if (!is_null($this->payments)) {
            return $this->payments;
        }

        return $this->payments = $this->model->listAvailablePayments()->pluck('name')->all();
    }

    public function schedules(): Collection
    {
        return $this->model->getWorkingHours()->groupBy(fn($model) => $model->day->isoFormat('dddd'));
    }

    public function scheduleTypes()
    {
        return collect(resolve(OrderTypes::class)->listOrderTypes())
            ->prepend(['name' => 'igniter.local::default.text_opening'], LocationModel::OPENING)
            ->all();
    }

    public function scheduleItems(): array
    {
        $scheduleItems = [];
        foreach ($this->scheduleTypes() as $code => $definition) {
            $schedule = $this->model->createScheduleItem($code);
            foreach ((new WorkingHour)->getWeekDaysOptions() as $index => $day) {
                $hours = array_map(function(array $hour): array {
                    $hour['open'] = now()->setTimeFromTimeString($hour['open'])->isoFormat(lang('system::lang.moment.time_format'));
                    $hour['close'] = now()->setTimeFromTimeString($hour['close'])->isoFormat(lang('system::lang.moment.time_format'));

                    return $hour;
                }, array_get($schedule->getHours(), $index, []));

                $scheduleItems[$code][$day] = array_filter($hours, fn(array $hour): bool => (bool)$hour['status']);
            }
        }

        return $scheduleItems;
    }

    public function openingSchedule(): WorkingSchedule
    {
        return $this->openingSchedule;
    }
}
