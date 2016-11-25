<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;

class ExpensesController extends UsersController
{

    public function request($id = 0, $action = '')
    {
        $this->ExpenseRequest = TableRegistry::get('expense_requests');
        $this->Expensetype = TableRegistry::get('expense_types');
        
        $user_id = $this->Auth->user('id'); 
        $company_id = $this->Auth->user('userrole') == "company" ? $this->Auth->user('id') : $this->Auth->user('parent_id');
		
        if($action == 'delete')
        {
            $this->ExpenseRequest->delete($this->ExpenseRequest->get($id));
            $this->Flash->success('Expense request has been deleted successfully!!');
            $this->redirect(array("action" => 'request'));
        }
        elseif ($this->request->is('post') )
        { 
			if(isset($this->request->data['id'])){
                $request = $this->ExpenseRequest->get($this->request->data['id']);

            //$this->request->data['user_id'] = $user_id;
            //$this->request->data['company_id'] = $company_id;

            $request = $this->ExpenseRequest->patchEntity($request, $this->request->data);
            
            if ($this->ExpenseRequest->save($request)) {
                
                $this->Flash->success(__('The request has been Updated.'));
                return $this->redirect(['action' => 'request']);
            }
            //$this->Flash->error(__('Unable to add the Expense.'));
            }
            else{

            $request = $this->ExpenseRequest->newEntity();

            $this->request->data['user_id'] = $user_id;
            $this->request->data['company_id'] = $company_id;

            $request = $this->ExpenseRequest->patchEntity($request, $this->request->data);
            
            if ($this->ExpenseRequest->save($request)) {
				
                $this->Flash->success(__('The request has been saved.'));
                return $this->redirect(['action' => 'request']);
            }
            $this->Flash->error(__('Unable to add the Expense.'));
            }
        }
        elseif($id)
        {
            $request = $this->ExpenseRequest->get($id);
            $this->set('request', $request);
        }

		$requests =  $this->ExpenseRequest->find('all')->leftJoin('expense_types', 'expense_types.id = expense_requests.type_id')
                    ->where(['user_id' => $user_id])
                    ->select(['expense_requests.id','expense_requests.amount','expense_requests.applied_date','expense_requests.expense_name','expense_requests.reason','expense_requests.status','expense_requests.created','expense_types.type']);

        $leavetype =  $this->Expensetype->find('all')->where(['company_id' => $company_id]);

        $this->set('requests', $requests);
        $this->set('leavetype', $leavetype);
    }

    public function response($id = 0, $action = '')
    {
        $this->LeaveRequest = TableRegistry::get('leave_requests');
        
        $user_id = $this->Auth->user('id');
        
        if($action == 'accept')
        {
            $accept = $this->LeaveRequest->get($id);
            $accept->status = 1;
            if($this->LeaveRequest->save($accept)){
                $this->Flash->success('Leave request has been accepted successfully!!');
                $this->redirect(array("action"=>'response'));
            }
        }
        elseif($action == 'reject')
        {
            $accept = $this->LeaveRequest->get($id);
            $accept->status = 2;
            if($this->LeaveRequest->save($accept)){
                $this->Flash->success('Leave request has been rejected successfully!!');
                $this->redirect(array("action"=>'response'));
            }
        }
        elseif($id)
        {
            $request = $this->LeaveRequest->find('all')
            ->leftJoin('users', 'users.id = leave_requests.user_id')
            ->leftJoin('leave_types', 'leave_types.id = leave_requests.type_id')
            ->where(['leave_requests.id' => $id,'users.lead_id' => $user_id])
            ->select(['leave_requests.id','leave_requests.no_of_days','leave_requests.start_date','leave_requests.end_date','leave_requests.reason','leave_requests.status','leave_requests.created','users.username','leave_types.type']);
            $this->set('request', $request);
        }

        $requests =  $this->LeaveRequest->find('all')->order(['leave_requests.status' => 'ASC','leave_requests.id' => 'DESC'])
        ->leftJoin('users', 'users.id = leave_requests.user_id')
        ->leftJoin('leave_types', 'leave_types.id = leave_requests.type_id')
        ->where(['users.lead_id' => $user_id])
        ->select(['leave_requests.id','leave_requests.no_of_days','leave_requests.start_date','leave_requests.end_date','leave_requests.reason','leave_requests.status','leave_requests.created','users.username','leave_types.type']);

        $this->set('requests', $requests);
    }
   
}