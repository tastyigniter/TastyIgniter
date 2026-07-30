<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Igniter\Local\Models\Review as ReviewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Override;

final class StarRating extends Component
{
    protected static ?array $hints = null;

    public function __construct(
        public string $name = '',
        public float $score = 0,
        public float $max = 5,
        public bool $readOnly = true,
    ) {
        $this->max = max(1, count($this->getHints()));
    }

    #[Override]
    public function render(): View
    {
        return view('igniter-orange::components.star-rating', [
            'hints' => $this->getHints(),
        ]);
    }

    protected function getHints()
    {
        return self::$hints ??= (new ReviewModel)->getRatingOptions();
    }
}
