<?php
echo $this->Html->script('ckeditor/ckeditor');
#pr($subjects);
?>
<div class="teachers index">

	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
                <li><a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard">
                    <span class="glyphicon glyphicon-home"></span></a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'view')); ?>"><?php echo __($this->Session->read('Subject.title')); ?></a>
                </li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'exams', 'action' => 'lists')); ?>">Assessments</a></li>
                <li class="active"><?php echo $exam['Exam']['title'];?> : Add Questions</li>
            </ol>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Actions</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								 <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;Back to Subject Index'), array('controller' => 'subjects', 'action' => 'view'), array('escape' => false)); ?> </li>
								 <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;List of Assessments'), array('controller' => 'exams', 'action' => 'lists'), array('escape' => false)); ?> </li>								
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?php echo $exam['Exam']['title']; ?>
						
						<div id="dropmenu" class="btn-group" style="float: right; top: -6px; right: -10px;">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li><a href="<?php echo $this->Html->url(array('controller' => 'exams', 'action' => 'edit', $this->Detergent->urlsafe_b64encode($exam['Exam']['id']))); ?>" style="color: #12AD2B;"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edit</a></li>
								<li><a href="<?php echo $this->Html->url(array('controller' => 'exams', 'action' => 'remove', $exam['Exam']['id'])); ?>" style="color: #FF6141;"><span class="glyphicon glyphicon-trash"></span>&nbsp;Remove</a></li>
								<li><a href="#" style="color: #5E53C7;"><span class="glyphicon glyphicon-save"></span>&nbsp;Archive</a></li>
							</ul>
						</div>
						<span style="float: right;"><?php echo $exam['Exam']['modified']; ?></span>
					</div>
					<div class="panel-body">
						<ul class="nav nav-pills nav-stacked">
							<li class="box-description">
								<span class="glyphicon glyphicon-time" title="Time limit"></span>&nbsp;
								<?php echo $exam['Exam']['time_limit']; ?>
								<br><br>
								
								<div style="margin: 20px 0 5px;">
									Create Question <span class="glyphicon glyphicon-chevron-down"></span>
								</div>
								<a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'create', $this->Detergent->urlsafe_b64encode($exam['Exam']['id']))); ?>" class="btn btn-default btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion" style="float: left; margin-right: 5px;" >
									Single Choice
								</a>

								<a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'create', $this->Detergent->urlsafe_b64encode($exam['Exam']['id']), 'Multiple Select')); ?>" class="btn btn-default btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: left; margin-right: 5px;">
									Multiple Select
								</a>

								<a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'create', $this->Detergent->urlsafe_b64encode($exam['Exam']['id']), 'True or False')); ?>" class="btn btn-default btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: left; margin-right: 5px;">
									True or False
								</a>

								<a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'create', $this->Detergent->urlsafe_b64encode($exam['Exam']['id']), 'Matching Type')); ?>" class="btn btn-default btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: left; margin-right: 5px;">
									Matching Type
								</a>

								<a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'reuse_preview', $this->Detergent->urlsafe_b64encode($exam['Exam']['id']))); ?>" class="btn btn-success btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: left; margin-right: 5px;">
									Re-use Questions
								</a>


								
								<br clear="all">
							</li>
						</ul>
						

						<!-- Modal -->
						<div class="modal fade" id="myModalQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title" id="myModalLabel">Initiating...</h4>
									</div>
									<div class="modal-body" style="padding: 20px !important; text-align: center;">
										Loading content ... <br>
										<img src="<?php echo $this->Html->url('/app/webroot/img/loader.gif'); ?>" />
									</div>
									<div class="modal-footer" style="margin: 0 !important;">
										<button type="button" class="btn btn-default" data-dismiss="modal" disabled="disabled">Close</button>
										<button type="submit" class="btn btn-primary" disabled="disabled">Save</button>
									</div>
								</div>

							</div>
						</div>
						<div class="modal-loading" style="display: none !important;">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Initiating...</h4>
							</div>
							<div class="modal-body" style="padding: 20px !important; text-align: center;">
								Loading content ... <br>
								<img src="<?php echo $this->Html->url('/app/webroot/img/loader.gif'); ?>" />
							</div>
							<div class="modal-footer" style="margin: 0 !important;">
								<button type="button" class="btn btn-default" data-dismiss="modal" disabled="disabled">Close</button>
								<button type="submit" class="btn btn-primary" disabled="disabled">Save</button>
							</div>
						</div>


						<?php if (!empty($exam_questions)): ?>
						<div class="row" style="margin: 0; padding: 10px;">
						<ol class="list-group" style="list-style: decimal inside !important;">
							<?php foreach ($exam_questions as $exam_question): ?>
							<li class="list-group-item">
								<div id="dropmenu" class="btn-group" style="float: right; top: -6px; right: -10px;">
									<ul style="list-style: none; margin-top: 8px;">
										<li>
											<a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'update', $this->Detergent->urlsafe_b64encode($exam['Exam']['id']), $this->Detergent->urlsafe_b64encode($exam_question['Question']['id']), $exam_question['Question']['type'])); ?>" data-toggle="modal" data-target="#myModalQuestion" style="color: #ADADAD;" title="Edit"><span class="glyphicon glyphicon-edit"></span></a></li>
										<li><a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'remove', $this->Detergent->urlsafe_b64encode($exam['Exam']['id']), $this->Detergent->urlsafe_b64encode($exam_question['Question']['id']))); ?>" style="color: #ADADAD;" title="Delete"><span class="glyphicon glyphicon-trash"></span></a></li>
									</ul>
								</div>

								<strong><?php echo $exam_question['Question']['content']; ?></strong>


								<?php if($exam_question['Question']['type']=="Matching Type"): ?>
									<div style="padding-bottom: 5px; font-style: italic;">
										<div style="float: left; width: 50%;">
											Column A
										</div>
										Column B
										<br clear="all">
									</div>
									<?php foreach ($exam_question['Option'] as $option): ?>
									<div style="color: #43CA43;">
										<div style="float: left; width: 50%;">
											<i class="glyphicon glyphicon-check"></i>&nbsp;&nbsp;
											<?php echo $option['option']; ?>
										</div>
										<?php echo $option['alternate_option']; ?>
										<br clear="all">
									</div>
									<?php endforeach; ?>
								<?php elseif($exam_question['Question']['type']=="Multiple Select"): ?>
									<?php foreach ($exam_question['Option'] as $option): ?>
									<div <?php if($option['correct']) echo 'style="color: #43CA43;"'; ?>>
										<i class="glyphicon glyphicon-<?php if(!$option['correct']) echo 'un'; ?>check<?php if(!$option['correct']) echo 'ed'; ?>"></i>&nbsp;&nbsp;
										<?php echo $option['option']; ?>
									</div>
									<?php endforeach; ?>
								<?php else: ?>
									<?php foreach ($exam_question['Option'] as $option): ?>
									<div <?php if($option['correct']) echo 'style="color: #43CA43;"'; ?>>
										<i class="glyphicon glyphicon-<?php if(!$option['correct']) echo 'un'; ?>check<?php if(!$option['correct']) echo 'ed'; ?>"></i>&nbsp;&nbsp;
										<?php echo $option['option']; ?>
									</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</li>
							<?php endforeach; ?>
						</ol>
						</div>
						<?php endif; ?>
						

					</div><!-- end body -->
				</div><!-- end panel -->
			</div>
		</div> <!-- end col md 9 -->


		<script>
		$(function(){
			/*
		    $('#myModalQuestion').on('show.bs.modal', function () {
		        $('.modal-loading').show();
		    });

		    $('#myModalQuestion').on('loaded.bs.modal', function () {
		        $('.modal-loading').hide();
		    });
			*/
		    
		});

		function resetModal() {
			var loadingContent = $('.modal-loading').html();
	    	$('#myModalQuestion .modal-body').html(loadingContent);

			//$('.modal-loading').show();
			//alert(loadingContent);
	    }
		</script>
	</div><!-- end row -->


</div><!-- end containing of content -->