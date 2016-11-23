<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;

class ProjectsTable extends Table
{

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
	    'foreignKey' => 'company_id',
	    ]);

	    $this->hasMany('Tasks', [
	    'foreignKey' => 'project_id',
	    ]);

    }


} 