<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;

class GalleriesTable extends Table
{

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }

} 