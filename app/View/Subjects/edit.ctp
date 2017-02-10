<script type="text/javascript"
  src="http://localhost/MathJax/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>	
<?php
#echo $this->Html->css('sample');

echo $this->Html->script('ckeditor/ckeditor');
?>
<div class="subjects form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
                                <h1><?php echo __($this->Session->read('Subject.title')); ?> &raquo; Edit</h1>
			</div>
		</div>
	</div>



	<div class="row">
		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Actions</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
                                                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;Back to Subject Index'), array('controller' => 'subjects', 'action' => 'view'), array('escape' => false)); ?> </li>
                                                                <li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete'), array('action' => 'delete', $this->Form->value('Subject.id')), array('escape' => false), __('Are you sure you want to delete # %s?', $this->Form->value('Subject.id'))); ?></li>
                                                                 <!--<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Subjects'), array('action' => 'index'), array('escape' => false)); ?></li>-->
                                                               <!-- <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Teachers'), array('controller' => 'teachers', 'action' => 'index'), array('escape' => false)); ?> </li>-->
                                                                <!-- <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Teacher'), array('controller' => 'teachers', 'action' => 'add'), array('escape' => false)); ?> </li>-->
                                                                <!--<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Topics'), array('controller' => 'topics', 'action' => 'index'), array('escape' => false)); ?> </li>-->
                                                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Topic'), array('controller' => 'topics', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Subject', array('role' => 'form', 'action' => 'edit/'.$id)); ?>

				<div class="form-group-id">
					<?php echo $this->Form->input('id', array('class' => 'form-control', 'placeholder' => 'Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => 'Title','value' => $teachers['Subject']['title']));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('description', array('class' => 'form-control', 'placeholder' => 'Description','value' => $teachers['Subject']['description']));?>
				</div>
				<!--
				<div class="form-group">
					<?php echo $this->Form->input('cover_img', array('class' => 'form-control', 'placeholder' => 'Cover Img'));?>
				</div>
				-->
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
<script> 
/*var roxyFileman = '/nayklase/app/webroot/js/ckeditor/plugins/fileman/index.html'; 
$(function(){
  
   CKEDITOR.replace( 'TopicContent',{filebrowserBrowseUrl:roxyFileman, 
	                                 filebrowserUploadUrl:roxyFileman,
	                                 filebrowserImageBrowseUrl:roxyFileman+'?type=image',
	                                 filebrowserImageUploadUrl:null,
	                                 filebrowserImageBrowseLinkUrl: false

	                                }); 
});*/
var roxyFileman = '/nayklase/app/webroot/js/ckeditor/plugins/fileman/index.html'; 
$(function(){
   CKEDITOR.replace( 'TopicContent',{filebrowserBrowseUrl:roxyFileman, 
	                                 filebrowserUploadUrl:roxyFileman,
	                                 filebrowserImageBrowseUrl:roxyFileman+'?type=image',
	                                 filebrowserImageUploadUrl:null,
	                                 filebrowserImageBrowseLinkUrl: false
	                                }); 

});

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