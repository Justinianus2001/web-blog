<?php

namespace App\Helpers;

use Image;

class AppHelper
{
    public static function randStr($length = 15): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public static function randEmail(): string
    {
        return self::randStr() . '@gmail.com';
    }

    public static function uploadImage($image, $folder): string
    {
        $imageName = $folder . '/' . self::randStr() . '.' . $image->getClientOriginalExtension();
        $imageDir = public_path('storage/' . $imageName);
        Image::make($image)->resize(980, 980)->save($imageDir);

        return $imageName;
    }
}
