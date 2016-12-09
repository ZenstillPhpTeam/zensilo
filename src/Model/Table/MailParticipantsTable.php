<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;

class MailParticipantsTable extends Table
{

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');

        $this->belongsTo('Mails', [
            'foreignKey' => 'mail_id',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
    }

}