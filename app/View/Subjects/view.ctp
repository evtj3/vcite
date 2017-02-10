
<div class="subjects view">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to main page">
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
                                        <a href="#" onclick="scrollTo('StudentBox');"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Students and Assessments</a>
                                </li>
                                <!--
                                <li>
                                        <a href="#" onclick="scrollTo('AssessmentBox');"><span class="glyphicon glyphicon-tasks"></span>&nbsp;&nbsp;&nbsp;Assessments</a>
                                </li>
                                -->
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Current Section Enrolled</div>
						<div class="panel-body">
							<div class="nav nav-pills nav-stacked">
                                <div style="padding:10px;">
                                <?php foreach($section as $st):?>
                                	<?php echo ' <div class="currSection"> '.$st['Student']['section'].' </div> ';?>
                            	<?php endforeach;?>
                            	</div>
                            	<div class="removeBtn">
	                            	<form method="POST" action="<?php echo $this->Html->url(array('controller' => 'Subjects','action' => 'deletecurrentenrolled'));?>">

	                            		<input type="hidden" name="currsections" value="<?php echo $strtmpst2;?>"/>
		                            	<p><input type="submit" name="removeenrolledst" value="Remove all" class="btn btn-default">
											</p>
									</form>
                            	</div>
							</div>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
			<?php /* create a temporary account for 1st tri
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">1st Tri Students
						<a id="updatebtn" href="<?php echo $this->Html->url(array('controller'=>'subjects','action'=>'view','?'=> array('sections'=>'checked')));?>" style="color:#fff; float: right;cursor:pointer;">
										<span class="glyphicon glyphicon-plus"></span>
									</a>
					</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
                                <li style="border:solid 1px #EEEEEE;"><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Create a 1st TRI account'), array('controller' => 'students', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
							<p style="font-style:italic; font-size:10px; padding:10px;">This are the temporary accounts that are created for 1st Tri Students<br/><font style="color:red;">Note: Please check first the Student's Database if it's updated</font></p>
							<ul class="nav nav-pills nav-stacked">
								<li style="padding:10px;">
                               
                                <?php foreach($tempst_section as $tempst):?>
                                	<?php echo ' | '.$tempst['Tempstudent']['section'].' | ';?>
                                	
                            	<?php endforeach;?>
                            	<form method="POST" action="<?php echo $this->Html->url(array('controller' => 'Subjects','action' => 'deletetempst'));?>">
                            	<input type="hidden" name="sections" value="<?php echo $strtmpst;?>"/>
	                            	<p style="float: right;"><input type="submit" name="removetempst" value="Remove all" class="btn btn-default">
										</p>
								</form>
                            	</li>
							</ul>
							
							<?php if(!empty($this->params['url']['sections']) && !empty($sect_batch_array)):?>
							<hr>
							<?php echo $this->Form->create('Subject', array('id' => 'myform','role' => 'form','action' => 'view'
																								)); ?>
							<div style="padding:10px;">
							<?php echo '<p style="text-align:right; font-size:12px;font-style:italic;"><input type="submit" class="btn btn-default" name="tempStBtn" value="Enroll"/></p>';?>
							<ul class="SectionsData">
								<li>Sections
									
								</li>
							</ul>
							
							<ul class="SectionsData">
								<?php 
								$counte_tempst = 0;
								?>
								<?php foreach($sect_batch_array as $tempst):?>
								<?php 

									$counte_tempst++;
								?>
								<li><?php echo $tempst['Tempstudent']['section'];?>
									
										<?php echo '<input type="checkbox" name="data[Section_checkbox2]['.$counte_tempst.']" value="'.$tempst['Tempstudent']['section'].'-'.$tempst['Tempstudent']['batch'].'-'.$this->Session->read('Subject.id').'"/>';?>
										
										<font style="padding-left:10px; padding-right: 10px; float:right;">|</font>
										<p style="float:right; color:#999999; font-size:14px;" ><span class="glyphicon glyphicon-user"></span> check students</p>
									
									
									<?php 
									$sec = $tempst['Tempstudent']['section'];

									if($sec == '1E'){
										echo '<ul class="SectionsData">
											<li style="text-align:right; color:#999999; font-size:12px; font-style:italic; padding:5px;">'.'Information Technology'.'</li>
										</ul>
									';
									}else{
										echo '<ul class="SectionsData">
											<li style="text-align:right; color:#999999; font-size:12px; font-style:italic; padding:5px;">'.'Electromechanical Technology'.'</li>
										</ul>
									';
									}

									?>
								</li>
								<?php endforeach;?>
							</ul>
							<?php echo $this->Form->end;?>
							
							</div>
							<?php endif;?>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
			*/
			?>
			<div class="actions" id="listOfStudents" style="display:none;">
					<div class="panel panel-default">
						<div class="panel-heading">
							Section <?php 
								if(!empty($this->params['url']['section']))
								echo $this->params['url']['section'];
							?>
							- Batch 
							<?php
								if(!empty($this->params['url']['batch']))
								echo $this->params['url']['batch'];
							#pr($this->params['url']);
							?>
							
						</div>
						<div class="panel-body">
							<div style="width:95%; margin:0 auto;">
									<br class="clear-all"/>	

										
									<div id="jsonDataStudents">
										<p id="invitemsgStudents" style="font-size:12px; padding-left:30px; font-style:italic;">
										</p>
										
									</div>

								<br class="clear-all"/>	
							</div>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>
				
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Student's Database
							<?php if(empty($this->params['url']['sections'])):?>
									
									<a id="updatebtn" href="<?php echo $this->Html->url(array('controller'=>'subjects','action'=>'view','?'=> array('sections'=>'checked')));?>" style="color:#fff; float: right;cursor:pointer;">
										<span class="glyphicon glyphicon-plus"></span>
									</a>
									 <!--
									<a id="updatebtn" href="#" style="color:#fff; float: right;cursor:pointer;">
										<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;
									</a>
									-->
							<?php else:?>
							<p id="displayJsonHTML" style="color:#fff; float: right; cursor:pointer;">
								hide
							</p>

							<?php endif;?>
							

					</div>
						<div class="panel-body">
							
                               
									<div style="width:95%; margin:0 auto;">
										<br class="clear-all"/>	

										

										<?php #pr($this->data);?>
										
										<div id="jsonData">
												<?php echo $this->Form->create('Subjects',array('role' =>'form', 'action' => 'view'));?>
												
												<?php 
													#if(empty($this->params['url']))
														echo $inviteStudents;
													if(!empty($parseJson)){
														#echo $inviteStudents;
														echo '
															<ul class="SectionsData">
																<li>Sections
																	
																</li>
																<li id="courseCheckbox">
																	
																		<label for="checkedAllIT">IT
																		<input type="checkbox" id="checkedAllIT" name="checkedAllIT"/></label>
																		<label for="checkedAllEM">EM
																		<input type="checkbox" id="checkedAllEM" name="checkedAllEM"/></label>
																	
																</li>
															</ul>

															<ul class="SectionsData" id="sectionsCheckbox">
														';
														$counter = 0;
														foreach($parseJson as $pj){
															$sec = $pj['ClassAdvisory']['advisory_class'];
															#pr($pj);
															if($sec == '1E' || $sec == '2E' || $sec == '3E' || $sec == '4E' || $sec == '5E' || $sec == '6E' || $sec == '7E' || $sec == '8E' || $sec == '9E'){
																echo '<li class="sectionIT">';
															}else{
																echo '<li class="sectionEM">';
															}
															echo ''.$pj['ClassAdvisory']['advisory_class'];
															
															echo '<input type="checkbox" name="data[Section_checkbox]['.$counter.']" value="'.$pj['ClassAdvisory']['section_id'].'-'.$pj['ClassAdvisory']['batch_id'].'-'.$pj['ClassAdvisory']['advisory_class'].'"/>';
															echo '<font style="padding-left:10px; padding-right: 10px; float:right;">|</font>';
															echo '<a href="'.$this->Html->url(array('controller' => 'subjects', 'action'=>'view?sid='.$pj['ClassAdvisory']['section_id'].'&batch='.$pj['ClassAdvisory']['batch_id'].'&section='.$pj['ClassAdvisory']['advisory_class'])).'" style="float:right; font-size:14px;" ><span class="glyphicon glyphicon-user"></span> check students</a>';
															
																

																if($sec == '1E' || $sec == '2E' || $sec == '3E' || $sec == '4E' || $sec == '5E' || $sec == '6E' || $sec == '7E' || $sec == '8E' || $sec == '9E'){
																	echo '<ul class="SectionsData">
																		<li style="text-align:right; color:#999999; font-size:12px; font-style:italic; padding:5px;">'.'Information Technology'.'</li>
																	</ul>
																';
																}else{
																	echo '<ul class="SectionsData">
																		<li style="text-align:right; color:#999999; font-size:12px; font-style:italic; padding:5px;">'.'Electromechanical Technology'.'</li>
																	</ul>
																';
																}
															echo '</li>';
															$counter += 1;
														}
														echo '</ul>';
													}
												?>
										
												<?php 
													if(!empty($this->params['url']['sid']) && !empty($this->params['url']['batch']) && !empty($this->params['url']['section'])){
														echo '<p style="font-size:12px; margin-bottom:30px; font-style:italic;">Total Sections Students: '.$limitDataSt.'<input style="float:right;" type="submit" class="btn btn-default" name="studentsBtn" value="Enroll"/></p>';
														
														echo '
															<ul class="SectionsData">
																<li>Sections '.$this->params['url']['section'].'
																	<ul>
																		<li style="text-align:right;">
																		';
																	$sec = $this->params['url']['section'];
																	if($sec == '2E' || $sec == '3E' || $sec == '4E' || $sec == '5E' || $sec == '6E' || $sec == '7E' || $sec == '8E' || $sec == '9E'){
																	echo '
																		<font style="font-size:12px; ">Information Technology</font>
																	';
																}else{
																	echo '
																		<font style="font-size:12px; ">Electromechanical Technology</font>
																	';
																}
														echo '	
																	</li>
																	</ul>	
																</Eli>
															</ul>

															<ol class="SectionsData">
														';
														$counter = 0;

														foreach($parseJsonst as $pjst){
															//pr($pjst);
															echo '<li style="list-style:decimal; font-size:12px; margin-left:-20px;">';
															echo $pjst['Student']['pd_fname'].' '.$pjst['Student']['pd_lname'].' '.$pjst['Student']['pd_ext'];
															
															echo '<input type="checkbox" name="data[Student_checkbox]['.$counter.']" value="'.$pjst['Student']['id'].'!'.$pjst['Student']['student_id'].'!'.$pjst['Student']['pd_fname'].'!'.$pjst['Student']['pd_lname'].'!'.$pjst['Student']['pd_ext'].'!'.$this->params['url']['section'].'"/>';
															echo '<font style="padding-left:10px; padding-right: 10px; float:right;">|</font>';
															#echo '<a href="'.$this->Html->url(array('controller' => 'subjects', 'action'=>'view?sid='.$pjst['ClassAdvisory']['section_id'].'&batch='.$pjst['ClassAdvisory']['batch_id'].'&section='.$pjst['ClassAdvisory']['advisory_class'])).'" style="float:right; font-size:14px;" ><span class="glyphicon glyphicon-user"></span> check students</a>';
																/*
																echo '<ul class="SectionsData">
																		<li style="text-align:right; color:#999999; font-size:12px; font-style:italic; padding:5px;">Batch '.$pjst['ClassAdvisory']['batch_id'].'</li>
																	</ul>
																';*/
															echo '</li>';
															$counter += 1;
														}
														echo '</ol>';
														
													}
													
												?>
												<?php echo $this->Form->end;?>

										</div>
										
										
										<br class="clear-all"/>	
									</div>
							
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
			
		</div><!-- end col md 3 -->

		<div class="col-md-9">
				
				<div class="actions" id="DescriptionBox">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo h($subject['Subject']['title']); ?>
							<?php if(!$isMobile):?>
							<div id="dropmenu" class="btn-group" style="float: right; top: -6px; right: -10px;">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									
									
									<li><a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'remove', $subject['Subject']['id'])); ?>" style="color: #FF6141;"><span class="glyphicon glyphicon-trash"></span>&nbsp;Remove</a></li>
									<!--<li><a href="#" style="color: #5E53C7;"><span class="glyphicon glyphicon-save"></span>&nbsp;Archive</a></li>-->
									
								</ul>
							</div>
							<?php endif;?>
							<span class="date_created"><?php echo h($subject['Subject']['created']); ?></span>
						</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li class="box-description no-border">
                                    <?php if (!empty($subject['Subject']['description'])): ?>
                                        <span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;
                                        <?php echo h($subject['Subject']['description']); ?>
                                    <?php else: ?>
                                        <span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;
                                        <a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'edit', $subject['Subject']['id'])); ?>" class="btn-regular">
                                            <em>Put description here.</em>
                                        </a>
                                    <?php endif; ?>
								</li>
							</ul>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>

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
                                        <?php $chapter_counter = 1; ?>
										<?php foreach ($outline as $chapter): ?>
											<li class="list-group-item no-border">
												<?php 
												$chapter_title = "Chapter ".$chapter_counter.": ".$chapter['Chapter']['title'];
												$quizAvailable = '<span class="badge">quiz</span> ';
												?>

												<a href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'view', $this->Detergent->urlsafe_b64encode($chapter['Chapter']['id']."|".$chapter_title))); ?>">
													<?php 
													echo $chapter_title;

														foreach($quzzesArr as $quizCheck){
															#pr($quizCheck);
															if($quizCheck['Quizzes']['topic_id'] == $chapter['Chapter']['id'])
															echo ' '.$quizAvailable;
														}
													?>
                                                </a>
                                                <?php $outline_map[] = $this->Detergent->urlsafe_b64encode($chapter['Chapter']['id']."|".$chapter_title); ?>
											</li>

											<?php $lesson_counter = 1; ?>
											<?php foreach ($chapter['Lessons'] as $lessons): ?>
												<li class="list-group-item no-border" style="padding-left: 15px;">
													<?php 
													$lesson_title = "Lesson ".$chapter_counter.".".$lesson_counter.": ".$lessons['Topic']['title'];
													?>


                                                    <a href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'view', $this->Detergent->urlsafe_b64encode($lessons['Topic']['id']."|".$lesson_title))); ?>">
                                                        <span class="glyphicon glyphicon-chevron-right"></span>&nbsp;&nbsp;
                                                        <?php 
														echo $lesson_title;
														?>
                                                    </a>
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
											<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;
											<em>Please write your first topic for this subject.</em>
										</div>
									<?php endif; ?>

									<?php if(!$isMobile):?>
									<a href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'add')); ?>" class="btn btn-default btn-sm" role="button" style="float: right;">
										<span class="glyphicon glyphicon-plus"></span>
										Create New Topic
									</a>
									<?php endif;?>
									<br clear="all">
									
								</li>
							</ul>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>


				<div class="actions" style="display: none;">
					<div class="panel panel-default">
						<div class="panel-heading">
							Topics
							<div id="dropmenu" class="btn-group" style="float: right; top: -6px; right: -10px;">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li><a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'edit', $subject['Subject']['id'])); ?>" style="color: #12AD2B;"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edit</a></li>
									<li><a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'remove', $subject['Subject']['id'])); ?>" style="color: #FF6141;"><span class="glyphicon glyphicon-trash"></span>&nbsp;Remove</a></li>
								</ul>
							</div>
							<span style="float: right;"></span>
						</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li class="box-description">
									<div>
										<!--<span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;-->
										<em>Please write your first topic for this subject.</em>
									</div>
									<a href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'add')); ?>" class="btn btn-primary btn-sm" role="button" style="float: right;">
										Go Inside
										<span class="glyphicon glyphicon-arrow-right"></span>
									</a>
									<br clear="all">
								</li>
							</ul>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>


				<div class="actions" id="StudentBox">
					<div class="panel panel-default">
						<div class="panel-heading">
							Students and Assessments Progress
						</div>
						<div style="width:95%; margin:0 auto;text-align:right; padding:5px 10px 5px 5px;">
							<?php
							#pr($this->data);
								echo $this->Form->create();
								echo '<input type="text" name="searcher" style="width:100%; font-style:italic; text-align:left; padding:5px;" placeholder="search a student here"/>';
								#echo $this->Form->submit();
								echo $this->Form->end();
							?>
						</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li class="box-description">
                                    <?php if (!empty($students)): ?>
                                        <div style="padding-bottom: 10px; padding-left: 3px;">List of student with overall progress - <font style="font-size:12px;color:#fff; "><?php echo '<span style="background-color:#77CBDE; padding:4px 8px 4px 8px;
											border-radius: 10px 10px 10px 10px;
											-moz-border-radius: 10px 10px 10px 10px;
											-webkit-border-radius: 10px 10px 10px 10px;
										">'.$studentsCount.'</span>';?></font>
											
											
										
									</div>
                                        <ul class="list-group">
                                        	<?php 
                                        		
                                        		$countSt = 0;
										    	
                                        	?>
                                        	
                                            <?php foreach ($students as $student): ?>
                                                <?php 
                                                		$countSt += 1;
                                                		#pr($student);
	                                                			 //progress
                                                				$totalTopTakenArr = array();
                                                				$totalQuizTakenArr = array();
                                                				$counter = 0;
                                                				#pr($student['Student']['id']);
                                                				#pr($this->Session->read('Subject.id'));
                                                				$totalctt = array();
																
		                                                		foreach($readpageData as $rpd){
		                                                			
			                                        				if($student['Student']['id'] === $rpd['Readpage']['student_id'] && $this->Session->read('Subject.id') === $rpd['Readpage']['subject_id']){
			                                        					$counter += 1;
			                                        					$totalTopTakenArr['total'] = $rpd['Readpage']['page_read'];
			                                        					$totalTopTakenArr['total_page'] = $rpd['Readpage']['total_page'];
			                                        					#echo '<br>'.$student['Student']['fname'].' -TotalTakenPages- '.$totalTopTakenArr['total'];
			                                        					#echo '<br>'.$student['Student']['fname'].' -TotalPages- '.$totalTopTakenArr['total_page'];
			                                        					array_push($totalctt,$totalTopTakenArr['total']);
			                                        				}
			                                        			#pr($student['Student']['id']);
			                                        			}
			                                        			#pr($totalTopTakenArr);

			                                        			$currTopTaken = 0;
			                                        			$totalTopics = 0;
															    if(!empty($totalTopTakenArr)){
															  		 $currTopTaken = array_sum($totalctt);
														    		 $totalTopics = $totalTopTakenArr['total_page'];
														    	}

														    	$current_topic_taken = $currTopTaken;
														        $total_topic = $totalTopics;
														        
														        $average_topic_taken = 0;
																if($current_topic_taken != 0)
																$average_topic_taken = ($current_topic_taken / $total_topic) * 100;
																
																
                                                				#$counter2 = 0;
																$totalst = array();
																$totalqst = array();
																foreach($quizresultData as $qrd){
																	if($qrd['Quizresult']['student_id'] === $student['Student']['id'] && $this->Session->read('Subject.id') === $qrd['Quizresult']['subject_id']){
																		$totalQuizTakenArr['score'] = $qrd['Quizresult']['score'];
			                                        					$totalQuizTakenArr['total_score'] = $qrd['Quizresult']['total_score'];
			                                        					#echo '<br>'.$student['Student']['fname'].' -TotalTakenScores- '.$totalQuizTakenArr['score'];
			                                        					#echo '<br>'.$student['Student']['fname'].' -TotalScores- '.$totalQuizTakenArr['total_score'];
																		array_push($totalst,$totalQuizTakenArr['score']);
																		array_push($totalqst,$totalQuizTakenArr['total_score']);
																	}
																	#pr($qrd);
																}

																
														    	$currQuizTaken = 0;
														    	$totalQuiz = 0;
														    	if(!empty($totalQuizTakenArr)){
														    		$currQuizTaken = array_sum($totalst);
														    		$totalQuiz = array_sum($totalqst);
														    	}
														    	
														    	$current_quiz_taken = $currQuizTaken;
														        $total_quiz = $totalQuiz;
																
																$average_quiz_taken = 0;
																if($current_quiz_taken != 0)
														       	$average_quiz_taken = ($current_quiz_taken / $total_quiz)*100;
														    	
														    	$average = 0;
														    	if($current_quiz_taken != 0 || $average_topic_taken != 0)
														        $average = ($average_topic_taken + $average_quiz_taken);
																
														        $totalProgress = 0;

														        
														        if($average != 0)
														       	 $totalProgress = $average / 2;
														        
														      // echo $totalProgress;
														       #pr($student);
                                                		?>
	                                                 <?php ?>
	                                                
	                                                			<li class="list-group-item" >
			                                                        <?php $completed = number_format($totalProgress, 2, '.', '');
			                                                        	$name = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower(h($student['Student']['fname'].' '.$student['Student']['lname'].' '.$student['Student']['ext'])))));
			                                                        ?>
			                                                        <span class="badge"><?php echo $completed; ?>% completed</span> 
			                                                        <h5><?php echo $name; ?> - <?php echo $student['Student']['section'];?></h5>
			                                                        <div class="progress">
			                                                                <div class="progress-bar progress-bar-info animProg<?php echo $countSt;?>" role="progressbar" aria-valuenow="<?php echo $completed; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo 0; ?>%">
			                                                                        <span class="sr-only"><?php echo $completed; ?>% Complete</span>
			                                                                </div>
			                                                        </div>
			                                                    </li>
	                                                        
                                                <script>
	                                            	$('.animProg<?php echo $countSt;?>').animate({width:"<?php echo $completed;?>%"});
	                                            </script>

                                            <?php endforeach; ?>
                                           
                                        </ul>
                                        
                                    <?php else: ?>
                                        <?php if(!empty($this->data['searcher'])):?>
                                        <div style="float: left; padding-top: 4px;" ><em>Sorry, cannot find the student this student named: <strong><?php echo $this->data['searcher'];?></strong></em></div>
                                    	<?php else:?>
                                        <div style="float: left; padding-top: 4px;" ><em>You currently have no student for this subject. Would you like to enroll someone?</em></div>
										<?php endif;?>
									<?php endif; ?>
                                                                            
									<br clear="all">

								</li>
							</ul>
							<div style="text-align:center; padding-right:5px;">
									<!--<p>
										<small><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></small>
									</p>
									-->
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
							</div>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>

				<?php echo $this->Form->create('Subject', array('id' => 'myform','role' => 'form','action' => 'view'
																								)); ?>
				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Section <?php
								if(!empty($this->params['url']['section']) && !empty($this->params['url']['id']) && !empty($this->params['url']['batch']))
									echo $this->params['url']['section'];
								 ?>
								</h4>
							</div>
							<div class="modal-body" style="padding: 0 !important;">
								<br class="clear-all"/>	
								<h3>&nbsp;&nbsp;&nbsp;&nbsp;List of Students:</h3>
								<div style="width:70%; margin:0 auto;">
										
										<br class="clear-all"/>	

											
										<div id="SectionsAndStudents">
											<?php echo pr($listOfStudentsArr); ?>
										</div>


									<br class="clear-all"/>	
								</div>
								
							</div>
							<div class="modal-footer" style="margin: 0 !important;">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" name="submit" value="submit" class="btn btn-primary">Save changes</button>
							</div>
							
						</div>
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
		</div><!-- end col md 9 -->

	</div>
