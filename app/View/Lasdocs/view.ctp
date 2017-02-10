
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
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;Add Folder'), array('controller' => 'lasdocs', 'action' => 'adddoc?doc='.$this->params['url']['doc'].'&docid='.$this->params['url']['docid']), array('escape' => false)); ?> </li>
                                <?php if(count($folderName) != 0):?>
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Folder'), array('controller' => 'lasdocs', 'action' => 'editdoc?doc='.$this->params['url']['doc'].'&docid='.$this->params['url']['docid']), array('escape' => false)); ?> </li>
                                <?php endif;?>
                                <?php if(count($folderName) != 0):?>
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-remove"></span>&nbsp&nbsp;Remove Folder'), array('controller' => 'lasdocs', 'action' => 'deletedoc?doc='.$this->params['url']['doc'].'&docid='.$this->params['url']['docid']), array('escape' => false)); ?> </li>
                            	<?php endif;?>
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
                                   <?php //pr($lasdocsfiles);?>
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
		                                   			<?php echo $fn['Docfoldertree']['foldername'];?> <a href="#" data-toggle="modal" data-target="#adddocfile<?php echo $countFolder;?>" title="add files"><span class="glyphicon glyphicon-plus"></span></a>
		                                   		</b>
		                                   	</li>
			                                <hr/>
		                                   	<li style="padding-left:30px;">
	                                   			<ul style="font-size:14px;">
	                                   				<?php foreach($Laspagelink_db as $df):?>
	                                   				<?php //pr($df);?>
	                                   				<?php if($df['Laspagelink']['lasfolder_id'] == $fn['Docfoldertree']['id'] && empty($df['Laspagelink']['subtopic']) && !empty($df['Laspagelink']['title'])):?>
	                                   				<?php $count += 1;?>
	                                   				<li><span class="glyphicon glyphicon-link"></span> <?php echo $df['Laspagelink']['title'];?> | <a href="#" title="add" data-toggle="modal" data-target="#sublinks<?php echo $df['Laspagelink']['id'];?>"><span class="glyphicon glyphicon-plus"></span></a> | <a href="<?php echo $this->Html->url(array('controller' => 'laspagelinks','action' => 'delete/'.$df['Laspagelink']['id']));?>" title="remove"><span class="glyphicon glyphicon-remove"></span></a>
	                                   				
	                                   				</li>
	                                   				<hr/>
	                                   				<ul>
	                                   					<?php foreach($Laspagelink_db2 as $df2):?>
	                                   					<?php if($df2['Laspagelink']['lasfolder_id'] == $fn['Docfoldertree']['id'] && !empty($df2['Laspagelink']['subtopic']) && $df2['Laspagelink']['subtopic_id'] == $df['Laspagelink']['id']):?>
	                                   					<li>
	                                   						
	                                   					<a href="<?php echo $this->Html->url(array(
	                                   						'controller' => 'laspagelinks','action' => 'view/'.$df2['Laspagelink']['id']
	                                   					));?>"><span class="glyphicon glyphicon-book"></span> <?php echo $df2['Laspagelink']['subtopic'];?></a> | <a href="<?php echo $this->Html->url(array('controller' => 'laspagelinks','action' => 'delete/'.$df2['Laspagelink']['id']));?>" title="remove"><span class="glyphicon glyphicon-remove"></span></a>

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

