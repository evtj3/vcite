<div class="subjects view">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard">
					<span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active"><?php echo 'Notifications'; ?></li>
				<li class="active"><?php echo 'Read'; ?></li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			
			
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Actions</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;Dashboard'), array('controller' => 'teachers', 'action' => 'dashboard'), array('escape' => false)); ?> </li>
                                <!--<li>
                                        <a href="#" onclick="scrollTo('DescriptionBox');"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;&nbsp;Description</a>
                                </li>
                                <li>
                                        <a href="#" onclick="scrollTo('OutlineBox');"><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;&nbsp;Outline</a>
                                </li>
                                <li>
                                        <a href="#" onclick="scrollTo('StudentBox');"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Students and Assessments</a>
                                </li>
                                
                                <li>
                                        <a href="#" onclick="scrollTo('AssessmentBox');"><span class="glyphicon glyphicon-tasks"></span>&nbsp;&nbsp;&nbsp;Assessments</a>
                                </li>
                                -->
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
			
			
			
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<p style="font-style:italic; font-size:10px;">Total Read notifications: <?php echo count($notifs_read);?></p>
			<?php foreach($notifs_read as $read):?>
				<div class="actions" id="DescriptionBox">
					<div class="panel panel-default">
						
							<div class="panel-heading">
								<?php echo 'Sender: '.$read['Notification']['sender'];?>
							</div>
							<div class="panel-body">
								<div class="subquickMenu_notif">
									<?php echo $read['Notification']['content'];?>

									<p style="font-size:10px;float:right;"><?php echo $read['Notification']['modified'];?></p>
								</div>
							</div><!-- end body -->
						
					</div><!-- end panel -->
				</div>
			
			<?php endforeach;?>
				
	</div>
</div>

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
	
	<hr><a href="#"><h8 style="padding:5px;">see all unread - <?php echo $countNotif;?></h8></a></hr>
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
		<hr><a href="#"><h8 style="padding:5px;">see all read - <?php echo $countNotifread;?></h8></a></hr>
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

<script>

var count = 1;
	$('#displayJsonHTML').click(function(){
		count += 1;
		if(count > 2)
			count = 1;

		if(count == 2){
			$('#displayJsonHTML').html('show');
			$('.SectionsData').fadeOut(500);
		}if(count == 1){
			$('#displayJsonHTML').html('hide');
			$('.SectionsData').slideToggle(500);
		}
		//$('#displayJsonHTML').html('');
	});
	$('#updatebtn').click(function(){
		$('#invitemsg').html('Please wait... Connecting to SIS database.');
	});
	function recon(){
		$('#invitemsgSt').html('Please wait... Reconnecting...');
	}



</script>
