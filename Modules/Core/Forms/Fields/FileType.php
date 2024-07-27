<?php
namespace Modules\Core\Forms\Fields;

use Illuminate\Http\UploadedFile;
use Kris\LaravelFormBuilder\Fields\FormField;
use Modules\Core\Services\TranslitServices;
use Illuminate\Support\Arr;

class FileType extends FormField
{

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'file';
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
            if( Arr::has($request, $name.'_del') ){
                $this->deleteOldFile(Arr::get($request, $name.'_old', ''));
                $value = null;
            }else{
                $value = Arr::get($request, $name.'_old', null);
            }
        }
    }

    protected function uploadFile(UploadedFile $file)
    {
        $name = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName());

        return $file->storeAs('/files', $this->stringToSlug($name) . '_' . str_replace(['.', ' '], '', microtime(false)) . '.' . $file->getClientOriginalExtension());
//        return $file->store('/files');
    }

    protected function deleteOldFile($file_path = ''){
        if($file_path){
            \Storage::delete($file_path);
        }
    }

	protected function stringToSlug($value)
	{
		return app()->make(TranslitServices::class)->toUrl($value);
	}
}