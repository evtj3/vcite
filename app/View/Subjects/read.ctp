
<div class="subjects view">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard">
					<span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active"><?php echo __($this->Session->read('Subject.title')); ?></li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Contents</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;Main Page'), array('controller' => 'teachers', 'action' => 'dashboard'), array('escape' => false)); ?> </li>
                                <li>
                                        <a href="#" onclick="scrollTo('DescriptionBox');"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;&nbsp;Description</a>
                                </li>
                                <li>
                                        <a href="#" onclick="scrollTo('OutlineBox');"><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;&nbsp;Outline</a>
                                </li>
                                <li>
                                        <a href="#" onclick="scrollTo('AssessmentBox');"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Progress</a>
                                </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
			
		</div><!-- end col md 3 -->


		<div class="col-md-9">
				<div class="actions" id="DescriptionBox">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo h($subject['Subject']['title']); ?>
							<span style="float: right;"><?php echo h($subject['Subject']['created']); ?></span>
						</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li class="box-description no-border">
                                    <?php if (!empty($subject['Subject']['description'])): ?>
                                        <span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;
                                        <?php echo h($subject['Subject']['description']); ?>
                                    <?php endif; ?>
								</li>
							</ul>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>

<!-- start - list of chapters - lessons-->
				<div class="actions" id="OutlineBox">
					<div class="panel panel-default">
						<div class="panel-heading">
							Outline
						</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li class="box-description">
									<?php if (!empty($outline)): ?>
										<ul class="list-group">
										<?php $outline_map = array(); ?>
                                        <?php $chapter_counter = 1;
                                        	  
                                         	  
                                        	 #$checkID = '';
                                        #pr($readpageDataCheck);
                                        $updateLastReadTopic = '<font style="color:red; font-size:10px; padding:5px; ">you currently left here.</font>';
                                        $quizAvailable = '<span class="badge">quiz</span> ';
                                         ?>
										<?php foreach ($outline as $chapter): ?>
											<li class="list-group-item no-border">
												<?php 
													#pr($outline);
												$chapter_title = "Chapter ".$chapter_counter.": ".$chapter['Chapter']['title'];
												$chapter_check = '';
												#pr($readpageDataCheck);
												?>
													
													
														<?php 													
														
														#$chapter_check = '';
														if(!empty($outline[0]['Chapter']['id'])){
															if($outline[0]['Chapter']['id'] == $chapter['Chapter']['id'])
															$chapter_check = '<a href="#" data-toggle="modal" data-target="#readAccept">'.$chapter_title;
															/*else
															$chapter_check = '<a href="'.$this->Html->url(array('controller' => 'topics', 'action' => 'read', $this->Detergent->urlsafe_b64encode($chapter['Chapter']['id']."|".$chapter_title))).'">
	                                                        <span class="glyphicon glyphicon-chevron-right"></span>&nbsp;&nbsp;'.$chapter_title;
															*/													
														}
														/*
														if(!empty($readpageDataCheck[]))
															$chapter_check = '<a href="'.$this->Html->url(array('controller' => 'topics', 'action' => 'read', $this->Detergent->urlsafe_b64encode($chapter['Chapter']['id']."|".$chapter_title))).'">
	                                                        '.$chapter_title;
														*/

	                                                     $totalRPDC = count($readpageDataCheck);
                                                       	for($i=0;$i< $totalRPDC;$i++){
                                                       		#pr($readpageDataCheck[$i]);
                                                       		if($readpageDataCheck[$i]['Readpage']['topic_id'] == $chapter['Chapter']['id'])
                                                       			$chapter_check = '<a href="'.$this->Html->url(array('controller' => 'topics', 'action' => 'read', $this->Detergent->urlsafe_b64encode($chapter['Chapter']['id']."|".$chapter_title))).'">
                                                        '.$chapter_title;
															
															}

														echo $chapter_check;
														
														if(empty($chapter_check))
	                                                    	echo $chapter_check = '<a style="color:#000;">'.$chapter_title;
														
														$disdata = '';
														foreach($readpageDataCheck as $rdc){
															$TI = '<span style="color:green;" class="glyphicon glyphicon-ok"></span> ';
															$checkID = $chapter['Chapter']['id'];
															$timeFinishedRead = '<span class="badge">'.$rdc['Readpage']['time_finished_read'].'</span> ';
															if($checkID != $rdc['Readpage']['topic_id']){
																$TI = '';
																$timeFinishedRead = '';
															}

															$disdata = ' '.$TI.' '.$timeFinishedRead;
															
															if($chapter['Chapter']['id'] == $rdc['Readpage']['topic_id'])
															echo $disdata;
															else
															echo $disdata;
														
														}


														foreach($quizesArr as $quizCheck){
															#pr($quizCheck);
															if($quizCheck['Quizzes']['topic_id'] == $chapter['Chapter']['id'])
															echo $quizAvailable;
															#pr($quizCheck);
														}
														
														echo '</a>';
														#pr($readpageDataCheck);
														/*
														$cd = count($readpageDataCheck);
														for($i=0;$i<$cd;$i++){
															if($checkLatestPageRead['Readpage']['time_finished_read'] == $readpageDataCheck[$i]['Readpage']['time_finished_read'])
															echo $updateLastReadTopic;
														}*/
														#if($rpdc['Readpage']['time_finished_read'] == $checkLatestPageRead['Readpage']['time_finished_read'])
														#	echo $updateLastReadTopic;
														#if($outline[0]['outline'] $checkLatestPageRead['Readpage']['time_finished_read'])
														
														?>
	                                              		
	                                            

	                                                <!-- modals for page next/prev button-->
					                                <?php echo $this->Form->create('subjects', array('role' => 'form',
					                                                                                'action' => 'read'
					                                                                                )); ?>
					                                  <!-- Modal -->
					                                  <div id="readAccept" class="modal fade" role="dialog">
					                                    <div class="modal-dialog">

					                                      <!-- Modal content-->
					                                      <div class="modal-content">
					                                        <div class="modal-header">
					                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
					                                          <h4 class="modal-title">You want to read this topic?</h4>
					                                        </div>
					                                        <div class="modal-body">
					                                          	
					                                         <p style="font-style:italic; font-size:22px;">"The more you <font style="font-size:28px; font-weight:bold; color:#489384;">read</font></p>
					                                         <p style="font-style:italic; font-size:22px; padding-left:45px;">the more <font style="font-size:28px; font-weight:bold; color:#82C456;">things</font> you know.</p>
					                                         <p style="font-style:italic; font-size:22px; padding-left:85px;">The more that you <font style="font-size:28px; font-weight:bold; color:#E38C25;">learn</font></p>
					                                         <p style="font-style:italic; font-size:22px; padding-left:125px;">the more <font style="font-size:28px; font-weight:bold; color:#E22247;">places</font> you'll go."</p>
					                                         <p style="font-style:italic; font-size:16px; float:right;">- Dr. Seuss -</p>

					                                        <?php if(!empty($readpageData)):?>
					                                       	 <input type="hidden" name="data[Readpages][student_id]" value="<?php echo $readpageData['Readpages']['student_id']; ?>"/>
					                                          <input type="hidden" name="data[Readpages][topic_id]" value="<?php echo $readpageData['Readpages']['topic_id'] ?>"/>
					                                          <input type="hidden" name="data[Readpages][subject_id]" value="<?php echo $readpageData['Readpages']['subject_id'] ?>"/>
					                                          <input type="hidden" name="data[Readpages][page_read]" value="<?php echo $readpageData['Readpages']['page_read'];?>"/>
					                                          <input type="hidden" name="data[Readpages][total_page]" value="<?php echo $readpageData['Readpages']['total_page'];?>"/>
					                                          <input type="hidden" name="data[Readpages][time_finished_read]" value="<?php echo $readpageData['Readpages']['time_finished_read'];?>"/>
					                                           <input type="hidden" name="data[Readpages][hashID]" value="<?php echo $this->Detergent->urlsafe_b64encode($chapter['Chapter']['id']."|".$chapter_title);?>"/>
					                                        <?php endif;?>
					                                        </div>
					                                        <div class="modal-footer">
					                                          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

					                                              <input type="submit" value="Yes" name='confirm' class="btn btn-default" />
					                                         
					                                        </div>
					                                      </div>

					                                    </div>
					                                  </div>
					                                 <?php echo $this->Form->end() ?>

                                                <?php $outline_map[] = $this->Detergent->urlsafe_b64encode($chapter['Chapter']['id']."|".$chapter_title); ?>
											</li>

											<?php $lesson_counter = 1; 
													$lesson_check = '';
											?>

											<?php foreach ($chapter['Lessons'] as $lessons): ?>
												<li class="list-group-item no-border" style="padding-left: 15px;">
													<?php 
													$lesson_title = "Lesson ".$chapter_counter.".".$lesson_counter.": ".$lessons['Topic']['title'];
													?>


                                                    
                                                        <?php 
                                                    	$lesson_check = '';    
                                                        $totalRPDC = count($readpageDataCheck);
                                                       	for($i=0;$i< $totalRPDC;$i++){
                                                       		#pr($readpageDataCheck[$i]);
                                                       		if($readpageDataCheck[$i]['Readpage']['topic_id'] == $lessons['Topic']['id'])
                                                       			$lesson_check = '<a style="padding-left:15px" href="'.$this->Html->url(array('controller' => 'topics', 'action' => 'read', $this->Detergent->urlsafe_b64encode($lessons['Topic']['id']."|".$lesson_title))).'">
                                                        <span class="glyphicon glyphicon-chevron-right"></span>&nbsp;&nbsp;'.$lesson_title;
															
															}
                                                        
														$disdata = '';
														echo $lesson_check;
														if(empty($lesson_check))
                                                        	echo $lesson_check = '<a style="padding-left:15px;color:#000;" ><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;&nbsp;'.$lesson_title;

                                                        
                                                        foreach($readpageDataCheck as $rdc){
															$TI = '<span style="color:green;" class="glyphicon glyphicon-ok"></span>';
															$checkID = $lessons['Topic']['id'];
															$timeFinishedRead = '<span class="badge">'.$rdc['Readpage']['time_finished_read'].'</span>';
															if($checkID != $rdc['Readpage']['topic_id']){
																$TI = '';
																$timeFinishedRead = '';
															}

															$disdata = ' '.$TI.' '.$timeFinishedRead;
															if($lessons['Topic']['id'] == $rdc['Readpage']['topic_id'])
															echo $disdata;
															else
															echo $disdata;
														}
														
														echo '</a>';
														?>
                                                    
                                                    <?php $outline_map[] = $this->Detergent->urlsafe_b64encode($lessons['Topic']['id']."|".$lesson_title); ?>
												</li>
												<?php $lesson_counter++; ?>
											<?php endforeach; ?>

											<?php $chapter_counter++; ?>
										<?php endforeach; ?>

                                            <?php 
                                            $this->Session->put('Subject.outline', $this->Detergent->urlsafe_b64encode(serialize($outline_map))); 
                                            ?>
										</ul>
									<?php else: ?>
										<div>
											<span class="glyphicon glyphicon-file"></span><span class="glyphicon glyphicon-remove-circle"></span>&nbsp;&nbsp;
											<em>No topic available for now</em>
										</div>
									<?php endif; ?>

									
									<br clear="all">
									
								</li>
							</ul>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>
<!-- end - list of chapters - lessons-->
				<div class="actions" id="AssessmentBox">
					<div class="panel panel-default">
						<div class="panel-heading">
							Progress
						</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li class="box-description">
                                    
                                        <div style="padding-bottom: 10px; padding-left: 3px;"></div>
                                        <ul class="list-group">
                                            	<li class="list-group-item">
                                                        
                                                        <?php echo $subject['Subject']['title']; ?> <span class="badge"><?php echo $totalProgress; ?>% completed</span>
                                                        <div class="progress">
                                                                <div class="progress-bar progress-bar-info animProg" role="progressbar" aria-valuenow="<?php echo '40'; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo 0; ?>%">
                                                                        <span class="sr-only"><?php echo $totalProgress; ?>% Complete</span>
                                                                </div>
                                                        </div>
                                                        
                                                </li>
                                            
                                        </ul>

								</li>
							</ul>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>
				<script>
                	$('.animProg').animate({width:"<?php echo $totalProgress;?>%"});
                </script>



			

		</div><!-- end col md 9 -->

	</div>
</div>
<script>
	function scrollTo(id)
	{
	  $('html,body').animate({scrollTop: $("#"+id).offset().top - 55},'slow');
	}
</script>