<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;

class MailsTable extends Table
{

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');

        $this->hasMany('MailParticipants', [
            'foreignKey' => 'mail_id',
            'dependent' => true,
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'mail_from',
        ]);
    }

}