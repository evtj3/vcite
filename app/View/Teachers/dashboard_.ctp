<?php
#pr($subjects);

?>
<div class="teachers index">

	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li class="active"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Welcome to Dashboard!</li>
			</ol>
		</div><!-- end col md 12 -->
	</div><!-- end row -->



	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Teacher's ID</div>
						<div class="panel-body">
							<div class="profile">
								<img src="<?php echo $this->Html->url('/app/webroot/img/profile_pic/teachers/'.$this->Session->read('User.id').'.jpg'); ?>" />
								<div>Name: <?php echo $this->Session->read('User.wholename'); ?></div>
								<div>Phone: (032) 422-1325 </div>
							</div>
						</div><!-- end body -->
				</div><!-- end panel -->
				<div class="panel panel-default">
					<div class="panel-heading">Actions</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Subject'), array('controller' => 'subjects', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<?php foreach($subjects as $subject): ?>
				<div class="actions">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo $subject['Subject']['title']; ?>
							


							<div id="dropmenu" class="btn-group" style="float: right; top: -6px; right: -10px;">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li><a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'edit', $subject['Subject']['id'])); ?>" style="color: #12AD2B;"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edit</a></li>
									<li><a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'remove', $subject['Subject']['id'])); ?>" style="color: #FF6141;"><span class="glyphicon glyphicon-trash"></span>&nbsp;Remove</a></li>
									<li><a href="#" style="color: #5E53C7;"><span class="glyphicon glyphicon-save"></span>&nbsp;Archive</a></li>
								</ul>
							</div>
							<span class="date_created"><?php echo $subject['Subject']['created']; ?></span>
						</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li class="box-description">
									<span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;
									<?php echo $subject['Subject']['description']; ?>
									<br><br>
									<div style="padding: 5px 0 0; font-size: 12px;">
										<span class="glyphicon glyphicon-user"></span> <?php echo $subject['Student']; ?> Students

										<span class="glyphicon glyphicon-list-alt"></span> <?php echo $subject['Topic']; ?> Topics
									</div>
									
									<a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'set_subject', $subject['Subject']['id'])); ?>" class="btn btn-primary btn-sm" role="button" style="float: right;">
										Go Inside
										<span class="glyphicon glyphicon-arrow-right"></span>
									</a>
									<br clear="all">
								</li>
							</ul>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>
			<?php endforeach; ?>
		</div> <!-- end col md 9 -->

		<!--
		<button type="button" data-toggle="modal" data-target="#imageUpload">Launch modal</button>

		<div class="modal fade" id="imageUpload" tabindex="-1">
		    <div class="modal-dialog">
		        <div class="modal-content">
				    Upload form here
		        </div>
		    </div>
		</div>
		<script>
		$(function(){
    
		    $('#imageUpload').on('hidden.bs.modal', function () {
		        alert('hidden event fired!');
		    });
		    
		     $('#imageUpload').on('shown.bs.modal', function () {
		        alert('show event fired!');
		    });
		});
		</script>
		-->
	</div><!-- end row -->


</div><!-- end containing of content -->