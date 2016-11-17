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

		if($this->is_sub_domain())
            return $this->redirect("http://zensilo.com/".strtolower($this->request->params['controller']).'/'.strtolower($this->request->params['action']));
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
            $user = $this->Users->patchEntity($user, $data);
            $res = $this->Users->save($user);
            if ($res) {
                $this->Flash->success(__('Your tool is ready. Login and check it now'));
                if($this->is_localhost())
                    return $this->redirect(['action' => 'setlogin', $res->id]); 
                else
                    return $this->redirect("http://".$data['username'].".zensilo.com/users/setlogin");
            }
            $this->Flash->error(__('Sorry!! Unable to create your company tool. Please try again.'));
		}
	}
}