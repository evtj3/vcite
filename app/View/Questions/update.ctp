<?php
echo $this->Html->script('ckeditor/ckeditor');

#echo $type;
?>


<?php echo $this->Form->create('Question', array('role' => 'form')); ?>
<?php echo $this->Form->hidden('Type.question_type', array('value' => $type)); ?>



<?php if ($type=="Multiple Select"): ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Multiple Select</h4>
	</div>
	<div class="modal-body" style="padding: 0 !important;">
		<div class="form-group">
			<?php echo $this->Form->input('Question.content', array('class' => 'form-control ckeditor', 'placeholder' => 'Content', 'label' => false));?>
		</div>

		<div class="form-group">
			<ul style="margin: 0; padding: 0 10px 0; list-style: none;">
				<?php $small_l = "a"; ?>
				<?php foreach($this->request->data['Option'] as $option): ?>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="checkbox" name="data[Answer][<?php echo $option['id'] ?>]" value="1" <?php if($option['correct']) echo 'checked="checked"'?> /> <?php echo $small_l; ?>.)
					  </div>
					  <input type="text" required="" name="data[Option][<?php echo $option['id'] ?>]" class="form-control" maxlength="100" value="<?php echo $option['option'] ?>">
					</div>
				</li>
				<?php $small_l++; ?>
				<?php endforeach; ?>
			</ul>
			<div style="padding-left: 10px;">
				Shuffle Choices <input type="checkbox" id="QuestionShuffle" name="data[Question][shuffle]" <?php if ($this->request->data['Question']['shuffle']) echo 'checked'; ?>>
			</div>
		</div>
	</div>
	<div class="modal-footer" style="margin: 0 !important;">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>
<?php elseif ($type=="True or False"): ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">True or False</h4>
	</div>
	<div class="modal-body" style="padding: 0 !important;">
		<div class="form-group">
			<?php echo $this->Form->input('Question.content', array('class' => 'form-control ckeditor', 'placeholder' => 'Content', 'label' => false));?>
		</div>

		<div class="form-group">
			<ul style="margin: 0; padding: 0 10px 0; list-style: none;">
				<?php $small_l = "a"; ?>
				<?php foreach($this->request->data['Option'] as $option): ?>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="radio" name="data[Answer][correct]" value="<?php echo $option['id'] ?>" <?php if($option['correct']) echo 'checked="checked"'?> required /> <?php echo $small_l; ?>.)
					  </div>
					  <input type="text" required="" name="data[Option][<?php echo $option['id'] ?>]" class="form-control" maxlength="100" value="<?php echo $option['option'] ?>">
					</div>
				</li>
				<?php $small_l++; ?>
				<?php endforeach; ?>
			</ul>
			<div style="padding-left: 10px;">
				Shuffle Choices <input type="checkbox" id="QuestionShuffle" name="data[Question][shuffle]" <?php if ($this->request->data['Question']['shuffle']) echo 'checked'; ?>>
			</div>
		</div>
	</div>
	<div class="modal-footer" style="margin: 0 !important;">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>
<?php elseif ($type=="Matching Type"): ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Matching Type</h4>
	</div>
	<div class="modal-body" style="padding: 0 !important;">
		<div class="form-group">
			<?php echo $this->Form->input('Question.content', array('class' => 'form-control ckeditor', 'placeholder' => 'Content', 'label' => false));?>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<ul style="margin: 0; padding: 0 10px 0; list-style: none;">
						<?php $small_l = "a"; ?>
						<?php foreach($this->request->data['Option'] as $option): ?>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		<?php echo $small_l; ?>.)
							  	</div>
							  	<input type="text" required="" name="data[Alternate][<?php echo $option['id'] ?>]" class="form-control" maxlength="100" value="<?php echo $option['alternate_option'] ?>">
							</div>
						</li>
						<?php $small_l++; ?>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="col-md-6">
					<ul style="margin: 0; padding: 0 10px 0; list-style: none;">
						<?php $big_l = "A"; ?>
						<?php foreach($this->request->data['Option'] as $option): ?>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		<?php echo $big_l; ?>.)
							  	</div>
							  	<input type="text" required="" name="data[Option][<?php echo $option['id'] ?>]" class="form-control" maxlength="100" value="<?php echo $option['option'] ?>">
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
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>	
<?php else: ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Single Choice</h4>
	</div>
	<div class="modal-body" style="padding: 0 !important;">
		<div class="form-group">
			<?php echo $this->Form->input('Question.content', array('class' => 'form-control ckeditor', 'placeholder' => 'Content', 'label' => false));?>
		</div>

		<div class="form-group">
			<ul style="margin: 0; padding: 0 10px 0; list-style: none;">
				<?php $small_l = "a"; ?>
				<?php foreach($this->request->data['Option'] as $option): ?>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="radio" name="data[Answer][correct]" value="<?php echo $option['id'] ?>" <?php if($option['correct']) echo 'checked="checked"'?> required /> <?php echo $small_l; ?>.)
					  </div>
					  <input type="text" required="" name="data[Option][<?php echo $option['id'] ?>]" class="form-control" maxlength="100" value="<?php echo $option['option'] ?>">
					</div>
				</li>
				<?php $small_l++; ?>
				<?php endforeach; ?>
			</ul>
			<div style="padding-left: 10px;">
				Shuffle Choices <input type="checkbox" id="QuestionShuffle" name="data[Question][shuffle]" <?php if ($this->request->data['Question']['shuffle']) echo 'checked'; ?>>
			</div>
		</div>
	</div>
	<div class="modal-footer" style="margin: 0 !important;">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>
<?php endif; ?>

	<script>
		$.fn.bootstrapSwitch.defaults.size = 'normal';
		$("[id='QuestionShuffle']").bootstrapSwitch();
		
		CKEDITOR.replace( 'QuestionContent', {
			toolbar: [
				{ name: 'document', items: [ 'NewPage'] },	
				[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ], 
				{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
				{ name: 'insert', items : [ 'Video','Pdf','Image','FileBrowser','Flash','Table','HorizontalRule','SpecialChar' ] }
			],
			height: '100px',
			label : 'This checkbox is selected by default'
		});
	</script>
<?php echo $this->Form->end(); ?>