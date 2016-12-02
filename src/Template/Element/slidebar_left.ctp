<div ng-controller="TodoListController">
  <div class="sb-slidebar bg-black sb-left sb-style-overlay">
    <div class="scrollable-content scrollable-slim-sidebar">
      <div class="pad10A">
        <div class="divider-header">Users</div>
        <ul class="chat-box">
          <?php 
          foreach ($designation as $key => $design) { 
            $designation1[$design['id']] = $design['designation'];
          }
          foreach($company_users as $us){?>
          <li>
            <div class="status-badge"><img class="img-circle" width="40" src="http://identicon.org/?t=<?= $us->email;?>&s=40" alt="">
              <div class="small-badge online-status" ng-class="{'bg-green': get_user_online_status(<?= $us->id;?>),'bg-orange': !get_user_online_status(<?= $us->id;?>)}" data-email="<?= $us->email;?>" data-name="<?= $us->username;?>" data-id="<?= $us->id;?>"></div>
            </div>
            <b><?= $us->username;?></b>
            <p>On the other hand, we denounce...</p>
            <a href="#" ng-click="new_chat(<?= $us->id;?>);" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
          </li>
          <?php }?>
        </ul>
        <div class="divider-header">Clients</div>
        <ul class="chat-box">
          <?php foreach($company_clients as $us){?>
          <li>
            <div class="status-badge"><img class="img-circle" width="40" src="http://identicon.org/?t=<?= $us->email;?>&s=40" alt="">
              <div class="small-badge online-status" ng-class="{'bg-green': get_user_online_status(<?= $us->id;?>),'bg-orange': !get_user_online_status(<?= $us->id;?>)}" data-email="<?= $us->email;?>" data-name="<?= $us->username;?>" data-id="<?= $us->id;?>"></div>
            </div>
            <b><?= $us->username;?></b>
            <p>On the other hand, we denounce...</p>
            <a href="#" ng-click="new_chat(<?= $us->id;?>);" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
          </li>
          <?php }?>
        </ul>
      </div>
    </div>
  </div>
  
  <div ng-cloak class="chat_container">
      <div class="chat_box" ng-repeat="chat in current_chat" ng-show="$index < 2 || $index == current_chat.length-1">
        <div class="chat_header">
          <div class="status-badge"><img class="img-circle" width="20" ng-src="{{getAvatarbyId(chat)}}" alt="">
            <div class="small-badge" ng-class="{'bg-green': get_user_online_status(chat),'bg-orange': !get_user_online_status(chat)}"></div>
          </div>
          <b>{{getNamebyId(chat)}}</b>
          <a ng-click="remove_chat(chat)"><i class="glyph-icon icon-close"></i></a>
          <a ng-click="new_video_chat(chat)"><i class="glyph-icon icon-video-camera"></i></a>
        </div>
        <div id="chat_box_{{chat}}" class="chat_conversation_box">
          <div ng-repeat="msg in all_chat_data[chat]" on-finish-render="{{chat}}" ng-class="{own_msg: msg.id == <?= $loggedInUser['id']; ?>, opponent_msg: msg.id != <?= $loggedInUser['id']; ?>}">
            <div class="clearfix" ng-if="msg.msg && msg.id == <?= $loggedInUser['id']; ?>">
              <div><p>{{msg.msg}}<p></div>
              <img ng-src="http://identicon.org/?t=<?= $loggedInUser['email']; ?>&s=20">
            </div>
            <div class="clearfix" ng-if="msg.msg && msg.id != <?= $loggedInUser['id']; ?>">
              <img ng-src="{{getAvatarbyId(msg.id)}}">
              <div><p>{{msg.msg}}</p></div>
            </div>
          </div>
        </div>
        <div class="chat_input">
          <input type="text" ng-model="multi_chat[chat]" ng-enter="add(chat);">
        </div>
      </div>
  </div>

  <div class="video_chat_container" ng-class="{start_video_chat: start_video_chat}">
    <ot-layout props="{animate:true}" ng-if="start_video_chat_load">
              <ot-publisher id="publisher" 
                props="{style: {nameDisplayMode: 'off'}, resolution: '500x300', frameRate: 30}">
              </ot-publisher>
    </ot-layout>
    <div class="subscriber_layout" ng-class="{whiteboard_enabled: whiteboard}">
      <ot-whiteboard ng-if="whiteboard"></ot-whiteboard>
      <ot-layout props="{animate:true}" ng-if="start_video_chat && !whiteboard">
                <ot-subscriber ng-repeat="stream in streams" 
                  stream="stream" 
                  props="{style: {nameDisplayMode: 'off'}}">
                </ot-subscriber>
      </ot-layout>
      <img class="loading_image" ng-if="!streams.length && !whiteboard" src="<?= $this->Url->build("/"); ?>img/bars.svg" width="40" alt="">
      <div ng-show="is_initiater" class="video_call_action">
        <button ng-hide="whiteboard" ng-click="whiteboard_change(true);" class="btn btn-sm btn-warning">Switch to Whiteboard</button>
        <button ng-show="whiteboard && streams.length" ng-click="whiteboard_change(false);" class="btn btn-sm btn-warning">Back to Video</button>
        <button ng-click="call_again()" class="btn btn-sm btn-warning">Call Again</button>
        <button ng-show="streams.length" ng-click="call_end(1);" class="btn btn-sm btn-danger">End Call</button>
      </div>
    </div>
  </div>
</div>