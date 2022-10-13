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
    	$zb = Zb::withoutGlobalScopes()->find($zbid);
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
            \Session::flash('success','删除成功');     
        }else{
            \Session::flash('success','删除失败');  
        }
         $file->delete();
        //return redirect()->back();
    }



    public function findexcel()
    {
        $files = Storage::allFiles('public/excel');

    $files = collect($files)->filter(function($val){
        return strstr($val,'.xl') AND !strstr($val, '~$');
    });

   // dd($files);

        foreach ($files as $file) {
            $file = substr($file,7);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

            $count = $spreadsheet->getSheetCount();

            $currentIndex = 0;

            do {
                
                    $worksheet = $spreadsheet->getSheet($currentIndex);

                    // Get the highest row number and column letter referenced in the worksheet
                    $highestRow = $worksheet->getHighestRow(); // e.g. 10
                    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                    // Increment the highest column letter
                    $highestColumn++;

                    echo '<table>' . "\n";
                    for ($row = 1; $row <= $highestRow; ++$row) {
                        echo '<tr>' . PHP_EOL;
                        for ($col = 'A'; $col != $highestColumn; ++$col) {
                            echo '<td>' .
                                 $cell_value = $worksheet->getCell($col . $row)
                                     ->getValue() .
                                 '</td>' . PHP_EOL;
                                 if (strstr($cell_value,'更新')) {
                                    dump('finded');
                                 }
                        }
                        echo '</tr>' . PHP_EOL;
                    }
                    echo '</table>' . PHP_EOL;

                    //dd(strstr($cell_value,'更新'));

                    
                    $currentIndex++;

                    dump('==============================================================================================================================================================================');

            } while ($currentIndex < $count);
        }


    }
}
