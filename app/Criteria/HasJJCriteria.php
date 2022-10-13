<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MyCriteria.
 */
class HasJJCriteria implements CriteriaInterface
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
        switch ($this->jj) {
            case '1':
                return $model = $model->where('jjbz', null);
                break;

            case '2':
                return $model = $model->where('jjbz', 2);
                break;

            default:
                return $model;
                break;
        }
    }

    /**
     * __construct.
     */
    public function __construct($jj)
    {
        $this->jj = $jj;
    }

    private $jj;
}
