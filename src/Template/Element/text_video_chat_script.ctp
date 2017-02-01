angular_module
    .directive('ngEnter', function() {
        return function(scope, element, attrs) {
            element.bind("keydown keypress", function(event) {
                if(event.which === 13) {
                        scope.$apply(function(){
                                scope.$eval(attrs.ngEnter);
                        });
                        
                        event.preventDefault();
                }
            });
        };
    })
    .directive('onFinishRender', function ($timeout) {
        return {
            restrict: 'A',
            link: function (scope, element, attr) {
                if (scope.$last === true) {
                    $timeout(function () {
                      //scope.$emit(attr.onFinishRender);
                      if(jQuery("#chat_box_"+attr.onFinishRender).length)
                        jQuery("#chat_box_"+attr.onFinishRender).scrollTop(jQuery("#chat_box_"+attr.onFinishRender)[0].scrollHeight);
                    });
                }
            }
        }
    })
    .controller('TodoListController', function($scope, OTSession, $http) {
        var online_status = new Firebase('https://vinogautam.firebaseio.com/zensilo/online_status/');
        var chat_notification = new Firebase('https://vinogautam.firebaseio.com/zensilo/chat_notification/<?= $loggedInUser['id']; ?>/');

        online_status.update({ <?= $loggedInUser['id']; ?>:new Date().getTime()});
        setInterval(function(){
          online_status.update({ <?= $loggedInUser['id']; ?>:new Date().getTime()});
        }, 10000);
        
        $scope.online_users = [];
        $scope.get_user_online_status = function(id)
        {
          return $scope.online_users[id] === undefined ? false : $scope.online_users[id];
        };

        online_status.on('value', function(snapshot) {
          angular.forEach(snapshot.val(), function(v,k){
            current_time_stamp = new Date().getTime();
            diff = current_time_stamp - v;
            if(!$scope.$$phase) {
              $scope.$apply(function(){
                if(diff > 10000)
                  $scope.online_users[k] = false;
                else
                  $scope.online_users[k] = true;
              });
            }
            else
            {
              if(diff > 10000)
                $scope.online_users[k] = false;
              else
                $scope.online_users[k] = true;
            }
          });
        });
        is_chat_noti = 0;
        chat_notification.on('value', function(snapshot) {
          if(is_chat_noti == 0)
          {
            is_chat_noti = 1;
            return;
          }

          noti_val = snapshot.val();
          console.log(noti_val);
          if(noti_val.type == "new_chat")
          {
              if(!$scope.$$phase) {
                $scope.$apply(function(){
                  $scope.new_chat(noti_val.user_id);
                });
              }
              else
              {
                $scope.new_chat(noti_val.user_id);
              }
          }
          else if(noti_val.type == "video_chat")
          {
              if(!$scope.$$phase) {
                $scope.$apply(function(){
                  $scope.initiated_video_chat(noti_val);
                });
              }
              else
              {
                $scope.initiated_video_chat(noti_val);
              }
          }
          else if(noti_val.type == 'call_end')
          {
            if(!$scope.$$phase) {
              $scope.$apply(function(){
                $scope.call_end(0);
              });
            }
            else
            {
              $scope.call_end(0);
            }
          }
        });

        $scope.current_chat = [];
        var all_chat_listeners = [];
        $scope.all_chat_data = [];
        $scope.multi_chat = {};
        $scope.new_chat = function(id)
        {
          if($scope.current_chat.indexOf(id) != -1) return;

          $scope.current_chat.push(id);
          if(all_chat_listeners[id] === undefined)
          {
            $scope.all_chat_data[id] = [];
            if(<?= $loggedInUser['id']; ?> > id)
              all_chat_listeners[id] = new Firebase('https://vinogautam.firebaseio.com/zensilo/individual_chat/'+id+'-<?= $loggedInUser['id']; ?>/');
            else
              all_chat_listeners[id] = new Firebase('https://vinogautam.firebaseio.com/zensilo/individual_chat/<?= $loggedInUser['id']; ?>-'+id+'/');
            
            all_chat_listeners[id].on('child_added', function(snapshot) {
                if(!$scope.$$phase) {
                  $scope.$apply(function(){
                    $scope.all_chat_data[id].push(snapshot.val());
                  });
                }
                else
                {
                  $scope.all_chat_data[id].push(snapshot.val());
                }
            });
          }

          //chat_interface(0);
        };

        $scope.remove_chat = function(id){
          ind = $scope.current_chat.indexOf(id);
          if(ind == -1) return;

          $scope.current_chat.splice(ind, 1);
        };

        $scope.getAvatarbyId = function(id){
          av = $(".online-status[data-id="+id+"]").data("email");
          return "http://identicon.org/?t="+av+"&s=20";
        };

        $scope.getNamebyId = function(id){
          return $(".online-status[data-id="+id+"]").data("name");
        };

        $scope.add = function(id){
            all_chat_listeners[id].push({id: <?= $loggedInUser['id']; ?>, msg: $scope.multi_chat[id]});
            $scope.send_notification(id, {type:"new_chat", user_id: <?= $loggedInUser['id']; ?>, ts: new Date().getTime()});
            $scope.multi_chat[id] = '';
        };

        $scope.send_notification = function(id, obj){
          console.log(id, obj);
          new Firebase('https://vinogautam.firebaseio.com/zensilo/chat_notification/'+id+'/').update(obj);
        };
        
        $scope.start_video_chat = false;
        $scope.start_video_chat_load = false;
        $scope.current_token = false;
        $scope.is_initiater = false;
        $scope.is_receiver = false;

        $scope.new_video_chat = function(id)
        {
          $scope.start_video_chat = id;
          $http.get("<?= $this->Url->build(['controller' => 'ajax', 'action' => 'opentok']);?>").then(function(res){
            if(res['data'])
            {
                OTSession.init(res['data'].apikey, res['data'].sessionId, res['data'].token, function (err) {
                  if (!err) {
                    $scope.$apply(function () {
                      $scope.start_video_chat_load = true;
                      res['data']['user_id'] = <?= $loggedInUser['id']; ?>;
                      res['data']['type'] = "video_chat";
                      $scope.current_token = res['data'];
                      $scope.send_notification(id, res['data']);
                      $scope.is_initiater = true;
                    });

                    OTSession.session.on('signal:joined_meeting', function (event) {
                      console.log(event);
                      OTSession.session.signal( 
                            {  type: 'whiteboard',
                               data: $scope.whiteboard
                            }, 
                            function(error) {
                                if (error) {
                                  console.log("signal error ("
                                         + error.code
                                         + "): " + error.message);
                                } else {
                                  console.log("whiteboard signal sent.");
                                }
                            });
                    });
                  }
                });
            }
          });
        };

        $scope.streams = OTSession.streams;

        $scope.initiated_video_chat = function(res)
        {
            $scope.new_chat(res.user_id);
            $scope.start_video_chat = res.user_id;
            $scope.is_receiver = true;
            OTSession.init(res.apikey, res.sessionId, res.token, function (err) {
                if (!err) {
                  $scope.$apply(function () {
                    $scope.start_video_chat_load = true;
                  });
                  
                  OTSession.session.signal( 
                  {  type: 'joined_meeting',
                     data: {}
                  }, 
                  function(error) {
                      if (error) {
                        console.log("signal error ("
                               + error.code
                               + "): " + error.message);
                      } else {
                        console.log("joined_meeting signal sent.");
                      }
                  });

                  OTSession.session.on('signal:whiteboard', function (event) {
                    console.log(event);
                    $scope.$apply(function(){
                      $scope.whiteboard = event.data;
                    });
                  });
                  
                }
            });
        }

        $scope.call_again = function()
        {
          $scope.current_token.ts = new Date().getTime();
          $scope.send_notification($scope.start_video_chat, $scope.current_token)
        };

        $scope.call_end = function(st)
        {
            
            if(st)
            $scope.send_notification($scope.start_video_chat, {type: 'call_end', user_id: <?= $loggedInUser['id']; ?>});

            $scope.start_video_chat = false;
            $scope.start_video_chat_load = false;
            $scope.current_token = false;
            $scope.is_initiater = false;
            $scope.is_receiver = false;
        };

        $scope.whiteboard_change = function(st)
        {
            $scope.whiteboard = st;

            OTSession.session.signal( 
            {  type: 'whiteboard',
               data: $scope.whiteboard
            }, 
            function(error) {
                if (error) {
                  console.log("signal error ("
                         + error.code
                         + "): " + error.message);
                } else {
                  console.log("joined_meeting signal sent.");
                }
            });
        };

    })
    .controller('GroupChatController', function($scope, OTSession, $http) {

        $(".sb-left").click(function(e){
          e.stopPropagation();
        });

        var group_chat = new Firebase('https://vinogautam.firebaseio.com/zensilo/group_chat/<?= $project->id; ?>/');
        
        $scope.all_chat_data = [];
        
        group_chat.on('child_added', function(snapshot) {
            if(!$scope.$$phase) {
              $scope.$apply(function(){
                $scope.all_chat_data.push(snapshot.val());
              });
            }
            else
            {
              $scope.all_chat_data.push(snapshot.val());
            }
        });

        $scope.add = function(id){
            group_chat.push({id: <?= $loggedInUser['id']; ?>, email: <?= $loggedInUser['id']; ?>, msg: $scope.grmsg});
            $scope.grmsg = '';
        };

        $scope.getAvatarbyId = function(email){
          return "http://identicon.org/?t="+email+"&s=20";
        };
    });