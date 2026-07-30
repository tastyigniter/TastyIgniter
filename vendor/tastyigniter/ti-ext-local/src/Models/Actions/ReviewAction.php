<?php

declare(strict_types=1);

namespace Igniter\Local\Models\Actions;

use Igniter\Flame\Database\Model;
use Igniter\Local\Models\Review;
use Igniter\System\Actions\ModelAction;

class ReviewAction extends ModelAction
{
    public function __construct(?Model $model)
    {
        parent::__construct($model);

        $this->model->relation['morphMany']['review'] = [Review::class, 'name' => 'reviewable'];
    }

    public function leaveReview(array $attributes): Review
    {
        return Review::leaveReview($this->model, $attributes);
    }
}
