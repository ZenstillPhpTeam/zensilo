<?php ?>
<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/chosen/chosen', '../assets/widgets/chosen/chosen-demo','../assets/widgets/parsley/parsley','../assets/widgets/datepicker/datepicker','../assets/widgets/datepicker-ui/datepicker','../assets/widgets/daterangepicker/moment','../assets/widgets/calendar/calendar','../assets/widgets/calendar/calendar-demo','../assets/piechart/canvasjs.min')) ?>
<style>
.pieID,.pieID1 {
  display: inline-block;
  vertical-align: top;
}
.pie,.pie1 {
  height: 200px;
  width: 200px;
  position: relative;
  margin: 0 30px 30px 0;
}
.pie::before,.pie1::before {
  content: "";
  display: block;
  position: absolute;
  z-index: 1;
  width: 100px;
  height: 100px;
  background: #EEE;
  border-radius: 50%;
  top: 50px;
  left: 50px;
}
.pie::after,.pie1::after {
  content: "";
  display: block;
  width: 120px;
  height: 2px;
  background: rgba(0,0,0,0.1);
  border-radius: 50%;
  box-shadow: 0 0 3px 4px rgba(0,0,0,0.1);
  margin: 220px auto;
  
}
.slice {
  position: absolute;
  width: 200px;
  height: 200px;
  clip: rect(0px, 200px, 200px, 100px);
  animation: bake-pie 1s;
}
.slice span {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  background-color: black;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  clip: rect(0px, 200px, 200px, 100px);
}
.legend,.legend1 {
  list-style-type: none;
  padding: 0;
  margin: 0;
  background: #FFF;
  padding: 15px;
  font-size: 13px;
  box-shadow: 1px 1px 0 #DDD,
              2px 2px 0 #BBB;
}
.legend li,.legend1 li {
  width: 110px;
  height: 1.25em;
  margin-bottom: 0.7em;
  padding-left: 0.5em;
  border-left: 1.25em solid black;
}
.legend em,.legend1 em {
  font-style: normal;
}
.legend span,.legend1 span {
  float: right;
}
footer {
  position: fixed;
  bottom: 0;
  right: 0;
  font-size: 13px;
  background: #DDD;
  padding: 5px 10px;
  margin: 5px;
}
</style>
<div id="page-title">
  <h2>Dashboard</h2>
  <p></p>
</div>
<div class="row">
  <div class="col-md-6">
  <div class="content-box">
  <h3 class="content-box-header content-box-header-alt bg-white"><span class="icon-separator"><i class="glyph-icon icon-linecons-megaphone"></i></span> <span class="header-wrapper">Recent Expenses <small></small></span> 
  </h3>
  <div class="content-box-wrapper">
  <section>
  <div class="pieID pie"></div>
    <ul class="pieID legend">
    <?php foreach($expense as $expense1) { ?>
      <li>
        <em><?= $expense1['legendText'] ?></em>
        <span><?= $expense1['y'] ?></span>
      </li>
      <?php } ?>          
    </ul>
  </section>
  </div>
  </div>

  <div class="content-box">
  <h3 class="content-box-header content-box-header-alt bg-white"><span class="icon-separator"><i class="glyph-icon icon-linecons-megaphone"></i></span><span class="header-wrapper">Recent Leave Requests  <small></small></span> 
  </h3>
  <div class="content-box-wrapper">
