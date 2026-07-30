<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Flame\Database\Attach\Media;
use League\Fractal\TransformerAbstract;

class MediaTransformer extends TransformerAbstract
{
    public function transform(Media $media)
    {
        return $media->toArray();
    }
}
