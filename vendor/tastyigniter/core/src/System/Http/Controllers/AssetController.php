<?php

declare(strict_types=1);

namespace Igniter\System\Http\Controllers;

use Igniter\System\Facades\Assets;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AssetController extends Controller
{
    public function __invoke(Request $request, ?string $asset = null): Response
    {
        $parts = explode('-', (string)$asset);
        $cacheKey = $parts[0];

        return Assets::combineGetContents($cacheKey);
    }
}
