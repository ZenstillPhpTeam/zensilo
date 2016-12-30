<?php foreach($notifications as $noti){ 

	$name = $this->Custom->get_username($noti->notifrom);
	$type = $noti->type;=\
	]function __construct($foo = null) {
		$this->foo = $foo;
	}
?>
<div>
<img src="">
<?php if($type == 'leave_request_new'){?>
<p><? $name;?> send to you <a href="<?= $this->Url->build(['controller' => 'leaverequests', 'action' => 'response']);?>">leave request.</a></p>
<?php }elseif($type == 'leave_request_accepted'){?>
<p><? $name;?> accept your <a href="<?= $this->Url->build(['controller' => 'leaverequests', 'action' => 'request']);?>">leave request.</a></p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> declined your <a href="<?= $this->Url->build(['controller' => 'leaverequests', 'action' => 'request']);?>">leave request.</a></p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> submitted his/her <a href="<?= $this->Url->build(['controller' => 'timesheet', 'action' => 'add']);?>">timesheet</a> for your approval.</p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> accept your <a href="<?= $this->Url->build(['controller' => 'timesheet', 'action' => 'lists']);?>">timesheet</a></p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> declined your <a href="<?= $this->Url->build(['controller' => 'timesheet', 'action' => 'lists']);?>">timesheet data</a></p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> submitted his/her <a href="<?= $this->Url->build(['controller' => 'timesheet', 'action' => 'add']);?>">expense</a> for your approval.</p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> accept your <a href="<?= $this->Url->build(['controller' => 'timesheet', 'action' => 'lists']);?>">expense</a></p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> declined your <a href="<?= $this->Url->build(['controller' => 'timesheet', 'action' => 'lists']);?>">expense data</a></p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> assigned you in a new project <a href="<?= $this->Url->build(['controller' => 'timesheet', 'action' => 'add']);?>">expense</a></p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> assigned you in a new task <a href="<?= $this->Url->build(['controller' => 'timesheet', 'action' => 'lists']);?>">expense</a> in <?= $project?></p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> updated status "Completed" of the task<a href="<?= $this->Url->build(['controller' => 'timesheet', 'action' => 'lists']);?>">expense data</a> in project</p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> updated status "Completed" of the task<a href="<?= $this->Url->build(['controller' => 'timesheet', 'action' => 'lists']);?>">expense data</a> in project</p>
<?php }elseif($type == 'leave_request_declined'){?>
<p><? $name;?> updated status "Completed" of the project <a href="<?= $this->Url->build(['controller' => 'timesheet', 'action' => 'lists']);?>">expense data</a>.</p>
<?php }elseif($type == 'custom'){?>
<p><? $name;?> send a notification to you "Notes".</p>
<?php }?>
</div>

<?php }?>