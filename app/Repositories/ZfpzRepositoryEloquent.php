<?php

namespace App\Repositories;

use App\Model\Zfpz;
use App\Validators\ZfpzValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ZfpzRepositoryEloquent.
 */
class ZfpzRepositoryEloquent extends BaseRepository implements ZfpzRepository, CacheableInterface
{
    use CacheableRepository;

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Zfpz::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
        return ZfpzValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    protected $fieldSearchable = [
        'ZY'    => 'like',
        'SKR'   => 'like',
        'ZFFSMC'=> 'like',
        'JE',
        'YSDWMC'=> 'like',
        'QS_RQ'=> 'like',
        'PDRQ'=> 'like',
        'received',
        'fail',
        'deleted'
    ];

    protected $skipPresenter = true;
//开启 present功能
    public function presenter()
    {
        return "App\\Presenters\\ZfpzPresenter";
    }
}
