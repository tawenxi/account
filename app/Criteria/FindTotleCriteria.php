<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MyCriteria.
 */
class FindTotleCriteria implements CriteriaInterface
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
        return $model->where('ZY', $this->keyword->ZY)
                     ->where('PDRQ', $this->keyword->PDRQ)
                     ->where('SKR', $this->keyword->SKR);
    }

    public function __construct($keyword)
    {
        $this->keyword = $keyword;
    }

    private $keyword;
}
