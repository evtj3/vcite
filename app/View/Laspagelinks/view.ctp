
<div class="subjects view">
	<!--
	<button data-toggle="modal" data-target="#shareLAS" type="button" class="share_subject_button btn btn-default">
		<span class="glyphicon glyphicon-link"></span> Share this subject
	</button>
	-->
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard">
					<span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active"><?php echo $laspagelinks_db['Laspagelink']['subtopic'];?></li>
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
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;Back to '.$lasdoc_db['Lasdoc']['title']), array('controller' => 'lasdocs', 'action' => 'view?doc='.$lasdoc_db['Lasdoc']['title'].'&docid='.$lasdoc_db['Lasdoc']['id']), array('escape' => false)); ?> </li>
                            </ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
				<?php echo $this->Form->create('Laspagelink', array('role' => 'form','action'=>'addnewlasfile')); ?>
				<input type="hidden" name="id" value="<?php echo $laspagelinks_db['Laspagelink']['id'];?>"/>
				<div class="actions" id="DescriptionBox">
					<div class="panel panel-default">
						
						<div class="panel-body">
							<br style="clear:both;"/>
							<div id="content-title">
								<br style="clear:both;"/>
								<p><?php echo 'Welcome to '.$laspagelinks_db['Laspagelink']['subtopic'];?></p>
								<p style="font-size:12px;">Subjects for this technology</p>
							</div>
							<br style="clear:both;"/>
							
							<div class="contentlas" id="content-subjcode">

								<p class="content-sections">Subject Code</p>
								<p><input type="text" class="form-control" name="subjcode" placeholder="Write a subject code here" value="<?php echo $laspagelinks_db['Laspagelink']['subject_code'];?>"/></p>
								
							</div>
							<div class="contentlas" id="content-duration">

								<p class="content-sections"> Duration </p>
								<p><input type="text" class="form-control" name="duration" placeholder="Write a duration here" value="<?php echo $laspagelinks_db['Laspagelink']['duration'];?>"/></p>
								
							</div>
							<div class="contentlas" id="content-subjdes">

								<p class="content-sections">Subject Description</p>
								<p><textarea class="form-control" name="subjdes" placeholder="Write a description here"><?php echo $laspagelinks_db['Laspagelink']['subject_description'];?></textarea></p>
								
							</div>
							<br style="clear:both;" />
							<p style="text-align:right; padding:5px; margin-right:20px;"><input type="submit" class="btn btn-default" value="Update" name="submit_subjdes"/> </p>
							<div class="contentlas" id="content-las">

								<p class="content-sections"> Units of Instructions / LAS </p>
								<p>Create New LAS: | <a href="#" data-toggle="modal" data-target="#addLAS"><span class="glyphicon glyphicon-plus"></span></a></p>
								<hr/>
								<?php foreach($Docfile_db as $dfdb):?>
								<p><a href="<?php echo $dfdb['Docfile']['link'];?>"><?php echo $dfdb['Docfile']['title'];?></a> | <a href="<?php echo $this->Html->url(array('controller' => 'docfiles','action' => 'delete/'.$dfdb['Docfile']['id']));?>" title="remove"><span class="glyphicon glyphicon-remove"></span></a></p>
								<?php endforeach;?>
							</div>
							
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>
		<?php echo $this->Form->end();?>
		</div><!-- end col md 9 -->

	</div>
</div>

<?php echo $this->Form->create('Laspagelinks', array('action' => 'share_document_by_section/'.$id,'role' => 'form')); ?>
<!-- Modal -->
<div class="modal fade" id="shareLAS" tabindex="-1" role="dialog" aria-labelledby="sublinksLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sublinksLabel">Share this subject to:</h4>
      </div>
     
      <div class="modal-body">
        <div class="form-group">
        		<label>Lists of Sections</label>
        		<hr></hr>
        		<?php $count = 0;?>
        		<?php foreach($data_arr as $da):?>
        			<div class="section_box">
        				<input type="checkbox" name="sections_checklist<?php echo $count;?>" value="<?php echo $da['advisory_class'];?>"/>
        				<hr/>
	        			<div data-toggle="modal" data-target="#<?php echo $da['advisory_class'];?>" class="sections"><?php echo $da['advisory_class'];?>
						</div>
					</div>
					<?php $count++;?>
					<input type="hidden" name="advisory_class" value="<?php echo $da['advisory_class'];?>" />
	    			<input type="hidden" name="total_students_per_section" value="<?php echo count($data_arr);?>"/>
        		<?php endforeach;?>

        		<br style="clear:both"/>
        		
	    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" value="Share" class="btn btn-default"/>
      </div>
  	
  		

    </div>
  </div>
