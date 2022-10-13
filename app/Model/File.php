<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Zb;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File extends Model
{
	public $fillable = ['title','name','url','ZBID'];
    public function zb()
    {
        return $this->belongsTo(Zb::class, 'ZBID', 'ZBID')->withoutGlobalScopes();
    }



    protected $baseDir = 'excel/';
    public $filename;

    public function flyer()
    {
        return $this->belongsTo(Flyer::class);
    }

    public static function named($name,$data)
    {
        return (new static)->saveAs($name,$data);
    }


    protected function saveAs($filename,$data)
    {
        $this->title = $data['title'];
        $this->name = $data['name'];
        $this->url = sprintf("%s/%s", '/'.$this->baseDir, $filename);
        $this->type = substr($filename,-3);
       
        $this->filename = $filename;
        return $this;
    }

    public function move(UploadedFile $file)
    {
        $file->move($this->baseDir, $this->filename);
        return $this;
    }
}
