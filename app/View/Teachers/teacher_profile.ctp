
<div class="teachers index">

	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li class="active"><a href="<?php echo $this->Html->url(array('controller'=>'teachers','action'=>'dashboard'));?>"><span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Welcome <?php echo $this->Session->read('User.wholename');?>!</li>
			</ol>
		</div><!-- end col md 12 -->
	</div><!-- end row -->



	<div class="row">

			<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Teacher's ID 
						<?php if(!$isMobile):?>
						<!--<a style="color:#fff;" href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'edit',$this->Session->read('User.id')));?>"><span style="float:right;" class="glyphicon glyphicon-pencil"></span></a>-->
						<?php endif;?>
					</div>
						<div class="panel-body">
							<div class="profile">
								<!--<img src="<?php echo $this->Html->url('/app/webroot/img/profile_pic/teachers/'.$this->Session->read('User.id').'.jpg'); ?>" />-->
								<div>Name: <?php echo $this->Session->read('User.wholename'); ?></div>
								<!--<div>ID: 336</div>-->
							</div>
						</div><!-- end body -->
				</div><!-- end panel -->
				<?php if(!$isMobile):?>
				<div class="panel panel-default">
					<div class="panel-heading">Actions</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Subject'), array('controller' => 'subjects', 'action' => 'add'), array('escape' => false)); ?> </li>
								
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->

				<?php endif;?>
				<div class="panel panel-default">
					<div class="panel-heading">Activity Logs <font style="float:right;font-size:12px; color:#fff; "><?php echo '<span class="glyphicon glyphicon-user" style="padding:2px 4px 2px 4px;
											border-radius: 10px 10px 10px 10px;
											-moz-border-radius: 10px 10px 10px 10px;
											-webkit-border-radius: 10px 10px 10px 10px;
										"></span> '.count($countLogDistinctUser).' <span class="glyphicon glyphicon-briefcase" style="padding:2px 4px 2px 4px;
											border-radius: 10px 10px 10px 10px;
											-moz-border-radius: 10px 10px 10px 10px;
											-webkit-border-radius: 10px 10px 10px 10px;
										"></span>'.$countlogs;?> </font></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked" style="font-style:italic ;border:solid 1px #EBEBEB;">
								<li>
									<p id="actTimelogs" style="text-align:right; font-style:italic; font-size:10px; padding:5px;">updating...</p>
								</li>
								<a href="<?php echo $this->Html->url(array('controller' => 'logs','action' => 'index'));?>">
									<li style="text-align:right; padding:5px; font-size:12px;">
									see all
									</li>
								</a>
								<?php foreach($logs2 as $l):?>
									
									<li style="font-weight:bold; font-size:13px; padding:5px;"><?php echo str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($l['Log']['name'])))).' <font style="font-weight:normal; font-size:10px; font-style:italic; float:right;">'.$l['Log']['created'].'</font>';?></li>
									<li style="color:red; border:solid 1px #EBEBEB; text-align:center; font-size:12px; font-style:italic;"><?php echo $l['Log']['activity'];?></li>
									
								<?php endforeach;?>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->
		
		<div class="col-md-9">
			<?php if(empty($subjects)):?>
				<p style="text-align: center; font-style:Italic; font-size:30px; padding:10px; color:#256D7D; ">No Subject shown yet.</p>
			<?php endif;?>
			<?php foreach($subjects as $subject): ?>
				<div class="actions">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo $subject['Subject']['title']; ?>
							

							<?php if(!$isMobile):?>
							<div id="dropmenu" class="btn-group" style="float: right; top: -6px; right: -10px;">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								
								<ul class="dropdown-menu pull-right" role="menu">
									<li><a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'edit', $subject['Subject']['id'])); ?>" style="color: #12AD2B;"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edit</a></li>
									<li><a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'remove', $subject['Subject']['id'])); ?>" style="color: #FF6141;"><span class="glyphicon glyphicon-trash"></span>&nbsp;Remove</a></li>
									
								</ul>
								
							</div>
							<?php endif;?>
							<span class="date_created"><?php echo $subject['Subject']['created']; ?></span>
						</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li class="box-description">
									<span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;
									<?php echo $subject['Subject']['description']; ?>
									<br><br>
									<div style="padding: 5px 0 0; font-size: 12px;">
										<span class="glyphicon glyphicon-user"></span> <?php echo $subject['Student']; ?> 
										
										<?php if($subject['Student'] <= 1):?>
										Student
										<?php else:?>
										Students
										<?php endif;?>

										<span class="glyphicon glyphicon-list-alt"></span> <?php echo $subject['Topic']; ?> 
										<?php if($subject['Topic'] <= 1):?>
										Topic
										<?php else:?>
										Topics
										<?php endif;?>

									</div>
									
									<a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'set_subject', $subject['Subject']['id'])); ?>" class="btn btn-default " role="button" style="float: right;">
										<span class="glyphicon glyphicon-list-alt"></span>
										Read
										
									</a>
									
									<br clear="all">
								</li>
							</ul>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>
			<?php endforeach; ?>
		</div> <!-- end col md 9 -->

	</div><!-- end row -->


</div><!-- end containing of content -->
	
	<script>
    
    
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        //display.textContent = minutes + ":" + seconds;
        display.textContent = seconds+' seconds to update logs.';
        if (--timer < 0) {
        	window.location.reload();
            timer = duration;
        }
    }, 1000);
}

window.onload = function () {
    var time = 10,
        display = document.querySelector('#actTimelogs');
    startTimer(time, display);
};
    </script>
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