<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\File;
use App\MOdel\Zb;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index($zbid)
    {
    	$zb = Zb::find($zbid);
    	$results = $zb->files;
    	return view('file.index', compact('results','zb'));
    }

    public function uploadFile(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required'
        ]);

        $data = $request->all();

        $File = $this->makeFile($request->file('file'),$data);

        Zb::locatedAt($request->zb)->addFile($File);

    }

    public function makeFile(UploadedFile $file ,$data)
    {
        return File::named($file->getClientOriginalName() ,$data)->move($file);
    }


    public function deleteFile($id)
    {
        $file = File::find($id);


        if(Storage::delete('/public/'.$file->url)){
            flash()->success('Woohoo', '删除成功'); 
            
        }else{
            flash()->success('Woohoo', '删除失败'); 
        }
        return redirect()->back();
    }
}
