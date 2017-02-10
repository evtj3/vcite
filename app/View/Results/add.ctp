<div class="results form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Result'); ?></h1>
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

																<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Results'), array('action' => 'index'), array('escape' => false)); ?></li>
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Exams'), array('controller' => 'exams', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Exam'), array('controller' => 'exams', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Students'), array('controller' => 'students', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Student'), array('controller' => 'students', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Result', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('exam_id', array('class' => 'form-control', 'placeholder' => 'Exam Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('student_id', array('class' => 'form-control', 'placeholder' => 'Student Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('topics', array('class' => 'form-control', 'placeholder' => 'Topics'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('responses', array('class' => 'form-control', 'placeholder' => 'Responses'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('score', array('class' => 'form-control', 'placeholder' => 'Score'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('total', array('class' => 'form-control', 'placeholder' => 'Total'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
