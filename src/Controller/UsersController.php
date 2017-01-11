<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;

class UsersController extends AppController
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

	    $this->Auth->allow(['index', 'add', 'logout', 'forgotPassword', 'resetPassword','view', 'verify', 'setlogin']);

        if($this->Auth->user())
        {
            $this->viewBuilder()->layout('inner_layout');

            $this->User = TableRegistry::get('users');
            $this->Designation = TableRegistry::get('designations');
            $this->Notification = TableRegistry::get('notifications');
            $this->UserProfiles = TableRegistry::get('UserDetails');
            
            $user = $this->User->get($this->Auth->user()['id']);
            $this->loggedInUser = $this->Auth->user();
            $this->loggedInUser['status'] = $user->status;
            $this->set('loggedInUser', $this->loggedInUser);

            $profile = $this->UserProfiles->find('all', ['conditions' => ['UserDetails.user_id' => $this->Auth->user()['id']]])->first();
            $this->set('loggedInUserprofile', $profile);

            $this->company_id = ($this->loggedInUser['userrole'] == 'company') ? $this->loggedInUser['id'] : $this->loggedInUser['parent_id'];
            $this->set('company_id', $this->company_id);

            $company_users = $this->User->find("all", ["conditions" => ['OR' => [["parent_id" => $this->company_id], ["id" => $this->company_id]], "NOT" => ["id" => $this->loggedInUser['id']], "userrole IN" => ["user", "company"]], "order" => "username"])->all();
            $this->set('company_users', $company_users);

            $company_clients = $this->User->find("all", ["conditions" => ["parent_id" => $this->company_id, "userrole" => "client"], "order" => "username"])->all();
            $this->set('company_clients', $company_clients);
            
            $designation = $this->Designation->find('all',['conditions' =>['company_id' => $this->company_id ]])->all();
            $this->set('designation', $designation);

            if($profile->designation)
            {
                $current_user_designation = $this->Designation->find('all',['conditions' =>['id' => $profile->designation ]])->first();
                $this->set('current_user_designation', $current_user_designation);
            }

            $notifications = $this->Notification->find('all',['conditions' =>['company_id' => $this->company_id, 'notito' => $this->loggedInUser['id']]])->all();
            $this->set('notifications', $notifications);

            if($this->loggedInUser['status'] == 0)
                $this->render('verfiy_email');
        }
        elseif($this->request->params['action'] != 'setlogin')
        {
            if($this->is_sub_domain())
                return $this->redirect("http://zensilo.com/".strtolower($this->request->params['controller']).'/'.strtolower($this->request->params['action']));
        }
	}

    

    public function setlogin($id=0)
    {
        $arr = explode(".", $_SERVER['HTTP_HOST']);
        if($this->is_sub_domain())
        {
            $this->User = TableRegistry::get('users');
            if(!$id)
                $user = $this->User->find("all", ["conditions" => ["username" => $this->is_sub_domain()]])->first();
            else
                $user = $this->User->get($id);
            $this->Auth->setUser($user);
        }
        elseif($id)
        {
            $this->User = TableRegistry::get('users');
            $user = $this->User->get($id);
            $this->Auth->setUser($user);
        }
        
        return $this->redirect($this->Auth->redirectUrl());  
    }

    public function dashboard()
    {
        $this->Tasks = TableRegistry::get('tasks');
        $this->Users = TableRegistry::get('users');
        $this->Projects = TableRegistry::get('projects');
        $this->ProjectTeams = TableRegistry::get('project_teams');

        $this->LeaveRequest = TableRegistry::get('leave_requests');
        $this->Leavetype = TableRegistry::get('leave_types');

        $this->ExpenseRequest = TableRegistry::get('expense_requests');
        $this->Expensetype = TableRegistry::get('expense_types');
        
        $conn = ConnectionManager::get('default');
         $date = date('Y-m-d');
        $last_month = date('Y-m-d', strtotime("-1 month"));
        $comp_id = $this->Auth->user('id');
        if($this->Auth->user('userrole') == "company")
        {
            $projects =  $this->Projects->find('all',['conditions' => ['company_id' => $comp_id]])->count();
            $expense_requests =  $conn->execute("select a.type,sum(b.amount) as sum_amount from expense_types a, expense_requests b where a.id=b.type_id and b.company_id = ".$comp_id." and b.applied_date between '".$last_month."' and '".$date."' group by b.type_id");
            $leave_requests =  $conn->execute("select a.type,sum(b.no_of_days) as sum_days from leave_types a, leave_requests b where a.id=b.type_id and b.company_id = ".$comp_id." and b.start_date between '".$last_month."' and '".$date."' group by b.type_id");
            $project_tasks =  $conn->execute("select a.project_name,b.status,count(*) as sum_days from projects a, tasks b where a.id = b.project_id and  b.company_id = ".$comp_id." group by b.status");
            $clients =  $this->Users->find('all',['conditions' => ['userrole' => "client",'parent_id' => $comp_id]])->count();
            $users =  $this->Users->find('all',['conditions' => ['userrole' => "user",'parent_id' => $comp_id]])->count();
            $tasks_calendar = $conn->execute("select * from tasks where company_id=". $comp_id);

        }  
        else {
           $projects =  $this->ProjectTeams->find('all',['conditions' => ['user_id' => $comp_id]])->count(); 
           $expense_requests =  $conn->execute("select a.type,sum(b.amount) as sum_amount from expense_types a, expense_requests b where a.id=b.type_id and b.user_id = ".$comp_id." and b.applied_date between '".$last_month."' and '".$date."' group by b.type_id");
           $leave_requests =  $conn->execute("select a.type,sum(b.no_of_days) as sum_days from leave_types a, leave_requests b where a.id=b.type_id and b.user_id = ".$comp_id." and b.start_date between '".$last_month."' and '".$date."' group by b.type_id");
           $project_tasks =  $conn->execute("select a.project_name,b.status,count(*) as sum_days from projects a, tasks b, task_teams c where a.id = b.project_id and c.task_id = b.id and c.user_id = ".$comp_id." group by b.status");
           $clients = 0;
           $users = 0;
           $tasks_calendar =  $conn->execute("select a.type,sum(b.no_of_days) as sum_days from leave_types a, leave_requests b where a.id=b.type_id and b.user_id = ".$comp_id." and b.created between '".$last_month."' and '".$date."' group by b.type_id");

        }
       // echo "select a.type,sum(b.no_of_days) as sum_days from leave_types a, leave_requests b where a.id=b.type_id and b.user_id = ".$comp_id." and b.created between '".$last_month."' and '".$date."' group by b.type_id";

        //echo "select a.type,sum(b.amount) as sum_amount from expense_types a, expense_requests b where a.id=b.type_id and b.user_id = ".$comp_id." and b.applied_date between ".$date." and ".$last_month." group by b.type_id";
        //exit;
        //pr($tasks_calendar);exit;

        $pro_task = array();
        if($project_tasks){
        foreach($project_tasks as $k=>$tasks){
           $pro_task[$k]['title'] = $tasks['project_name'];
           $pro_task[$k]['status'] = $tasks['status'];
           $pro_task[$k]['count'] = $tasks['sum_days'];
        }
        }

        $tasks_cal = array();
        if($tasks_calendar){
        foreach($tasks_calendar as $k=>$tasks){
           $tasks_cal[$k]['title'] = $tasks['task_name'];
            $tasks_cal[$k]['start'] = $tasks['due_date'];
        }
        }

        $expense = array();
        foreach($expense_requests as $k=>$expensereq){
           $expense[$k]['legendText'] = $expensereq['type'];
            $expense[$k]['y'] = $expensereq['sum_amount'];
        }

        $leaves = array();
        foreach($leave_requests as $k=>$leavereq){
           $leaves[$k]['legendText'] = $leavereq['type'];
            $leaves[$k]['y'] = $leavereq['sum_days'];
        }


       $tasks = $this->Projects->find('all', ['conditions' => ['projects.company_id' => $comp_id]])->contain('Tasks');

        $this->set('projects', $projects);
        $this->set('leaves', $leaves);
        $this->set('expense', $expense);
        $this->set('tasks', $tasks);
        $this->set('users', $users);
        $this->set('pro_task', $pro_task);
        $this->set('clients', $clients);
        $this->set('tasks_cal', $tasks_cal);
    }

    public function index($st=0)
	{ 

		if($this->Auth->user())
            $this->redirect($this->Auth->redirectUrl());
	    elseif ($this->request->is('post') && $this->request->data['username'] && $this->request->data['password']) {

            $user = $this->Auth->identify();

	        if ($user) {
                if($this->is_localhost() || !$user['username'])
                {    
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl()); 
                }
                elseif($user['parent_id'])
                    return $this->redirect("http://".$this->getCompanyUsername($user['parent_id']).".zensilo.com/users/setlogin/".$user['id']);
                else
                    return $this->redirect("http://".$user['username'].".zensilo.com/users/setlogin"); 
	        }
            else
            {
                $this->User = TableRegistry::get('users');
                $user = $this->User->find("all", ["conditions" => ["email" => $this->request->data['username'], "userrole !=" => "user"]])->first();

               if (count($user)) {
                    $this->request->data['username'] = $user->username;
                    if($this->is_localhost() || !$user->username)
                    {
                        $user = $this->Auth->identify(); 
                        $this->Auth->setUser($user);
                        return $this->redirect($this->Auth->redirectUrl()); 
                    }
                    elseif($user['parent_id'])
                        return $this->redirect("http://".$this->getCompanyUsername($user['parent_id']).".zensilo.com/users/setlogin/".$user['id']);
                    else
                        return $this->redirect("http://".$user['username'].".zensilo.com/users/setlogin"); 
                }
                else
    	        {
                    $this->Flash->error(__('Invalid username or password, try again'));
                }   
            }
	    }
        
        if(!$this->Auth->user())
        {
            $this->redirect(array('controller' => 'home', 'action' => 'index'));
        }
        //$this->viewBuilder()->layout('admin_login');
        //$this->render('index');
	}

    public function getCompanyUsername($id)
    {
        $this->User = TableRegistry::get('users');
        $user = $this->User->get($id);
        return $user->username;
    }

    public function login($st=0)
    {
        $this->index($st);
    }

	public function logout()
	{
	    $this->Auth->logout();
        return $this->redirect([
                'controller' => 'users',
                'action' => 'login'
            ]);
	}


    public function add()
    {
        $this->viewBuilder()->layout('admin_login');
        $this->Users = TableRegistry::get('Users');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['role'] = 'admin';
            $user = $this->Users->patchEntity($user, $this->request->data);
            $hasher = new DefaultPasswordHasher();
            $user->password = $hasher->hash($user->password);
            //pr($user);exit;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }


    public function verify($id)
    {
        $this->Users = TableRegistry::get('Users');
        $this->UserProfiles = TableRegistry::get('UserProfiles');

        $user_id = base64_decode(base64_decode($id));

        $user = $this->Users->get($user_id);
        $user_data = array('status' => 1);
        $user = $this->Users->patchEntity($user, $user_data);
        
        $res = $this->Users->save($user);

        $vars = ['username' => $user->username];
        $this->send_email('account_verified', $user->email, 'Account Verified', $vars);

        $this->redirect(['action' => 'login']);
    }
    public function resendMail()
    {
        $this->autoRender = false;

        $data = $this->request->data;
        
        $this->Users = TableRegistry::get('Users');

        $user = $this->Users->find('all', ['conditions' => ['Users.email' => $this->request->data['email']]])->first();
            if($user)
            {
                $vars = ['username' => $user->username, "link" => Router::url('/users/verify/'.base64_encode(base64_encode($user->id)), true)];
                $this->send_email('verify_email', $data['email'], 'Verify Email', $vars); 
                echo "success";
            }
            else
                echo "error";
    }

    public function forgotPassword()
    {
        $this->Users = TableRegistry::get('Users');
        $this->viewBuilder()->layout('admin_login');
        if ($this->request->is('post')) {
           $user = $this->Users->find('all', ['conditions' => ['Users.email' => $this->request->data['email']]])->first();
           if($user)
           {
                              
                $password = $this->random_password();
                $vars = ['password' => $password];
                $this->send_email('reset_password', $this->request->data['email'], 'New Password', $vars);
                
                $hasher = new DefaultPasswordHasher();
                $user->password = $hasher->hash($password);
                $user_save  = $this->Users->save($user);

                $this->Flash->success(__('New password has been sent to your email address.'));
           }
           else
           {
                $this->Flash->error(__('Invalid email address.'));
           }
        }
    }

    public function resetPassword($id=0, $redirectto = '')
    {
        if ($this->request->is('post')) {
            $this->Users = TableRegistry::get('Users');
            $user = $this->Users->get($this->request->data['user_id']);
            $hasher = new DefaultPasswordHasher();
            $password = $hasher->hash($this->request->data['password']);
            $user_data = array('password' => $password);
            $user = $this->Users->patchEntity($user, $user_data);
            $res = $this->Users->save($user);
            
            $this->send_custom_mail(array(
                            'html_content' => $this->getEmailTemplate('password_updated', 
                                            array('###SITEURL###' => Router::url('/', true))),
                            'email_id' => array($user->email),
                            'subject' => 'Password Updated',
                            'apikey' => 'summa_token'
                            ));

            $this->Flash->success(__('Password changed succesfully. Try login with your new password!!'));
            exit;
        }
        else
        {
            $this->viewBuilder()->layout('admin_login');
            $user_id = base64_decode(base64_decode($id));
            $redirectto = $redirectto ? explode("-",base64_decode(base64_decode($redirectto))) : false;
            $this->set(compact('user_id', 'redirectto'));
        }
        
    }

    public function reset()
    {
        $this->viewBuilder()->layout('admin_login');
    }

    public function random_password( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }

    public function company($id = 0, $action = '')
    {
       $this->Users = TableRegistry::get('users');
       $this->UserDetails = TableRegistry::get('user_details');
       $siteurl =  Router::url('/', true);

       if($action == 'delete')
       {
            $this->UserDetails->deleteAll(['user_id' => $id]);
            $this->Users->delete($this->Users->get($id));
            $this->Flash->success('Company has been deleted successfully!!');
            $this->redirect(array("action" => 'company'));
       }
       elseif ($this->request->is('post'))
       {
            $data = $this->request->data;

            if(isset($data['id'])){
                $user = $this->Users->get($data['id']);
                $user = $this->Users->patchEntity($user, $this->request->data);
                $user_save  = $this->Users->save($user);
                if ($user_save) {
                    //echo  $data['id'];
                    $client = $this->UserDetails->find('all',['conditions' => ['user_details.user_id' => $data["id"]]])->first();
                   unset($this->request->data['id']);
                    $client = $this->UserDetails->patchEntity($client, $this->request->data);
                    $client_save  = $this->UserDetails->save($client);
                    $this->Flash->success('Company Details has been updated successfully!!');
                    //$this->set('success_msg', 'Client Details has been updated successfully!!');
                }
            }
            else{
                $user = $this->Users->newEntity();
                $this->request->data['userrole'] = 'company';
                $this->request->data['status'] = 1;
                $user = $this->Users->patchEntity($user, $this->request->data);
                $hasher = new DefaultPasswordHasher();
                $user->password = $hasher->hash($user->password);
                $user_save  = $this->Users->save($user);
                //pr($user);exit;
                if ($user_save) {
                    $client = $this->UserDetails->newEntity();
                    $this->request->data['user_id'] = $user_save->id;
                    $client = $this->UserDetails->patchEntity($client, $this->request->data);
                    $client_save  = $this->UserDetails->save($client);
                    $this->Flash->success('New Company has been added successfully!!');
                    //$this->set('success_msg', 'New Client has been added successfully!!');

                }else
                $this->Flash->error('Unable to add Company!!');
                }

            $this->redirect(array("action" => 'company'));
       }
       elseif($id)
       {
            $client = $this->UserDetails->find('all', ['conditions' => ['Users.id' => $id]])->contain('Users', function(\Cake\ORM\Query $q) {
                    return $q->where(['Users.id' => $id]);
                   })->first();
                $this->set('client', $client);
       }
       $users =  $this->UserDetails->find()->contain('Users', function(\Cake\ORM\Query $q) {
        return $q->where(['Users.id' => 'ClientDetails.User_id']);
       });
      // $users = $this->ClientDetails->find('all')->all()->contain('users');
      
       
       $this->set('users', $users);
       $this->set('siteurl', $siteurl);

    }

    public function projects($id = 0, $action = '')
    {
       $this->Users = TableRegistry::get('users');
       $this->UserDetails = TableRegistry::get('user_details');
       $this->Projects = TableRegistry::get('projects');
       $this->ProjectTimeline = TableRegistry::get('project_timeline');
       $this->ProjectTeams = TableRegistry::get('project_teams');
       $siteurl =  Router::url('/', true);

       if($action == 'delete')
       {
            $this->ProjectTimeline->deleteAll(['project_id' => $id]);
            $this->Projects->delete($this->Projects->get($id));
            $this->Flash->success('Project has been deleted successfully!!');
            $this->redirect(array("action" => 'projects'));
       }
       elseif ($this->request->is('post') )
       {
            $data = $this->request->data;
            $login_id = $this->Auth->user('id');

            if(isset($data['id'])){
                $project = $this->Projects->get($data['id']);
                $project = $this->Projects->patchEntity($project, $this->request->data);
                $project_save  = $this->Projects->save($project);
                if ($project_save) {    
                    $this->ProjectTeams->deleteAll(['project_id' => $id]);
                        $teams = $this->request->data['teams'];
                        if(count($teams)){
                    foreach($teams as $team) {
                         $team_data['user_id'] = $team;
                       $team_data['project_id'] = $data['id'];
                        //exit;
                        $teamdata = $this->ProjectTeams->newEntity();
                        $teamdata = $this->ProjectTeams->patchEntity($teamdata, $team_data);
                        $teamdata_save  = $this->ProjectTeams->save($teamdata);
                    }
                }


                        $project_timeline = $this->ProjectTimeline->newEntity();
                        $data1['project_id'] = $data['id'];
                        $data1['timeline_text']  = "Project Update";
                        $data1['timeline_description']  = "Project ".$this->request->data['project_name']." Details Updated!!";
                        $project_timeline = $this->ProjectTimeline->patchEntity($project_timeline, $data1);
                        $project_timeline_save  = $this->ProjectTimeline->save($project_timeline);
                    }
                $this->Flash->success('Project has been updated successfully!!');
            }
            else{
                //print_r($this->request->data);
                   $project = $this->Projects->newEntity();
                    $this->request->data['status'] = "New";
                    $comp_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
                    $this->request->data['company_id'] = $comp_id;
                    $project = $this->Projects->patchEntity($project, $this->request->data);
                    $project_save  = $this->Projects->save($project);

                    $teams = $this->request->data['teams'];
                    if(count($teams)){
                    foreach($teams as $team) {
                         $team_data['user_id'] = $team;
                       $team_data['project_id'] = $project_save->id;
                        //exit;
                        $teamdata = $this->ProjectTeams->newEntity();
                        $teamdata = $this->ProjectTeams->patchEntity($teamdata, $team_data);
                        $teamdata_save  = $this->ProjectTeams->save($teamdata);
                    }
                }
                    if ($project_save) {    
                        $project_timeline = $this->ProjectTimeline->newEntity();
                        $data['project_id'] = $project_save->id;
                        $data['timeline_text'] = "Project";
                        $data['reference_id'] = $project_save->id;
                        $data['timeline_text']  = "New Project";
                        $data['timeline_description']  = "New Project ".$this->request->data['project_name']." Added!!";
                        $project_timeline = $this->ProjectTimeline->patchEntity($project_timeline, $data);
                        $project_timeline_save  = $this->ProjectTimeline->save($project_timeline);
                        $this->Flash->success('New Project has been added successfully!!');
                    }
                    else
                        $this->Flash->error('Unable to add Project!!');
                }

            $this->redirect(array("action" => 'projects'));
       }
       elseif($id)
       {
            $project = $this->Projects->get($id);
            $project_team = $this->ProjectTeams->find('all', ['conditions' => ['project_id' => $id]]);
            $this->set('project', $project);
            $this->set('project_team', $project_team);
       }

       $comp_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
       if($this->Auth->user('userrole') == "company")
            $projects =  $this->Projects->find('all',['conditions' => ['company_id' => $this->Auth->user('id')]]);
       elseif($this->Auth->user('userrole') == "client")
            $projects =  $this->Projects->find('all',['conditions' => ['client_id' => $this->Auth->user('id')]]);
        else
            $projects =  $this->ProjectTeams->find('all',['conditions' => ['project_teams.user_id' => $this->Auth->user('id')]])->contain('Projects')->all();
       // pr($projects);exit;

       $conn = ConnectionManager::get('default');
       $clients = $conn->execute('select a.* from user_details a, users b where a.user_id = b.id and b.userrole="company" and b.parent_id = '.$comp_id);
       $team_members = $conn->execute('select a.* from user_details a, users b where a.user_id = b.id and b.userrole="user" and b.parent_id = '.$comp_id);
       $project_clients = $conn->execute('select a.* from user_details a, users b where a.user_id = b.id and b.userrole="client" and b.parent_id = '.$comp_id);
      // $clients = $stmt->fetch('assoc');
       //$clients =  $this->UserDetails->find('all',['conditions' => ['user']]);
      // $users = $this->ClientDetails->find('all')->all()->contain('users');
       
       $this->set('projects', $projects);
       $this->set('clients', $clients);
       $this->set('team_members', $team_members);
       $this->set('project_clients', $project_clients);
       $this->set('siteurl', $siteurl);

       if($this->Auth->user('userrole') == "user")
        $this->render('user_projects');
    }

    public function delete($id) {
            $this->ProjectDocuments = TableRegistry::get('project_documents');
            $siteurl =  Router::url('/', true);
            $doc = $this->ProjectDocuments->get($id);
            $file = $siteurl .'upload/project/'.$doc->document_name;
            if (is_file($file)) {
                            unlink($file);
                        }
            $this->ProjectDocuments->delete($this->ProjectDocuments->get($id));
           // $this->Flash->success('Document has been deleted successfully!!');
            exit;
            return true;
    }

    public function projectdetail($id = 0, $action = '')
    {
       $this->Users = TableRegistry::get('users');
       $this->ClientDetails = TableRegistry::get('user_details');
       $this->Projects = TableRegistry::get('projects');
       $this->ProjectTimeline = TableRegistry::get('project_timeline');
       $this->ProjectDocuments = TableRegistry::get('project_documents');
       $this->ProjectTeams = TableRegistry::get('project_teams');
       $this->Tasks = TableRegistry::get('tasks');
       $this->TimeSheetDays = TableRegistry::get('time_sheet_days');
       $siteurl =  Router::url('/', true);

       if($action == 'delete')
       {
            $this->ProjectTimeline->deleteAll(['project_id' => $id]);
            $this->Projects->delete($this->Projects->get($id));
            $this->Flash->success('Project has been deleted successfully!!');
            $this->redirect(array("action" => 'projects'));
       }
       elseif ($this->request->is('post') )
       {
            $data = $this->request->data;
            $login_id = $this->Auth->user('id');

            if(isset($data['id'])){
                $project = $this->Projects->get($data['id']);
                $project = $this->Projects->patchEntity($project, $this->request->data);
                $project_save  = $this->Projects->save($project);
                if ($project_save) {    
                        $project_timeline = $this->ProjectTimeline->newEntity();
                        $data1['project_id'] = $data['id'];
                        $data['timeline_type']  = "project";
                        $data['reference_id']  = $data['id'];
                        $data1['timeline_text']  = "Project Update";
                        $data1['timeline_description']  = "Project ".$this->request->data['project_name']." Details Updated!!";
                        $project_timeline = $this->ProjectTimeline->patchEntity($project_timeline, $data1);
                        $project_timeline_save  = $this->ProjectTimeline->save($project_timeline);
                    }
                $this->Flash->success('Project has been updated successfully!!');
            }
            else{
                    $project = $this->Projects->newEntity();
                    $project = $this->Projects->patchEntity($project, $this->request->data);
                    $project_save  = $this->Projects->save($project);
                    if ($project_save) {    
                        $project_timeline = $this->ProjectTimeline->newEntity();
                        $data['project_id'] = $project_save->id;
                        $data['timeline_type']  = "project";
                        $data['reference_id']  = $project_save->id;
                        $data['timeline_text']  = "New Project";
                        $data['timeline_description']  = "New Project ".$this->request->data['project_name']." Added!!";
                        $project_timeline = $this->ProjectTimeline->patchEntity($project_timeline, $data);
                        $project_timeline_save  = $this->ProjectTimeline->save($project_timeline);
                        $this->Flash->success('New Project has been added successfully!!');
                    }
                    else
                        $this->Flash->error('Unable to add Project!!');
                }

            $this->redirect(array("action" => 'projects'));
       }
       elseif($id)
       {
            $project = $this->Projects->get($id);
            $project_timeline = $this->ProjectTimeline->find('all',['conditions' => ['project_id' => $id]]);
            $documents = $this->ProjectDocuments->find('all',['conditions' => ['project_id' => $id]]);
            $teams = $this->ProjectTeams->find('all',['conditions' => ['project_id' => $id]])->count();
            $tasks = $this->Tasks->find('all',['conditions' => ['project_id' => $id, "parent_task_id" => 0]])->count();
            $tasks_completed = $this->Tasks->find('all',['conditions' => ['project_id' => $id, "parent_task_id" => 0,'status' => 'Completed']])->count();
            $percent_completed = ($tasks_completed / $tasks) * 100;

            $total_effort = $this->Tasks->find('all')
            ->where(['project_id' => $id]);
            $total_effort_sum = $total_effort->func()->sum('estimated_effort');
            $total_effort = $total_effort->select(['total' => $total_effort_sum])->first();

            $actual_effort = $this->TimeSheetDays->find('all')
            ->where(['project_id' => $id]);
             $sum = $actual_effort->func()->sum('hours');
             $actual_effort = $actual_effort->select(['total' => $sum])->first();
            //$this->dateDiff("2010-01-26", "2004-01-26");exit;
           // print_r($actual_effort);exit;
            $this->set('project', $project);
            $this->set('project_timeline', $project_timeline);
            $this->set('documents', $documents);
            $this->set('teams', $teams);
            $this->set('tasks', $tasks);
            $this->set('percent_completed', $percent_completed);
            $this->set('actual_effort', $actual_effort);
            $this->set('total_effort', $total_effort);
       }      
       $this->set('siteurl', $siteurl);
       $this->set('id', $id);
    }

    public function server($php, $id=0)
    {
        $this->ProjectDocuments = TableRegistry::get('project_documents');
        $this->ProjectTimeline = TableRegistry::get('project_timeline');
        $siteurl =  Router::url('/', true);

        if ($this->request->is('post'))
        {
            $data = $this->request->data;

            $images = [];
            $json['files'] = array();

            foreach($data['files'] as $k=>$pre)
            {
                $image = $pre;
                $imageName = $this->s3upload($image['tmp_name'], time().$image['name']);
                if($imageName)
                {    $images[] = $imageName;

                    $data['document_name'] = $imageName;
                    $data['type'] = pathinfo($imageName, PATHINFO_EXTENSION);
                    $data['project_id'] = $data['project_doc_id'];
                    $documents = $this->ProjectDocuments->newEntity();
                    $documents = $this->ProjectDocuments->patchEntity($documents, $data);
                    $documents = $this->ProjectDocuments->save($documents);
                    $json['files'][$k]['url'] = $imageName;
                    $json['files'][$k]['thumbnailUrl'] = $imageName;
                    $json['files'][$k]['name'] = $image['name'];
                    $json['files'][$k]['deleteUrl'] = $siteurl .'users/delete/'.$documents->id;
                    $json['files'][$k]['deleteType'] = "DELETE";
                }
            }
            //print_r($data);exit;
            echo json_encode($json);
            exit;
           
        }
        else {
            $json['files'] = array();
            $docs = $this->ProjectDocuments->find('all',['conditions' => ['project_id' => $id]]);
            foreach($docs as $k=>$pre)
            {
            $json['files'][$k]['url'] = $pre->document_name;
            $json['files'][$k]['thumbnailUrl'] = $pre->document_name;
            $json['files'][$k]['name'] = basename($pre->document_name);
            $json['files'][$k]['deleteUrl'] = $siteurl .'users/delete/'.$pre->id ;
            $json['files'][$k]['deleteType'] = "DELETE";
            }
            echo json_encode($json);
            exit;
        }

    }

    public function users($id = 0, $action = '')
    {
       $this->Users = TableRegistry::get('users');
       $this->UserDetails = TableRegistry::get('user_details');
       $siteurl =  Router::url('/', true);

       if($action == 'delete')
       {
            $this->UserDetails->deleteAll(['user_id' => $id]);
            $this->Users->delete($this->Users->get($id));
            $this->Flash->success('User has been deleted successfully!!');
            $this->redirect(array("action" => 'users'));
       }
       elseif ($this->request->is('post') )
       {
            $data = $this->request->data;

            if(isset($data['id'])){
                $user = $this->Users->get($data['id']);
                $user = $this->Users->patchEntity($user, $this->request->data);
                $user_save  = $this->Users->save($user);
                if ($user_save) {
                    //echo  $data['id'];
                    $client = $this->UserDetails->find('all',['conditions' => ['user_details.user_id' => $data["id"]]])->first();
                    $client = $this->UserDetails->patchEntity($client, $this->request->data);
                    $client_save  = $this->UserDetails->save($client);
                    $this->Flash->success('User Details has been updated successfully!!');
                    //$this->set('success_msg', 'Client Details has been updated successfully!!');
                }
            }
            else{
                $user = $this->Users->newEntity();
                $this->request->data['userrole'] = 'user';
                $this->request->data['status'] = 1;
                if($this->Auth->user('userrole') != "admin")
                $this->request->data['parent_id'] = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
                $user = $this->Users->patchEntity($user, $this->request->data);
                $hasher = new DefaultPasswordHasher();
                $user->password = $hasher->hash($user->password);
                $user_save  = $this->Users->save($user);
                //pr($user);exit;
                if ($user_save) {
                    $client = $this->UserDetails->newEntity();
                    $this->request->data['user_id'] = $user_save->id;
                    $client = $this->UserDetails->patchEntity($client, $this->request->data);
                    $client_save  = $this->UserDetails->save($client);
                    $this->Flash->success('New User has been added successfully!!');

                    $vars = ['password' => $this->request->data['password'],'username' => $this->request->data['username']];
                    $this->send_email('add_user', $this->request->data['email'], 'New Password', $vars);


                    //$this->set('success_msg', 'New Client has been added successfully!!');

                }else
                $this->Flash->error('Unable to add User!!');
                }

            $this->redirect(array("action" => 'users'));
       }
       elseif($id)
       {
            $client = $this->UserDetails->find('all', ['conditions' => ['Users.id' => $id]])->contain('Users', function(\Cake\ORM\Query $q) {
                    return $q->where(['Users.id' => $id]);
                   })->first();
                $this->set('client', $client);
       }

      $parent_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
      $users = $this->UserDetails->find('all', ['conditions' => ['Users.userrole' => 'user', 'Users.parent_id' => $parent_id]])->contain('Users')->all();
       
       $this->set('users', $users);
       $this->set('siteurl', $siteurl);
    }


    public function clients($id = 0, $action = '')
    {
       $this->Users = TableRegistry::get('users');
       $this->UserDetails = TableRegistry::get('user_details');
       $siteurl =  Router::url('/', true);

       if($action == 'delete')
       {
            $this->UserDetails->deleteAll(['user_id' => $id]);
            $this->Users->delete($this->Users->get($id));
            $this->Flash->success('User has been deleted successfully!!');
            $this->redirect(array("action" => 'clients'));
       }
       elseif ($this->request->is('post'))
       {
            $data = $this->request->data;

            if(isset($data['id'])){
                $user = $this->Users->get($data['id']);
                $user = $this->Users->patchEntity($user, $this->request->data);
                $user_save  = $this->Users->save($user);
                if ($user_save) {
                    //echo  $data['id'];
                    $client = $this->UserDetails->find('all',['conditions' => ['user_details.user_id' => $data["id"]]])->first();
                    $client = $this->UserDetails->patchEntity($client, $this->request->data);
                    $client_save  = $this->UserDetails->save($client);
                    $this->Flash->success('Client Details has been updated successfully!!');
                    //$this->set('success_msg', 'Client Details has been updated successfully!!');
                }
            }
            else
            {              
                $user = $this->Users->newEntity();
                $this->request->data['userrole'] = 'client';
                $this->request->data['status'] = 1;
                if($this->Auth->user('userrole') != "admin")
                $this->request->data['parent_id'] = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
                $user = $this->Users->patchEntity($user, $this->request->data);
                $hasher = new DefaultPasswordHasher();
                $user->password = $hasher->hash($user->password);
                $user_save  = $this->Users->save($user);
                //pr($user);exit;
                if ($user_save) {
                    $client = $this->UserDetails->newEntity();
                    $this->request->data['user_id'] = $user_save->id;
                    $client = $this->UserDetails->patchEntity($client, $this->request->data);
                    $client_save  = $this->UserDetails->save($client);
                    $this->Flash->success('New Client has been added successfully!!');
                    //$this->set('success_msg', 'New Client has been added successfully!!');

                    $vars = ['password' => $this->request->data['password'],'username' => $this->request->data['username']];
                    $this->send_email('add_user', $this->request->data['email'], 'New Password', $vars);
                }else
                $this->Flash->error('Unable to add Client!!');
                }

            $this->redirect(array("action" => 'clients'));
       }
       elseif($id)
       {
            $client = $this->UserDetails->find('all', ['conditions' => ['Users.id' => $id]])->contain('Users', function(\Cake\ORM\Query $q) {
                    return $q->where(['Users.id' => $id]);
                   })->first();
                $this->set('client', $client);
       }

      $parent_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
       $users = $this->UserDetails->find('all', ['conditions' => ['Users.userrole' => 'client', 'Users.parent_id' => $parent_id]])->contain('Users')->all();
      
       
       $this->set('users', $users);
       $this->set('siteurl', $siteurl);
    }

    public function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }

    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }

    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();

    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Create temp time from time1 and interval
      $ttime = strtotime('+1 ' . $interval, $time1);
      // Set initial values
      $add = 1;
      $looped = 0;
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
        // Create new temp time from time1 and interval
        $add++;
        $ttime = strtotime("+" . $add . " " . $interval, $time1);
        $looped++;
      }
 
      $time1 = strtotime("+" . $looped . " " . $interval, $time1);
      $diffs[$interval] = $looped;
    }
    
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
        break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
        // Add s if value is not 1
        if ($value != 1) {
          $interval .= "s";
        }
        // Add value and interval to times array
        $times[] = $value . " " . $interval;
        $count++;
      }
    }

    // Return string with times
    return implode(", ", $times);
  }

}