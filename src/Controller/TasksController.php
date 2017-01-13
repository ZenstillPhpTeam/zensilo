<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;
class TasksController extends UsersController
{

    public function tasks($id = 0, $action = ''){

       $this->Projects = TableRegistry::get('projects');
       $this->Tasks = TableRegistry::get('tasks');
       $this->ProjectTimeline = TableRegistry::get('project_timeline');
       $this->TaskTeams = TableRegistry::get('task_teams');
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
                $team_members = $this->request->data['assigned_to'];    
                $this->request->data['assigned_to'] = implode(",",$this->request->data['assigned_to']);
                $task = $this->Tasks->patchEntity($task, $this->request->data);
                $task_save  = $this->Tasks->save($task);
                //print_r($this->request->data);exit;
                if ($task_save) {

                    foreach($team_members as $team) {
                         $team_data['user_id'] = $team;
                       $team_data['task_id'] = $task_save->id;
                       $team_data['project_id'] = $this->request->data['project_id'];
                        //exit;
                        $teamdata = $this->TaskTeams->newEntity();
                        $teamdata = $this->TaskTeams->patchEntity($teamdata, $team_data);
                        $teamdata_save  = $this->TaskTeams->save($teamdata);
                     }   

                    $project_timeline = $this->ProjectTimeline->newEntity();
                        $data['project_id'] = $this->request->data['project_id'];
                        $data['timeline_type']  = "task";
                        $data['reference_id']  = $task_save->id;
                        $data['timeline_text']  = "New Task";
                        $data['timeline_description']  = "New Task ".$this->request->data['task_name']." Added!!";
                        $project_timeline = $this->ProjectTimeline->patchEntity($project_timeline, $data);
                        $project_timeline_save  = $this->ProjectTimeline->save($project_timeline);

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

        if($this->Auth->user('userrole') == "company")
            $tasks =  $this->Tasks->find('all',['conditions' => ['company_id' => $this->Auth->user('id')]]);
        elseif($this->Auth->user('userrole') == "client")
            $tasks =  $this->Tasks->find('all')->leftJoin('projects','projects.id = tasks.project_id')->where(['conditions' => ['projects.client_id' => $this->Auth->user('id')]])->select(['tasks.id','tasks.task_name','tasks.parent_task_id','tasks.project_id','tasks.estimated_effort','tasks.due_date','tasks.status'])->all();
        else
        {
            $tasks =  $this->Tasks->find('all')
            ->leftJoin('task_teams','tasks.id = task_teams.task_id')
            ->where(['task_teams.user_id' => $this->Auth->user('id')])
            ->select(['tasks.id','tasks.task_name','tasks.parent_task_id','tasks.project_id','tasks.estimated_effort','tasks.due_date','tasks.status'])
            ->all();
        }

      //echo "<pre>";print_r($tasks);exit;
       $conn = ConnectionManager::get('default');
       $team_members = $conn->execute('select a.* from user_details a, users b where a.user_id = b.id and b.userrole="user" and b.parent_id = '.$parent_id);

       $this->set('projects', $projects);
       $this->set('team_members', $team_members);
       $this->set('tasks', $tasks);
       $this->set('siteurl', $siteurl);

    }

     public function server($php, $id=0)
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
                $imageName = $this->s3upload($image['tmp_name'], time().$image['name']);
                if($imageName)
                {    $images[] = $imageName;

                    $data['document_name'] = $imageName;
                    $data['type'] = pathinfo($imageName, PATHINFO_EXTENSION);
                    $data['project_id'] = $data['project_doc_id'];
                    $data['task_id'] = $data['task_doc_id'];
                    $documents = $this->TaskDocuments->newEntity();
                    $documents = $this->TaskDocuments->patchEntity($documents, $data);
                    $documents = $this->TaskDocuments->save($documents);
                    $json['files'][$k]['url'] = $imageName;
                    $json['files'][$k]['thumbnailUrl'] = $imageName;
                    $json['files'][$k]['name'] = $imageName;
                    $json['files'][$k]['deleteUrl'] = $siteurl .'tasks/docdelete/'.$documents->id;
                    $json['files'][$k]['deleteType'] = "DELETE";
                }
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

    public function defect()
    {
        
    }

}