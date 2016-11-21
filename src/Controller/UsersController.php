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
            $this->set('loggedInUser', $this->Auth->user());

            if($this->Auth->user()['status'] == 0)
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
            $user = $this->User->find("all", ["conditions" => ["username" => $this->is_sub_domain()]])->first();
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

    }

    public function index($st=0)
	{ 

		if($this->Auth->user())
            $this->redirect($this->Auth->redirectUrl());

        $this->viewBuilder()->layout('admin_login');

	    if ($this->request->is('post') && $this->request->data['username'] && $this->request->data['password']) {

            $user = $this->Auth->identify();

	        if ($user) {
                if($this->is_localhost() || !$user['username'])
                {    
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl()); 
                }
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
                    else
                        return $this->redirect("http://".$user['username'].".zensilo.com/users/setlogin"); 
                }
                else
    	        {
                    //$this->Flash->error(__('Invalid username or password, try again'));
                    $this->set('error_msg', 'Wrong credentials.Please try again.');
                }   
            }
	    }

        $this->render('index');
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

    public function changePassword()
    {
       $this->Users = TableRegistry::get('Users');
       $this->viewBuilder()->layout('buzztm_admin');
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
                     $this->Flash->success(__('Password has been updated successfully!!.'));
                else
                    echo 'error';
            } else {
                $this->Flash->error(__('Old Password not valid!!.'));
            }
        }
    }

    public function forgotPassword()
    {
        $this->Users = TableRegistry::get('Users');
        $this->viewBuilder()->layout('admin_login');
        if ($this->request->is('post')) {
           $user = $this->Users->find('all', ['conditions' => ['Users.email' => $this->request->data['email']]])->first();
           if($user)
           {
                $rlink = isset($this->request->data['slug']) ? Router::url('/users/reset-password/'.base64_encode(base64_encode($user->id)), true).'/'.$this->request->data['slug']: Router::url('/users/reset-password/'.base64_encode(base64_encode($user->id)), true);

                $this->UserProfiles = TableRegistry::get('UserProfiles');
                $profile = $this->UserProfiles->find('all', ['conditions' => ['UserProfiles.user_id' => $user->id]])->first();
                $this->send_custom_mail(array(
                            'html_content' => $this->getEmailTemplate('reset_password', 
                                        array('###SITEURL###' => Router::url('/', true), 
                                              '###RESETLINK###' => $rlink,
                                                '###CNAME###' => $profile->company_name)),
                            'email_id' => array($this->request->data['email']),
                            'subject' => 'Mybuzztm Reset password link',
                            'apikey' => 'summa_token'
                            ));
                if(!isset($this->request->data['slug']))
                    $this->Flash->success(__('Reset password link has been sent to your email address.'));
           }
           else
           {
                $this->Flash->success(__('Invalid email address.'));
           }
           exit;
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
            $client = $this->UserDetails->find('all', ['conditions' => ['users.id' => $id]])->contain('Users', function(\Cake\ORM\Query $q) {
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
                    $project = $this->Projects->patchEntity($project, $this->request->data);
                    $project_save  = $this->Projects->save($project);

                    $teams = $this->request->data['teams'];
                    foreach($teams as $team) {
                         $team_data['user_id'] = $team;
                       $team_data['project_id'] = $project_save->id;
                        //exit;
                        $teamdata = $this->ProjectTeams->newEntity();
                        $teamdata = $this->ProjectTeams->patchEntity($teamdata, $team_data);
                        $teamdata_save  = $this->ProjectTeams->save($teamdata);
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
       $projects =  $this->Projects->find('all',['conditions' => ['company_id' => $comp_id]]);
       $conn = ConnectionManager::get('default');
       $clients = $conn->execute('select a.* from user_details a, users b where a.user_id = b.id and b.userrole="company"');
       $team_members = $conn->execute('select a.* from user_details a, users b where a.user_id = b.id and b.userrole="user" and b.parent_id = '.$comp_id);
       $project_clients = $conn->execute('select a.* from user_details a, users b where a.user_id = b.id and b.userrole="client"');
      // $clients = $stmt->fetch('assoc');
       //$clients =  $this->UserDetails->find('all',['conditions' => ['user']]);
      // $users = $this->ClientDetails->find('all')->all()->contain('users');
      
       
       $this->set('projects', $projects);
       $this->set('clients', $clients);
       $this->set('team_members', $team_members);
       $this->set('project_clients', $project_clients);
       $this->set('siteurl', $siteurl);

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
            $teams = $this->ProjectTeams->find('all',['conditions' => ['project_id' => $id]]);
            //$this->dateDiff("2010-01-26", "2004-01-26");exit;

            $this->set('project', $project);
            $this->set('project_timeline', $project_timeline);
            $this->set('documents', $documents);
            $this->set('teams', $teams);
       }

      
       $this->set('siteurl', $siteurl);

    }

    public function server()
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
                $uploadPath = WWW_ROOT .'upload/project';
                $imageName = time().$image['name'];
                $full_image_path = $uploadPath . '/' . $imageName;
                if(move_uploaded_file($image['tmp_name'], $full_image_path))
                    $images[] = $imageName;

            $data['document_name'] = $imageName;
            $data['type'] = pathinfo($imageName, PATHINFO_EXTENSION);
            $data['project_id'] = $data['project_doc_id'];
            $documents = $this->ProjectDocuments->newEntity();
            $documents = $this->ProjectDocuments->patchEntity($documents, $data);
            $documents = $this->ProjectDocuments->save($documents);
            $json['files'][$k]['url'] = $siteurl .'upload/project/'.$imageName;
            $json['files'][$k]['thumbnailUrl'] = $siteurl .'upload/project/'.$imageName;
            $json['files'][$k]['name'] = $imageName;
            $json['files'][$k]['deleteUrl'] = $siteurl .'users/delete/'.$documents->id;
            $json['files'][$k]['deleteType'] = "DELETE";
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
            $json['files'][$k]['url'] = $siteurl .'upload/project/'.$imageName;
            $json['files'][$k]['thumbnailUrl'] = $siteurl .'upload/project/'.$imageName;
            $json['files'][$k]['name'] = $imageName;
            $json['files'][$k]['deleteUrl'] = $siteurl .'users/delete/'.$pre->id;
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
       $this->Designation = TableRegistry::get('designations');
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
                    //$this->set('success_msg', 'New Client has been added successfully!!');

                }else
                $this->Flash->error('Unable to add User!!');
                }

            $this->redirect(array("action" => 'users'));
       }
       elseif($id)
       {
            $client = $this->UserDetails->find('all', ['conditions' => ['users.id' => $id]])->contain('Users', function(\Cake\ORM\Query $q) {
                    return $q->where(['Users.id' => $id]);
                   })->first();
                $this->set('client', $client);
       }

      $parent_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
       $users = $this->UserDetails->find('all', ['conditions' => ['Users.userrole' => 'user', 'Users.parent_id' => $parent_id]])->contain('Users')->all();
       $designation = $this->Designation->find('all',['conditions' =>['company_id' => $parent_id ]])->all();
      
       
       $this->set('users', $users);
       $this->set('designation', $designation);
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
            else{
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

                }else
                $this->Flash->error('Unable to add Client!!');
                }

            $this->redirect(array("action" => 'clients'));
       }
       elseif($id)
       {
            $client = $this->UserDetails->find('all', ['conditions' => ['users.id' => $id]])->contain('Users', function(\Cake\ORM\Query $q) {
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