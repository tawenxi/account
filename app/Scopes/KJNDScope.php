<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class KJNDScope implements Scope
{
    /**
     * 应用作用域
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (strstr(url()->current(),'/project') OR 
            strstr(url()->current(),'/village') OR 
            strstr(url()->current(),'/divider') OR 
            strstr(url()->current(),'/point')) {
            return $builder;
        }
        return $builder->where('kjnd', session('ND',config('app.MYND')));
    }
}