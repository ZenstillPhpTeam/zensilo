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

	public function checkUniqueData($field='', $value='')
	{
		if($field == '' && count($_GET))
		{
			if(isset($_GET['username']))
			{
				$field = 'username';
				$value = $_GET['username'];
			}
			elseif(isset($_GET['email']))
			{
				$field = 'email';
				$value = $_GET['email'];
			}
		}
		elseif($field == 'username')
			$value = Inflector::slug(strtolower($value), "-");

		$this->Users = TableRegistry::get('Users');

		$res = $this->Users->find("all", ["conditions" => [$field => $value]])->count();
		echo $res ? false : true;
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

	public function updateImportantMail($id, $status){
		$this->Mail = TableRegistry::get('mails');
		$data = $this->Mail->get($id);
		$data = $this->Mail->patchEntity($data, array('starred' => $status));
		$data = $this->Mail->save($data);
		exit;
	}

	public function bulkAction(){
		if(isset($this->request->data['ids']))
		{
			$this->Mail = TableRegistry::get('mails');

			if($this->request->data['action'] == 'trash')
				$udata = array('status' => 2);
			elseif($this->request->data['action'] == 'important')
				$udata = array('starred' => 1);
			elseif($this->request->data['action'] == 'unimportant')
				$udata = array('starred' => 0);
			elseif($this->request->data['action'] == 'revert')
				$udata = array('status' => 0);

			foreach ($this->request->data['ids'] as $key => $value) {
				$data = $this->Mail->get($value);
				
				if($this->request->data['action'] == 'remove')
				{
					$this->Mail->delete($data);
				}
				else
				{
					$this->Mail->save($this->Mail->patchEntity($data, $udata));
				}
			}
		}
		exit;
	}
}