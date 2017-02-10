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
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="checkbox" name="data[Answer][1]" value="1" /> a.)
					  </div>
					  <input type="text" required="" name="data[Option][1]" class="form-control" maxlength="100">
					</div>
				</li>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="checkbox" name="data[Answer][2]" value="1" /> b.)
					  </div>
					  <input type="text" required="" name="data[Option][2]" class="form-control" maxlength="100">
					</div>
				</li>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="checkbox" name="data[Answer][3]" value="1" /> c.)
					  </div>
					  <input type="text" required="" name="data[Option][3]" class="form-control" maxlength="100">
					</div>
				</li>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="checkbox" name="data[Answer][4]" value="1" /> d.)
					  </div>
					  <input type="text" required="" name="data[Option][4]" class="form-control" maxlength="100">
					</div>
				</li>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="checkbox" name="data[Answer][5]" value="1" /> e.)
					  </div>
					  <input type="text" name="data[Option][5]" class="form-control" placeholder="<optional>" maxlength="100">
					</div>
				</li>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="checkbox" name="data[Answer][6]" value="1" /> f.)
					  </div>
					  <input type="text" name="data[Option][6]" class="form-control" placeholder="<optional>" maxlength="100">
					</div>
				</li>
			</ul>
			<div style="padding-left: 10px;">
				Shuffle Choices <input type="checkbox" id="QuestionShuffle" name="data[Question][shuffle]" checked>
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
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="radio" name="data[Answer][correct]" value="1" required class="" /> a.)
					  </div>
					  <input type="text" required="" name="data[Option][1]" class="form-control" maxlength="100" value="True">
					</div>
				</li>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="radio" name="data[Answer][correct]" value="2" required class="" /> b.)
					  </div>
					  <input type="text" required="" name="data[Option][2]" class="form-control" maxlength="100" value="False">
					</div>
				</li>
			</ul>
			<div style="padding-left: 10px;">
				Shuffle Choices <input type="checkbox" id="QuestionShuffle" name="data[Question][shuffle]" checked>
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
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		a.)
							  	</div>
							  	<input type="text" required="" name="data[Alternate][1]" class="form-control" maxlength="100">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		b.)
							  	</div>
							  <input type="text" required="" name="data[Alternate][2]" class="form-control" maxlength="100">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		c.)
							  	</div>
							  	<input type="text" required="" name="data[Alternate][3]" class="form-control" maxlength="100">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		d.)
							  	</div>
							  <input type="text" required="" name="data[Alternate][4]" class="form-control" maxlength="100">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		e.)
							  	</div>
							  	<input type="text" name="data[Alternate][5]" class="form-control" maxlength="100" placeholder="Optional">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		f&nbsp;.)
							  	</div>
							  <input type="text" name="data[Alternate][6]" class="form-control" maxlength="100" placeholder="Optional">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		g.)
							  	</div>
							  	<input type="text" name="data[Alternate][7]" class="form-control" maxlength="100" placeholder="Optional">
							</div>
						</li>
					</ul>
				</div>
				<div class="col-md-6">
					<ul style="margin: 0; padding: 0 10px 0; list-style: none;">
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		A.)
							  	</div>
							  	<input type="text" required="" name="data[Option][1]" class="form-control" maxlength="100">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		B.)
							  	</div>
							  <input type="text" required="" name="data[Option][2]" class="form-control" maxlength="100">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		C.)
							  	</div>
							  	<input type="text" required="" name="data[Option][3]" class="form-control" maxlength="100">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		D.)
							  	</div>
							  <input type="text" required="" name="data[Option][4]" class="form-control" maxlength="100">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		E.)
							  	</div>
							  	<input type="text" placeholder="Optional / Distractor" name="data[Option][5]" class="form-control" maxlength="100">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		F.)
							  	</div>
							  <input type="text" placeholder="Optional / Distractor" name="data[Option][6]" class="form-control" maxlength="100">
							</div>
						</li>
						<li>
							<div style="margin-bottom: 15px;" class="input-group">
						  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
						      		G.)
							  	</div>
							  	<input type="text" placeholder="Optional / Distractor" name="data[Option][7]" class="form-control" maxlength="100">
							</div>
						</li>
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
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="radio" name="data[Answer][correct]" value="1" required class="" /> a.)
					  </div>
					  <input type="text" required="" name="data[Option][1]" class="form-control" maxlength="100">
					</div>
				</li>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="radio" name="data[Answer][correct]" value="2" required class="" /> b.)
					  </div>
					  <input type="text" required="" name="data[Option][2]" class="form-control" maxlength="100">
					</div>
				</li>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="radio" name="data[Answer][correct]" value="3" required class="" /> c.)
					  </div>
					  <input type="text" required="" name="data[Option][3]" class="form-control" maxlength="100">
					</div>
				</li>
				<li>
					<div style="margin-bottom: 15px;" class="input-group">
				  		<div class="input-group-btn" style="font-size: 14px !important; padding-right: 5px;">
				      		<input type="radio" name="data[Answer][correct]" value="4" required class="" /> d.)
					  </div>
					  <input type="text" required="" name="data[Option][4]" class="form-control" maxlength="100">
					</div>
				</li>
			</ul>
			<div style="padding-left: 10px;">
				Shuffle Choices <input type="checkbox" id="QuestionShuffle" name="data[Question][shuffle]" checked>
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

		CKEDITOR.instances['QuestionContent'].setData('Compose your question here ...');
	</script>













	
<?php echo $this->Form->end(); ?>