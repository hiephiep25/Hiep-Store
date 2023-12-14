<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\DocumentRequest;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentController extends Controller
{
    public $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function getMyDocuments(Request $request)
    {
        $params = $request->only(['per_page']);
        $documents = $this->documentService->get($params);
        return JsonResource::collection($documents);
    }

    public function getAllDocuments(Request $request)
    {
        $params = $request->only(['per_page', 'status', 'supplier_id']);
        $documents = $this->documentService->getAllDocuments($params);
        return JsonResource::collection($documents);
    }

    public function create(DocumentRequest $request): JsonResource
    {
        $documentData = $request->only(['supplier_id', 'product_name', 'category', 'description', 'qty', 'price',
                                'manufacture_day', 'expiry_day', 'image', 'license_company', 'license_product']);
        $document = $this->documentService->create($documentData);
        return new JsonResource($document);
    }

    public function show(int $id): JsonResource
    {
        $document = $this->documentService->findDocumentById($id);
        return new JsonResource($document);
    }

    public function showMyDocuments(int $id): JsonResource
    {
        $document = $this->documentService->findDocumentById($id);
        return new JsonResource($document);
    }

    public function update(DocumentRequest $request, string $id): JsonResource
    {
        $documentData = $request->only(['supplier_id', 'product_name', 'category', 'description', 'qty', 'price',
                                'manufacture_day', 'expiry_day', 'image', 'license_company', 'license_product']);
        $document = $this->documentService->update($documentData, $id);
        return new JsonResource($document);
    }

    public function delete(int $id)
    {
        $this->documentService->delete($id);

        return $this->success();
    }
}
