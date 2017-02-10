
<?php #echo $this->Form->create('Question', array('role' => 'form')); ?>
<?php #echo $this->Form->hidden('Type.question_type', array('value' => $type)); ?>



<?php if ($question[0]['Question']['type']=="Multiple Select"): ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel"><?php echo $question[0]['Question']['type']; ?></h4>
	</div>
	<div class="modal-body" style="padding: 15px !important;">
		<div class="form-group">
			<?php echo $question[0]['Question']['content']; ?>
		</div>

		<div class="form-group">
			<ul style="margin: 0; padding: 0 10px 0; list-style: none;">
				<?php $small_l = "a"; ?>
				<?php foreach($question[0]['Option'] as $option): ?>
				<li>
					<div style="margin-bottom: 15px; <?php if($option['correct']) echo 'color: #43CA43;'; ?>" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				  			<i class="glyphicon glyphicon-<?php if(!$option['correct']) echo 'un'; ?>check<?php if(!$option['correct']) echo 'ed'; ?>"></i>&nbsp;&nbsp;
				      		<?php echo $small_l; ?>.)
					  </div>
					  <?php echo $option['option'] ?>
					</div>
				</li>
				<?php $small_l++; ?>
				<?php endforeach; ?>
			</ul>
			
		</div>
	</div>
	<div class="modal-footer" style="margin: 0 !important;">
		<?php if ($this->Paginator->request->params['paging']['Question']['prevPage']): ?>
		<?php $prevpage = $this->Paginator->request->params['paging']['Question']['page'] - 1; ?>
		<a href="<?php echo $this->Html->url('/questions/reuse_preview/'.$exam_id.'/page:'.$prevpage); ?>" class="btn btn-success btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: left; margin-right: 5px;">
			Previous
		</a>
		<?php endif; ?>

		<center>
		<a href="#<?php #echo $this->Html->url('/questions/reuse_preview/'.$exam_id.'/page:'.$prevpage); ?>" class="btn btn-primary btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion">
			Insert
		</a>
		</center>

		<?php if ($this->Paginator->request->params['paging']['Question']['nextPage']): ?>
		<?php $nextpage = $this->Paginator->request->params['paging']['Question']['page'] + 1; ?>
		<a href="<?php echo $this->Html->url('/questions/reuse_preview/'.$exam_id.'/page:'.$nextpage); ?>" class="btn btn-success btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: right;">
			Next
		</a>
		<?php endif; ?>
	</div>
<?php elseif ($question[0]['Question']['type']=="True or False"): ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel"><?php echo $question[0]['Question']['type']; ?></h4>
	</div>
	<div class="modal-body" style="padding: 15px !important;">
		<div class="form-group">
			<?php echo $question[0]['Question']['content']; ?>
		</div>

		<div class="form-group">
			<ul style="margin: 0; padding: 0 10px 0; list-style: none;">
				<?php $small_l = "a"; ?>
				<?php foreach($question[0]['Option'] as $option): ?>
				<li>
					<div style="margin-bottom: 15px; <?php if($option['correct']) echo 'color: #43CA43;'; ?>" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				  			<i class="glyphicon glyphicon-<?php if(!$option['correct']) echo 'un'; ?>check<?php if(!$option['correct']) echo 'ed'; ?>"></i>&nbsp;&nbsp;
				      		<?php echo $small_l; ?>.)
					  </div>
					  <?php echo $option['option'] ?>
					</div>
				</li>
				<?php $small_l++; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="modal-footer" style="margin: 0 !important;">
		<?php if ($this->Paginator->request->params['paging']['Question']['prevPage']): ?>
		<?php $prevpage = $this->Paginator->request->params['paging']['Question']['page'] - 1; ?>
		<a href="<?php echo $this->Html->url('/questions/reuse_preview/'.$exam_id.'/page:'.$prevpage); ?>" class="btn btn-success btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: left; margin-right: 5px;">
			Previous
		</a>
		<?php endif; ?>


		<?php if ($this->Paginator->request->params['paging']['Question']['nextPage']): ?>
		<?php $nextpage = $this->Paginator->request->params['paging']['Question']['page'] + 1; ?>
		<a href="<?php echo $this->Html->url('/questions/reuse_preview/'.$exam_id.'/page:'.$nextpage); ?>" class="btn btn-success btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: right;">
			Next
		</a>
		<?php endif; ?>
	</div>
