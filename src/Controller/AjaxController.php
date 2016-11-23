<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\Utility\Inflector;

class AjaxController extends AppController
{
	public function beforeFilter(Event $event)
	{
		$this->autoRender = false;
	}

	public function checkUniqueData($field, $value)
	{
		if($field == 'username')
			$value = Inflector::slug(strtolower($value), "-");

		$this->Users = TableRegistry::get('Users');

		echo $this->Users->find("all", ["conditions" => [$field => $value]])->count();
		exit;
	}

	public function copyTask($id)
	{
		
		$this->Tasks = TableRegistry::get('Tasks');

		echo $this->Tasks->get($id);
		exit;
	}


}