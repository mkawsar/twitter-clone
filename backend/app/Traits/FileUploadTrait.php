<?php

namespace App\Traits;

use App\Models\FileUpload;
use Intervention\Image\Facades\Image;

trait FileUploadTrait
{
    public function upload($file, $userID)
    {
        $fileName = uniqid() . rand() . '.' . $file->getClientOriginalExtension();
        $filePath = 'profile/image';
        $file->storeAs($filePath, $fileName, 'public');

        $save_path = storage_path('app/public/profile/image/thumb/');
        if (!file_exists($save_path)) {
            mkdir($save_path, 0777, true);
        }
        $thumbPath = storage_path('app/public/profile/image/thumb/' . $fileName);
        Image::make($file->getRealPath())->resize(96, 96)->save($thumbPath);

        return $fileName;
    }
}
