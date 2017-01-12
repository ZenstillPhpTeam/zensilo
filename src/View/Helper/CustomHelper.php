<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class CustomHelper extends Helper
{

    public function get_leave_request_count($user_id)
    {
        $this->LeaveRequest = TableRegistry::get('leave_requests');
    
        $requests =  $this->LeaveRequest->find('all')->leftJoin('users', 'users.id = leave_requests.user_id')
         ->where(['users.lead_id' => $user_id,'leave_requests.status' => 0])->select(['leave_requests.id'])->toArray();

        return count($requests);
    }

     public function get_expense_request_count($user_id)
    {
        $this->LeaveRequest = TableRegistry::get('expense_requests');
    
        $requests =  $this->LeaveRequest->find('all')->leftJoin('users', 'users.id = expense_requests.user_id')
         ->where(['users.lead_id' => $user_id,'expense_requests.status' => 0])->select(['expense_requests.id'])->toArray();

        return count($requests);
    }

    public function get_time_sheet_count($user_id) {
        
        $this->TimeSheetWeek = TableRegistry::get('time_sheet_weeks');
    
        $requests =  $this->TimeSheetWeek->find('all')->where(['manager_id' => $user_id,'status' => 1])->select(['id'])->toArray();

        return count($requests);
    }

    public function current_week_range($date) {
        
        $ts = strtotime($date);
        $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
        return array(date('Y-m-d', $start),date('Y-m-d', strtotime('next saturday', $start)));
    }

    public function inbox_count($user_id)
    {
        $this->Mail = TableRegistry::get('mails');
        $this->MailParticipant = TableRegistry::get('mail_participants');

        $mailids = array_values($this->MailParticipant->find('list', ['conditions' => ['user_id' => $user_id], 'keyField' => 'id', 'valueField' => 'mail_id'])->toArray());
        if(count($mailids))
            return $this->Mail->find('all', ['conditions' => ['id IN' => array_values($mailids)]])->count();
        else
            return 0;
    }

    public function getemailbyid($user_id)
    {
        $this->User = TableRegistry::get('users');

        $res = $this->User->find('all', ['conditions' => ['id IN ' => $user_id]])->all();

        $arr = array();

        foreach ($res as $key => $value) {
            $arr[] = $value->email;
        }

        return implode(",", $arr);
    }

    public function get_username($id) {
        
        $this->User = TableRegistry::get('users');
    
        $requests =  $this->User->find('all')->where(['id' => $id])->first();

        return count($requests) ? $requests->username : '';
    }

    public function get_projectname($id) {
        
        $this->Table = TableRegistry::get('projects');
    
        $requests =  $this->Table->find('all')->where(['id' => $id])->first();

        return count($requests) ? $requests->project_name : '';
    }

    public function get_taskname($id) {
        
        $this->User = TableRegistry::get('tasks');
    
        $requests =  $this->Table->find('all')->where(['id' => $id])->first();

        return count($requests) ? $requests->task_name : '';
    }

    public function get_task_teams($id) {
        
        $this->Task = TableRegistry::get('task_teams');
        $this->Users = TableRegistry::get('users');
        //$parent_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');

        $requests =  array_values($this->Task->find('list',  [ 'conditions' => ['task_id' => $id],'keyField' => 'id', 'valueField' => 'user_id'])->toArray());

         if(count($requests)){
           $users = array_values($this->Users->find('list', ['conditions' => ['id IN' => array_values($requests)], 'keyField' => 'id', 'valueField' => 'username' ])->toArray());
           return $username = implode(",", $users);
         }
         else
            return 0;
    }

    public function user_menu_avalablity_check($role, $designation, $menu)
    {
        if($role == 'company')
            return true;

        if($role == 'client' && $menu == 'project')
            return true;

        if($role == 'user')
        {
            if(isset($designation->project_access))
            {
                if($designation->project_access && $menu == 'project')
                    return true;
                if($designation->client_access && $menu == 'client')
                    return true;
                if($designation->user_access && $menu == 'user')
                    return true;
                if($designation->setting_access && $menu == 'setting')
                    return true;
            }
        }

        return false;
    }

    public function is_lead($id) {
        
        $this->User = TableRegistry::get('users');
    
        $requests =  $this->User->find('all')->where(['lead_id' => $id])->count();

        return $requests;
    }
}