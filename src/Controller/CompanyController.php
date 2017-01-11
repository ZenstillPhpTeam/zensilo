<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;
class CompanyController extends UsersController
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
  	}

    

    public function setting(){
      $this->User = TableRegistry::get('users');
      $this->UserProfiles = TableRegistry::get('UserDetails');
      $myacc = $this->User->get($this->Auth->user()['id']);
      $profile = $this->UserProfiles->find('all', ['conditions' => ['UserDetails.user_id' => $this->Auth->user()['id']]])->first();

      if ($this->request->is('post')) {

        if(!empty($this->request->data['image']['name']))
          $this->request->data['image'] = $this->s3upload($this->request->data['image']['tmp_name'], time().$this->request->data['image']['name']);
        $profile = $this->UserProfiles->patchEntity($profile, $this->request->data);
        $res = $this->UserProfiles->save($profile);
        $profile = $this->UserProfiles->find('all', ['conditions' => ['UserDetails.user_id' => $this->Auth->user()['id']]])->first();
        $this->Flash->success(__('Profile has been updated successfully.'));
        $this->redirect(array("action" => 'setting'));
      }

      $this->set(compact('myacc', 'profile'));
    }

    public function changePassword()
    {
       $this->Users = TableRegistry::get('Users');
       $user_det =$this->Users->get($this->Auth->user('id')); 
       if ($this->request->is('post')) {
            $hasher = new DefaultPasswordHasher();          
            if ($hasher->check($this->request->data['old_password'], $user_det['password'])) {
                $user = $this->Users->get($this->Auth->user('id'));
                $data['modified'] = date("Y-m-d H:i:s");  
                $data['password'] = $hasher->hash($this->request->data['new_password']);
                $profile = $this->Users->patchEntity($user, $data);
                $res = $this->Users->save($profile);
                if($res)
                {     
                  $this->Flash->success(__('Password has been updated successfully.'));
                  $this->redirect(array("action" => 'setting'));
                }
                else
                    $this->Flash->error(__('Old Password not valid!'));
            } else {
                $this->Flash->error(__('Old Password not valid!'));
            }

            $this->redirect(array("action" => 'changePassword'));
        }
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
                
                $i = 0;

                foreach ($this->request->data['designation'] as $key => $value) {
                  $user = $this->Designation->newEntity();
                  
                  $data['designation'] = $value;
                  $data['project_access'] = $this->request->data['project_access'][$key];
                  $data['client_access'] = $this->request->data['client_access'][$key];
                  $data['setting_access'] = $this->request->data['setting_access'][$key];
                  $data['user_access'] = $this->request->data['user_access'][$key];
                  if($this->Auth->user('userrole') != "admin")
                   $data['company_id'] = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
                  $user = $this->Designation->patchEntity($user, $data);
                  $user_save  = $this->Designation->save($user);
                  $i++;
                }
               
                if ($i) 
                  $this->Flash->success('New Designation has been added successfully!!');
                else
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
                
                $i = 0;
                foreach ($this->request->data['type'] as $key => $value) {
                  $user = $this->LeaveType->newEntity();
                  
                  $data['type'] = $value;
                  $data['max_allowed_days'] = $this->request->data['max_allowed_days'][$key];
                  if($this->Auth->user('userrole') != "admin")
                   $data['company_id'] = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
                  $user = $this->LeaveType->patchEntity($user, $data);
                  $user_save  = $this->LeaveType->save($user);
                  $i++;

                }
               
                if ($i) 
                  $this->Flash->success('New Leave Type has been added successfully!!');
                else
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


    public function expensetypes($id = 0, $action = ''){
       
       $this->ExpenseType = TableRegistry::get('expense_types');

       $siteurl =  Router::url('/', true);


       if($action == 'delete')
       {
            $this->ExpenseType->delete($this->ExpenseType->get($id));
            $this->Flash->success('Expense Type has been deleted successfully!!');
            $this->redirect(array("action" => 'expensetypes'));
       }
       elseif ($this->request->is('post') )
       {
            $data = $this->request->data;

            if(isset($data['id'])){
                $user = $this->ExpenseType->get($data['id']);
                $user = $this->ExpenseType->patchEntity($user, $this->request->data);
                $user_save  = $this->ExpenseType->save($user);
                if ($user_save) {
                    //echo  $data['id'];
                   
                    $this->Flash->success('Expense Type has been updated successfully!!');
                    //$this->set('success_msg', 'Client Details has been updated successfully!!');
                }
            }
            else{
                
                $i = 0;
                foreach ($this->request->data['type'] as $key => $value) {
                  $user = $this->ExpenseType->newEntity();
                  
                  $data['type'] = $value;
                  
                  if($this->Auth->user('userrole') != "admin")
                   $data['company_id'] = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
                  $user = $this->ExpenseType->patchEntity($user, $data);
                  $user_save  = $this->ExpenseType->save($user);
                  $i++;
                }
                if ($i) 
                  $this->Flash->success('New Expense Type has been added successfully!!');
                else
                  $this->Flash->error('Unable to add Expense Type!!');
            }

            $this->redirect(array("action" => 'expensetypes'));
       }
       elseif($id)
       {
            $designation = $this->ExpenseType->get($id);
                $this->set('client', $designation);
       }

      $parent_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
       
       $designation = $this->ExpenseType->find('all',['conditions' => ["company_id" => $parent_id ]]);
      
       
       $this->set('designation', $designation);
       $this->set('siteurl', $siteurl);
    }
}