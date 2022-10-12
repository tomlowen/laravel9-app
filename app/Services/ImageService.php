<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Store an image
     *
     * @param string $url
     * @param Model $imageable
     * @param UploadedFile $file
     *
     * @return App\Models\Image
     */
    public function storeImage($url, $imageable, $file = null)
    {
        $fileType = $file ? $file->extension : '.png';
        $filename = Str::uuid() . $fileType;

        if (!$file) {
            $file = file_get_contents($url);
        }

        Storage::disk('public')->put($filename, $file);

        return Image::create([
            'name' => 'default name',
            'type' => 'default type',
            'filename' => $filename,
            'order' => 1,
            'imageable_id' => $imageable->id,
            'imageable_type' => $imageable::MORPH_KEY,
        ]);
    }
}
