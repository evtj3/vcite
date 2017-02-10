<style>

  #cke_1_contents{
    height: 1in !important;
  }
</style>
<?php
echo $this->Html->script('ckeditor/ckeditor');
$outline_map = unserialize(base64_decode($this->Session->read('Subject.outline')));
?>
<div class="topics view">
	<div class="row">
		<div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard">
                    <span class="glyphicon glyphicon-home"></span></a></li>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'view')); ?>"><?php echo __($this->Session->read('Subject.title')); ?></a>
                </li>
                <li class="active"><?php echo $split_id[1]; ?></li>
            </ol>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Actions</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;Back to Subject Index'), array('controller' => 'subjects', 'action' => 'read'), array('escape' => false)); ?> </li>
                                
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
            <div class="actions" style="display: none;">
                <div class="panel panel-default">
                    <div class="panel-heading">Discussions</div>
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked discussions">
                                <?php foreach($discussions as $discussion): ?>
                                    <?php $split_student = explode('|', $discussion['Discussion']['discussed_by']); ?>

                                    <?php if($split_student[1]=="student"): ?>
                                        <li class="student">
                                            <img src="<?php echo $this->Html->url('/app/webroot/img/profile_pic/students/'.$split_student[0].'.jpg'); ?>" />
                                            <div class="discussion_content">
                                                <div class="discussed_by"><?php echo $split_student[2]?></div>
                                                <?php echo $discussion['Discussion']['content']; ?>
                                            </div>
                                            <br clear="both">
                                        </li>
                                    <?php else: ?>
                                        <li class="teacher">
                                            <div class="discussion_content">
                                                <div class="discussed_by" style="text-align: right"><?php echo $split_student[2]?></div>
                                                <?php echo $discussion['Discussion']['content']; ?>
                                            </div>
                                            <img src="<?php echo $this->Html->url('/app/webroot/img/profile_pic/teachers/'.$split_student[0].'.jpg'); ?>" />
                                            <br clear="both">
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php #echo $this->Form->create('Topic', array('role' => 'form')); ?>
                                <li class="student" style="border: 0;">
                                    <img src="<?php echo $this->Html->url('/app/webroot/img/profile_pic/'.$this->Session->read('User.group').'s/'.$this->Session->read('User.id').'.jpg'); ?>" />
                                    <div class="discussion_content">
                                        <input type="text" name="data[Discussion][contentx]" placeholder="What's on your mind?">
                                    </div>
                                    <br clear="both">
                                </li>
                                <?php #echo $this->Form->end(); ?>
                            </ul>
                        </div><!-- end body -->
                </div><!-- end panel -->
            </div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-body" style="padding: 10px !important;">
                            <h3 class="topic-title">
                                <?php echo $split_id[1]; ?>
                                <ul style="float:right;">
                                  <a href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'viewpdf',$id));?>"><li  style="float:right;list-style:none;"><span style="font-size:16px; " class="glyphicon glyphicon-download-alt"></span> <font style="font-size:12px;">Convert to PDF</font></li></a>
                                </ul>
                            </h3>

                            <div class="topic-content">
                                <?php 
                                $content = $topic['Topic']['content'];
                                $pdfs = '';
                          
                              $pdfs = str_replace('[PDF_EMBED|', '<a href="',$content);
                              $pdfs = str_replace('|PDF_EMBED]', '">Download this PDF</a>',$pdfs);

                              $content = str_replace('[PDF_EMBED|', '<object width="100%" height="800px" type="application/pdf" data="', $content);
                              


                                              $content = str_replace('|PDF_EMBED]', '#toolbar=1&scrollbar=1">
                  It appears you don\'t have Adobe Reader or PDF support in this web browser. '.$pdfs.'</object>', $content);

                                              
                                         //pr($pdfs);
                                          echo $content;
                                ?>
                            </div>
                            
                            <div style="font-style: italic; margin-top: -10px; padding-top: 15px; float: right;">Modified: <?php echo $topic['Topic']['modified']; ?></div>
                        </div>
                        <div id="pracquiz" class="panel-body">
                            <?php if(!empty($quizData)):?>
                            <h3 class="topic-title" style="padding: 10px !important;"><?php echo 'Practice Quiz' ?></h3>
                          <?php endif;?>
                             <!-- questionaire --> 
                                <?php 
                                #pr($this->Session->read('User'));
                                #pr($split_id);
                                #pr($questions[0]['Question']);
                                #pr($this->data);

                                $current_topic_taken = 0;
                                $total_topic = 0;
                                $current_quiz_taken = 0;
                                $total_quiz = 0;

                                if(!empty($this->data['ques'])){
                                $current_topic_taken = 1;
                                $total_topic = 10;
                                $current_quiz_taken = $correct;
                                $total_quiz = $totalans;
                                }

                                #$average_topic_taken = ($current_topic_taken / $total_topic) * 100;
                                if($current_quiz_taken != 0)
                                $average_quiz_taken = ($current_quiz_taken / $total_quiz)*100;
                                else
                                $average_quiz_taken = 0;
                                #$totalProgress = ($average_topic_taken + $average_quiz_taken) / 2;
                               
                              #pr($this->data);
                               ?>
                              
                                 <?php if($this->request->is('post') && !empty($this->data['ques'])):?>
                                   
                                  <?php 
                                  
                                 # echo 'Quiz ID: '.$quizData['Quizzes']['id'].'<br/>';
                                  #echo 'Teacher ID: '.$quizData['Quizzes']['teacher_id'].'<br/>';
                                 # echo 'Topic ID: '.$quizData['Quizzes']['topic_id'].'<br/>';
                                  #echo 'Subject ID: '.$quizData['Quizzes']['subject_id'].'<br/>';
                                  #echo 'Your score: '.$correct.'<br/>';
                                  #echo 'Your average: '.$average.'%<br/>';
                                  #echo 'Overall Progress: '.$totalProgress.'%<br/>';

                                  ?>

                                   <?php $countQues = count($this->data['Question']); ?>
                                   <p style="width:100%; text-align:center;">
                                    <?php echo $this->Session->read('User.wholename');?>, you have got <?php 
                                     if($correct == $totalans)
                                     echo 'a perfect score!';
                                     else{
                                     echo ' a total score of '.$correct.' out of '.$totalans.'.'; 
                                     if($average_quiz_taken < 75)
                                      echo '<p style="text-align:center; color:red; font-size:12px;">You should get 75% of your current score inorder to continue.</p>';
                                      }
                                    ?>
                                  </p>
                                   <div class="progress" style="height:20px;">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $average;?>"
                                    aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $average.'%';?>">
                                      <?php echo $average.'%';?>
                                    </div>
                                  </div>
                                <?php else:?>
                                    <?php if(!empty($this->data['Question']) && empty($this->data['ques'])):?>
                                    <p style="width:100%; color:red;text-align:center;">Please answer the following question/s. In order for you to continue to the next topic.</p>
                                    <?php endif;?>
                                <?php endif;?>
                                <div class="col-md-12 assestmentCss">
                                <?php echo $this->Form->create('topic', array('controller' => 'Topic','action' => 'read/'.$id,'role' => 'form')); ?>
                                
                                



                                <div class="form-group">
                                <?php 
                                $alphaLetters = range('A', 'Z');
                            
                                $counter = 0;
                                $data = array();
                                 echo '<ol class="questionare">';
                                //default shuffle                                
                                /*  if(empty($this->data)){
                                      shuffle($questions);
                                      echo 'shuffle enabled';
                                      }
                                  else{
                                    echo 'shuffle disabled';
                                    }

                                  pr($this->data);
                                */ 
                                   
                                    foreach($questions as $ques){
                                      if($ques['Question']['topic_id'] == $split_id[0]){
                                       $counter += 1;
                                       $counter2 = 0;
                                        echo '<li><p>';
                                        echo $ques['Question']['content'];
                                        echo '</p></li>';

                                        $qdata = str_replace('<p>', '', $ques['Question']['content']);
                                        $qdata2 = str_replace('</p>', '', $qdata);

                                        echo '<input type="hidden" name="data[questionId]['.$counter.']" value="'.$ques['Question']['id'].'"/>';

                                        echo '<input type="hidden" name="data[Question]['.$counter.']" value="'.$qdata2.'"/>';

                                                foreach($options as $opt){
                                                   if($opt['Option']['question_id'] == $ques['Question']['id']){
                                                    
                                                    $counter2 += 1;
                                                   
                                                    if($opt['Option']['correct'] == 1){
                                                    echo '<input type="hidden" name="data[Answer]['.$counter.']" value="'.$opt['Option']['options'].'"/>';
                                                    }



                                                     echo '<div class="col-lg-12" >';
                                                      
                                                       echo '<div class="input-group">';
                                                           
                                                           echo '<span class="input-group-addon">';
                                                           if($this->request->is('post') && !empty($this->data['ques'])){
                                                              $totalans = count($this->data['Answer']);
                                                              #$correct = 0;

                                                              for($i=1;$i<=$totalans;$i++){

                                                               if($this->data['questionId'][$i] == $opt['Option']['question_id']) {
                                                               
                                                                  #echo $this->data['Answer'][$i];
                                                                  if(!empty($this->data['ques'][$i]) && $this->data['ques'][$i] == $opt['Option']['options'] ){
                                                                    
                                                                    if($this->data['ques'][$i] == $this->data['Answer'][$i]){
                                                                      
                                                                      echo ' <span style="color:green;" class="glyphicon glyphicon-check"></span> ';

                                                                      
                                                                    }else{
                                                                      echo ' <span style="color:red;" class="glyphicon glyphicon-remove"></span> ';

                                                                      
                                                                    }

                                                                  }
                                                               }

                                                              }
                                                               
                                                           }

                                                           echo $alphaLetters[($counter2 - 1)].'. ';
                                                                                                                    
                                                           echo '<input type="radio" aria-label="ques'.$counter.'" name="data[ques]['.$counter.']" value="'.$opt['Option']['options'].'" ';
                                                           
                                                           if($this->request->is('post')  && !empty($this->data['ques'])){
                                                              $totalans2 = count($this->data['Answer']);
                                                              #$correct = 0;

                                                              for($i2=1;$i2<=$totalans2;$i2++){

                                                               if($this->data['questionId'][$i2] == $opt['Option']['question_id']) {
                                                               
                                                                  #echo $this->data['Answer'][$i];
                                                                  if(!empty($this->data['ques'][$i2]) && $this->data['ques'][$i2] == $opt['Option']['options'] ){
                                                                    
                                                                    if($this->data['ques'][$i2] == $this->data['Answer'][$i2]){
                                                                      
                                                                      echo ' style="padding:30px !important;" checked';

                                                                      
                                                                    }else{
                                                                      echo ' checked';

                                                                      
                                                                    }

                                                                  }
                                                               }

                                                              }
                                                               
                                                           }
                                                           
                                                            echo '>';
                                                          

                                                     
                                                           echo '</span>';

                                                           #echo '<input type="text" class="form-control" aria-label="ques'.$counter.'" name="data[ques]['.$counter.']" value="'.$opt['Option']['options'].'" disabled>';
                                                           echo '<div style="border:solid 1px #EEEEEE;padding:10px;">'.$opt['Option']['options'].'</div>';
                                                       echo '</div>';
                                                    echo '</div>';

                                                   }
                                                }
                                            
                                       }
                                   }
                                 
                                 echo '</ol>';
                                 #pr($this->data);
                                ?>

                                  </div>
                                      <?php #echo $questionCount;?>
                                      <?php if($questionCount > 0 && empty($this->data['ques'])):?>
                                       <div class="form-group" style="padding-top:10px;padding-right:10px;float:right;">
                                        <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
                                       </div>
                                     <?php elseif($questionCount > 0 && !empty($this->data['ques']) && $correct != $totalans):?>
                                      <div class="form-group" style="padding-top:10px;padding-right:10px;float:right;">
                                       
                                       <a href="<?php echo $this->Html->url(array('controller' => 'topics','action' => 'read',$id) );?>" class="btn btn-default">Retry</a>
                                       </div>
                                      <?php endif;?>
                                  <?php echo $this->Form->end(); ?>
                                </div>
                                <!-- end of questionaire -->
                              
                        </div>
                    </div>
		    
                    <?php $topic_map_id = array_search($id, $outline_map); ?>
                    
                    <?php if($average_quiz_taken >= 75 && !empty($this->data['ques'])):?>

                        <!-- -->

                        <?php if (array_key_exists($topic_map_id - 1, $outline_map)): ?>
                        <a style="float: left;" role="button" class="btn btn-default btn-sm" href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'read', $outline_map[$topic_map_id - 1])); ?>">
                                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;
                                Previous Topic
                        </a>
                        <?php endif; ?>

                        <?php if (array_key_exists($topic_map_id + 1, $outline_map)): ?>
                       
                                <button style="float: right;" type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#nextButton">
                                   Next Topic &nbsp;&nbsp;
                                        <span class="glyphicon glyphicon-arrow-right"></span>
                                </button>
                                
                              
                                <!-- modals for page next/prev button-->
                                <?php echo $this->Form->create('topics', array('role' => 'form',
                                                                                'action' => 'read/'.$outline_map[$topic_map_id]
                                                                                )); ?>
                                  <!-- Modal -->
                                  <div id="nextButton" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">Finished reading?</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p style="font-style:italic;">Father of Learning: Curiosity</p>

                                            <p style="font-style:italic;">Mother of Learning: Repitition</p>

                                          <input type="hidden" name="data[Readpages][student_id]" value="<?php echo $readpageData['Readpages']['student_id']; ?>"/>
                                          <input type="hidden" name="data[Readpages][topic_id]" value="<?php echo $readpageData['Readpages']['topic_id'] ?>"/>
                                          <input type="hidden" name="data[Readpages][subject_id]" value="<?php echo $readpageData['Readpages']['subject_id'] ?>"/>
                                          <input type="hidden" name="data[Readpages][page_read]" value="<?php echo $readpageData['Readpages']['page_read'];?>"/>
                                          <input type="hidden" name="data[Readpages][total_page]" value="<?php echo $readpageData['Readpages']['total_page'];?>"/>
                                          <input type="hidden" name="data[Readpages][time_finished_read]" value="<?php echo $readpageData['Readpages']['time_finished_read'];?>"/>
                                         
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                                              <input type="submit" value="Yes" class="btn btn-default" name="confirm"/>
                                         
                                        </div>
                                      </div>

                                    </div>
                                  </div>
                                 <?php echo $this->Form->end() ?>
                        <?php endif; ?>
                  <?php else:?>
                      <?php if($questionCount <= 0):?>

                          <!-- -->
                          <?php if (array_key_exists($topic_map_id - 1, $outline_map)): ?>


                              <a style="float: left;" role="button" class="btn btn-default btn-sm" href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'read', $outline_map[$topic_map_id - 1])); ?>">
                                      <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;
                                      Previous Topic
                              </a>


                          <?php endif; ?>
                          
                          <?php if (array_key_exists($topic_map_id + 1, $outline_map)): ?>
                                
                                <button style="float: right;" type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#nextButton">
                                   Next Topic &nbsp;&nbsp;
                                        <span class="glyphicon glyphicon-arrow-right"></span>
                                </button>
                              
                                <!-- modals for page next/prev button-->
                                <?php echo $this->Form->create('topics', array('role' => 'form',
                                                                                'action' => 'read/'.$outline_map[$topic_map_id]
                                                                                )); // + 1 ?>
                                  <!-- Modal -->
                                  <div id="nextButton" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">Finish reading?</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p style="font-style:italic;">Father of Learning: Curiosity</p>

                                            <p style="font-style:italic;">Mother of Learning: Repitition</p>
                                          

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
                          <?php else:?>
                                  <button style="float: right;" type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#doneButton">
                                   Done &nbsp;&nbsp;
                                        <span class="glyphicon glyphicon-arrow-right"></span>
                                </button>
                              
                                <!-- modals for page next/prev button-->
                                <?php echo $this->Form->create('topics', array('role' => 'form',
                                                                                'action' => 'read/'.$outline_map[$topic_map_id]
                                                                                )); // + 1 ?>
                                  <!-- Modal -->
                                  <div id="doneButton" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">Finished reading?</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p style="font-style:italic;">Father of Learning: Curiosity</p>

                                            <p style="font-style:italic;">Mother of Learning: Repitition</p>
                                          

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
                         <?php endif; ?>

                      <?php endif; ?>
                  <?php endif;?>

		</div><!-- end col md 9 -->

	</div>
</div>
<script type="text/javascript"
        src="http://localhost/MathJax/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
      </script> 
     

<?php if($this->data):?>
<script>
      
  
    $('html,body').animate({scrollTop:document.body.scrollHeight},'slow');
  
</script>
<?php endif;?>