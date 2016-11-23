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


    public function current_week_range($date) {
        
        $ts = strtotime($date);
        $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
        return array(date('Y-m-d', $start),date('Y-m-d', strtotime('next saturday', $start)));
    }

}