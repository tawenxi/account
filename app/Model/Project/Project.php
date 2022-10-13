<?php

namespace App\Model\Project;

use App\Model\Zb;
use App\Model\Zfpz;
use Illuminate\Database\Eloquent\Model;
use App\Model\Project\Village;

class Project extends Model
{
    public $fillable = ['name','village_id','category','year','bidprice','contractprice','settlementprice','describe','budget'];
    public $timestamps = false;

    public static function locatedAt($id)
    {
    	return Static::whereId($id);

    }

    public function zfpzs()
    {
    	return $this->hasMany(Zfpz::Class);
    }

    public function zbs()
    {
        return $this->belongsToMany(Zb::class)->withPivot('amount');
    }

    public function village()
    {
        return $this->belongsTo(Village::Class);
    }

    public function scopeVillage($query, $village_id)
    {
        if ($village_id > 0) {
            return $query->where('village_id',$village_id);
        }
        return $query;
    }
}
