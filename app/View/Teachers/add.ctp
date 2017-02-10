<div class="teachers form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Teacher'); ?></h1>
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

																<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Teachers'), array('action' => 'index'), array('escape' => false)); ?></li>
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Subjects'), array('controller' => 'subjects', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Subject'), array('controller' => 'subjects', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Teacher', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('fname', array('class' => 'form-control', 'placeholder' => 'Fname'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('lname', array('class' => 'form-control', 'placeholder' => 'Lname'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => 'Email'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('pword', array('type'=> 'password','class' => 'form-control', 'placeholder' => 'Password'));?>
					<?php echo $this->Form->input('istutorial', array('type'=> 'hidden','class' => 'form-control', 'value' => '1'));?>
					<?php echo $this->Form->input('ext', array('type'=> 'hidden','class' => 'form-control', 'value' => '[Mentor]'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
