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

class HomeController extends AppController
{
	public function beforeFilter(Event $event)
	{
		$this->viewBuilder()->layout('home_layout');
	}

	public function index()
	{
		$this->Users = TableRegistry::get('Users');

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$data['username'] = Inflector::slug(strtolower($data['name']), "-");
			$password = $data['password'];
			$hasher = new DefaultPasswordHasher();
            $data['password'] = $hasher->hash($password);
            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your tool is ready. Login and check it now'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Sorry!! Unable to create your company tool. Please try again.'));
		}
	}
}