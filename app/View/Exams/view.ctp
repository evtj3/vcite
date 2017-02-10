<div class="exams view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Exam'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Exam'), array('action' => 'edit', $exam['Exam']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Exam'), array('action' => 'delete', $exam['Exam']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $exam['Exam']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Exams'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Exam'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Subjects'), array('controller' => 'subjects', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Subject'), array('controller' => 'subjects', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Results'), array('controller' => 'results', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Result'), array('controller' => 'results', 'action' => 'add'), array('escape' => false)); ?> </li>
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
			<?php echo h($exam['Exam']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Subject'); ?></th>
		<td>
			<?php echo $this->Html->link($exam['Subject']['title'], array('controller' => 'subjects', 'action' => 'view', $exam['Subject']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Topics'); ?></th>
		<td>
			<?php echo h($exam['Exam']['topics']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Title'); ?></th>
		<td>
			<?php echo h($exam['Exam']['title']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Time Limit'); ?></th>
		<td>
			<?php echo h($exam['Exam']['time_limit']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Allow Retake'); ?></th>
		<td>
			<?php echo h($exam['Exam']['allow_retake']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Questions'); ?></th>
		<td>
			<?php echo h($exam['Exam']['questions']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($exam['Exam']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Modified'); ?></th>
		<td>
			<?php echo h($exam['Exam']['modified']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

<div class="related row">
	<div class="col-md-12">
	<h3><?php echo __('Related Results'); ?></h3>
	<?php if (!empty($exam['Result'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<thead>
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Exam Id'); ?></th>
		<th><?php echo __('Student Id'); ?></th>
		<th><?php echo __('Topics'); ?></th>
		<th><?php echo __('Responses'); ?></th>
		<th><?php echo __('Score'); ?></th>
		<th><?php echo __('Total'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"></th>
	</tr>
	<thead>
	<tbody>
	<?php foreach ($exam['Result'] as $result): ?>
		<tr>
			<td><?php echo $result['id']; ?></td>
			<td><?php echo $result['exam_id']; ?></td>
			<td><?php echo $result['student_id']; ?></td>
			<td><?php echo $result['topics']; ?></td>
			<td><?php echo $result['responses']; ?></td>
			<td><?php echo $result['score']; ?></td>
			<td><?php echo $result['total']; ?></td>
			<td><?php echo $result['created']; ?></td>
			<td><?php echo $result['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), array('controller' => 'results', 'action' => 'view', $result['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), array('controller' => 'results', 'action' => 'edit', $result['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), array('controller' => 'results', 'action' => 'delete', $result['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $result['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>

	<div class="actions">
		<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Result'), array('controller' => 'results', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-default')); ?> 
	</div>
	</div><!-- end col md 12 -->
</div>
