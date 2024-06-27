<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProcessService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcessController extends Controller
{
    public $processService;

    public function __construct(ProcessService $processService)
    {
        $this->processService = $processService;
    }

    public function index(Request $request)
    {
        $params = $request->only(['per_page']);
        $staffs = $this->processService->get($params);
        return JsonResource::collection($staffs);
    }

    public function create(Request $request): JsonResource
    {
        $processData = $request->only(['store_id', 'product_code', 'qty', 'option']);
        $process = $this->processService->create($processData);
        return new JsonResource($process);
    }

    public function show(int $id): JsonResource
    {
        $process = $this->processService->findProcessById($id);
        return new JsonResource($process);
    }
}
