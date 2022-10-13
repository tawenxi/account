<?php

namespace App\Model;

use App\Scopes\KJNDScope;
use App\Model\Project\Project;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Zfpz extends Model implements Presentable
{
    // use SearchableTrait;
    use PresentableTrait;
    use \App\Model\Tt\RecordsActivity;
    public $timestamps = true;
    
    public function getZySkrAttribute()
    {
        return $this->attributes['ZY'].' '.$this->attributes['SKR'].' '.$this->attributes['JE'];
    }

    public function getVillageAttribute()
    {
        return filterVillage($this->ZY)?:'其他';
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_number', 'account_number');
    }

    public function scopeHasaccount($query, $account=false)
    {
        if (!$account) {
            return $query->where('account_number', '')->orwhere('account_number', null);
        }

        return $query;
    }

    public function zb()
    {
        return $this->belongsTo(Zb::class, 'ZBID', 'ZBID')->withoutGlobalScopes();
    }

    public function setJeAttribute($amount)
    {
        $this->attributes['JE'] = beint100($amount);
        //dd($this->attributes['JE']);
    }

    public function setQsAttribute()
    {
        $this->attributes['qs'] = $this->attributes['QS_RQ']?1:0;
    }

    public function getJeAttribute($amount)
    {
        return div($this->attributes['JE']/100);
    }

    public function getStatusAttribute($amount)
    {
        if ($this->SH_RQ) {
            if ($this->NEWDYBZ==='已打印') {
                if (!substr($this->QS_RQ,3)) {
                    return '已打印';
                } else {
                    return substr($this->QS_RQ,3);
                }
                
            } else {
                return '未打印';
            }
            
        } else {
            if ($this->qs) {
                return substr($this->QS_RQ,3);
            } else {
                return '未审核';
            }

        }
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    public function point($project_id)
    {
        $this->project()->associate($project_id)->save();
    }

protected $fillable = [
    'XH','KJND','PDQJ','PDH','PDRQ','DJBH','YSDWDM','ZY','SKR','QS_RQ','SKZH','SKRKHYH','FKR','FKZH','FKRKHYH','ZBID','JE','DZKMC','YSDWMC','YSDWQC','ZJXZMC','JSFSMC','YSKMMC','YSKMQC','JFLXMC','JFLXQC','ZFFSMC','ZCLXMC','ZBLYMC','XMMC','YSGLLXMC','NEWDYBZ','NEWZZPZ','NEWPZLY','NEWZT','NEWCXBZ','MXZBWH','BJWH','account_number','received','qs','deleted','fail','beizhu','SH_RQ',
    ];


    // use Searchable;

    // public function toSearchableArray()
    // {
    //     return ['ZY'=>$this->ZY,'SKR'=>$this->SKR];
    // }

}
