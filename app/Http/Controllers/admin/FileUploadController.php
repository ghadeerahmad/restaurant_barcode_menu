<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    /**
     * upload image using ckeditor
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ckupload(Request $request){
        if($request->hasFile('upload')){
            $file = $request->file('upload');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('uploads',$fileName,'public');
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }
}
