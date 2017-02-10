<div class="subjects view">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard">
					<span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active"><?php echo $this->params['url']['doc']; ?></li>
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
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;Back to Document Index'), array('controller' => 'lasdocs', 'action' => 'index'), array('escape' => false)); ?> </li>
                                
                            </ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
				
				<div class="actions" id="DescriptionBox">
					<div class="panel panel-default">
						
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li class="box-description no-border">
                                   
                                   <h4><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;&nbsp;<?php echo $this->params['url']['doc'];?></h4>
                                   
                                   <ul class="nav nav-pills nav-stacked">
                                   		<hr/>
                                   		<?php $countFolder = 0;?>
                                   		<?php foreach($folderName as $fn):?>
		                                   	<?php 
		                                   	$countFolder += 1;
		                                   	$count = 0;

		                                   	?>
		                                   	<li>
		                                   		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;&nbsp;&nbsp;
		                                   		<b>
		                                   			<?php echo $fn['Docfoldertree']['foldername'];?>
		                                   		</b>
		                                   	</li>
			                                <hr/>
		                                   	<li style="padding-left:30px;">
	                                   			<ul style="font-size:14px;">
	                                   				<?php foreach($Laspagelink_db as $df):?>
	                                   				
	                                   				<?php if($df['Laspagelink']['lasfolder_id'] == $fn['Docfoldertree']['id'] && empty($df['Laspagelink']['subtopic']) && !empty($df['Laspagelink']['title'])):?>
	                                   				<?php $count += 1;?>
	                                   				<li><span class="glyphicon glyphicon-link"></span> <?php echo $df['Laspagelink']['title'];?>
	                                   				
	                                   				</li>
	                                   				<hr/>
	                                   				<ul>
	                                   					<?php foreach($Laspagelink_db2 as $df2):?>
	                                   					<?php if($df2['Laspagelink']['lasfolder_id'] == $fn['Docfoldertree']['id'] && !empty($df2['Laspagelink']['subtopic']) && $df2['Laspagelink']['subtopic_id'] == $df['Laspagelink']['id']):?>
	                                   					
	                                   					<li>
	                                   					<?php if($vcite_permit['vcite_permissions']['isEnabled'] == 1 || strpos($student_data['Student']['allowed_subjects'], $df2['Laspagelink']['id'])):?>
	                                   						<a href="<?php echo $this->Html->url(array(
		                                   						'controller' => 'laspagelinks','action' => 'read/'.$df2['Laspagelink']['id']
		                                   					));?>"><span class="glyphicon glyphicon-book"></span> <?php echo $df2['Laspagelink']['subtopic'];?></a>
	                                   					<?php else:?>
		                                   					<p><span class="glyphicon glyphicon-book"></span> <?php echo $df2['Laspagelink']['subtopic'];?></p>
	                                   					<?php endif;?>
	                                   					</li>
	                                   					<?php endif;?>
	                                   					<?php endforeach;?>
	                                   					
	                                   				</ul>
	                                   				<hr/>
	                                   				<?php endif;?>
	                                   				<?php endforeach;?>
	                                   				
	                                   			</ul>
	                                   		</li>
	                                   		
                                   		<?php endforeach;?>
                                   </ul>
								</li>
							</ul>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>

		</div><!-- end col md 9 -->

	</div>
</div>
<?php $totalFolders = 0;?>
	<?php foreach($folderName as $fn):?>
	<?php $totalFolders += 1;?>
<?php echo $this->Form->create('Docfile', array('role' => 'form','action'=>'add')); ?>
	
	<!-- modals here -->
	<div id="adddocfile<?php echo $totalFolders;?>" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Add new file:</h4>
	</div>
	<div class="modal-body">

	        <div class="form-group">
	            <?php echo $this->Form->input('document_id',array('type' => 'hidden','value' => $this->params['url']['docid'],'class'=>'form-control')); ?>
	            <?php echo $this->Form->input('foldertree_id',array('type' => 'hidden','value' => $fn['Docfoldertree']['id'],'class'=>'form-control')); ?>
	            <?php echo $this->Form->input('foldertree',array('type' => 'hidden','value' => $this->params['url']['doc'],'class'=>'form-control')); ?>
	            <?php echo $this->Form->input('link',array('type' => 'hidden','value' => '/'.$this->params['url']['doc'].'/'.$fn['Docfoldertree']['foldername'].'/','class'=>'form-control')); ?>
	            <?php echo $this->Form->input('file',array('placeholder' => 'sample.pdf','class'=>'form-control','style'=>'font-style:italic;')); ?>
	            <?php echo $this->Form->input('title',array('placeholder' => 'Sample Title','class'=>'form-control','style'=>'font-style:italic;')); ?>
	        </div>
	      

	</div>
	<div class="modal-footer">


	    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

	    <input type="submit" value="Create" class="btn btn-default" name="sub-btn"/>


	</div>
	</div>

	</div>
	</div>
	<!-- modals end here -->
	
<?php echo $this->Form->end() ;?>

<?php endforeach;?>
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
