<?php

namespace App\Repositories;

use App\Model\Salary;
use App\Validators\SalaryValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class SalaryRepositoryEloquent.
 */
class SalaryRepositoryEloquent extends BaseRepository implements SalaryRepository, CacheableInterface
{
    use CacheableRepository;

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Salary::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
        return SalaryValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria.
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
