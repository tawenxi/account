<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MyCriteria.
 */
class FindSkrOrZyCriteria implements CriteriaInterface
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
        return $model->where('ZY', 'like', '%'.$this->keyword.'%')->orWhere('SKR' ,'like', '%'.$this->keyword.'%');
    }
    public function __construct($keyword)
    {
        $this->keyword = $keyword;
    }

    private $keyword;    
}
