<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/chosen/chosen', '../assets/widgets/chosen/chosen-demo','../assets/widgets/parsley/parsley','../assets/widgets/datepicker/datepicker','../assets/widgets/datepicker-ui/datepicker','../assets/angular/angular.min','../assets/angular/timesheet')) ?>

  <div ng-app="TimesheetApp" ng-controller="TimesheetCtrl" class="panel">
    <div class="panel-body content-box">
      <h3 class="title-hero bg-primary">Time Sheet</h3>
      <div class="example-box-wrapper">
        <div class="panel" >
          <div class="panel-body">

            <h3 class="title-hero"> Time Sheet Add
              
              <div class="float-right" >
              <button ng-click="add_new_row();" class="btn btn-alt btn-hover btn-primary "  data-toggle="modal" data-target=".bs-example-modal-lg">
                <span>Add Row</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div>
              </button>
              <button ng-click="save_timeSheet(TimeSheetData,0);" class="btn btn-alt btn-hover btn-primary "  data-toggle="modal" data-target=".bs-example-modal-lg">
                <span>Save</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div>
              </button>
               <button ng-click="save_timeSheet(TimeSheetData,1);"  class="btn btn-alt btn-hover btn-primary "  data-toggle="modal" data-target=".bs-example-modal-lg">
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
                          <option ng-click="TimeSheetData.days[key]['task_name'] = task.task_name" ng-selected="task.id == TimeSheetData.days[key]['task']" ng-repeat="task in TimeSheetData.tasks" 
                          value="{{task.id}}"> {{task.task_name}}</option>
                        </select>

                        <i class="glyph-icon icon-caret-down"></i>
                      </div> 
                    </div>

                    <div ng-repeat="(datehrs,hrs) in days.days_hrs" class="col-md-1">
                      <div ng-init="isDisabled[key][datehrs] = false" class="input-group">
                        <input ng-disabled="isDisabled[key][datehrs]" ng-model="TimeSheetData.days[key]['days_hrs'][datehrs]" class="form-control" type="text">
                         <span class="input-group-addon bg-blue">
                          <i ng-click="isDisabled[key][datehrs] = false" style="cursor: pointer;" class="glyph-icon icon-pencil"></i>
                        </span>
                      </div> 
                    </div>

                    <div class="col-md-1" style="text-align: center;"> 
                      <span><i style="cursor: pointer;" ng-click="remove_row(key);" title="Remove" class="glyph-icon icon-close"></i></span> 
                    </div>

                    </div>
                  </a> 

          
                 
                 
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
      