<?php echo $this->Form->create('Laspagelink', array('role' => 'form','action'=>'addnewsubtopic')); ?>
	
	<!-- modals here -->
	<div id="adddocfile<?php echo $totalFolders;?>" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Add new Sub Topic:</h4>
	</div>
	<div class="modal-body">

	        <div class="form-group">
	            <?php echo $this->Form->input('lasdoc_id',array('type' => 'hidden','value' => $this->params['url']['docid'],'class'=>'form-control')); ?>
	            <?php echo $this->Form->input('lasfolder_id',array('type' => 'hidden','value' => $fn['Docfoldertree']['id'],'class'=>'form-control')); ?>
	           <?php echo $this->Form->input('foldertree',array('type' => 'hidden','value' => $this->params['url']['doc'],'class'=>'form-control')); ?>
	            <?php echo $this->Form->input('title',array('placeholder' => 'Sample Title','class'=>'form-control','style'=>'font-style:italic;')); ?>
	        </div>
	        <hr/>
	        Or use existing topics
	        <hr/>

	        <select class="form-control" name="sub_topic">
	        	<?php $count1 = 0;?>
	        	<?php foreach($Laspagelink_db3 as $lpldb3):?>
	        		<?php if($lpldb3['Laspagelink']['lasfolder_id'] == $fn['Docfoldertree']['id'] && !empty($lpldb3['Laspagelink']['title']) && empty($lpldb3['Laspagelink']['subtopic_id']) && strpos($lpldb3['Laspagelink']['lasdoc_id'],$this->params['url']['docid']) === false):?>
	        		
	        		<option value="<?php echo $lpldb3['Laspagelink']['id'];?>"><?php echo $lpldb3['Laspagelink']['title'];?></option>
	        		<?php $count1 = count($lpldb3);?>
	        		


	        	<?php endif;?>
	        	<?php endforeach;?>
	        		<?php if($count1 == 0) :?>
	        		<option value="null" disabled>All existing topics are already added.</option>
	        		<?php endif;?>
	        </select>
	</div>
	<div class="modal-footer">


	    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

	    <input type="submit" value="Submit request" class="btn btn-default" name="sub-btn"/>


	</div>
	</div>

	</div>
	</div>
	<!-- modals end here -->
	
<?php echo $this->Form->end() ;?>
<?php foreach($Laspagelink_db as $ldb):?>

<?php echo $this->Form->create('Laspagelink', array('role' => 'form','action'=>'addnewsublink')); ?>

