<?php
namespace Modules\Core\Services\Seed;

class RandomImage
{
    private $list_images_url = 'https://picsum.photos/list';
    private $base_url = 'https://picsum.photos/';
    private $image_list = [];

    public function getImage($width = 640, $height = 480)
    {
        $image = $this->getRandomImage();

        return $this->base_url.$width.'/'.$height.'?image='.$image['id'];
    }

    private function getRandomImage()
    {
        if(!$this->image_list){
            $this->image_list = json_decode(file_get_contents($this->list_images_url), true);
        }

        return array_random($this->image_list);
    }
}