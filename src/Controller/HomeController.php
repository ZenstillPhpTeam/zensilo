<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;

class HomeController extends AppController
{
	public function beforeFilter(Event $event)
	{
		$this->viewBuilder()->layout('home_layout');
	}

	public function index()
	{

	}
}