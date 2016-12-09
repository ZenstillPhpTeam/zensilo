<?php 
$to = []; $cc = []; $bcc = [];
foreach($data->mail_participants as $us)
{
  if($us->type == 'to')
    $to[] = $us->user_id;
  elseif($us->type == 'cc')
    $cc[] = $us->user_id;
  elseif($us->type == 'bcc')
    $bcc[] = $us->user_id;
}
?>
<div class="pad15A clearfix mrg10B">
  <div class="float-left">
    <button id="back_to_list" class="btn btn-alt btn-hover btn-primary" >
      <i class="glyph-icon icon-arrow-left"></i>
       <span>Back</span>
      <div class="ripple-wrapper"></div>
    </button>
  </div>
  <div class="float-left mrg10L">
    <b><?= $data->user->username;?></b> (<?= $data->user->email;?>) <i>to</i> <b><?= $this->Custom->getemailbyid($to); ?></b>
    <?php if(count($cc)){?><p>cc : <?= $this->Custom->getemailbyid($cc); ?></p><?php }?>
    <?php if(count($bcc) && $data->mail_from == $loggedInUser['id']){?><p>bcc : <?= $this->Custom->getemailbyid($bcc); ?></p><?php }?>
  </div>
  <div class="float-right opacity-80"><i class="glyph-icon icon-clock-o mrg5R"></i> <?= $data->created;?></div>
</div>
<div class="mail-toolbar clearfix">
  <div class="float-left">
    <h4 class="font-primary"><?= $data->subject;?></h4>
  </div>
  <div class="float-right">
    <a href="#" class="btn btn-default print_mail" title="Print"><i class="glyph-icon icon-print"></i></a> 
    <a href="#" class="btn btn-danger mrg10L trash_mail" title="Delete"><i class="glyph-icon icon-trash-o"></i></a>
  </div>
</div>
<div class="email-body">
  <?= $data->message;?>
</div>
<div class="button-pane">
  <a href="<?= $this->Url->build(['controller' => 'mail', 'action' => 'compose', $data->id, 'reply'])?>" class="btn btn-blue-alt" title="Reply"><i class="glyph-icon icon-mail-reply"></i> Reply</a> 
  <a href="<?= $this->Url->build(['controller' => 'mail', 'action' => 'compose', $data->id, 'forward'])?>" class="btn btn-default" title="Reply">Forward <i class="glyph-icon icon-mail-forward"></i></a>
</div>