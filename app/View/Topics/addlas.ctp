<?php
#echo $this->Html->css('sample');

echo $this->Html->script('ckeditor/ckeditor');

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
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Topic', array('role' => 'form')); ?>
                        <?php echo $this->Form->hidden('chapter'); ?>

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
				  <input type="text" id="TopicTitle" maxlength="100" placeholder="Title" class="form-control no-border-left" name="data[Topic][title]" required>
				</div>

				<div class="form-group">
					
					<?php echo $this->Form->input('content', array('class' => 'form-control ckeditor', 'placeholder' => 'Content'));?>
				
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Save New Topic'), array('class' => 'btn btn-success')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
<script> 
var roxyFileman = '/nayklase/app/webroot/js/ckeditor/plugins/fileman/index.html'; 
$(function(){
   CKEDITOR.replace( 'TopicContent',{filebrowserBrowseUrl:roxyFileman, 
	                                 filebrowserUploadUrl:roxyFileman,
	                                 filebrowserImageBrowseUrl:roxyFileman+'?type=image',
	                                 filebrowserImageUploadUrl:null,
	                                 filebrowserImageBrowseLinkUrl: false,
	                                  toolbar : 'MyToolbarLAS'
	                                }); 
});
 </script>