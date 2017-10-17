<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SalaryRepository;
use App\Model\Salary;
use App\Validators\SalaryValidator;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class SalaryRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SalaryRepositoryEloquent extends BaseRepository implements SalaryRepository
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Salary::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return SalaryValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function resetModel()
    {
        $this->makeModel();
        $this->resetCriteria();
    }

}
