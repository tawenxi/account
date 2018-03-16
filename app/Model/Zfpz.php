<?php

namespace App\Model;

use App\Scopes\KJNDScope;
use App\Model\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Zfpz extends Model
{
    use SearchableTrait;
    use \App\Model\Tt\RecordsActivity;
    public $timestamps = false;
    
    public function getZySkrAttribute()
    {
        return $this->attributes['ZY'].' '.$this->attributes['SKR'].' '.$this->attributes['JE'];
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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    public function point($project_id)
    {
        $this->project()->associate($project_id)->save();
    }

    protected $fillable = [
            'XH',
            'KJND',
            'PDQJ',
            'PDH',
            'PDRQ',
            'DJBH',
            'YSDWDM',
            'ZY',
            'SKR',
            'QS_RQ',
            'SKZH',
            'SKRKHYH',
            'FKR',
            'FKZH',
            'FKRKHYH',
            'ZBID',
            'JE',
            'DZKMC',
            'YSDWMC',
            'YSDWQC',
            'ZJXZMC',
            'JSFSMC',
            'YSKMMC',
            'YSKMQC',
            'JFLXMC',
            'JFLXQC',
            'ZFFSMC',
            'ZCLXMC',
            'ZBLYMC',
            'XMMC',
            'YSGLLXMC',
            'NEWDYBZ',
            'NEWZZPZ',
            'NEWPZLY',
            'NEWZT',
            'NEWCXBZ',
            'MXZBWH',
            'BJWH',
            'account_number',
            'received',
            'qs',
            'deleted',
            'beizhu'
];
}
