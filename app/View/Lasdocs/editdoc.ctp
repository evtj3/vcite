
<div class="subjects form">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard">
					<span class="glyphicon glyphicon-home"></span></a></li>
				<li ><a href="<?php echo $this->Html->url(array('controller' => 'lasdocs', 'action' => 'view?doc='.$this->params['url']['doc'].'&docid='.$this->params['url']['docid'])); ?>" title="Back to Index">
					<?php echo $this->params['url']['doc'];?></a></li>
				<li class="active">Edit Folders</li>
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
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;Back'), array('controller' => 'lasdocs', 'action' => 'view?doc='.$this->params['url']['doc'].'&docid='.$this->params['url']['docid']), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->
		
		<div class="col-md-9">
				<?php echo $this->Form->create('Docfoldertree', array('role' => 'form','action' => 'edit')); ?>
				<div class="form-group">
				<?php echo $this->Form->input('doc', array('value'=>$this->params['url']['doc'],'type' => 'hidden','class' => 'form-control'));?>
					<?php echo $this->Form->input('lasdoc_id', array('value'=>$this->params['url']['docid'],'type' => 'hidden','class' => 'form-control'));?>
				<?php foreach ($updateFolder as $uf):?>
					<?php echo $this->Form->input('doc_id', array('value'=>$uf['Docfoldertree']['id'],'type' => 'hidden','class' => 'form-control'));?>
					<?php echo $this->Form->input($uf['Docfoldertree']['id'], array('value'=>$uf['Docfoldertree']['id'],'type' => 'hidden','class' => 'form-control'));?>
					<?php echo $this->Form->input($uf['Docfoldertree']['foldername'], array('value' => $uf['Docfoldertree']['foldername'],'class' => 'form-control', 'placeholder' => 'Folder Name', 'requireds'));?>
				<?php endforeach;?>	
				</div>
				

				<div class="form-group">
						<?php echo $this->Form->submit(__('Update'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>
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
