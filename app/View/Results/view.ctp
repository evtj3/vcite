<div class="results view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Result'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Result'), array('action' => 'edit', $result['Result']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Result'), array('action' => 'delete', $result['Result']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $result['Result']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Results'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Result'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Exams'), array('controller' => 'exams', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Exam'), array('controller' => 'exams', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Students'), array('controller' => 'students', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Student'), array('controller' => 'students', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">			
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
				<tr>
		<th><?php echo __('Id'); ?></th>
		<td>
			<?php echo h($result['Result']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Exam'); ?></th>
		<td>
			<?php echo $this->Html->link($result['Exam']['title'], array('controller' => 'exams', 'action' => 'view', $result['Exam']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Student'); ?></th>
		<td>
			<?php echo $this->Html->link($result['Student']['id'], array('controller' => 'students', 'action' => 'view', $result['Student']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Topics'); ?></th>
		<td>
			<?php echo h($result['Result']['topics']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Responses'); ?></th>
		<td>
			<?php echo h($result['Result']['responses']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Score'); ?></th>
		<td>
			<?php echo h($result['Result']['score']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Total'); ?></th>
		<td>
			<?php echo h($result['Result']['total']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($result['Result']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Modified'); ?></th>
		<td>
			<?php echo h($result['Result']['modified']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

