<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Modules\Core\Services\TranslitServices;

class ImagesController extends Controller
{
    protected function stringToSlug($value)
    {
        return app()->make(TranslitServices::class)->toUrl($value);
    }

    public function uploadOne(Request $request)
    {
        $this->validate($request, [
            'image' => 'image'
        ]);

        $file = $request->file('image');

        if($file instanceof UploadedFile) {
            try{
                $image = $file->store('/images/page');
                $response['uploadName'] = '/uploads/'.$image;
                $response['success'] = true;
            }catch (\Exception $e){
                $response['error'] = $e->getMessage();
            }

        }else{
            $response['error'] = "Ошибка при загрузке файла";
        }

        return response()->json($response);
    }

    public function uploadFile(Request $request)
    {
        $this->validate($request, [
            'file' => 'file'
        ]);

        $file = $request->file('file');

        if($file instanceof UploadedFile) {
            try{
                $name = $this->stringToSlug($file->getClientOriginalName()) . '-' .  uniqid() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('/files', $name);

                $response['uploadName'] = '/uploads/files/' . $name;
                $response['success'] = true;
            }catch (\Exception $e){
                $response['error'] = $e->getMessage();
            }

        }else{
            $response['error'] = "Ошибка при загрузке файла";
        }

        return response()->json($response);
    }

    public function uploadOneBy(Request $request)
    {
        $file = $request->file();
        $response['images'] = [];

        foreach($file as $k => $val) {
            $file[$k] = $val;

            if ($file[$k] instanceof UploadedFile) {
                try {
                    $image[$k] = $file[$k]->store('/images/page');
                    $response['images'][$k] = '/uploads/' . $image[$k];
                    $response['success'] = true;
                } catch (\Exception $e) {
                    $response['error'] = $e->getMessage();
                }

            } else {
                $response['error'] = "Ошибка при загрузке файла";
            }
        }

        return response()->json($response);
    }

    public function uploadMany(Request $request)
    {
        foreach ($request->get('items') as $k => $item) {
            $file = $request->file('image' . $k);

            if ($file instanceof UploadedFile) {
                try {
                    $image = $file->store('/images/page');
                    $response[$k]['uploadName'] = '/uploads/' . $image;
                    $response[$k]['success'] = true;
                } catch (\Exception $e) {
                    $response[$k]['error'] = $e->getMessage();
                }

            } else {
                $response[$k]['error'] = "Ошибка при загрузке файла";
            }
        }

        return response()->json($response);
    }

    public function uploadManyCustom(Request $request)
    {
        foreach ($request->get('items') as $k => $item) {
            $file1 = $request->file('image1' . $k);
            $file2 = $request->file('image2' . $k);
            $file3 = $request->file('image3' . $k);
            $file4 = $request->file('image4' . $k);
            $file5 = $request->file('image5' . $k);

            if ($file1 instanceof UploadedFile) {
                try {
                    $image = $file1->store('/images/page');
                    $response[$k]['uploadName1'] = '/uploads/' . $image;
                    $response[$k]['success1'] = true;
                } catch (\Exception $e) {
                    $response[$k]['error1'] = $e->getMessage();
                }

            } else {
                $response[$k]['error1'] = "Ошибка при загрузке файла";
            }

            if ($file2 instanceof UploadedFile) {
                try {
                    $image = $file2->store('/images/page');
                    $response[$k]['uploadName2'] = '/uploads/' . $image;
                    $response[$k]['success2'] = true;
                } catch (\Exception $e) {
                    $response[$k]['error2'] = $e->getMessage();
                }

            } else {
                $response[$k]['error2'] = "Ошибка при загрузке файла";
            }

            if ($file3 instanceof UploadedFile) {
                try {
                    $image = $file3->store('/images/page');
                    $response[$k]['uploadName3'] = '/uploads/' . $image;
                    $response[$k]['success3'] = true;
                } catch (\Exception $e) {
                    $response[$k]['error3'] = $e->getMessage();
                }

            } else {
                $response[$k]['error3'] = "Ошибка при загрузке файла";
            }

            if ($file4 instanceof UploadedFile) {
                try {
                    $image = $file4->store('/images/page');
                    $response[$k]['uploadName4'] = '/uploads/' . $image;
                    $response[$k]['success4'] = true;
                } catch (\Exception $e) {
                    $response[$k]['error4'] = $e->getMessage();
                }

            } else {
                $response[$k]['error4'] = "Ошибка при загрузке файла";
            }

            if ($file5 instanceof UploadedFile) {
                try {
                    $image = $file5->store('/images/page');
                    $response[$k]['uploadName5'] = '/uploads/' . $image;
                    $response[$k]['success5'] = true;
                } catch (\Exception $e) {
                    $response[$k]['error5'] = $e->getMessage();
                }

            } else {
                $response[$k]['error5'] = "Ошибка при загрузке файла";
            }
        }

        return response()->json($response);
    }


    public function upload(Request $request)
    {
        $this->validate($request, [
            'qqfile' => 'image'
        ]);

        $data = [];
        $id = $request->get('id');
        $table = $request->get('table');
        $link = $request->get('link') != 'undefined' ? $request->get('link', false) : '';
        $file = $request->file('file');

        if($file instanceof UploadedFile) {
            try{
                $image = $file->store('/images');
                storeWebp($image);

                $data['image'] = $image;
                if($link){
                    $data[$link] = $id;
                }

                $uuid = \DB::table($table)->insertGetId($data);
                getImagePath($image);
                getWebpPath($image);

                $response['uploadName'] = getImagePath($image, 120, 100);
                $response['image'] = \Storage::url($image);
                $response['success'] = true;
                $response['uuid'] = $uuid;
                $response['file-id'] = $uuid;
                $response['file_id'] = $uuid;
            }catch (\Exception $e){
                $response['error'] = $e->getMessage();
            }

        }else{
            $response['error'] = "Ошибка при загрузке файла";
        }

        return response()->json($response);
    }

    public function files_list(Request $request)
    {
        $id = $request->get('id');
        $table = $request->get('table');
        $link = $request->get('link', false);

        if($link && $link != 'undefined'){
            $items = \DB::table($table)->select(\DB::raw('*, id as uuid, image as name'))->where($link, $id)->get();
        }else{
            $items = \DB::table($table)->select(\DB::raw('*, id as uuid, image as name'))->get();
        }

        foreach ($items as $item) {
            $item->thumbnailUrl = getImagePath($item->name, 120, 100);
        }

        return response()->json($items);
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $table = $request->get('table');
        $response = ['result' => false];

        if($id){
            $item = \DB::table($table)->find($id);
            \Storage::delete($item->image);
            \DB::table($table)->delete($id);
            $response['result'] = true;
        }

        return response()->json($response);
    }

    public function sortImages(Request $request)
    {
        $ret = 0;
        $ids = $request->query->get('ids', []);
        $table = preg_replace('/[^A-z0-9-_]/', '', $request->query->get('tbl', ''));
        $pos = 0;

        foreach ($ids as $id) {
            if ($id == '') continue;
            $this->q->format("UPDATE " . $table . " SET pos = " . $pos . " WHERE id = %d ", $id);
            $pos++;
        }

        return response()->json(['success' => true]);
    }
}