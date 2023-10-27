<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function success($data): JsonResponse
    {
        return response()->json($data);
    }

    public function error($errors, string $message = '', int $code = 400): JsonResponse
    {
        return response()->json([
            'errors' => $errors,
            'message' => $message
        ], $code);
    }

    public function uploadFile(UploadedFile $file, string $folder): string
    {
        return Storage::disk('public')->put($folder, $file);
    }

    public function deleteFile($file): bool
    {
        if ($file){
            return Storage::disk('public')->delete($file);
        }

        return false;
    }
}
