<?php

namespace App\Traits;

use App\Models\FileUpload;
use Intervention\Image\Facades\Image;

trait FileUploadTrait
{
    public function upload($file, $userID)
    {
        $type = $file->getClientOriginalExtension();
        $fileName = uniqid() . rand() . '.' . $file->getClientOriginalExtension();
        $filePath = 'profile/' . $userID . '/image';
        $path = $file->storeAs($filePath, $fileName, 'public');
        $path = 'storage/' . $path;


        $save_path = storage_path('app/public/profile/' . $userID . '/image/thumb/');
        if (!file_exists($save_path)) {
            mkdir($save_path, 0777, true);
        }
        $thumbPath = storage_path('app/public/profile/' . $userID . '/image/thumb/' . $fileName);
        Image::make($file->getRealPath())->resize(96, 96)->save($thumbPath);

        $thumb_path = 'storage/' . $userID . '/image/thumb/' . $fileName;

        $new = new FileUpload();
        $new->path = $path;
        $new->thumb_path = $thumb_path;
        $new->type = $type;
        $new->save();

        return $new->uuid;
    }
}
