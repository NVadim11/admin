<?php
namespace Modules\Core\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Arr;

class ImageType extends FormField
{

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'image';
    }

    public function getType()
    {
        return 'file';
    }

    public function getDefaults()
    {
        return [
            'attr' => [
                'class' => '',
            ],
			'rules' => 'mimes:jpg,jpeg,png,gif|max:5000',
        ];
    }

	public function alterFieldValues(&$value)
	{
		$request = $this->parent->getRequest()->all();
		$name = $this->getNameKey();

		$value = $this->parent->getRequest()->file($name);

		if($value instanceof UploadedFile){
			$value = $this->uploadFile($value);
			$this->deleteOldFile(Arr::get($request, $name.'_old', ''));
		}else{
			if(Arr::has($request, $name.'_del')){
				$this->deleteOldFile(Arr::get($request, $name.'_old', ''));
				$value = null;
			}else{
				$value = Arr::get($request, $name.'_old', null);
			}
		}
	}

    protected function uploadFile(UploadedFile $file)
    {
        $stored = $file->store('/images');
        storeWebp($stored);
        getImagePath($stored);
        getWebpPath($stored);

        return $stored;
    }

	protected function deleteOldFile($file_path = ''){
		if($file_path){
			\Storage::delete($file_path);
		}
	}

}