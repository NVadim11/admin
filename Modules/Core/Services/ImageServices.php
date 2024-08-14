<?php
namespace Modules\Core\Services;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;
use WebPConvert\WebPConvert;

/**
 * Optionally may use https://unsplash.it/
 *
 * Class ImageServices
 * @package Modules\Core\Services
 */
class ImageServices
{
    public function getImagePath($path, $width, $height, $type)
    {
        $width = $width ?? config('image.default_image_width');
        $height = $height ?? config('image.default_image_height');
        $type = $type ?? config('image.default_image_process_type');

        if($this->externalLink($path)){
            return $path;
        }

        $images_path = config('image.images_path');
        $path = ltrim($path, "/");

        //returns the original image if isn't passed width and height
        if ($this->notSizes($width, $height)) {
            return url("{$images_path}/" . $path);
        }

        //if thumbnail exist returns it
        if (File::exists(public_path("{$images_path}/{$type}/" . "{$width}x{$height}/" . $path))) {
            return url("{$images_path}/{$type}/" . "{$width}x{$height}/" . $path);
        }

        //If original image doesn't exists returns a default image which shows that original image doesn't exist.
        if (!File::exists(public_path("{$images_path}/" . $path))) {
            return "http://placehold.it/{$width}x{$height}";
        }

        $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
        $contentType = \mime_content_type(public_path("{$images_path}/" . $path));

        if (in_array($contentType, $allowedMimeTypes)) { //Checks if is an image

            $image = self::imageProcessing($path, $images_path, $width, $height, $type);

            //relative directory path starting from main directory of images
            $dir_path = (dirname($path) == '.') ? "" : dirname($path);

            //Create the directory if it doesn't exist
            if (!File::exists(public_path("{$images_path}/{$type}/" . "{$width}x{$height}/" . $dir_path))) {
                File::makeDirectory(public_path("{$images_path}/{$type}/" . "{$width}x{$height}/" . $dir_path), 0775, true);
            }

            //Save the thumbnail
            $image->save(public_path("{$images_path}/{$type}/" . "{$width}x{$height}/" . $path));

            //return the url of the thumbnail
            return url("{$images_path}/{$type}/" . "{$width}x{$height}/" . $path);
        } else {
            //return a placeholder image
            return url("{$images_path}/" . $path);
        }
    }

    public function getWebpPath($path, $width, $height, $type)
    {
        $width = $width ?? config('image.default_image_width');
        $height = $height ?? config('image.default_image_height');
        $type = $type ?? config('image.default_image_process_type');

        if($this->externalLink($path)){
            return $path;
        }

        $images_path = config('image.images_path');
        $path = ltrim($path, "/");
        $webp_path = 'webp/' . stristr(str_replace('images/', '', $path), '.', true).'.webp';

        if ($this->notSizes($width, $height)) {
            return url("{$images_path}/images/" . $webp_path);
        }

        if (!File::exists(public_path("{$images_path}/images/" . $webp_path))) {
            return "http://placehold.it/{$width}x{$height}";
        }

        if (File::exists(public_path("{$images_path}/{$type}/" . "{$width}x{$height}/" . $webp_path))) {
            return url("{$images_path}/{$type}/" . "{$width}x{$height}/" . $webp_path);
        } else {
            if (File::exists(public_path("{$images_path}/{$type}/" . "{$width}x{$height}/" . $path))) {
                $dir_path = (dirname($webp_path) == '.') ? "" : dirname($webp_path);

                if (!File::exists(public_path("{$images_path}/{$type}/" . "{$width}x{$height}/" . $dir_path))) {
                    File::makeDirectory(public_path("{$images_path}/{$type}/" . "{$width}x{$height}/" . $dir_path), 0775, true);
                }

                WebPConvert::convert(public_path("{$images_path}/{$type}/" . "{$width}x{$height}/" . $path), public_path("{$images_path}/{$type}/" . "{$width}x{$height}/" . $webp_path), $options = []);

                return url("{$images_path}/{$type}/" . "{$width}x{$height}/" . $webp_path);
            }
        }

        return url("{$images_path}/" . $path);
    }

    public function imageProcessing($path, $images_path, $width, $height, $type) {

        $image = Image::make(public_path("{$images_path}/" . $path));

        switch ($type) {
            case "crop": {
                $image->fit($width, $height, function ($constraint) {
                    $constraint->upsize();
                });
                break;
            }
            case "resize":
                $image_height = $image->getHeight();
                $image_width = $image->getWidth();
                $new_height = $height;
                $new_width = $width;

                if($image_height > $image_width){
                    $new_width = null;
                }else{
                    $new_height = null;
                }

                $image->resize($new_width, $new_height, function ($constraint) {
//                        //keeps aspect ratio and sets black background
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                break;

            case "thumb":
                $image_height = $image->getHeight();
                $image_width = $image->getWidth();
                $new_height = $height;
                $new_width = $width;

                if($image_height > $image_width){
                    $new_width = null;
                }else{
                    $new_height = null;
                }

                $image->resize($new_width, $new_height, function ($constraint) {
                    //keeps aspect ratio and sets black background
                    $constraint->aspectRatio();
                });
                $image->resizeCanvas($width, $height, 'center', false, 'rgba(255, 255, 255, 0)'); //gets the center part
                break;

            case "resizeCanvas": {
                $image->resizeCanvas($width, $height, 'center', false, 'rgba(255, 255, 255, 0)'); //gets the center part
            }
        }

        return $image;
    }

    public function getWebp($path)
    {
        if( config('image.default_image_width') &&
            config('image.default_image_height'))
        {
            $width = config('image.default_image_width');
            $height = config('image.default_image_height');
            $type = config('image.default_image_process_type');

            return (stristr(str_replace('images', "{$type}/{$width}x{$height}/webp", $path), '.', true).'.webp');
        } else {
            return (stristr(str_replace('images', 'images/webp', $path), '.', true).'.webp');
        }
    }

    public function getImg($path)
    {
        if( config('image.default_image_width') &&
            config('image.default_image_height'))
        {
            $width = config('image.default_image_width');
            $height = config('image.default_image_height');
            $type = config('image.default_image_process_type');

            return str_replace('images', "{$type}/{$width}x{$height}/images", $path);
        } else {
            return $path;
        }
    }

    function imageExists($path) : bool
    {
        return \Illuminate\Support\Facades\File::exists(public_path($path));
    }

    public function notSizes($width, $height) : bool
    {
        return is_null($width) && is_null($height);
    }

    public function externalLink($path) : bool
    {
        return (bool) strstr($path, '://');
    }
}