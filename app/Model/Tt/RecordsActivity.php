<?php

namespace App\Model\Tt;

use App\Model\Activity;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
    	foreach (static::getModelEvents() as $event) {
        	static::$event(function($model) use ($event){
        		$model->recordActivity($event);
        	});
        }
    }

    public function getActivityName($model, $action)
    {
    	$name = strtolower((new \ReflectionClass($model))->getShortName());
    	return "{$action}_{$name}";
    }

    protected function recordActivity($event)
    {
    	Activity::create([
    		'subject_id' => $this->id,
    		'subject_type' => get_class($this),
    		'name' => $this-> getActivityName($this, $event),
    		'user_id' => 39,
    	]);
    }

    protected static function getModelEvents()
    {
    	if (isset(static::$recordEvent)) {
    		return static::$recordEvent;
    	}
    	return ['created', 'updated','deleted'];
    }



    
}