</div>

<?php if(!$isMobile):?>
<!-- notifications -->
<?php //pr($parseJson);
	
	//pr($notifs);
	$countNotif = count($notifs);
	$countNotifread = count($notifs_read);

?>

<div class="listNotifs" style="display:none; cursor:pointer;">
	<span style="float:right; color:#256D7D;" class="glyphicon glyphicon-remove"></span>
	<h4 style="color:#3DB5D0;">Notifications</h4>
	
	<hr><a href="<?php echo $this->Html->url(array('controller' => 'notifications','action' => 'unread'));?>"><h8 style="padding:5px;">see all unread - <?php echo $countNotif;?></h8></a></hr>
	<ul class="sqm">
		<?php $countNotis = 0;?>
		<?php foreach($notifs as $n):?>
		<?php $countNotis++;?>
		<?php if($countNotis <= 3):?>
		<a href="<?php echo $this->Html->url(array('controller' => 'notifications','action'=>'notifs',$n['Notification']['id']));?>"><li class="notifDes"><span class="glyphicon glyphicon-user"></span> <?php 
		$limitStr = 23;
		$strContent = $n['Notification']['sender'];
		$list = '';
		
		$list = substr($strContent,0,$limitStr);
		if(strlen($n['Notification']['sender']) <= $limitStr){
		echo $list;}
		else{
		echo $list.'...';}
		?>
		<span style="font-size:18px; float:right;"class="glyphicon glyphicon-question-sign"></span></li>
		</a>
		<?php endif;?>
		<?php endforeach;?>
		<hr><a href="<?php echo $this->Html->url(array('controller' => 'notifications','action' => 'read'));?>"><h8 style="padding:5px;">see all read - <?php echo $countNotifread;?></h8></a></hr>
		<?php $countNotisread = 0;?>
		<?php foreach($notifs_read as $n):?>
		<?php $countNotis++;?>
		<?php if($countNotisread <= 3):?>
		<a href="<?php echo $this->Html->url(array('controller' => 'notifications','action'=>'notifs',$n['Notification']['id']));?>"><li class="notifDes notifDesRead"><span class="glyphicon glyphicon-user"></span> 
			<?php $limitStr = 23;
		$strContent = $n['Notification']['sender'];
		$list = '';
		
		$list = substr($strContent,0,$limitStr);
		if(strlen($n['Notification']['sender']) <= $limitStr){
		echo $list;}
		else{
		echo $list.'...';}
		?>
			<span style="font-size:18px; float:right;"class="glyphicon glyphicon-ok-circle"></span></li>
		</a>
		<?php endif;?>
		<?php endforeach;?>
	</ul>
