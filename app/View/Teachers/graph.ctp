<style>
.highcharts-button{
	display: none;
}
</style>
<?php if(!empty($this->data)):?>
<script type="text/javascript">
<?php 
    $count = 0;
        $totalPercentagePerSection = array();
?>
$(function () {
    // Create the chart
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Student\'s Total Progress'
        },
        subtitle: {
            text: '<p style="color:red;">Click the columns to view the students that are enrolled per section.</p>'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total Progress of Students per Section ( % )'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span> has a total progress of  <b>{point.y:.2f}%</b><br/>'
        },
        <?php 
        echo '
        series: [{
            name: "Section",
            colorByPoint: true,
            data: [
         ';
         
         foreach($stDataArr3 as $sd3){   
            
            
            echo'
                {
                    name: "'.$sd3.'",
                ';
            
            echo'
                y: '.$stDataArr6[$count].',
            ';
          
           echo'
                    drilldown: "'.$sd3.'"
                },
            ';
            $count += 1;
        }
        echo '
            ]
        }],';

        echo '
        drilldown: {
            series: [
        ';
        
        
         foreach($stDataArr3 as $sd3){   
           
        echo '
            {
                name: "'.$sd3.'",
                id: "'.$sd3.'",
                data: [
            ';
                    
                foreach($stDataArr as $stdp){
			       if($sd3 == $stdp['section']){
                    echo '
			                [
			                "'.$stdp['fname'].' '.$stdp['lname'].' '.$stdp['ext'].'",
			                '.$stdp['totalPercentage'].'
			                ],
			                
			            ';
		            }  
                  }
       		 
        echo ' ]
            },
           ';
           
       }
        echo '
            ]
        }';
        ?>
    });
});
		</script>
<?php endif;?>
<?php echo $this->Html->script('HighCharts/highcharts');?>
<?php echo $this->Html->script('HighCharts/modules/data');?>
<?php echo $this->Html->script('HighCharts/modules/drilldown');?>

<div class="teachers index">
    
    <?php echo $this->Form->create('teachers',array('action'=>'graph'));?>
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
                
				<h1><?php echo __('Statistics'); ?>
                <font style="font-style:italic; font-size:12px; color:red; padding:15px;">Reminder: Select and Update to show the graphical data.</font>
                </h1>
                <ul class="subject_handled">
                    <?php if(empty($subjectsData)):?>
                        <li><p style="font-size:14px; font-style:italic;">Sorry, You don't have a subject handled yet. Go to your <span class="glyphicon glyphicon-chevron-right"></span> 
                            <a href="<?php echo $this->Html->url(array('controller' => 'teachers','action' => 'teacher_profile'));?>">Profile</a></p></li>
                    <?php endif;?>
                    <?php foreach($subjectsData as $sdata):?>
                       
                        <li>
                            <div class="radio">
                              <label><input type="radio" name="subject" value="<?php echo $sdata['Subject']['id'];?>"><?php echo $sdata['Subject']['title'];?></label>
                            </div>
                        </li>
                        
                        
                    <?php endforeach;?>
                    <li>&nbsp;<input style="font-size:12px;" class="btn bnt-default" type="submit" name="update" value="create graph"/></li>
                </ul>

			</div>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
    <?php echo $this->Form->end();?>

    <?php if(!empty($this->data['subject'])):?>
	<div class="row">

		<div class="col-md-12">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">

                        <?php foreach($subjectsData as $sdata):?>
                            <?php
                                if(!empty($this->data['subject'])){
                                    if($sdata['Subject']['id'] == $this->data['subject'])
                                        echo '<font style="font-style:italic;">'.$sdata['Subject']['title'].'</font>';
                                }
                            ?>
                        <?php endforeach;?>

                    </div>
						<div class="panel-body">
							<div id="container" style=" margin: 0 auto"></div>
                            <ul style="list-style:none;" >
                                <li style="font-weight:bold;  float:left; padding-right:20px;">Legend:
                                </li>
                                <li style="color:#256D7D;"><strong>0.0%</strong> - no student enrolled / no progess at all</li>

                            </ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

	</div><!-- end row -->
    
    <?php else:?>
    <div class="row">

        <div class="col-md-12" style="text-align:center; color:#256D7D; font-size:30px; padding:10px;">
            <p>No Graph shown yet</p>
        </div>
    </div>
    <?php endif;?>