</div>
<!-- end Modal -->
<?php echo $this->Form->end() ;?>
<?php echo $this->Form->create('Laspagelinks', array('action' => 'share_document_by_student/'.$id,'role' => 'form')); ?>
<?php foreach($data_arr as $da):?>
<!-- Modal -->
<div class="modal fade" id="<?php echo $da['advisory_class'];?>" tabindex="-1" role="dialog" aria-labelledby="sublinksLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sublinksLabel">Share this subject to:</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
        		<label>Lists of Students</label>
        		<p><?php echo 'Section '.$da['advisory_class'];?></p>
        		<hr></hr>

 		<?php 
				$url2 = $server.'/cis/students/show_students/'.$da['section_id'].'/'.$da['batch_id'];
				 	
			 	$dataStudents = loadFile($url2);
			 	$parseJson  = json_decode($dataStudents,true);
			 	//pr($parseJson);
			 	$count2 = 0;
    		?>
    		<?php foreach($parseJson as $pst):?>
    			<div class="students_box">
    				<input type="checkbox" name="students_checklist<?php echo $count2;?>" value="<?php echo $pst['Student']['student_id'];?>"/>
    				<hr></hr>
    				<p><?php echo $pst['Student']['student_id'];?></p>
    				<p><?php echo $pst['Student']['pd_fname'].' '.$pst['Student']['pd_lname'].' '.$pst['Student']['pd_ext'];?></p>
    				
    			</div>
    			<?php $count2++;?>
	    	<?php endforeach;?>
	    		<input type="hidden" name="advisory_class" value="<?php echo $da['advisory_class'];?>" />
	    		<input type="hidden" name="total_students_per_section" value="<?php echo count($parseJson);?>"/>
        		<br style="clear:both;"/>
	    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" value="Share" class="btn btn-default"	/>
      </div>

    </div>
  </div>
</div>
<!-- end Modal -->
<?php endforeach;?>
<?php echo $this->Form->end() ;?>
<?php echo $this->Form->create('Docfile', array('role' => 'form','action'=>'add')); ?>

<!-- Modal -->
<div class="modal fade" id="addLAS" tabindex="-1" role="dialog" aria-labelledby="sublinksLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sublinksLabel">Add new LAS</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
        	<label >All files are uploaded in <a target="_blank" href="/vcite/app/webroot/js/ckeditor/plugins/fileman/index.html?CKEditor=TopicContent&CKEditorFuncNum=1&langCode=en" >File Manager</a></label>
	            <?php echo $this->Form->input('lasdoc_id',array('type' => 'hidden','value' => $laspagelinks_db['Laspagelink']['lasdoc_id'],'class'=>'form-control')); ?>
	            <?php echo $this->Form->input('foldertree_id',array('type' => 'hidden','value' => $laspagelinks_db['Laspagelink']['lasfolder_id'],'class'=>'form-control')); ?>
	            <?php echo $this->Form->input('laspagelink_id',array('type' => 'hidden','value' => $laspagelinks_db['Laspagelink']['id'],'class'=>'form-control')); ?>
	            
	            <?php echo $this->Form->input('link',array('type' => 'hidden','value' => '/'.$laspagelinks_db['Laspagelink']['folder_subject'].'/','class'=>'form-control')); ?>
	            <?php echo $this->Form->input('file or Link',array('placeholder' => 'pdf file or subject link','class'=>'form-control','style'=>'font-style:italic;')); ?>
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
<!-- end Modal -->
<?php echo $this->Form->end() ;?>
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
