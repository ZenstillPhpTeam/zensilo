<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;

class LeaveRequestsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'users',
                'action' => 'dashboard'
            ],
            'logoutRedirect' => [
                'controller' => 'users',
                'action' => 'login'
            ],
        ]);

    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        if($this->Auth->user())
        {
            $this->viewBuilder()->layout('inner_layout');
            $this->set('loggedInUser', $this->Auth->user());
        }
    }	

    public function request($id = 0, $action = '')
    {
        $this->LeaveRequest = TableRegistry::get('leave_requests');
        
        $user_id = $this->Auth->user('id');
		
        if($action == 'delete')
        {
            $this->LeaveRequest->delete($this->LeaveRequest->get($id));
            $this->Flash->success('Leave request has been deleted successfully!!');
            $this->redirect(array("action" => 'request'));
        }
        elseif ($this->request->is('post') )
        { 
			
            $request = $this->LeaveRequest->newEntity();

            $this->request->data['user_id'] = $user_id;
            $request = $this->LeaveRequest->patchEntity($request, $this->request->data);
            
            if ($this->LeaveRequest->save($request)) {
				
                $this->Flash->success(__('The request has been saved.'));
                return $this->redirect(['action' => 'request']);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        elseif($id)
        {
            $request = $this->LeaveRequest->get($id);
            $this->set('request', $request);
        }

		$requests =  $this->LeaveRequest->find('all',['conditions' => ['user_id' => $user_id]])->order(['id' => 'DESC']); 
        $this->set('requests', $requests);
    }

    public function response($id = 0, $action = '')
    {
        $this->LeaveRequest = TableRegistry::get('leave_requests');
        
        $user_id = $this->Auth->user('id');
        
        if($action == 'accept')
        {
            $accept = $this->LeaveRequest->get($id);
            $accept->status = 1;
            if($this->LeaveRequest->save($accept)){
                $this->Flash->success('Leave request has been accepted successfully!!');
                $this->redirect(array("action"=>'response'));
            }
        }
        elseif($action == 'reject')
        {
            $accept = $this->LeaveRequest->get($id);
            $accept->status = 2;
            if($this->LeaveRequest->save($accept)){
                $this->Flash->success('Leave request has been rejected successfully!!');
                $this->redirect(array("action"=>'response'));
            }
        }
        elseif($id)
        {
            $request = $this->LeaveRequest->find('all')
            ->leftJoin('users', 'users.id = leave_requests.user_id')->where(['leave_requests.id' => $id,'users.parent_id' => $user_id])
            ->select(['leave_requests.id','leave_requests.no_of_days','leave_requests.start_date','leave_requests.end_date','leave_requests.reason','leave_requests.status','leave_requests.created','users.username']);;
            $this->set('request', $request);
        }

        $requests =  $this->LeaveRequest->find('all')->order(['leave_requests.status' => 'ASC', 'leave_requests.id' => 'DESC'])
        ->leftJoin('users', 'users.id = leave_requests.user_id')->where(['users.parent_id' => $user_id])
        ->select(['leave_requests.id','leave_requests.no_of_days','leave_requests.start_date','leave_requests.end_date','leave_requests.reason','leave_requests.status','leave_requests.created','users.username']);

        $this->set('requests', $requests);
    }
   
}