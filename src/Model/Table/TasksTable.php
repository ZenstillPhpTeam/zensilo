<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;

class TasksTable extends Table
{

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
	    'foreignKey' => 'project_id',
	    ]);

    }


} 