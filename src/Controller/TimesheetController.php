<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\View\Helper\CustomHelper;

class TimesheetController extends UsersController
{

    public function add()
    {
        $this->TimeSheetWeek = TableRegistry::get('time_sheet_weeks');
        $this->TimeSheetDay = TableRegistry::get('time_sheet_days');

        $user_id = $this->Auth->user('id');
        $company_id = $this->Auth->user('parent_id');
        $manager_id = $this->Auth->user('lead_id');

        if($this->request->is('post'))
        { 
            $postdata = $this->request->data;
            
            if($postdata['data']['timesheetWeekId']){

                $week = $this->TimeSheetWeek->get($postdata['data']['timesheetWeekId']);
                $week->status = $postdata['status'];
                $save = $this->TimeSheetWeek->save($week);

                $condition = array('timesheet_week_id' => $postdata['data']['timesheetWeekId']);
                $this->TimeSheetDay->deleteAll($condition,false);  

            } else {

                $request = $this->TimeSheetWeek->newEntity();
                $newdata['user_id'] = $user_id;
                $newdata['company_id'] = $company_id;
                $newdata['manager_id'] = $manager_id;
                $newdata['moth_year'] = date("Y-m",strtotime(date($postdata['data']['dates'][0])));
                $newdata['start_date'] = $postdata['data']['dates'][0];
                $newdata['end_date'] = $postdata['data']['dates'][6];
                $newdata['status'] = $postdata['status'];
                $request = $this->TimeSheetWeek->patchEntity($request,$newdata);
                $save = $this->TimeSheetWeek->save($request);
            }

            foreach ($postdata['data']['days'] as $record) {

                if($record['project'] > 0 && $record['task'] > 0) { 

                    foreach ($record['days_hrs'] as $date => $hrs) {

                        $request = $this->TimeSheetDay->newEntity();
                        $newday['timesheet_week_id'] = $save->id;
                        $newday['user_id'] = $user_id;
                        $newday['company_id'] = $company_id;
                        $newday['project_id'] = $record['project'];
                        $newday['task_id'] = $record['task'];
                        $newday['date'] = $date;
                        $newday['hours'] = $hrs;
                        $request = $this->TimeSheetDay->patchEntity($request,$newday);
                        $this->TimeSheetDay->save($request);
                    }
                }
            }

            $this->Flash->success(__('The timesheet has been saved.'));
            echo 'success'; 
            exit;
        }
    }

    public function lists()
    {
        $this->TimeSheetWeek = TableRegistry::get('time_sheet_weeks');
        $this->TimeSheetDay = TableRegistry::get('time_sheet_days');

        $user_id = $this->Auth->user('id');
        $company_id = $this->Auth->user('parent_id');
       
        $requests =  $this->TimeSheetWeek->find('all')->order(['time_sheet_weeks.status' => 'ASC','time_sheet_weeks.id' => 'DESC'])
        ->leftJoin('users', 'users.id = time_sheet_weeks.user_id')
        ->where(['time_sheet_weeks.manager_id' => $user_id,'time_sheet_weeks.status >' => 0])
        ->select(['time_sheet_weeks.id','time_sheet_weeks.start_date','time_sheet_weeks.end_date','time_sheet_weeks.status','time_sheet_weeks.created','time_sheet_weeks.modified','users.username']);

        $this->set('requests', $requests);
    }


    public function view($id = 0, $action = '')
    {
        $this->TimeSheetWeek = TableRegistry::get('time_sheet_weeks');
        $this->TimeSheetDay = TableRegistry::get('time_sheet_days');
        $this->Project = TableRegistry::get('projects');
        $this->Task = TableRegistry::get('tasks');

        $user_id = $this->Auth->user('id');
        $company_id = $this->Auth->user('parent_id');

        $week = $this->TimeSheetWeek->find('all')->where(['time_sheet_weeks.id' => $id])
                ->leftJoin('users', 'users.id = time_sheet_weeks.user_id')
                ->select(['time_sheet_weeks.id','time_sheet_weeks.status','time_sheet_weeks.start_date',
                    'time_sheet_weeks.end_date','users.username'])->first();

        $days = $this->TimeSheetDay->find('all')->where(['time_sheet_days.timesheet_week_id' => $id])
                ->select(['time_sheet_days.id','time_sheet_days.project_id','time_sheet_days.task_id',
                    'time_sheet_days.date','time_sheet_days.hours'])->toArray();
        
        $projects1 =  $this->Project->find('all')->where(['company_id' =>  $company_id,'status !=' => 'Completed'])
        ->select(['id','project_name'])->toArray();

        $tasks1 =  $this->Task->find('all')->where(['company_id' => $company_id,'status !=' => 'Completed'])
        ->select(['id','task_name','project_id'])->toArray();
               
        function get_project_name($projects,$pid){
            foreach ($projects as $project) {
                if($project->id == $pid) { return $project->project_name;}
            }
        }

        function get_task_name($tasks,$tid){
            foreach ($tasks as $task) {
                if($task->id == $tid) { return $task->task_name;}
            }
        }

        $result = array();
        
        $result['id'] = $week->id;
        $result['username'] = $week->users['username'];
        $result['status'] = $week->status;
        $result['start_date'] = $week->start_date;
        $result['end_date'] = $week->end_date;

        $data = $res = $weekdays = array();
        foreach ($days as $key => $value) {
          
            $tss = strtotime(date($value->date));
            $data[$value->project_id][$value->task_id][date('Y-m-d', $tss)] = $value->hours; 
            if(!in_array(date('Y-m-d', $tss), $weekdays)){ $weekdays[] = date('Y-m-d', $tss); }
        }
        
        foreach ($data as $project_id => $project) {
            foreach ($project as $task_id => $task) {
                $ress['project'] = $project_id;
                $ress['project_name'] = get_project_name($projects1,$project_id);
                $ress['task'] = $task_id;
                $ress['task_name'] = get_task_name($tasks1,$task_id);
                $ress['days_hrs'] = $task;
                $ress['total_hrs'] = array_sum($task);
                $res[] = $ress;
            }
        }

        $result['days'] = $res;
        $result['weekdays'] = $weekdays;

        $this->set('result', $result);

        if($action == 'accept')
        {
            $accept = $this->TimeSheetWeek->get($id);
            $accept->status = 2;
            if($this->TimeSheetWeek->save($accept)){
                $this->Flash->success('Time Sheet has been accepted successfully!!');
                $this->redirect(array("action"=>'lists'));
            }
        }

        if ($this->request->is('post') )
        { 
            $reject = $this->request->data;
            
            if($reject['fmaction'] == 'reject'){
                $rejects = $this->TimeSheetWeek->get($reject['id']);
                $rejects->status = 3;
                $rejects->reject_reason = $reject['reason'];
                if($this->TimeSheetWeek->save($rejects)){
                    $this->Flash->success('Time Sheet has been rejected successfully!!');
                    $this->redirect(array("action"=>'lists'));
                }
            }
        }

    }

