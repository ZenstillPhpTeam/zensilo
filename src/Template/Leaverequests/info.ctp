<?php ?>
  <div ng-controller="LeaveAvailableCtrl" class="panel">
    <div class="panel-body content-box">
      <h3 class="title-hero bg-primary">Leave Info</h3>
      <div class="example-box-wrapper">
        <div class="panel" >
          <div class="panel-body">

            
            <div style="margin-bottom: 20px; " class="btn-group dropdown">
                <button style="width: 250px;" type="button" class="btn btn-primary3">{{SelectUser}}
                  <div class="ripple-wrapper"></div>
                </button> 
                <button type="button" class="btn btn-primary3 dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <span class="caret"></span> 
                  <span class="sr-only">Toggle Dropdown</span>
                  <div class="ripple-wrapper"></div>
                </button>
                <ul style="width: 280px;" class="dropdown-menu pull-right" role="menu">

                  <li>
                  <a ng-click="get_user_leaves(user);" ng-repeat="user in Leaves.users"  href="javascript:;">{{user.username}}</a>
                  </li>
                 
                </ul>
            </div>


            <div class="example-box-wrapper">
              <div class="profile-box content-box">
                <div class="content-box-header clearfix bg-green" style="font-size: 12px;font-weight: bold; padding: 6px !important;">
                  
                  <div class="row">
                    
                    <div class="col-md-3"> <span style="margin-left:10px;">Leave Type</span> </div>
                    <div class="col-md-3"> <span style="margin-left:10px;">Total Days</span> </div>
                    <div class="col-md-3"> <span style="margin-left:10px;">Leaves Taken</span> </div>
                    <div class="col-md-3"> <span style="margin-left:10px;">Available Days</span> </div>
                    
                  </div>
                  

                </div>

                <div class="list-group">

                  <a ng-repeat="(key,infos) in Leaves.info" style="border-bottom: 1px solid #4caf50;margin-top: 1px;" class="list-group-item">
                    <div class="row">
                      
                    <div class="col-md-3"> 
                       <span>{{infos.name}}</span>
                    </div>

                    <div class="col-md-3"> 
                       <span style="margin-left:10px;">{{infos.max}}</span>
                    </div>

                    <div class="col-md-3"> 
                       <span style="margin-left:10px;">{{infos.taken}}</span>
                    </div>

                    <div class="col-md-3"> 
                       <span style="margin-left:10px;">{{infos.max - infos.taken}}</span>
                    </div>

                    </div>
                  </a> 
                 
                </div>
              </div>
            </div>


            <div class="example-box-wrapper">
              <div class="profile-box content-box" style="text-align: center;">

              </div>

              <div class="content-box-header clearfix bg-green" style=" border-top-left-radius: 0px;border-top-right-radius: 0px; border-bottom-left-radius: 3px;border-bottom-right-radius: 3px;font-size: 12px;font-weight: bold; padding: 10px !important;">
                
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
  </div>
      
