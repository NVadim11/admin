<?php

if(!function_exists('getImagePath')){
    function getImagePath($path, $width = null, $height = null, $type = null)
    {
        return app('Modules\Core\Services\ImageServices')
            ->getImagePath(
                $path,
                $width,
                $height,
                $type
            );
    }
}

if(!function_exists('getWebpPath')){
    function getWebpPath($path, $width = null, $height = null, $type = null)
    {
        return app('Modules\Core\Services\ImageServices')
            ->getWebpPath(
                $path,
                $width,
                $height,
                $type
            );
    }
}

if(!function_exists('getImg')){
    function getImg($path)
    {
        return app('Modules\Core\Services\ImageServices')->getImg($path);
    }
}

if(!function_exists('getWebp')){
    function getWebp($path)
    {
        return app('Modules\Core\Services\ImageServices')->getWebp($path);
    }
}

if(!function_exists('imageExists')){
    function imageExists($path)
    {
        return app('Modules\Core\Services\ImageServices')->imageExists($path);
    }
}

if(!function_exists('storeWebp')){
    function storeWebp($stored, $sorcePath = 'images/')
    {
        $originalPath = '/uploads/';
        $webpPath = '/uploads/images/webp/';
        $webpFilePath = public_path($webpPath);
        $name = stristr(str_replace($sorcePath, '', $stored), '.', true);
        $options = [];

        if (!Illuminate\Support\Facades\File::exists($webpFilePath.$name.'.webp')) {
            WebPConvert\WebPConvert::convert(public_path($originalPath) . $stored, $webpFilePath . $name . '.webp', $options);
        }
    }
}

if(!function_exists('_')){
    function _($text)
    {
        return $text;
    }
}

if(!function_exists('url_without_locale')){
	function url_without_locale(){
		$segments = request()->segments();
		unset($segments[1]);

		return '/'.implode('/', $segments);
	}
}

if(!function_exists('seed_get_random_image')){
    function seed_get_random_image($width = 640, $height = 480)
    {
        return app('Modules\Core\Services\Seed\RandomImage')->getImage($width, $height);

    }
}

if(!function_exists('customer_auth')){
    function customer_auth()
    {
        return Auth::guard('account')->check();
    }
}

if(!function_exists('makeBlocks')){
    function makeBlocks($path)
    {
        return app('Modules\Core\Services\ConstructorServices')->makeBlocks($path);
    }
}

if(!function_exists('renderHtml')){
    function renderHtml($path)
    {
        return app('Modules\Core\Services\ConstructorServices')->renderHtml($path);
    }
}

if(!function_exists('visible')){
    function visible($relation)
    {
        return $relation->where('vis', 1);
    }
}

if(!function_exists('checkToken')){
    function checkToken($token)
    {
        return app('Modules\Core\Services\AccessTokenService')->checkToken($token);
    }
}
