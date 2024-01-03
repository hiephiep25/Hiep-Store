<?php

namespace App\Services;

use App\Models\User;
use App\Models\Document;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

class DocumentService
{
    public function get(array $params): LengthAwarePaginator
    {
        $user = Auth::user();
        $status = $params['status'] ?? '';
        $perPage = $params['per_page'] ?? PER_PAGE;

        return Document::where('supplier_id', $user->id)
            ->when(!empty($status), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('id', 'asc')
            ->paginate($perPage);
    }

    public function getAllDocuments(array $params): LengthAwarePaginator
    {
        $status = $params['status'] ?? '';
        $supplier_id = $params['supplier_id'] ?? '';
        $perPage = $params['per_page'] ?? PER_PAGE;
        return Document::where(function ($query) use ($status, $supplier_id) {
            if (!empty($status)) {
                $query->where('status', $status);
            }
            if (!empty($supplier_id)) {
                $query->where('supplier_id', $supplier_id);
            }
        })->orderBy('id', 'asc')->paginate($perPage);
    }

    public function create(array $data): Document
    {
        $user = Auth::user();

        $image = '/public/documents/product_image/' . Str::slug($user->id);
        $name1 = $data['image']->getClientOriginalName();
        $path1 = Storage::putFileAs($image, $data['image'], $name1);
        $data['image'] = url(Storage::url($path1));

        $licenseCompany = '/public/documents/license_company/' . Str::slug($user->id);
        $name = $data['license_company']->getClientOriginalName();
        $path = Storage::putFileAs($licenseCompany, $data['license_company'], $name);
        $data['license_company'] = url(Storage::url($path));

        $licenseProduct = '/public/documents/license_product/' . Str::slug($user->id);
        $name2 = $data['license_product']->getClientOriginalName();
        $path2 = Storage::putFileAs($licenseProduct, $data['license_product'], $name2);
        $data['license_product'] = url(Storage::url($path2));

        $document = Document::create([
            ...$data,
        ]);

        return $document;
    }

    public function update(array $data, $id): Document
    {

        $document = $this->findDocumentById($id);

        if ($document->status == Document::APPROVED || $document->status == Document::DENIED) {
            throw new Exception("Cannot edit a document that has been approved or denied.");
        }

        $createdAtDiff = Carbon::now()->diffInDays($document->created_at);
        if ($createdAtDiff > 1) {
            throw new Exception("Cannot edit a document created more than 1 day ago.");
        }

        if (isset($data['license_company'])) {
            $data['license_company'] = $this->updateImage($document->license_company, $data['license_company'], 'license_company');
        }

        if (isset($data['license_product'])) {
            $data['license_product'] = $this->updateImage($document->license_product, $data['license_product'], 'license_product');
        }

        $document->update($data);

        return $document;
    }

    protected function updateImage($oldImageUrl, $newImage, $folder): string
    {
        $this->deleteImage($oldImageUrl);

        $directory = '/public/documents/' . $folder . '/' . Str::slug(Auth::id());
        $name = $newImage->getClientOriginalName();
        $path = Storage::putFileAs($directory, $newImage, $name);

        return url(Storage::url($path));
    }

    public function findDocumentById(int $id)
    {
        return Document::findOrFail($id);
    }

    public function findMyDocumentById(int $id)
    {
        $user = Auth::user();
        return Document::where('supplier_id', $user->id)->findOrFail($id);
    }

    protected function deleteImage($imageUrl): void
    {
        $imagePath = str_replace(url('/storage'), '', $imageUrl);
        $image = public_path('storage' . $imagePath);

        if (file_exists($image)) {
            unlink($image);
        }
    }

    public function delete(int $id)
    {
        $document = $this->findMyDocumentById($id);
        if ($document->status == Document::APPROVED) {
            throw new Exception("Cannot delete a document that has been approved");
        }
        $this->deleteImage($document->license_company);
        $this->deleteImage($document->license_product);
        $document->delete();
    }
}
