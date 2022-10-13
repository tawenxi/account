<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ZjzbRepository;
use App\Model\Zjzb;
use App\Validators\ZjzbValidator;

/**
 * Class ZjzbRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ZjzbRepositoryEloquent extends BaseRepository implements ZjzbRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Zjzb::class;
    }



    protected $fieldSearchable = [
        'ZY'    => 'like',
        'KYJHJE'=> '!=',
        'YSDWMC'=> 'like',
        'useable',
    ];
    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ZjzbValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
