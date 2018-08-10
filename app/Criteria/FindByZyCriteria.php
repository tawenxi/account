<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MyCriteria.
 */
class FindByZyCriteria implements CriteriaInterface
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
        if (is_numeric($this->keyword)) {
            return $model->where('ZBYE', $this->keyword*100)->with(['projects','files','zfpzs','shouquan','zhijie']);
        }
        return $model->where('ZY', 'like', '%'.$this->keyword.'%')->with(['projects','files','zfpzs','shouquan','zhijie']);
    }

    public function __construct($keyword)
    {
        $this->keyword = $keyword;
    }

    private $keyword;
}
