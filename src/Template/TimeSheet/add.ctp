<?php ?>
  <div ng-controller="TimesheetCtrl" class="panel">
    <div class="panel-body content-box">
      <h3 class="title-hero bg-primary">Time Sheet</h3>
      <div class="example-box-wrapper">
        <div class="panel" >
          <div class="panel-body">

            <h3 class="title-hero">

              <span style=" margin-left: 33%;padding: 10px;" class="bs-label label-info"> 
                  {{TimeSheetData.dates[0] | date: 'd MMM yyyy'}} to {{TimeSheetData.dates[6] | date: 'd MMM yyyy'}} 
              </span>
              
              <div class="float-right" ng-if="TimeSheetData.timesheetWeekstatus == 0">
              <button ng-click="add_new_row();" class="btn btn-alt btn-hover btn-primary">
                <span>Add Row</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div>
              </button>
              <button ng-click="save_timeSheet(TimeSheetData,0);" class="btn btn-alt btn-hover btn-primary">
                <span>Save</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div>
              </button>
               <button ng-click="save_timeSheet(TimeSheetData,1);"  class="btn btn-alt btn-hover btn-primary">
                <span>Submit</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div>
              </button>
              </div>
            </h3>

            <div class="example-box-wrapper">
              <div class="profile-box content-box">
                <div class="content-box-header clearfix bg-green" style="font-size: 12px;font-weight: bold; padding: 6px !important;">
                  
                  <div class="row">
                    
                    <div class="col-md-2"> <span style="margin-left:10px;">Project</span> </div>
                    <div class="col-md-2"> <span style="margin-left:10px;">Task</span> </div>

                    <div class="col-md-1" ng-repeat="day in TimeSheetData.dates"> <span>{{day | date: 'EEE d'}}</span> </div>

                    <div class="col-md-1"> <span>Remove</span> </div>

                  </div>
                  

                </div>

                <div class="list-group">

                  <a ng-repeat="(key,days) in TimeSheetData.days" style="border-bottom: 1px solid #4caf50;margin-top: 1px;" class="list-group-item">
                    <div class="row">
                      
                    <div class="col-md-2"> 
                      <div class="selector" style="width: 98px;">
                        <span style="width: 76px; -moz-user-select: none;">{{TimeSheetData.days[key]['project_name']}}</span>

                        <select ng-model="TimeSheetData.days[key]['project']" class="custom-select">
                          <option ng-click="TimeSheetData.days[key]['project_name'] = 'Select Project'" ng-selected="project.id == TimeSheetData.days[key]['project']" value="0">Select Project</option>
                          <option ng-click="TimeSheetData.days[key]['project_name'] = project.project_name" ng-selected="project.id == TimeSheetData.days[key]['project']" ng-repeat="project in TimeSheetData.projects" value="{{project.id}}">{{project.project_name}}</option>
                        </select>

                        <i class="glyph-icon icon-caret-down"></i>
                      </div> 
                    </div>

                    <div class="col-md-2"> 
                      <div class="selector" style="width: 98px;">
                        <span style="width: 76px; -moz-user-select: none;">{{TimeSheetData.days[key]['task_name']}}</span>

                        <select ng-model="TimeSheetData.days[key]['task']" name="" class="custom-select">
                          <option ng-click="TimeSheetData.days[key]['task_name'] = 'Select Task'" ng-selected="task.id == TimeSheetData.days[key]['task']" value="0">Select Task</option>
                          <option ng-show="is_already_taken(task.id, 'task',key) && TimeSheetData.days[key]['project'] == task.project_id" ng-click="TimeSheetData.days[key]['task_name'] = task.task_name" ng-selected="task.id == TimeSheetData.days[key]['task']" ng-repeat="task in TimeSheetData.tasks" 
                          value="{{task.id}}"> {{task.task_name}}</option>
                        </select>

                        <i class="glyph-icon icon-caret-down"></i>
                      </div> 
                    </div>

                    <div ng-repeat="(datehrs,hrs) in days.days_hrs" class="col-md-1">
                      <div ng-init="isDisabled[key][datehrs] = false" class="input-group">

                        <input ng-if="TimeSheetData.timesheetWeekstatus == 1" ng-disabled="true" ng-model="TimeSheetData.days[key]['days_hrs'][datehrs]" class="form-control" type="text">

                        <input ng-if="TimeSheetData.timesheetWeekstatus == 0" ng-model="TimeSheetData.days[key]['days_hrs'][datehrs]" class="form-control" type="text">

                        <span class="input-group-addon bg-blue">
                          <i ng-click="isDisabled[key][datehrs] = false" style="cursor: pointer;" class="glyph-icon icon-pencil"></i>
                        </span>
                      </div> 
                    </div>

                    <div class="col-md-1" style="text-align: center;"> 
                      <span>
                          <i ng-if="TimeSheetData.timesheetWeekstatus == 0" style="cursor: pointer;" ng-click="remove_row(key);" title="Remove" class="glyph-icon icon-close"></i>
                          <i ng-if="TimeSheetData.timesheetWeekstatus == 1" style="cursor: pointer;" title="Remove" class="glyph-icon icon-close"></i>
                      </span> 
                    </div>

                    </div>
                  </a> 

          
                 
                 
                </div>
              </div>
            </div>


            <div class="example-box-wrapper" style="margin-top: 100px;">
              <div class="profile-box content-box" style="text-align: center;">

                <div class="btn-group dropup">
                    <button style="width: 130px;" type="button" class="btn btn-primary">{{SelectMonth}}
                      <div class="ripple-wrapper"></div>
                    </button> 
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <span class="caret"></span> 
                      <span class="sr-only">Toggle Dropdown</span>
                      <div class="ripple-wrapper"></div>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">

                      <li><a ng-click="change_timeSheet_month(month);" ng-repeat="month in TimeSheetData.moth_year"  href="javascript:;">{{month.start_date | date:'MMM yyyy'}}</a></li>
                     
                    </ul>
                </div>

                <div class="btn-group dropup">
                    <button style="width: 130px;" style="width: 130px;" type="button" class="btn btn-primary">{{SelectWeek}}
                      <div class="ripple-wrapper"></div>
                    </button> 
                    <button  type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <span class="caret"></span> 
                      <span class="sr-only">Toggle Dropdown</span>
                      <div class="ripple-wrapper"></div>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">

                      <li >
                        <a ng-click="change_timeSheet_week(weeks);" ng-repeat="weeks in TimeSheetData.week_list" href="javascript:;">
                        {{weeks.start_date | date:'EEE d'}} - {{weeks.end_date | date:'EEE d'}}</a>
                      </li>

                    </ul>
                </div>

                <div class="btn-group dropup">
                <button ng-click="change_timeSheet_range(nextTSWeekId);" class="btn btn-alt btn-hover btn-primary">
                  <span>Go</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div>
                </button>
                </div>

              </div>

              <div class="content-box-header clearfix bg-green" style=" border-top-left-radius: 0px;border-top-right-radius: 0px; border-bottom-left-radius: 3px;border-bottom-right-radius: 3px;font-size: 12px;font-weight: bold; padding: 10px !important;">
                
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
  </div>
      
<script type="text/javascript">
  $(window).load(function(){
    $("#close-sidebar").trigger("click");
  });
</script>