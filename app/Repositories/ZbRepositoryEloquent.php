<?php

namespace App\Repositories;

use App\Model\Zb;
use App\Validators\ZbValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ZbRepositoryEloquent.
 */
class ZbRepositoryEloquent extends BaseRepository implements ZbRepository, CacheableInterface
{
    use CacheableRepository;

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Zb::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
        return ZbValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    protected $fieldSearchable = [
        'ZY'=> 'like',
        'JE',
        'yeamount'=>'>',
        'YSDWMC'=> 'like',
        'LR_RQ'=>'like',
    ];
}
