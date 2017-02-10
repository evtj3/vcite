<div class="exams index">

	
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard">
                    <span class="glyphicon glyphicon-home"></span></a></li>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'view')); ?>"><?php echo __($this->Session->read('Subject.title')); ?></a>
                </li>
                <li class="active">Assessments</li>
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
								<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Create a Quiz'), array('action' => 'add'), array('escape' => false)); ?></li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
						<th><?php echo $this->Paginator->sort('title'); ?></th>
						<th style="width: 87px;"><?php echo $this->Paginator->sort('time_limit'); ?></th>
						<th style="width: 90px;"><?php echo $this->Paginator->sort('questions'); ?></th>
						<th><?php echo $this->Paginator->sort('topics', 'Remarks'); ?></th>
						<th style="width: 160px;"><?php echo $this->Paginator->sort('modified', 'Last Modified'); ?></th>
						<th style="width: 67px;" class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($exams as $exam): ?>
					<tr>
						<td><?php echo h($exam['Exam']['id']); ?>&nbsp;</td>
						
						<td><?php echo h($exam['Exam']['title']); ?>&nbsp;</td>
						<td class="center-align"><?php echo h($exam['Exam']['time_limit']); ?>&nbsp;</td>
						<td class="center-align">
							<?php 
							if (!empty($exam['Exam']['questions'])) {
								echo substr_count($exam['Exam']['questions'], '][') + 1;
							} else {
								echo 0;
							}
							?>
							&nbsp;
						</td>
						<td>
							<?php 
							if (!empty($exam['Exam']['topics'])) echo "Used in " . h($exam['Exam']['topics']); 
							if ($exam['Exam']['allow_retake']) echo "Allow retake"; ?>
							&nbsp;
						</td>
						<td><?php echo h($exam['Exam']['modified']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'questions', $this->Detergent->urlsafe_b64encode($exam['Exam']['id'])), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $this->Detergent->urlsafe_b64encode($exam['Exam']['id'])), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $this->Detergent->urlsafe_b64encode($exam['Exam']['id'])), array('escape' => false), __('Are you sure you want to delete # %s?', $exam['Exam']['title'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<p>
				<small><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></small>
			</p>

			<?php
			$params = $this->Paginator->params();
			if ($params['pageCount'] > 1) {
			?>
			<ul class="pagination pagination-sm">
				<?php
					echo $this->Paginator->prev('&larr; Previous', array('class' => 'prev','tag' => 'li','escape' => false), '<a onclick="return false;">&larr; Previous</a>', array('class' => 'prev disabled','tag' => 'li','escape' => false));
					echo $this->Paginator->numbers(array('separator' => '','tag' => 'li','currentClass' => 'active','currentTag' => 'a'));
					echo $this->Paginator->next('Next &rarr;', array('class' => 'next','tag' => 'li','escape' => false), '<a onclick="return false;">Next &rarr;</a>', array('class' => 'next disabled','tag' => 'li','escape' => false));
				?>
			</ul>
			<?php } ?>

		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->