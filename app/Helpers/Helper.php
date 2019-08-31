<?php

// use Intervention\Image\File;
// use Intervention\Image\Facades\Image;

function savePhoto($name, $photo, $location)
{
        $images = str_slug($name) . time() . '.' . $photo->getClientOriginalExtension();
        $path = storage_path('app/public/' . $location); // otomatis masuk ke folder storage

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        Image::make($photo)->resize(600, 400)->save($path . '/' . $images);
        return $location . '/' . $images;
}

function savePhotoOriginal($name, $photo, $location)
{
        $images = str_slug($name) . time() . '.' . $photo->getClientOriginalExtension();
        $path = storage_path('app/public/' . $location); // otomatis masuk ke folder storage

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        Image::make($photo)->save($path . '/' . $images);
        return $location . '/' . $images;
}

?>
