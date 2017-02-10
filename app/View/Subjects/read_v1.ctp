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

                                        <?php 
											date_default_timezone_set('Asia/Manila');
											
											
											
											if(!empty($readpageDataCheck))
												$currentPageRead = count($readpageDataCheck);
											else
												$currentPageRead = 1;
											
											
											
											
											#$countChapter.' + ';
											#$countLessons.' = ';
											$totalTopics = $countChapter + $countLessons;

											$chapterCount = 0;
											$lessonsCount = 0;
											$topicsTotal = 0;
											#pr($readpageDataCheck);
											#pr($readpageDataCheck);
											#echo $readpageDataCheck[0]['Readpage']['page_read'];
										#pr($outline);
										?>
										
										<?php foreach ($outline as $chapter): ?>
											
											<?php 
												
												$chapter_title = "Chapter ".$chapter_counter.": ".$chapter['Chapter']['title'];
												$chapterCount += 1;
												
												$topicsTotal = $chapterCount;
												$TI = '';

												if(!empty($readpageDataCheck))
												pr($readpageDataCheck[$topicsTotal - 1]['Readpage']['time_finished_read']);
												$TI = '<span style="color:green;" class="glyphicon glyphicon-ok"></span> '.$readpageDataCheck[$topicsTotal - 1]['Readpage']['time_finished_read'];
												?>
												
												<li class="list-group-item no-border">

													<?php if(!empty($chapter['Lessons'])):?>
														<?php 
															if($chapterCount > 1){
																
																$topicTotal = (($chapterCount + $countLessons));
																$isEven = $topicTotal % 2;
																if($isEven == 1)
																	$topicTotal = $countLessons + 1;
																elseif($isEven == 0)
																	$topicTotal = $countLessons - 1;
																
																if(!empty($readpageDataCheck[$topicsTotal - 1]))
																$TI = '<span style="color:green;" class="glyphicon glyphicon-ok"></span> '.$readpageDataCheck[$topicsTotal - 1]['Readpage']['time_finished_read'];
															}
															else
															 	$topicTotal = $chapterCount;
														
																
														?>	

															<?php if($chapterCount == 1 && $currentPageRead == 1):?>
								                                <a href="#" data-toggle="modal" data-target="#readAccept">
																	<?php 
																	echo $chapter_title;
																	?>
				                                                </a>
				                                               	<?php echo $TI;?>
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
									                                          <h4 class="modal-title">Start reading now?</h4>
									                                        </div>
									                                        <div class="modal-body">
									                                          	
									                                         <p style="font-style:italic; font-size:22px;">"The more you <font style="font-size:28px; font-weight:bold; color:#489384;">read</font></p>
									                                         <p style="font-style:italic; font-size:22px; padding-left:45px;">the more <font style="font-size:28px; font-weight:bold; color:#82C456;">things</font> you know.</p>
									                                         <p style="font-style:italic; font-size:22px; padding-left:85px;">The more that you <font style="font-size:28px; font-weight:bold; color:#E38C25;">learn</font></p>
									                                         <p style="font-style:italic; font-size:22px; padding-left:125px;">the more <font style="font-size:28px; font-weight:bold; color:#E22247;">places</font> you'll go."</p>
									                                         <p style="font-style:italic; font-size:16px; float:right;">- Dr. Seuss -</p>
									                                        
									                                       	 <input type="hidden" name="data[Readpages][student_id]" value="<?php echo $readpageData['Readpages']['student_id']; ?>"/>
									                                          <input type="hidden" name="data[Readpages][topic_id]" value="<?php echo $readpageData['Readpages']['topic_id'] ?>"/>
									                                          <input type="hidden" name="data[Readpages][subject_id]" value="<?php echo $readpageData['Readpages']['subject_id'] ?>"/>
									                                          <input type="hidden" name="data[Readpages][page_read]" value="<?php echo $readpageData['Readpages']['page_read'];?>"/>
									                                          <input type="hidden" name="data[Readpages][total_page]" value="<?php echo $readpageData['Readpages']['total_page'];?>"/>
									                                          <input type="hidden" name="data[Readpages][time_finished_read]" value="<?php echo $readpageData['Readpages']['time_finished_read'];?>"/>
									                                        
									                                        </div>
									                                        <div class="modal-footer">
									                                          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

									                                              <input type="submit" value="Yes" name='confirm' class="btn btn-default" />
									                                         
									                                        </div>
									                                      </div>

									                                    </div>
									                                  </div>
									                                 <?php echo $this->Form->end() ?>

															<?php elseif($currentPageRead >= $topicTotal):?>
																
																<a href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'read', $this->Detergent->urlsafe_b64encode($chapter['Chapter']['id']."|".$chapter_title))); ?>">
																	<?php 
																	echo $chapter_title;
																	?>
				                                                </a>
				                                                <?php 

				                                                if(!empty($readpageDataCheck[$topicsTotal - 1]))
																$TI = '<span style="color:green;" class="glyphicon glyphicon-ok"></span> '.$readpageDataCheck[($topicTotal - 1)]['Readpage']['time_finished_read'];
															
				                                                ?>
				                                                <?php echo $TI;?>
			                                            	<?php else:?>
			                                            		<?php 
																echo $chapter_title;
																?>
			                                            	<?php endif;?>
														<?php elseif($currentPageRead >= $topicsTotal):?>
															<a href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'read', $this->Detergent->urlsafe_b64encode($chapter['Chapter']['id']."|".$chapter_title))); ?>">
																<?php 
																echo $chapter_title;
																?>
			                                                </a>
		                                               		<?php echo $TI;?>
		                                         		<?php else:?>
		                                         			<?php 
															echo $chapter_title;
															?>
		                                         		<?php endif;?>

	                                                <?php $outline_map[] = $this->Detergent->urlsafe_b64encode($chapter['Chapter']['id']."|".$chapter_title); ?>
												</li>

											<?php $lesson_counter = 1; ?>
											<?php foreach ($chapter['Lessons'] as $lessons): ?>
												
												<li class="list-group-item no-border" style="padding-left: 15px;">
												<?php 
												$lesson_title = "Lesson ".$chapter_counter.".".$lesson_counter.": ".$lessons['Topic']['title'];	
													$lessonsCount += 1;

													$topicsTotal = $chapterCount + $lessonsCount;
													
													if(!empty($readpageDataCheck[$topicsTotal - 1]))
													$TI = '<span style="color:green;" class="glyphicon glyphicon-ok"></span> '.$readpageDataCheck[$topicsTotal - 1]['Readpage']['time_finished_read'];
												?>
														<?php if($currentPageRead >= $topicsTotal):?>
		                                                    <a href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'read', $this->Detergent->urlsafe_b64encode($lessons['Topic']['id']."|".$lesson_title))); ?>">
		                                                        <span class="glyphicon glyphicon-chevron-right"></span>&nbsp;&nbsp;
		                                                        <?php 
																echo $lesson_title;
																?>
		                                                    </a>
		                                                    <?php echo $TI;?>
	                                                	<?php else:?>
	                                                		<span class="glyphicon glyphicon-chevron-right"></span>&nbsp;&nbsp;
	                                                        <?php 
															echo $lesson_title;
															?>
	                                                	<?php endif;?>
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
											<em>Your teacher did not write any topic for this subject yet.</em>
										</div>
									<?php endif; ?>
									
								</li>
							</ul>
						</div><!-- end body -->
					</div><!-- end panel -->
				</div>