</div><!-- end containing of content -->

<?php if(!$isMobile):?>
<!-- notifications -->
<?php //pr($parseJson);
    
    //pr($notifs);
    $countNotif = count($notifs);
    $countNotifread = count($notifs_read);

?>

<div class="listNotifs" style="display:none; cursor:pointer;">
    <span style="float:right; color:#256D7D;" class="glyphicon glyphicon-remove"></span>
    <h4 style="color:#3DB5D0;">Notifications</h4>
    
    <hr><a href="<?php echo $this->Html->url(array('controller' => 'notifications','action' => 'unread'));?>"><h8 style="padding:5px;">see all unread - <?php echo $countNotif;?></h8></a></hr>
    <ul class="sqm">
        <?php $countNotis = 0;?>
        <?php foreach($notifs as $n):?>
        <?php $countNotis++;?>
        <?php if($countNotis <= 3):?>
        <a href="<?php echo $this->Html->url(array('controller' => 'notifications','action'=>'notifs',$n['Notification']['id']));?>"><li class="notifDes"><span class="glyphicon glyphicon-user"></span> <?php 
        $limitStr = 23;
        $strContent = $n['Notification']['sender'];
        $list = '';
        
        $list = substr($strContent,0,$limitStr);
        if(strlen($n['Notification']['sender']) <= $limitStr){
        echo $list;}
        else{
        echo $list.'...';}
        ?>
        <span style="font-size:18px; float:right;"class="glyphicon glyphicon-question-sign"></span></li>
        </a>
        <?php endif;?>
        <?php endforeach;?>
        <hr><a href="<?php echo $this->Html->url(array('controller' => 'notifications','action' => 'read'));?>"><h8 style="padding:5px;">see all read - <?php echo $countNotifread;?></h8></a></hr>
        <?php $countNotisread = 0;?>
        <?php foreach($notifs_read as $n):?>
        <?php $countNotis++;?>
        <?php if($countNotisread <= 3):?>
        <a href="<?php echo $this->Html->url(array('controller' => 'notifications','action'=>'notifs',$n['Notification']['id']));?>"><li class="notifDes notifDesRead"><span class="glyphicon glyphicon-user"></span> 
            <?php $limitStr = 23;
        $strContent = $n['Notification']['sender'];
        $list = '';
        
        $list = substr($strContent,0,$limitStr);
        if(strlen($n['Notification']['sender']) <= $limitStr){
        echo $list;}
        else{
        echo $list.'...';}
        ?>
            <span style="font-size:18px; float:right;"class="glyphicon glyphicon-ok-circle"></span></li>
        </a>
        <?php endif;?>
        <?php endforeach;?>
    </ul>
</div>

<div id="quickMenu">
  
  <ul>
    <a href="#" id="privateMsg"><li>
      <span class="glyphicon glyphicon-comment"></span>
        <font class="qmnotif-count">0</font>
    </li></a>
     <a href="#" id="notif">
        <?php if($countNotif != 0):?>
        <li style="background-color:#3DB5D0;">
        <?php else:?>

        <li style="">
        <?php endif;?>
        
      <span class="glyphicon glyphicon-globe"></span>
        <font class="qmnotif-count"><?php echo $countNotif;?></font>
    </li></a>
  </ul>

</div>
<script>
    $('#notif').click(function(){
        $('.listNotifs').fadeIn(500);
    });
    $('.listNotifs').click(function(){
        $('.listNotifs').fadeOut(500);
    });

</script>
<!-- notifications -->
<?php endif;?>