<section>
  <div class="pieID1 pie1"></div>
    <ul class="pieID1 legend1">
    <?php foreach($leaves as $leave) { ?>
      <li>
        <em><?= $leave['legendText'] ?></em>
        <span><?= $leave['y'] ?></span>
      </li>
      <?php } ?>          
    </ul>
  </section>  
  </div>
  </div>


    <div class="content-box">
      <h3 class="content-box-header content-box-header-alt bg-white">
      <span class="icon-separator"><i class="glyph-icon icon-linecons-megaphone"></i></span> 
      <span class="header-wrapper">Recent Projects </span> 
      <span class="header-buttons"><a href="<?= $this->Url->build(array("action" => "projects"));?>" class="btn btn-sm btn-primary" title="">View All</a></span>
      </h3>
      <div class="content-box-wrapper">     	
      	<div id="chartContainer" style="height: 300px; width: 100%;"></div>
      </div>
    </div>

    <div class="content-box">
      <h3 class="content-box-header content-box-header-alt bg-white">
      <span class="icon-separator"><i class="glyph-icon icon-linecons-megaphone"></i></span> 
      <span class="header-wrapper">Recent Tasks </span> 
      <span class="header-buttons"><a href="<?= $this->Url->build(array("action" => "projects"));?>" class="btn btn-sm btn-primary" title="">View All</a></span>
      </h3>
      <div class="content-box-wrapper"> sfgdfgdfg</div>
    </div>
  
  </div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-6">
        <div class="tile-box tile-box-alt mrg20B bg-green">
          <div class="tile-header">Users</div>
          <div class="tile-content-wrapper"><i class="glyph-icon icon-dashboard"></i>
            <div class="tile-content"> <?= $users ?></div>
            <small><i class="glyph-icon icon-caret-up"></i> +7,6% new Users</small></div>
          <a href="<?= $this->Url->build(array("action" => "users"));?>" class="tile-footer tooltip-button" data-placement="bottom" title="" data-original-title="Users!">view details <i class="glyph-icon icon-arrow-right"></i></a></div>
      </div>
      <div class="col-md-6">
        <div class="tile-box tile-box-alt mrg20B bg-red">
          <div class="tile-header">Projects</div>
          <div class="tile-content-wrapper"><i class="glyph-icon icon-camera"></i>
            <div class="tile-content"><span></span> <?= $projects ?></div>
            <small><i class="glyph-icon icon-caret-up"></i> +% tasks</small></div>
          <a href="<?= $this->Url->build(array("action" => "projects"));?>" class="tile-footer tooltip-button" data-placement="bottom" title="" data-original-title="Projects!">view details <i class="glyph-icon icon-arrow-right"></i></a></div>
      </div>
      <div class="col-md-6">
        <div class="tile-box tile-box-alt mrg20B bg-orange">
          <div class="tile-header">Clients</div>
          <div class="tile-content-wrapper"><i class="glyph-icon icon-tag"></i>
            <div class="tile-content"><span></span> <?= $clients ?></div>
            <small><i class="glyph-icon icon-caret-up"></i> +% new projects </small></div>
          <a href="<?= $this->Url->build(array("action" => "clients"));?>" class="tile-footer tooltip-button" data-placement="bottom" title="" data-original-title="Clients!">view details <i class="glyph-icon icon-arrow-right"></i></a></div>
      </div>
      <div class="col-md-6">
        <div class="tile-box tile-box-alt mrg20B bg-blue-alt">
          <div class="tile-header">Monthly earnings</div>
          <div class="tile-content-wrapper"><i class="glyph-icon icon-camera"></i>
            <div class="tile-content"><span>$</span> 1,212</div>
            <small><i class="glyph-icon icon-caret-up"></i> +2,6% </small></div>
          <a href="#" class="tile-footer tooltip-button" data-placement="bottom" title="" data-original-title="!">view details <i class="glyph-icon icon-arrow-right"></i></a></div>
      </div>
    </div>
    <div class="panel">
      <div class="panel-body">
        <div id="calendar-example-1" class="col-md-10 center-margin fc fc-ltr"></div>
      </div>
    </div>
    
  </div>
</div>
<script type="text/javascript">
window.onload = function () {
  var chart = new CanvasJS.Chart("chartContainer",
  {
    title:{
      text: "Expense Report"
    },
        animationEnabled: true,
    legend:{
      verticalAlign: "center",
      horizontalAlign: "left",
      fontSize: 20,
      fontFamily: "Helvetica"        
    },
    theme: "theme2",
    data: [
    {        
      type: "pie",       
      indexLabelFontFamily: "Garamond",       
      indexLabelFontSize: 20,
      indexLabel: "{label} {y}",
      startAngle:-20,      
      showInLegend: true,
      toolTipContent:"{legendText} {y}",
      dataPoints: <?php echo json_encode($expense); ?>
      
    }
    ]
  });
  chart.render();
}


function sliceSize(dataNum, dataTotal) {
  return (dataNum / dataTotal) * 360;
}
function addSlice(sliceSize, pieElement, offset, sliceID, color) {
  $(pieElement).append("<div class='slice "+sliceID+"'><span></span></div>");
  var offset = offset - 1;
  var sizeRotation = -179 + sliceSize;
  $("."+sliceID).css({
    "transform": "rotate("+offset+"deg) translate3d(0,0,0)"
  });
  $("."+sliceID+" span").css({
    "transform"       : "rotate("+sizeRotation+"deg) translate3d(0,0,0)",
    "background-color": color
  });
}
function iterateSlices(sliceSize, pieElement, offset, dataCount, sliceCount, color) {
  var sliceID = "s"+dataCount+"-"+sliceCount;
  var maxSize = 179;
  if(sliceSize<=maxSize) {
    addSlice(sliceSize, pieElement, offset, sliceID, color);
  } else {
    addSlice(maxSize, pieElement, offset, sliceID, color);
    iterateSlices(sliceSize-maxSize, pieElement, offset+maxSize, dataCount, sliceCount+1, color);
  }
}
function createPie(dataElement, pieElement) {
  var listData = [];
  $(dataElement+" span").each(function() {
    listData.push(Number($(this).html()));
  });
  var listTotal = 0;
  for(var i=0; i<listData.length; i++) {
    listTotal += listData[i];
  }
  var offset = 0;
  var color = [
    "cornflowerblue", 
    "olivedrab", 
    "orange", 
    "tomato", 
    "crimson", 
    "purple", 
    "turquoise", 
    "forestgreen", 
    "navy", 
    "gray"
  ];
  for(var i=0; i<listData.length; i++) {
    var size = sliceSize(listData[i], listTotal);
    iterateSlices(size, pieElement, offset, i, 0, color[i]);
    $(dataElement+" li:nth-child("+(i+1)+")").css("border-color", color[i]);
    offset += size;
  }
}
createPie(".pieID.legend", ".pieID.pie");

createPie(".pieID1.legend1", ".pieID1.pie1");
$(document).ready(function(){
  $("#calendar-example-1").fullCalendar({
    header:{left:"prev,next today",center:"title",
    right:"month,agendaWeek,agendaDay"},defaultDate:new Date(),editable:!0,
    events:<?= json_encode($tasks_cal); ?>
  });
});
</script>