    public function getData($weeid = null)
    {
        $result = array();
        $result['dates'] = $days_hrs = array();

        $this->TimeSheetWeek = TableRegistry::get('time_sheet_weeks');
        $this->TimeSheetDay = TableRegistry::get('time_sheet_days');

        $this->Project = TableRegistry::get('projects');
        $this->Task = TableRegistry::get('tasks');

        $user_id = $this->Auth->user('id');
        $company_id = $this->Auth->user('parent_id');

        $result['projects'] =  $this->Project->find('all')->where(['company_id' =>  $company_id,'status !=' => 'Completed'])
        ->select(['id','project_name'])->toArray();

        $result['tasks'] =  $this->Task->find('all')->where(['company_id' => $company_id,'status !=' => 'Completed'])
        ->select(['id','task_name','project_id'])->toArray();

        $result['moth_year'] = $this->TimeSheetWeek->find('all',array('group'=>'moth_year'))
        ->select(['id','moth_year','start_date'])->where(['user_id' => $user_id])->toArray();

        $result['week_list'] = $this->TimeSheetWeek->find('all')->select(['id','moth_year','start_date','end_date'])
        ->where(['user_id' => $user_id])->toArray();


        function get_project_name($projects,$pid){
            foreach ($projects as $project) {
                if($project->id == $pid) { return $project->project_name;}
            }
        }

        function get_task_name($tasks,$tid){
            foreach ($tasks as $task) {
                if($task->id == $tid) { return $task->task_name;}
            }
        }

        if($weeid){
            $oldrecord = $this->TimeSheetWeek->find('all')->where(['id' => $weeid])->first();
        }else{

            $oldrecord = $this->TimeSheetWeek->find('all',array('order'=>'id DESC'))->where(['user_id' => $user_id,'status' => 0])->first();
        }
        

        if(count($oldrecord)){

            $ts = strtotime(date($oldrecord->start_date));
            $dow = date('w', $ts);
            $offset = $dow - 1;
            if ($offset < 0) { $offset = 6; }
            $ts = $ts - $offset*86400;
            for ($i = 0; $i < 7; $i++, $ts += 86400){
                $result['dates'][] = date("Y-m-d", $ts);
            }

            $ts_days =  $this->TimeSheetDay->find('all')->where(['timesheet_week_id' => $oldrecord->id])->toArray();
            $data = $res = array();
            foreach ($ts_days as $key => $value) {
              
                $tss = strtotime(date($value->date));
                $data[$value->project_id][$value->task_id][date('Y-m-d', $tss)] = $value->hours; 
            }

            foreach ($data as $project_id => $project) {
                foreach ($project as $task_id => $task) {
                    $ress['project'] = $project_id;
                    $ress['project_name'] = get_project_name($result['projects'],$project_id);
                    $ress['task'] = $task_id;
                    $ress['task_name'] = get_task_name($result['tasks'],$task_id);
                    $ress['days_hrs'] = $task;
                    $res[] = $ress;
                }
            }

            $result['days'] = $res;
            $result['timesheetWeekId'] = $oldrecord->id;
            $result['timesheetWeekstatus'] = $oldrecord->status;

        }else{

            $oldrecord = $this->TimeSheetWeek->find('all',array('order'=>'id DESC'))->where(['user_id' => $user_id])->first();

            if(count($oldrecord)){ $ts = strtotime(date('Y-m-d', strtotime($oldrecord->end_date.' +1 day'))); }
            else{ $ts = strtotime(date('Y-m-d')); }

            $dow = date('w', $ts);
            $offset = $dow - 1;
            if ($offset < 0) { $offset = 6; }
            $ts = $ts - $offset*86400;
            for ($i = 0; $i < 7; $i++, $ts += 86400){

                $result['dates'][] = date("Y-m-d", $ts);
                $days_hrs[date("Y-m-d", $ts)] = '';

            }

            $res['project'] = 0;
            $res['project_name'] = 'Select Project';
            $res['task'] = 0;
            $res['task_name'] = 'Select Task';
            $res['days_hrs'] = $days_hrs;
            $result['days'][] = $res;
            $result['timesheetWeekId'] = 0;
            $result['timesheetWeekstatus'] = 0;
        }

        echo json_encode($result); exit;
               
    }
   
   
}