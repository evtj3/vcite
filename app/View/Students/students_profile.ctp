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
					<div class="panel-heading">Students's ID <!--<a style="color:#fff;" href="<?php echo $this->Html->url(array('controller' => 'students', 'action' => 'edit',$this->Session->read('User.id')));?>"><span style="float:right;" class="glyphicon glyphicon-pencil"></span></a>--></div>
						<div class="panel-body">
							<div class="profile">
								<!--<img src="<?php echo $this->Html->url('/app/webroot/img/profile_pic/students/'.$this->Session->read('User.id').'.jpg'); ?>" />-->
								<div>Name: <?php echo $this->Session->read('User.wholename'); ?></div>
								<!--<div>Phone: (032) 422-1325 </div>-->
							</div>
						</div><!-- end body -->
				</div><!-- end panel -->
				
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<?php if(!empty($subjects)):?>
				<?php foreach($subjects as $subject): ?>
					<div class="actions">
						<div class="panel panel-default">
							<div class="panel-heading">
								<?php echo $subject['Subject']['title']; ?>
								<span style="float: right;"><?php echo $subject['Subject']['created']; ?></span>
							</div>
							<div class="panel-body">
								<ul class="nav nav-pills nav-stacked">
									<li class="box-description">
										<span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;
										<?php echo $subject['Subject']['description']; ?>
										<br><br>
										<div style="padding: 5px 0 0; font-size: 12px;">
											<span class="glyphicon glyphicon-list-alt"></span> <?php echo $subject['Topic']; ?> 
											<?php if($subject['Topic'] <= 1) :?>
											Topic
											<?php else:?>
											Topics
											<?php endif;?>
										</div>
										
										<a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'set_subject', $subject['Subject']['id'])); ?>" class="btn btn-default" role="button" style="float: right;">
											<span class="glyphicon glyphicon-list-alt"></span>
											Read
										</a>
										<br clear="all">
									</li>
								</ul>
							</div><!-- end body -->
						</div><!-- end panel -->
					</div>
				<?php endforeach; ?>
			<?php else:?>
				<div class="actions">
						<div class="panel panel-default">
							
							<div class="panel-body">
								<ul class="nav nav-pills nav-stacked">
									<li class="box-description">
										<p style="font-style:italic;">No Subject Enrolled yet. Please ask your respective teacher for the enrollment of the subject.</p>
									</li>
								</ul>
							</div><!-- end body -->
						</div><!-- end panel -->
					</div>
			<?php endif;?>
		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->