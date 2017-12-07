<?php

namespace App\Repositories;

use App\Model\Guzzledb;
use App\Validators\GuzzledbValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class GuzzledbRepositoryEloquent.
 */
class GuzzledbRepositoryEloquent extends BaseRepository implements GuzzledbRepository, CacheableInterface
{
    use CacheableRepository;

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Guzzledb::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
        return GuzzledbValidator::class;
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
        'KYJHJE'=> '!=',
        'YSDWMC'=> 'like',
        'useable',
    ];
}
