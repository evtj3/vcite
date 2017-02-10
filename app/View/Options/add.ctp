<div class="options form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Option'); ?></h1>
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

																<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Options'), array('action' => 'index'), array('escape' => false)); ?></li>
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Questions'), array('controller' => 'questions', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Question'), array('controller' => 'questions', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Option', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('question_id', array('class' => 'form-control', 'placeholder' => 'Question Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('option', array('class' => 'form-control', 'placeholder' => 'Option'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('correct', array('class' => 'form-control', 'placeholder' => 'Correct'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('alternate_option', array('class' => 'form-control', 'placeholder' => 'Alternate Option'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
