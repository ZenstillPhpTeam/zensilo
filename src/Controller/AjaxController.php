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
use OpenTok\OpenTok;

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

	public function opentok()
	{
		$apikey = '45724832';
		$apiSecret = 'b44885a224293a63db94465cfcf8d936245f5fdd';
		$apiObj = new OpenTok($apikey, $apiSecret);
		$session = $apiObj->createSession();
		$sessionId = $session->getSessionId(); 
		$token = $apiObj->generateToken($sessionId);
		
		echo json_encode(array('apikey' => $apikey, 'sessionId' => $sessionId, 'token' => $token));
		exit;
	}

	public function gettask($id){
		$this->Tasks = TableRegistry::get('Tasks');
		$json =array();
		$json =  $this->Tasks->get($id);
		if($json)
		echo json_encode($json);
		exit;
	}
}