<div class="students form">
	<p style="text-align:right; font-style:italic; font-size:10px; padding:5px;">If you have any concern about your profile name, please ask the administrator.</p>
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Edit Student'); ?></h1>
			</div>
		</div>
	</div>



	<div class="row" style="margin:0 auto;">
		
		<div class="col-md-12">
			<?php echo $this->Form->create('Student', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('id', array('class' => 'form-control', 'placeholder' => 'Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('fname', array('class' => 'form-control', 'placeholder' => 'Fname','disabled'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('lname', array('class' => 'form-control', 'placeholder' => 'Lname','disabled'));?>
				</div>
				
				<div class="form-group">
					<?php echo $this->Form->input('pword', array('type'=> 'password','class' => 'form-control', 'placeholder' => 'password','value' => ''));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('style'=>'float:left; margin-right:20px; ','class' => 'btn btn-default')); ?>
					<a href="<?php echo $this->Html->url(array('controller' => 'students' , 'action' => 'students_profile')); ?>" class="btn btn-default">Go back</a>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
