<!--<script type="text/javascript" src="http://latex.codecogs.com/integration/ckeditor_v4.1/ckeditor.js"></script>
InstanceEndEditable -->


<?php
#echo $this->Html->css('sample');
echo $this->Html->script('MathJax/MathJax.js?config=TeX-AMS-MML_HTMLorMML');
echo $this->Html->script('ckeditor/ckeditor');
//chdir("/opt/lampp/htdocs/nayklase/app/webroot/img/latex");

#echo $this->Html->script('tinymce/tinymce.min');
//pr($_POST);

//echo $this->Latex->texify('wh^{e^{e^{e^{e^{e_{e_e}}}}}}');
?>

<div class="teachers index">
	
	<!--
	<div class="row" >
		<div class="col-md-3" style="padding-bottom:15px;">
			<a href="#">Main Page</a> <span class="glyphicon glyphicon-chevron-right"></span>
		</div>
	</div>
-->
	<div class="row" >
		<div class="col-md-12">
			<ol class="breadcrumb">
				
				<li class="active"><?php 
				echo $this->Html->link(__('<span class="glyphicon glyphicon-home"></span>'),array('controller' => 'teachers', 'action' => 'dashboard'), array('escape' => false));
				?></li>
				<li >Edit</span></li>
			</ol>
		</div>
	</div>
		<div class="col-md-13">
			<div class="actions">
				<div class="panel panel-default">
					<div class="con_heading"></div>
					
						<div class="con_body">
								
								<div class="row" >
									
									
									
								
									<div class="col-md-12 content_con" >
									<?php echo $this->Form->create('Topic',array('controller' => 'topics','action'=>'edit/'.$id), array('role' => 'form')); ?>
										<div class="form-group">
											<?php echo $this->Form->submit(__('Save'), array('class' => 'btn btn-success')); ?>
										</div>
										<div class="form-groups">
											<?php echo $this->Form->input('id', array('class' => 'form-control', 'placeholder' => 'Id','value'=>$split_id[0]));?>
										</div>
										<div class="form-group">
											<?php echo $this->Form->input('title', array('disabled','class' => 'form-control', 'placeholder' => 'Title', 'requireds','value'=>$topic['Topic']['title']));?>
											<?php echo $this->Form->input('title', array('type' => 'hidden','class' => 'form-control', 'placeholder' => 'Title', 'requireds','value'=>$topic['Topic']['title']));?>
										</div>
										<div class="form-group">
											<?php echo $this->Form->input('content', array('class' => 'form-control ckeditor', 'placeholder' => 'Content','value' => $topic['Topic']['content']));?>
										</div>
										<div class="form-group">
											<?php echo $this->Form->submit(__('Save'), array('class' => 'btn btn-success')); ?>
										</div>

									<?php echo $this->Form->end(); ?>
									
								</div><!-- end col md 12 -->
									
								</div>
									
								
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->
		<div class="col-md-2">
		</div>
	</div>
	
</div><!-- end containing of content -->


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
var roxyFileman = '/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/index.html'; 
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