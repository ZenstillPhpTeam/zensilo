<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;
class MailController extends UsersController
{
	public $paginate = [
        'limit' => 15
    ];

	public function index($type = 'inbox', $ajax = 0)
	{
		if(!$this->Auth->user())
        {    
        	$this->redirect(["controller" => "users"]);exit;
        }

		$this->Mail = TableRegistry::get('mails');
		$this->MailParticipant = TableRegistry::get('mail_participants');

		$mailids = array_values($this->MailParticipant->find('list', ['conditions' => ['user_id' => $this->loggedInUser['id']], 'keyField' => 'id', 'valueField' => 'mail_id'])->toArray());

		$mails = array();
		$inbox_count = $important_count = $draft_count = $trash_count = $sent_count = 0;

		$this->paginate['order'] = [
            'Mails.id' => 'desc'
        ];

		if(count($mailids))
		{
			
	        $conditions = [
	            'Mails.id IN ' => $mailids,
	            'Mails.status' => 0
	        ];

	        if($type == 'trash')
	        	$conditions = ['OR' => ['Mails.id IN ' => $mailids, 'Mails.mail_from' => $this->loggedInUser['id']], 'Mails.status' => 2];

	        if($type == 'important')
	        	$conditions['Mails.starred'] = 1;

	        if($type == 'sent')
	        	$conditions = ['Mails.mail_from' => $this->loggedInUser['id'], 'Mails.status' => 0];

	        if($type == 'drafts')
	        	$conditions = ['Mails.mail_from' => $this->loggedInUser['id'], 'Mails.status' => 1];

	        $this->paginate['conditions'] = $conditions;
	        
	        $this->paginate['contain'] = ['MailParticipants', 'Users'];

	        $mails = $this->paginate('Mails');

	        $inbox_count = $this->Mail->find('all', ['conditions' => ['status' => 0, 'id IN' => array_values($mailids)]])->count();
	       	$important_count = $this->Mail->find('all', ['conditions' => ['starred' => 1, 'status' => 0, 'id IN' => array_values($mailids)]])->count();
	       	$trash_count = $this->Mail->find('all', ['conditions' => ['OR' => ['id IN ' => $mailids, 'mail_from' => $this->loggedInUser['id']], 'status' => 2]])->count();
		}
		elseif($type == 'sent' || $type == 'drafts')
		{
			if($type == 'sent')
	        	$conditions = ['Mails.mail_from' => $this->loggedInUser['id'], 'Mails.status' => 0];

	        if($type == 'drafts')
	        	$conditions = ['Mails.mail_from' => $this->loggedInUser['id'], 'Mails.status' => 1];

			$this->paginate['conditions'] = $conditions;
	        
	        $this->paginate['contain'] = ['MailParticipants', 'Users'];

	        $mails = $this->paginate('Mails');
		}

		$sent_count = $this->Mail->find('all', ['conditions' => ['mail_from' => $this->loggedInUser['id'], 'status' => 0]])->count();
		$draft_count = $this->Mail->find('all', ['conditions' => ['mail_from' => $this->loggedInUser['id'], 'status' => 1]])->count();
		$this->set(compact('type', 'mails', 'inbox_count', 'important_count', 'draft_count', 'trash_count', 'sent_count'));

		if($ajax)
    	{
    		$this->viewBuilder()->layout(false);
    		$this->render("ajax");
    	}
	}

	public function compose($id = 0, $type='draft')
	{
		$this->Mail = TableRegistry::get('mails');
		$this->MailParticipant = TableRegistry::get('mail_participants');
						
		if ($this->request->is('post'))
		{
			$this->request->data['mail_from'] = $this->loggedInUser['id'];

			if($type == 'reply')
				$this->request->data['parent'] = $id;

			if(isset($this->request->data['draftMail']))
				$this->request->data['status'] = 1;
			else
				$this->request->data['status'] = 0;

			if($id && $type == 'draft')
				$mail = $this->Mail->get($id);
			else
				$mail = $this->Mail->newEntity();
			$mail = $this->Mail->patchEntity($mail, $this->request->data);
			$res = $this->Mail->save($mail);

			if($id && $type == 'draft')
			{
				$this->MailParticipant->deleteAll(['mail_id' => $id]);
			}

			if($res)
			{
				$mail_id = $res['id'];

				$data = array('mail_id' => $mail_id);
				if(isset($this->request->data['mail_to']))
				{
					foreach ($this->request->data['mail_to'] as $key => $value) {
						$data['user_id'] = $value;
						$data['type'] = 'to';

						$mdata = $this->MailParticipant->newEntity();
						$mdata = $this->MailParticipant->patchEntity($mdata, $data);
						$this->MailParticipant->save($mdata);
					}
				}
				

				if(isset($this->request->data['mail_cc']))
				{
					foreach ($this->request->data['mail_cc'] as $key => $value) {
						$data['user_id'] = $value;
						$data['type'] = 'cc';

						$mdata = $this->MailParticipant->newEntity();
						$mdata = $this->MailParticipant->patchEntity($mdata, $data);
						$this->MailParticipant->save($mdata);
					}
				}

				if(isset($this->request->data['mail_bcc']))
				{
					foreach ($this->request->data['mail_bcc'] as $key => $value) {
						$data['user_id'] = $value;
						$data['type'] = 'bcc';

						$mdata = $this->MailParticipant->newEntity();
						$mdata = $this->MailParticipant->patchEntity($mdata, $data);
						$this->MailParticipant->save($mdata);
					}
				}

				$this->Flash->success(__('Your mail sent successfully.'));
                return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('Unable to send mail. Please try again'));
		}

		$this->index();

		if($id)
		{
			$ddata = $this->Mail->find('all', [
			    'conditions' => ['mails.id' => $id],
			    'contain' => ['MailParticipants', 'Users']
			])->first();
			$this->set(compact('ddata'));
		}
		
		$this->set(compact('type'));
	}

	public function single($id)
    {
    	$this->Mail = TableRegistry::get('mails');

    	$data = $this->Mail->find('all', [
		    'conditions' => ['mails.id' => $id],
		    'contain' => ['MailParticipants', 'Users']
		])->first();
    	
    	$this->viewBuilder()->layout(false);
    	$this->set(compact('data'));
    }
}