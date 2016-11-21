<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;
class CompanyController extends AppController
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
	    // Allow users to register and logout.
	    // You should not add the "login" action to allow list. Doing so would
	    // cause problems with normal functioning of AuthComponent.

	    $this->Auth->allow(['index', 'add', 'logout', 'forgotPassword', 'resetPassword','view', 'verify']);

        if($this->Auth->user())
        {
            $this->viewBuilder()->layout('inner_layout');
            $this->set('loggedInUser', $this->Auth->user());
        }
        
	}

    

    public function setting(){

    }


    public function designation($id = 0, $action = ''){
       
       $this->Designation = TableRegistry::get('designations');

       $siteurl =  Router::url('/', true);


       if($action == 'delete')
       {
            $this->Designation->delete($this->Designation->get($id));
            $this->Flash->success('Designation has been deleted successfully!!');
            $this->redirect(array("action" => 'designation'));
       }
       elseif ($this->request->is('post') )
       {
            $data = $this->request->data;

            if(isset($data['id'])){
                $user = $this->Designation->get($data['id']);
                $user = $this->Designation->patchEntity($user, $this->request->data);
                $user_save  = $this->Designation->save($user);
                if ($user_save) {
                    //echo  $data['id'];
                   
                    $this->Flash->success('Designation has been updated successfully!!');
                    //$this->set('success_msg', 'Client Details has been updated successfully!!');
                }
            }
            else{
                $user = $this->Designation->newEntity();
                if($this->Auth->user('userrole') != "admin")
                 $this->request->data['company_id'] = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
             //$this->request->data['company_id'] = 8;
            //print_r($this->request->data);exit;
             //pr($user);exit;
                $user = $this->Designation->patchEntity($user, $this->request->data);
                    //pr($user);exit;
                $user_save  = $this->Designation->save($user);
               
                if ($user_save) {
                   
                    $this->Flash->success('New Designation has been added successfully!!');
                    //$this->set('success_msg', 'New Client has been added successfully!!');

                }else
                $this->Flash->error('Unable to add Designation!!');
                }

            $this->redirect(array("action" => 'designation'));
       }
       elseif($id)
       {
            $designation = $this->Designation->get($id);
                $this->set('client', $designation);
       }

      $parent_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
       
       $designation = $this->Designation->find('all',['conditions' => ["company_id" => $parent_id ]]);
      
       
       $this->set('designation', $designation);
       $this->set('siteurl', $siteurl);
    }


     public function leavetypes($id = 0, $action = ''){
       
       $this->LeaveType = TableRegistry::get('leave_types');

       $siteurl =  Router::url('/', true);


       if($action == 'delete')
       {
            $this->LeaveType->delete($this->LeaveType->get($id));
            $this->Flash->success('Leave Type has been deleted successfully!!');
            $this->redirect(array("action" => 'leavetypes'));
       }
       elseif ($this->request->is('post') )
       {
            $data = $this->request->data;

            if(isset($data['id'])){
                $user = $this->LeaveType->get($data['id']);
                $user = $this->LeaveType->patchEntity($user, $this->request->data);
                $user_save  = $this->LeaveType->save($user);
                if ($user_save) {
                    //echo  $data['id'];
                   
                    $this->Flash->success('Leave Type has been updated successfully!!');
                    //$this->set('success_msg', 'Client Details has been updated successfully!!');
                }
            }
            else{
                $user = $this->LeaveType->newEntity();
                if($this->Auth->user('userrole') != "admin")
                 $this->request->data['company_id'] = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
             //$this->request->data['company_id'] = 8;
            //print_r($this->request->data);exit;
             //pr($user);exit;
                $user = $this->LeaveType->patchEntity($user, $this->request->data);
                    //pr($user);exit;
                $user_save  = $this->LeaveType->save($user);
               
                if ($user_save) {
                   
                    $this->Flash->success('New Leave Type has been added successfully!!');
                    //$this->set('success_msg', 'New Client has been added successfully!!');

                }else
                $this->Flash->error('Unable to add Leave Type!!');
                }

            $this->redirect(array("action" => 'leavetypes'));
       }
       elseif($id)
       {
            $designation = $this->LeaveType->get($id);
                $this->set('client', $designation);
       }

      $parent_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
       
       $designation = $this->LeaveType->find('all',['conditions' => ["company_id" => $parent_id ]]);
      
       
       $this->set('designation', $designation);
       $this->set('siteurl', $siteurl);
    }
}