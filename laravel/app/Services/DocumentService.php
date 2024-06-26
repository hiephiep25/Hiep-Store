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
use App\Services\NotificationService;

class DocumentService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

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

    public function getSuppliers()
    {
        return User::where('role', User::ROLE_SUPPLIER)->get();
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
        $data['image'] = str_replace('public/', 'storage/', $path1);

        $licenseCompany = '/public/documents/license_company/' . Str::slug($user->id);
        $name = $data['license_company']->getClientOriginalName();
        $path = Storage::putFileAs($licenseCompany, $data['license_company'], $name);
        $data['license_company'] =  str_replace('public/', 'storage/', $path);

        $licenseProduct = '/public/documents/license_product/' . Str::slug($user->id);
        $name2 = $data['license_product']->getClientOriginalName();
        $path2 = Storage::putFileAs($licenseProduct, $data['license_product'], $name2);
        $data['license_product'] = str_replace('public/', 'storage/', $path2);

        $document = Document::create($data);
        $this->notificationService->createNotification(1, 'create-document');

        return $document;
    }

    public function update(array $data, $id): Document
    {
        $document = $this->findDocumentById($id);

        if ($document->status == Document::APPROVED || $document->status == Document::DENIED) {
            throw new Exception("Không thể chỉnh sửa tài liệu đã được phê duyệt hoặc từ chối");
        }

        $createdAtDiff = Carbon::now()->diffInDays($document->created_at);
        if ($createdAtDiff > 1) {
            throw new Exception("Không thể chỉnh sửa tài liệu đã tạo được hơn 1 ngày");
        }

        if (isset($data['image'])) {
            $data['image'] = $this->updateImage($document->image, $data['image'], 'product_image');
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
        $directory = '/public/documents/' . $folder . '/' . Str::slug(Auth::id());
        $this->deleteImage($oldImageUrl);

        $name = $newImage->getClientOriginalName();
        $path = Storage::putFileAs($directory, $newImage, $name);

        return str_replace('public/', 'storage/', $path);
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
        if (file_exists($imageUrl)) {
            unlink($imageUrl);
        }
    }

    public function delete(int $id)
    {
        $document = $this->findMyDocumentById($id);
        if ($document->status == Document::APPROVED) {
            throw new Exception("Không thể xóa tài liệu đã được phê duyệt");
        }
        $this->deleteImage($document->image);
        $this->deleteImage($document->license_company);
        $this->deleteImage($document->license_product);
        $document->delete();
    }

    public function approve(int $id)
    {
        $document = $this->findDocumentById($id);
        if ($document->status === Document::AWAIT_APPROVAL) {
            $document->status = Document::APPROVED;
            $document->save();
            $this->notificationService->createNotification($document->supplier_id, 'approve-document');
        } else {
            abort(422, 'Không thể phê duyệt tài liệu đang không có trạng thái chờ phê duyệt');
        }
    }

    public function deny(int $id)
    {
        $document = $this->findDocumentById($id);
        if ($document->status === Document::AWAIT_APPROVAL) {
            $document->status = Document::DENIED;
            $document->save();
            $this->notificationService->createNotification($document->supplier_id, 'deny-document');
        } else {
            abort(422, 'Không thể từ chối tài liệu đang không có trạng thái chờ phê duyệt');
        }
    }
}
