<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MyCriteria.
 */
class MonthSearchCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository.
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('date', '<=', \Carbon\Carbon::parse($this->dt.'27'))
                       ->where('date', '>=', \Carbon\Carbon::parse($this->dt.'01'));

        return $model;
    }

    /**
     * __construct.
     */
    public function __construct($dt)
    {
        $this->dt = $dt;
    }

    private $dt;
}