</div>

<div id="quickMenu">
  
  <ul>
    <a href="#" id="privateMsg"><li>
      <span class="glyphicon glyphicon-comment"></span>
        <font class="qmnotif-count">0</font>
    </li></a>
     <a href="#" id="notif">
     	<?php if($countNotif != 0):?>
     	<li style="background-color:#3DB5D0;">
     	<?php else:?>

     	<li style="">
     	<?php endif;?>
     	
      <span class="glyphicon glyphicon-globe"></span>
        <font class="qmnotif-count"><?php echo $countNotif;?></font>
    </li></a>
  </ul>

</div>
<script>
	$('#notif').click(function(){
		$('.listNotifs').fadeIn(500);
	});
	$('.listNotifs').click(function(){
		$('.listNotifs').fadeOut(500);
	});

</script>
<!-- notifications -->
<?php endif;?>


<script>

var count = 1;
	$('#displayJsonHTML').click(function(){
		count += 1;
		if(count > 2)
			count = 1;

		if(count == 2){
			$('#displayJsonHTML').html('show');
			$('.SectionsData').fadeOut(500);
		}if(count == 1){
			$('#displayJsonHTML').html('hide');
			$('.SectionsData').slideToggle(500);
		}
		//$('#displayJsonHTML').html('');
	});
	$('#updatebtn').click(function(){
		$('#invitemsg').html('Please wait... Connecting to SIS database.');
	});
	function recon(){
		$('#invitemsgSt').html('Please wait... Reconnecting...');
	}



</script>
