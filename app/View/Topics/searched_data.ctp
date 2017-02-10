<div class="topics index">
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
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Search results'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->



	<div class="row">


		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<!--<th><?php echo $this->Paginator->sort('id'); ?></th>-->
						<th><?php echo $this->Paginator->sort('subject_id'); ?></th>
						<th><?php echo $this->Paginator->sort('title'); ?></th>
						<th><?php echo $this->Paginator->sort('content'); ?></th>
						<th><?php echo $this->Paginator->sort('created'); ?></th>
						<th><?php echo $this->Paginator->sort('modified'); ?></th>
						<!--<th class="actions"></th>-->
					</tr>
				</thead>
				<tbody>
				<?php foreach ($topics as $topic): ?>
					<tr>
						<!--<td><?php echo h($topic['Topic']['id']); ?>&nbsp;</td>-->
								<td>
			<?php 
			#pr($this->Session->read('User'));
			if($this->Session->read('User.group') == 'teacher')
			echo $this->Html->link($topic['Subject']['title'], array('controller' => 'subjects', 'action' => 'view', $topic['Subject']['id'])); 
			else
			echo $this->Html->link($topic['Subject']['title'], array('controller' => 'subjects', 'action' => 'read', $topic['Subject']['id'])); 
			?>
		</td>
						<td><?php echo h($topic['Topic']['title']); ?>&nbsp;</td>
						<td><?php echo h($topic['Topic']['content']); ?>&nbsp;</td>
						<td><?php echo h($topic['Topic']['created']); ?>&nbsp;</td>
						<td><?php echo h($topic['Topic']['modified']); ?>&nbsp;</td>
						<!--<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $topic['Topic']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $topic['Topic']['id']), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $topic['Topic']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $topic['Topic']['id'])); ?>
						</td>-->
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