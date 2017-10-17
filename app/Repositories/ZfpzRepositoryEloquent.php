<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ZfpzRepository;
use App\Model\Zfpz;
use App\Validators\ZfpzValidator;
use Prettus\Repository\Traits\CacheableRepository;


/**
 * Class ZfpzRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ZfpzRepositoryEloquent extends BaseRepository implements ZfpzRepository
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Zfpz::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ZfpzValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    protected $fieldSearchable = [
        'ZY'=>'like',
        'SKR'=>'like',
        'ZFFSMC'=>'like',
        'JE',
        'YSDWMC'=>'like',
    ];
}
