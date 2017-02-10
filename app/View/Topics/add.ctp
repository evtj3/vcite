<?php
#echo $this->Html->css('sample');

echo $this->Html->script('ckeditor/ckeditor');
echo $this->Html->script('MathJax/MathJax.js?config=TeX-AMS-MML_HTMLorMML');
#echo $this->Html->script('tinymce/tinymce.min');
?>
<!--
<script type="text/javascript">
tinymce.init({ 
    selector: "textarea",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor moxiemanager"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});
</script>
-->
<style>
  #cke_1_contents {
   height: 11in !important;
}
</style> 
<div class="topics form">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard"><span class="glyphicon glyphicon-home"></span></a></li>
				<li><a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'view')); ?>"><?php echo __($this->Session->read('Subject.title')); ?></a>
				</li>
				<li class="active">New Topic</li>
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
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;Back to Subject Index'), array('controller' => 'subjects', 'action' => 'view'), array('escape' => false)); ?> </li>
                                <li class="disabled">
                                        <a href="#" ><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;&nbsp;Description</a>
                                </li>
                                <li class="disabled">
                                        <a href="#"><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;&nbsp;Outline</a>
                                </li>
                                <li class="disabled">
                                        <a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Student</a>
                                </li>
							</ul>
						</div>
					</div>
				</div>			
				<div class="actions">
			        <div class="panel panel-default">
			          <div class="panel-heading">Math Guide 
			          </div>

			            <div class="panel-body">
			                <ul class="nav nav-pills nav-stacked discussions mathguide">
			                  <a target="_blank" href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Math Formula guide/LaTeXSymbols.pdf">
			                    <li style="list-style:none;"><span class="glyphicon glyphicon-file"></span> LaTeX Mathematical Symbols</li>
			                  </a>
			                 	
			                 			<ul>
			                 				<li>Basic Usage:</li>
			                 				<li>{} - <font style="font-size:12px;">group</font></li>
			                 				<li>\over - <font style="font-size:12px;">fraction number</font></li>
			                 				<li>\pm - <font style="font-size:12px;">plus and minus</font></li>
			                 				<li>\div - <font style="font-size:12px;">divide</font></li>
			                 				<li>\times - <font style="font-size:12px;">multiply</font></li>
			                 			</ul>
			                 	
			                </ul>


			            </div><!-- end body -->
			        </div><!-- end panel -->
			      </div><!-- end actions -->
		</div><!-- end col md 3 -->
		<div class="col-md-9">

			<?php echo $this->Form->create('Topic', array('role' => 'form')); ?>
                        <?php echo $this->Form->hidden('chapter'); ?>

                 <div class="form-group">
					<?php echo $this->Form->submit(__('Save'), array('class' => 'btn btn-success')); ?>
				</div>
				<label for="TopicTitle">Title</label><br>
				<div class="input-group" style="margin-bottom: 15px;">
				  
			      
				  <div class="input-group-btn">
				      <!--simple button-->    
				      <button id="title_chapter" type="button" class="btn btn-default remove-double-border" style="width: 120px;">New Chapter</button>
				      
				      <!--dropdown button-->    
				      <button type="button" class="btn btn-default dropdown-toggle remove-double-border" data-toggle="dropdown">
				          <span class="caret"></span>
				      </button>
				      <ul class="dropdown-menu">
                                          <li><a href="#" onclick="chapter('New Chapter'); $('#TopicChapter').val('');">New Chapter</a></li>
                                          
                                          <?php $chapter_counter = 1; foreach($subject_chapters as $chapter): ?>
                                          <li><a href="#" onclick="chapter('Chapter <?php echo $chapter_counter; ?>'); $('#TopicChapter').val('<?php echo $chapter['Topic']['id']; ?>');">Chapter <?php echo $chapter_counter.': '.$chapter['Topic']['title']; ?></a></li>
                                          <?php $chapter_counter++; endforeach; ?>
				      </ul>
                                      <script>
                                          function chapter(chap) {
                                              $('#title_chapter').html(chap);
                                          }
                                      </script>
				  </div>
				  <input type="text" id="TopicpicTitle" maxlength="100" placeholder="Title" class="form-control no-border-left" name="data[Topic][title]" required>
				</div>

				<div class="form-group">
					<?php echo $this->Form->input('content', array('class' => 'form-control ckeditor', 'placeholder' => 'Content'));?>
				</div>
				
				<div class="form-group">
					<?php echo $this->Form->submit(__('Save'), array('class' => 'btn btn-success')); ?>
				</div>
			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
<script> 
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