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
}