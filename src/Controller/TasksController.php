<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;
class TasksController extends AppController
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

    public function tasks($id = 0, $action = ''){

       $this->Projects = TableRegistry::get('projects');
       $this->Tasks = TableRegistry::get('tasks');
       $siteurl =  Router::url('/', true);

       if($action == 'delete')
       {
            
            $this->Tasks->delete($this->Users->get($id));
            $this->Flash->success('Task has been deleted successfully!!');
            $this->redirect(array("action" => 'tasks'));
       }
       elseif($action == 'copy')
       {
            $copy_task = $this->Tasks->get($id);
            $this->set('copy_task', $copy_task);

            if ($this->request->is('post'))
               {
                    $data = $this->request->data;

                    
                        $task = $this->Tasks->newEntity();
                        $parent_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
                        $this->request->data['company_id'] = $parent_id;
                        $this->request->data['assigned_by'] = $this->Auth->user('id');
                        $teams = implode(",",$this->request->data['assigned_to']);
                        $this->request->data['assigned_to'] = $teams;
                        $task = $this->Tasks->patchEntity($task, $this->request->data);
                        $task_save  = $this->Tasks->save($task);
                        //pr($user);exit;
                        if ($task_save) {
                            $this->Flash->success('New Task has been added successfully!!');
                            //$this->set('success_msg', 'New Client has been added successfully!!');

                        } else
                        $this->Flash->error('Unable to add Task!!');
                      

                    $this->redirect(array("action" => 'tasks'));
               }
            $this->Flash->success('Task has been copied successfully!!');
            //$this->redirect(array("action" => 'tasks'));
       }
       elseif ($this->request->is('post'))
       {
            $data = $this->request->data;

            if(isset($data['id'])){
                $task = $this->Tasks->get($data['id']);
                $task = $this->Tasks->patchEntity($task, $this->request->data);
                $task_save  = $this->Tasks->save($task);
                if ($task_save) {
                    $this->Flash->success('Task Details has been updated successfully!!');
                    //$this->set('success_msg', 'Client Details has been updated successfully!!');
                }
            }
            else {
                $task = $this->Tasks->newEntity();
                $parent_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
                $this->request->data['company_id'] = $parent_id;
                $this->request->data['assigned_by'] = $this->Auth->user('id');
                $this->request->data['assigned_by'] = $this->Auth->user('id');
                        $teams = implode(",",$this->request->data['assigned_to']);
                        $this->request->data['assigned_to'] = $teams;
                $task = $this->Tasks->patchEntity($task, $this->request->data);
                $task_save  = $this->Tasks->save($task);
                //pr($user);exit;
                if ($task_save) {
                    $this->Flash->success('New Task has been added successfully!!');
                    //$this->set('success_msg', 'New Client has been added successfully!!');
                } else
                $this->Flash->error('Unable to add User!!');
                }

            $this->redirect(array("action" => 'tasks'));
       }
       elseif($id)
       {
            $task = $this->Tasks->get($id);
                $this->set('task', $task);
       }

       $parent_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
       $projects = $this->Projects->find('all', ['conditions' => ['projects.company_id' => $parent_id]]);
       $tasks = $this->Projects->find('all', ['conditions' => ['projects.company_id' => $parent_id]])->contain('Tasks');

       $conn = ConnectionManager::get('default');
       $team_members = $conn->execute('select a.* from user_details a, users b where a.user_id = b.id and b.userrole="user" and b.parent_id = '.$parent_id);

       $this->set('projects', $projects);
       $this->set('team_members', $team_members);
       $this->set('tasks', $tasks);
       $this->set('siteurl', $siteurl);

    }

     public function server()
    {
        $this->TaskDocuments = TableRegistry::get('task_documents');
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
                $uploadPath = WWW_ROOT .'upload/task';
                $imageName = time().$image['name'];
                $full_image_path = $uploadPath . '/' . $imageName;
                if(move_uploaded_file($image['tmp_name'], $full_image_path))
                    $images[] = $imageName;

            $data['document_name'] = $imageName;
            $data['type'] = pathinfo($imageName, PATHINFO_EXTENSION);
            $data['project_id'] = $data['project_doc_id'];
            $data['task_id'] = $data['task_doc_id'];
            $documents = $this->TaskDocuments->newEntity();
            $documents = $this->TaskDocuments->patchEntity($documents, $data);
            $documents = $this->TaskDocuments->save($documents);
            $json['files'][$k]['url'] = $siteurl .'upload/task/'.$imageName;
            $json['files'][$k]['thumbnailUrl'] = $siteurl .'upload/task/'.$imageName;
            $json['files'][$k]['name'] = $imageName;
            $json['files'][$k]['deleteUrl'] = $siteurl .'tasks/docdelete/'.$documents->id;
            $json['files'][$k]['deleteType'] = "DELETE";
            }
            //print_r($data);exit;
            echo json_encode($json);
            exit;
           
        }
        else {
            $json['files'] = array();
            $docs = $this->TaskDocuments->find('all',['conditions' => ['project_id' => $id]]);
            foreach($docs as $k=>$pre)
            {
            $json['files'][$k]['url'] = $siteurl .'upload/task/'.$imageName;
            $json['files'][$k]['thumbnailUrl'] = $siteurl .'upload/task/'.$imageName;
            $json['files'][$k]['name'] = $imageName;
            $json['files'][$k]['deleteUrl'] = $siteurl .'tasks/docdelete/'.$pre->id;
            $json['files'][$k]['deleteType'] = "DELETE";
            }
            echo json_encode($json);
            exit;
        }

    }

    public function docdelete($id) {
            $this->TaskDocuments = TableRegistry::get('task_documents');
            $siteurl =  Router::url('/', true);
            $doc = $this->TaskDocuments->get($id);
            $file = $siteurl .'upload/task/'.$doc->document_name;
            if (is_file($file)) {
                            unlink($file);
                        }
            $this->TaskDocuments->delete($this->TaskDocuments->get($id));
           // $this->Flash->success('Document has been deleted successfully!!');
            exit;
            return true;
    }



}