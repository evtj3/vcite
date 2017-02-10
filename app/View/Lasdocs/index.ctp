<div class="subjects view">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard">
					<span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active">LAS Documents</li>
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
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;Main Page'), array('controller' => 'teachers', 'action' => 'dashboard'), array('escape' => false)); ?> </li>
                                <?php if($this->Session->read('User.group') == 'teacher'):?>
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;Add Document'), array('controller' => 'lasdocs', 'action' => 'add'), array('escape' => false)); ?> </li>
                               <?php endif;?>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->

				<div class="actions">
					<div class="panel panel-default">
						<div class="panel-heading">Contents</div>
							<div class="panel-body">
								<ul class="nav nav-pills nav-stacked">
	                            <li style="font-style:italic; padding:5px;">Total Documents shown: <?php echo count($docs);?></li>
	                            <li style="font-style:italic; padding:5px;">Total LAS PDF's: <?php echo $lasPDFfiles_data;?></li>
	                            <li style="font-style:italic; padding:5px;">Total LAS Page links: <?php echo $links;?></li>
	                            </ul>
							</div><!-- end body -->
					</div><!-- end panel -->
				</div><!-- end actions -->
			
		</div><!-- end col md 3 -->
		
		<div class="col-md-9">
				<?php foreach($docs as $d):?>
				<div class="actions">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo $d['Lasdoc']['title']; ?>
							<?php if(!$isMobile):?>
							<div id="dropmenu" class="btn-group" style="float: right; top: -6px; right: -10px;">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								
								<ul class="dropdown-menu pull-right" role="menu">
									<li><a href="<?php echo $this->Html->url(array('controller' => 'lasdocs', 'action' => 'edit', $d['Lasdoc']['id'])); ?>" style="color: #12AD2B;"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edit</a></li>
									<li><a href="<?php echo $this->Html->url(array('controller' => 'lasdocs', 'action' => 'remove', $d['Lasdoc']['id'])); ?>" style="color: #FF6141;"><span class="glyphicon glyphicon-trash"></span>&nbsp;Remove</a></li>
								</ul>
								
							</div>
							<?php endif;?>
							<span class="date_created"><?php echo $d['Lasdoc']['created']; ?></span>
						</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li class="box-description no-border">
                                   
                                   <ul class="nav nav-pills nav-stacked">
                                   		<li class="box-description">
											<span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;
											<?php echo $d['Lasdoc']['description']; ?>
											<br><br>
											<div style="padding: 5px 0 0; font-size: 12px;">
												<span class="glyphicon glyphicon-list-alt"></span> <?php 

												echo "LAS"; 
												?> 
												Documents
											</div>
											
                                   			<?php if($this->Session->read('User.group') == 'teacher'):?>
                                   			<a href="<?php echo $this->Html->url(array('controller' => 'lasdocs', 'action' => 'view?doc='.$d['Lasdoc']['title'].'&docid='.$d['Lasdoc']['id'])); ?>" class="btn btn-default " role="button" style="float: right;">
												<span class="glyphicon glyphicon-list-alt"></span>
												Open
											</a>
											<?php else:?>
											<a href="<?php echo $this->Html->url(array('controller' => 'lasdocs', 'action' => 'read?doc='.$d['Lasdoc']['title'].'&docid='.$d['Lasdoc']['id'])); ?>" class="btn btn-default " role="button" style="float: right;">
													<span class="glyphicon glyphicon-list-alt"></span>
													Open
												</a>
                                   			<?php endif;?>
                                   			
											
											<br clear="all">
                                   		</li>
                                   </ul>
								</li>
							</ul>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>
				<?php endforeach;?>
		</div><!-- end col md 9 -->
		
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
