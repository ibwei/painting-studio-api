<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    //
    //上传证件照
    public function upload(Request $request)
    {
        $Path   = "/uploads/images/";
        $mypath = "images/";
        if ( ! empty($_FILES["file"])) {
            //获取扩展名
            $exename = $this->getExeName($_FILES['file']['name']);
            if ($exename != 'png' && $exename != 'jpg' && $exename != 'gif') {
                return response()->json(
                    ['resultCode' => 1, 'resultMessage' => '不符合的图片格式.']
                );
            }
            $fileName    = $_SERVER['DOCUMENT_ROOT'] . $Path . date(
                    'Ym'
                ); //文件路径
            $upload_name = '/img_' . date("YmdHis") . rand(0, 100) . '.'
                . $exename; //文件名加后缀
            if ( ! file_exists($fileName)) {
                //进行文件创建
                mkdir($fileName, 0777, true);
            }

            $imageSavePath = $fileName . $upload_name;
            if (move_uploaded_file(
                $_FILES['file']['tmp_name'], $imageSavePath
            )
            ) {
                $path = $mypath . date('Ym') . $upload_name;

                return response()->json(
                    [
                        'resultCode'    => 0,
                        'resultMessage' => '图片上传成功',
                        'data'          => ['path' =>
                            'http:\/\/www.paintingapi.pinxianhs.com\\uploads\\' . $path],]

                );
            }
        }

        return 'err';
    }

    public function getExeName($fileName)
    {
        $pathinfo = pathinfo($fileName);

        return strtolower($pathinfo['extension']);
    }
}
