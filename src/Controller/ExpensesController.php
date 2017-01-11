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
        $this->Projects = TableRegistry::get('projects');
        
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
                    ->select(['expense_requests.id','expense_requests.amount','expense_requests.applied_date','expense_requests.expense_name','expense_requests.currency','expense_requests.reason','expense_requests.status','expense_requests.created','expense_types.type']);

        $leavetype =  $this->Expensetype->find('all')->where(['company_id' => $company_id]);
        $projects =  $this->Projects->find('all')->where(['company_id' => $company_id]);

        $this->set('requests', $requests);
        $this->set('leavetype', $leavetype);
        $this->set('projects', $projects);
    }

    public function response($id = 0, $action = '')
    {
        $this->ExpenseRequest = TableRegistry::get('expense_requests');
        
        $user_id = $this->Auth->user('id');
        
        if($action == 'accept')
        {
            $accept = $this->ExpenseRequest->get($id);
            $accept->status = 1;
            if($this->ExpenseRequest->save($accept)){
                $this->Flash->success('Expense request has been accepted successfully!!');
                $this->redirect(array("action"=>'response'));
            }
        }
        elseif($action == 'reject')
        {
            $accept = $this->ExpenseRequest->get($id);
            $accept->status = 2;
            $accept->approved_remarks = $this->request->data['approved_remarks'];
            if($this->ExpenseRequest->save($accept)){
                $this->Flash->success('Expense request has been rejected successfully!!');
                $this->redirect(array("action"=>'response'));
            }
        }
        elseif($id)
        {
            $request = $this->ExpenseRequest->find('all')
            ->leftJoin('users', 'users.id = expense_requests.user_id')
            ->leftJoin('expense_types', 'expense_types.id = expense_requests.type_id')
            ->where(['expense_requests.id' => $id,'users.lead_id' => $user_id])
            ->select(['expense_requests.id','expense_requests.expense_name','expense_requests.currency','expense_requests.amount','expense_requests.applied_date','expense_requests.reason','expense_requests.status','expense_requests.created','users.username','expense_types.type','expense_requests.approved_remarks']);
            $this->set('request', $request);
        }

        $requests =  $this->ExpenseRequest->find('all')->order(['expense_requests.status' => 'ASC','expense_requests.id' => 'DESC'])
        ->leftJoin('users', 'users.id = expense_requests.user_id')
        ->leftJoin('expense_types', 'expense_types.id = expense_requests.type_id')
        ->where(['users.lead_id' => $user_id])
        ->select(['expense_requests.id','expense_requests.expense_name','expense_requests.currency','expense_requests.amount','expense_requests.applied_date','expense_requests.reason','expense_requests.status','expense_requests.created','users.username','expense_types.type','expense_requests.approved_remarks']);

        $this->set('requests', $requests);
    }
   
}