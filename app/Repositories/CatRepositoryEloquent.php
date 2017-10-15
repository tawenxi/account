<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CatRepository;
use App\Entities\Cat;
use App\Validators\CatValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class CatRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CatRepositoryEloquent extends BaseRepository implements CatRepository
{
   // use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    protected $skipPresenter = true;
    public function model()
    {
        return Cat::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CatValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    protected $fieldSearchable = [
        'name'=>'like',
        'bumen'
    ];


    public function presenter()
    {
        return "\App\Presenters\CatPresenter";
    }
}
