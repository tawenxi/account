<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MyCriteria.
 */
class YearSearchCriteria implements CriteriaInterface
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
        $model = $model->where('date', '>=', \Carbon\Carbon::parse($this->year.'-01-01'))
                          ->where('date', '<=', \Carbon\Carbon::parse($this->year.'-12-31'));

        return $model;
    }

    /**
     * __construct.
     */
    public function __construct($year)
    {
        $this->year = $year;
    }

    private $year;
}
