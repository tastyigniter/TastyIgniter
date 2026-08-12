<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers\Tables;

use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Http\Controllers\AdminPageController;
use Naxas\RestaurantOps\Models\Floor;
use Naxas\RestaurantOps\Tables\TableException;
use Naxas\RestaurantOps\Tables\TableManagementService;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class FloorsController extends AdminPageController
{
    public function __construct(private readonly TableManagementService $tables) { parent::__construct(); }
    public function index(): Response { return response()->json(['data'=>Floor::where('location_id', app(LocationContextContract::class)->currentId())->orderBy('sort_order')->get()]); }
    public function store(): Response { return $this->respond(fn()=> $this->tables->saveFloor($this->user(), request()->all()), 201); }
    public function update(string $floor): Response { return $this->respond(fn()=> $this->tables->saveFloor($this->user(), request()->all(), Floor::findOrFail($floor))); }
    private function respond(callable $cb, int $status=200): Response { try { return response()->json(['data'=>$cb()], $status); } catch(TableException $e){ return response()->json(['error'=>['code'=>$e->errorCode,'message'=>$e->getMessage()]], $e->status); } catch(Throwable $e){ report($e); return response()->json(['error'=>['code'=>'floor_operation_failed','message'=>'The floor operation could not be completed safely.']],409); } }
    private function user(): mixed { return app('admin.auth')->user(); }
}
