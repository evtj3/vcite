<div class="exams form">

	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard">
                    <span class="glyphicon glyphicon-home"></span></a></li>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'view')); ?>"><?php echo __($this->Session->read('Subject.title')); ?></a>
                </li>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'exams', 'action' => 'lists')); ?>">Assessments</a>
                </li>
                <li class="active">Add Quiz</li>
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
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Exam', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => 'Title'));?>
				</div>
				<div class="form-group">
						<label for="ExamAllowRetake">Time Limit</label>

						<table>
							<tr>
								<td>
									<?php echo $this->Form->input('limit_hour', array('class' => 'form-control', 'style' => 'float: left; text-align: center;', 'placeholder' => 'mm', 'label' => false));?>
									<script type="text/javascript">
										$('#ExamLimitHour').spinedit({
										    minimum: 00,
										    maximum: 12,
										    step: 1,
										    numberOfDecimals: 0
										});
									</script>
								</td>
								<td style="font-weight: bold; font-size: 20px; padding: 5px;">
									:
								</td>
								<td>
									<?php echo $this->Form->input('limit_minute', array('class' => 'form-control', 'style' => 'float: left; text-align: center;', 'placeholder' => 'mm', 'label' => false));?>
									<script type="text/javascript">
										$('#ExamLimitMinute').spinedit({
										    minimum: 00,
										    maximum: 55,
										    step: 5,
										    numberOfDecimals: 0
										});
									</script>
								</td>
							</tr>
							<tr>
								<td style="color: #999999; font-style: italic;">hour</td>
								<td></td>
								<td style="color: #999999; font-style: italic;">minute</td>
							</tr>
						</table>
				</div>

				<div class="form-group">
					<label for="ExamAllowRetake">Allow Retake</label><br>
					

					<input type="checkbox" id="ExamAllowRetake" name="data[Exam][allow_retake]">
					<script type="text/javascript">
						$.fn.bootstrapSwitch.defaults.size = 'normal';
						$("[id='ExamAllowRetake']").bootstrapSwitch();
					</script>
					<br><br>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

				<!--
				<div class="form-group">
	                <div class='input-group date' id='datetimepicker'>
	                    <input type='text' class="form-control" />
	                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
	                    </span>
	                </div>
	            </div>
				<script type="text/javascript">
		            $(function () {
		                $('#datetimepicker').datetimepicker({
		                	pickDate: false,
		                	useMinutes: true,
					    	defaultDate:""
		                });
		            });
		        </script>
				-->
			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