<?php elseif ($question[0]['Question']['type']=="Matching Type"): ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel"><?php echo $question[0]['Question']['type']; ?></h4>
	</div>
	<div class="modal-body" style="padding: 15px !important;">
		<div class="form-group">
			<?php echo $question[0]['Question']['content']; ?>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<ul style="margin: 0; padding: 0 10px 0; list-style: none; color: #43CA43;">
						<?php $small_l = "a"; ?>
						<?php foreach($question[0]['Option'] as $option): ?>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		<?php echo $small_l; ?>.)
							  	</div>
							  	<?php echo $option['alternate_option']; ?>
							</div>
						</li>
						<?php $small_l++; ?>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="col-md-6">
					<ul style="margin: 0; padding: 0 10px 0; list-style: none; color: #43CA43;">
						<?php $big_l = "A"; ?>
						<?php foreach($question[0]['Option'] as $option): ?>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		<?php echo $big_l; ?>.)
							  	</div>
							  	<?php echo $option['option']; ?>
							</div>
						</li>
						<?php $big_l++; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer" style="margin: 0 !important;">
		<?php if ($this->Paginator->request->params['paging']['Question']['prevPage']): ?>
		<?php $prevpage = $this->Paginator->request->params['paging']['Question']['page'] - 1; ?>
		<a href="<?php echo $this->Html->url('/questions/reuse_preview/'.$exam_id.'/page:'.$prevpage); ?>" class="btn btn-success btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: left; margin-right: 5px;">
			Previous
		</a>
		<?php endif; ?>


		<?php if ($this->Paginator->request->params['paging']['Question']['nextPage']): ?>
		<?php $nextpage = $this->Paginator->request->params['paging']['Question']['page'] + 1; ?>
		<a href="<?php echo $this->Html->url('/questions/reuse_preview/'.$exam_id.'/page:'.$nextpage); ?>" class="btn btn-success btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: right;">
			Next
		</a>
		<?php endif; ?>
	</div>	
<?php else: ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel"><?php echo $question[0]['Question']['type']; ?></h4>
	</div>
	<div class="modal-body" style="padding: 15px !important;">
		<div class="form-group">
			<?php echo $question[0]['Question']['content']; ?>
		</div>

		<div class="form-group">
			<ul style="margin: 0; padding: 0 10px 0; list-style: none;">
				<?php $small_l = "a"; ?>
				<?php foreach($question[0]['Option'] as $option): ?>
				<li>
					<div style="margin-bottom: 15px; <?php if($option['correct']) echo 'color: #43CA43;'; ?>" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				  			<i class="glyphicon glyphicon-<?php if(!$option['correct']) echo 'un'; ?>check<?php if(!$option['correct']) echo 'ed'; ?>"></i>&nbsp;&nbsp;
				      		<?php echo $small_l; ?>.)
					  </div>
					  <?php echo $option['option'] ?>
					</div>
				</li>
				<?php $small_l++; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="modal-footer" style="margin: 0 !important; text-align: left !important;">
		<?php
		#pr($this->Paginator->request->params['paging']['Question']['nextPage']);

		#echo $this->Paginator->next(__('next'));

		#/nayklase/questions/reuse_preview/NA../page:2

		//echo $this->Paginator->params->nextPage();
		#echo $exam_id;
		#pr($this->Paginator->request->params['paging']['Question']);
		?>
		<?php if ($this->Paginator->request->params['paging']['Question']['prevPage']): ?>
		<?php $prevpage = $this->Paginator->request->params['paging']['Question']['page'] - 1; ?>
		<a href="<?php echo $this->Html->url('/questions/reuse_preview/'.$exam_id.'/page:'.$prevpage); ?>" class="btn btn-success btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: left; margin-right: 5px;">
			Previous
		</a>
		<?php endif; ?>


		<?php if ($this->Paginator->request->params['paging']['Question']['nextPage']): ?>
		<?php $nextpage = $this->Paginator->request->params['paging']['Question']['page'] + 1; ?>
		<a href="<?php echo $this->Html->url('/questions/reuse_preview/'.$exam_id.'/page:'.$nextpage); ?>" class="btn btn-success btn-sm" role="button" data-toggle="modal" data-target="#myModalQuestion"  style="float: right;">
			Next
		</a>
		<?php endif; ?>
	</div>
<?php endif; ?>
<?php #echo $this->Form->end(); ?>