<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class CustomHelper extends Helper
{
   
    public function category_name($id)
    {
        /*$this->Categories = TableRegistry::get('categories');
    	return $this->Categories->get($id)->name;*/
    }

    public function color_name($id)
    {
        
    }

    public function get_gallery_images($id)
    {
    	
    }

    public function get_gallery_reviews($id)
    {
    	
    }

    public function get_ticket_count()
    {
        
    }


    public function get_leave_equest_count()
    {
        $this->LeaveRequest = TableRegistry::get('leave_requests');
        $user_id = 1;

        $requests =  $this->LeaveRequest->find('all')->leftJoin('users', 'users.id = leave_requests.user_id')
         ->where(['users.parent_id' => $user_id,'leave_requests.status' => 0])->select(['leave_requests.id'])->toArray();

        return count($requests);
    }

}