<!-- Modal -->
<div class="modal fade" id="sublinks<?php echo $ldb['Laspagelink']['id'];?>" tabindex="-1" role="dialog" aria-labelledby="sublinksLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sublinksLabel"><?php echo $ldb['Laspagelink']['title'].'_Add New Sub Topic';?></h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
	            <?php echo $this->Form->input('lasdoc_id',array('type' => 'hidden','value' => $this->params['url']['docid'],'class'=>'form-control')); ?>
	            
	            <?php echo $this->Form->input('lasfolder_id',array('type' => 'hidden','value' => $ldb['Laspagelink']['lasfolder_id'],'class'=>'form-control')); ?>
	           <?php echo $this->Form->input('foldertree',array('type' => 'hidden','value' => $this->params['url']['doc'],'class'=>'form-control')); ?>
	            <?php echo $this->Form->input('subtopic_id',array('type' => 'hidden','value' => $ldb['Laspagelink']['id'],'class'=>'form-control')); ?>
	            <?php echo $this->Form->input('Topic',array('placeholder' => 'Sub Topic','class'=>'form-control','style'=>'font-style:italic;')); ?>
	            <br style="clear:both;"/>
	            <label for="subject-code">Subject</label>
	            <select class="form-control" name="data[Laspagelink][subject_code]">
	            	<option>AM 243_Animation</option>
	            	<option>AP 243_Application Programming I</option>
	            	<option>BCD 111_Basic Christian Doctrine I</option>
	            	<option>BCD 121_Basic Christian Doctrine II</option>
	            	<option>BCD 131_Basic Christian Doctrine III</option>
	            	<option>BCD 241_Basic Christian Doctrine IV</option>
	            	<option>BCD 251_Basic Christian Doctrine V</option>
	            	<option>BCD 261_Basic Christian Doctrine VI</option>
	            	<option>BCD 371_Basic Christian Doctrine VII</option>
	            	<option>BCD 381_Basic Christian Doctrine VIII</option>
	            	<option>BCD 391_Basic Christian Doctrine IX</option>
	            	<option>CA 132_Computer Accounting</option>
	            	<option>CC 242_Customer Care</option>
	            	<option>CHS 121_Computer Hardware & Servicing</option>
	            	<option>CKTS 113_DC Circuits</option>
	            	<option>CKTS 243_AC Circuits</option>
	            	<option>CNC 372_CNC Programming</option>
	            	<option>DBS 133_Database Systems I</option>
	            	<option>DE 121_Digital Electronics (Lab)</option>
	            	<option>DE 122_Digital Electronics (Lec)</option>
	            	<option>ELEC 113_Building Wiring</option>
	            	<option>ELEC 133_Motor Control</option>
	            	<option>ELEC 242_Automation I (Electro pneumatics)</option>
	            	<option>ELEC 252_Automation II (PLC) 1</option>
	            	<option>ELEC 352_Automation II (PLC) 2</option>
	            	<option>ELEX 111_Electronic Workshop</option>
	            	<option>ELEX 113_DC Circuits and Electronic Devices (Lec)</option>
	            	<option>ELEX 121_Industrial Electronics I (Lab)</option>
	            	<option>ELEX 123_Industrial Electronics I (Lec)</option>
	            	<option>ELEX 132_Logic Circuit & Switching Theory (Lab)</option>
	            	<option>ELEX 133_Logic Circuit & Switching Theory (Lec)</option>
	            	<option>ELEX 241_Industrial Electronics II (lab)</option>
	            	<option>ELEX243_Consumer Electronics</option>
	            	<option>ELEX 243_Industrial Electronics II (lec)</option>
	            	<option>ELEX 253_Industrial Electronics III (Lec)</option>
	            	<option>ELEX 263_Industrial Electronics III (Lec)</option>
	            	<option>ELEX 343_Industrial Electronics III</option>
	            	<option>ELEX 373_Industrial Electronics III (Lec)</option>
	            	<option>ES 122_Environmental Science</option>
	            	<option>ES 132_Environmental Science</option>
	            	<option>ESL 113_Grammar and Composition</option>
	            	<option>ESL 123_Technical Writing</option>
	            	<option>ESL 133_Business Correspondence</option>
	            	<option>ESL 243_Effective Communication (EFCOM)</option>
	            	<option>EWS 111_Assembly and Disassembly</option>
	            	<option>EWS 251_Electronics Workshop III</option>
	            	<option>EWS 261_Electronics Workshop III</option>
	            	<option>EWS 371_Electronics Workshop III</option>
	            	<option>IM 133_Instrumentation & Measurements</option>
	            	<option>IT 111_PC Operations</option>
	            	<option>IT 121_Computer Hardware & Servicing</option>
	            	<option>MATH 113_College Algebra</option>
	            	<option>MATH 123_Advanced Algebra</option>
	            	<option>MATH 133_College Trigonometry</option>
	            	<option>MATH 243_Analytic Geometry</option>
	            	<option>MATH 253_Solid Mensuration</option>
	            	<option>MM 113_Basic Arts</option>
	            	<option>MM 133_Advance Arts</option>
	            	<option>MM 243_Advance Multimedia</option>
	            	<option>MO 263_Management Operations I (PM and PP&PC)</option>
	            	<option>MO 383_Management Operations II (QC and QMS)</option>
	            	<option>MO 393_Management Operations II (QC and QMS)</option>
	            	<option>MS 113_Properties of Engineering Materials</option>
	            	<option>MT 113_Benchwork and Metrology</option>
	            	<option>MT 122_Multimedia Basics</option>
	            	<option>MT 123A_Lathe Machine and Drill Press</option>
	            	<option>MT 123B_Milling Machine and Grinding</option>
	            	<option>MWS 123_Mechanical Workshop I</option>
	            	<option>MWS 133_Mechanical Workshop II</option>
	            	<option>NBC 262_New Business Creation I</option>
	            	<option>NBC 382_New Business Creation II</option>
	            	<option>NBC 392_New Business Creation II</option>
	            	<option>NET 113_Networking I</option>
	            	<option>NET 123_Networking II</option>
	            	<option>NET 133_Networking III</option>
	            	<option>NET 243_Networking IV</option>
	            	<option>NET 253_Networking V</option>
	            	<option>NET 273_Networking VI</option>
	            	<option>NET 373_Networking VII</option>
	            	<option>NET 393_Networking VIII</option>
	            	<option>OOP 133_Object Oriented Programming I</option>
	            	<option>OOP 243_Object Oriented Programming II</option>
	            	<option>OS 123_Operating Systems</option>
	            	<option>PE 112_Self-Testing Activities</option>
	            	<option>PE 122_Fundamentals of Rhythmic Activities</option>
	            	<option>PE 132_Dual and Team Sports</option>
	            	<option>PE 242_Dual and Team Sports</option>
	            	<option>PHY 243_College Physics</option>
	            	<option>PS 372_Project Study I</option>
	            	<option>PS 382_Project Study II</option>
	            	<option>PS 392_Project Study III</option>
	            	<option>SEM 372_Seminar Series I (ITE, Econ, IPR)</option>
	            	<option>SEM 382_Seminar Series I (ITE, Econ, IPR)</option>
	            	<option>SEM 392_Seminar Series II (ITE, Econ, IPR)</option>
	            	<option>SFL 261_Skills for Life I</option>
	            	<option>SFL 371_Skills for Life II</option>
	            	<option>SFL 381_Skills for Life II</option>
	            	<option>SFTY 111_General and Industrial Safety I</option>
	            	<option>SFTY 121_General & Industrial Safety II</option>
	            	<option>SP 122_Structured Programming II</option>
	            	<option>SP 133_Structured Programming III</option>
	            	<option>SS 112_Social Science I</option>
	            	<option>SS 122_Social Science II</option>
	            	<option>SS 132_Social Science III</option>
	            	<option>SS 242_Social Science IV</option>
	            	<option>TD 121_Technical Drawing I</option>
	            	<option>TD 241_Computer-aided Design and Drafting</option>
	            	<option>TPM 242_Total Productive Maintenance</option>
	            	<option>TPM 252_Total Productive Maintenance</option>
	            	<option>WD 113_Web Design</option>
	            </select>
	            <hr/>
	            Or use existing links
	            <hr/>

		            <select class="form-control" name="sub_topic_link">
		            	<?php $count = 0;?>

		        	<?php foreach($Laspagelink_db3 as $lpldb3):?>

		        	<?php if($lpldb3['Laspagelink']['subtopic_id'] == $ldb['Laspagelink']['id'] && empty($lpldb3['Laspagelink']['title']) && !empty($lpldb3['Laspagelink']['subtopic_id']) && strpos($lpldb3['Laspagelink']['lasdoc_id'],$this->params['url']['docid']) === false):?>

		        		<option value="<?php echo $lpldb3['Laspagelink']['id'];?>"><?php echo $lpldb3['Laspagelink']['subtopic'];?></option>
		        		<?php $count = count($lpldb3);?>

		        	<?php endif;?>
		        	<?php endforeach;?>
		        		<?php if($count == 0):?>
		        		<option value="null" disabled>All existing topics are already added.</option>
		        		<?php endif;?>
		        	</select>
	        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" value="Create" class="btn btn-default" name="sub-btn"/>
      </div>
  	
  		
    </div>
  </div>
</div>

<?php echo $this->Form->end() ;?>
<?php endforeach;?>
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
	
	<hr><a href="<?php echo $this->Html->url(array('controller' => 'notifications','action' => 'unread'));?>"><h8 style="padding:5px;">see all unread_<?php echo $countNotif;?></h8></a></hr>
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
		<hr><a href="<?php echo $this->Html->url(array('controller' => 'notifications','action' => 'read'));?>"><h8 style="padding:5px;">see all read_<?php echo $countNotifread;?></h8></a></hr>
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
