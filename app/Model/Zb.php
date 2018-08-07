<?php

namespace App\Model;

use App\Model\Zb;
use App\Model\File;
use App\Scopes\KJNDScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Nicolaslopezj\Searchable\SearchableTrait;
use App\Model\Project\Project;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Zb extends Model implements Presentable
{
    use SearchableTrait;
    use PresentableTrait;
    use \App\Model\Tt\RecordsActivity;

    /**
     * Searchable rules.
     *
     * @var array
     */

    public $timestamps = false;
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_number', 'account_number');
    }

    public function prezbid()
    {   
        $prezbid = static::withoutGlobalScopes()->where('zbid',$this->prezbid)->first();
        if ($prezbid) {
            return $prezbid;
        }
        return false;
    }

    public function transforToOrigin()
    {
        if ($this->originzbid) {
            return static::withoutGlobalScopes()->where('ZBID',$this->originzbid)->first();
        }
        return $this; 
    }

    public function isOriginZb()
    {
        return $this->originzbid?false:true;
    }

    public function zfpzs()
    {
        return $this->hasMany(Zfpz::class, 'ZBID', 'ZBID');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'ZBID', 'ZBID');
    }

    public static function locatedAt($id)
    {
        return static::where('id', $id)->firstOrFail();
    }

    public function addFile(File $file)
    {
        return $this->files()->save($file);
    }

    public function GetDetailAttribute()
    {
        return $this->zfpzs->sum('JE');
    }
    public function GetOriginZbYearAttribute()
    {
        return $year = substr($this->originzbid,7,1);
    }
    public function scopeHasaccount($query, $account)
    {
        if (!$account) {
            return $query->where('account_number', null);
        }

        return $query;
    }

    public function setZbyeAttribute($amount)
    {
        $this->attributes['ZBYE'] = beint100($amount);
    }

    public function getZbyeAttribute($amount)
    {
        return div($this->attributes['ZBYE']/100);
    }

    public function setYeamountAttribute($amount)
    {
        $this->attributes['yeamount'] = beint100($amount);
    }

    public function getYeamountAttribute($amount)
    {
        return div($this->attributes['yeamount']/100);
    }

    public function setJeAttribute($amount)
    {
        $this->attributes['JE'] = beint100($amount);
    }

    public function getJeAttribute($amount)
    {
        return div($this->attributes['JE']/100);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('amount');
    }

    public function divide($project_id, $amount)
    {
        $project = $this->projects->where('id', $project_id)->first();
        if ($project) {
            $amount = $project->pivot->amount + $amount;
            $this->projects()->updateExistingPivot($project_id, compact('amount'));
        } else {
            $this->projects()->attach($project_id,compact('amount'));
        }
    }

    public function judgeAmountEnough($request)
    {
        $project = $this->projects->where('id', $request['project_id'])->first();
        if (isset($project)) {
            $amount_would_divided = $project->pivot->amount + $request['amount'];
        } else {
            $amount_would_divided = $request['amount'];
        }
        if ($amount_would_divided > $this->JE) {
            return false;
        } 
         return true;
    }

    public function deletedivide($project_id, $amount)
    {
        $this->projects()->detach($project_id);
    }


    public function shouquan()
    {
        return $this->hasMany('App\Model\Guzzledb', 'ZBID', 'ZBID');
    }

    public function zhijie()
    {
        return $this->hasMany('App\Model\Zjzb', 'ZBID', 'ZBID');
    }

    protected $fillable = [
    'id', 'GSDM', 'KJND', 'MXZBLB', 'MXZBBH', 'MXZBWH', 'MXZBXH', 'ZZBLB', 'ZZBBH', 'FWRQ', 'DZKDM', 'YSDWDM', 'ZBLYDM', 'YSKMDM', 'ZJXZDM', 'JFLXDM', 'ZCLXDM', 'XMDM', 'ZFFSDM', 'JE', 'ZY', 'LRR_ID', 'LRR', 'LR_RQ', 'XGR_ID', 'CSR_ID', 'CSR', 'CS_RQ', 'HQBZ', 'HQWCBZ', 'SHJBR_ID', 'SHR_ID', 'SHR', 'SH_RQ', 'SNJZ', 'NCYS', 'BNZA', 'BNZF', 'BNBF', 'ZBYE', 'SJLY', 'YZBLB', 'YSGLLXDM', 'ZBZT', 'TZBZ', 'JZRQ', 'ZBID', 'ZBIDWM', 'DCBZ', 'DCRID', 'STAMP', 'OAZT', 'TZH', 'JZR_ID', 'PZFLH', 'JZR_ID1', 'PZFLH1', 'DJZT', 'SCJHJE', 'DYBZ', 'YWLXDM', 'XMFLDM', 'SJWH', 'KZZLDM1', 'ASHR_ID', 'ASHR', 'ASH_RQ', 'ASHJD', 'AXSHJD', 'ASFTH', 'ZBLB', 'DZKMC', 'ZBLYMC', 'YSDWMC', 'YSDWQC', 'YSKMMC', 'YSKMQC', 'ZJXZMC', 'XMMC', 'YSGLLXMC', 'HQNAME', 'ZZBWH', 'ZZBXH','YWLXMC','XMFLMC','JFLXMC','JFLXQC','prezbid','originzbid'

    ];
}
