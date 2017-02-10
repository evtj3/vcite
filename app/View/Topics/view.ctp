<?php
#echo $this->Html->css('sample');
#pr($this->data);
echo $this->Html->script('ckeditor/ckeditor');
$counter = 0;
?>
<style>
  #cke_1_contents {
    height: 2in !important;
}
</style>   
<?php
$outline_map = unserialize(base64_decode($this->Session->read('Subject.outline')));
?>

<div class="topics view">

  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-danger"> 
           <?php echo 'REMINDER: For now, we cannot convert the Math Equations into a pdf format completely. Please ask the administrator for more information.';?>
      </div>
    </div>
  </div>
	<div class="row">
		<div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'dashboard')); ?>" title="Back to dashboard"><span class="glyphicon glyphicon-home"></span></a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'subjects', 'action' => 'view')); ?>"><?php echo __($this->Session->read('Subject.title')); ?></a></li>
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
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp&nbsp;Back to Subject Index'), array('controller' => 'subjects', 'action' => 'view'), array('escape' => false)); ?> </li>
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Topic'), array('controller' => 'topics', 'action' => 'add'), array('escape' => false)); ?> </li>
                                <li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Topic'), array('action' => 'edit', $id), array('escape' => false)); ?> </li>
                                <li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Topic'), array('action' => 'delete', $id), array('escape' => false), __('Are you sure you want to delete # %s?', $split_id[1])); ?> </li>

                                <!--
                                <li><?php #echo $this->Html->link(__('<span class="glyphicon glyphicon-tasks"></span>&nbsp&nbsp;Add Quiz'), array('controller' => 'topics', 'action' => 'add'), array('escape' => false)); ?> </li>
                                <li><?php #echo $this->Html->link(__('<span class="glyphicon glyphicon-tasks"></span>&nbsp&nbsp;Add Assignment'), array('controller' => 'topics', 'action' => 'add'), array('escape' => false)); ?> </li> -->
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
      
      
            <div class="actions">
              <div class="panel panel-default">
                <div class="panel-heading">Math Equations  
                  
                  <a href="#" style ="font-size:14px; color:#fff; float:right;"  data-toggle="modal" data-target="#deleteMath">
                    <span class="glyphicon glyphicon-trash"></span>
                  </a>
                  
                  <a style ="font-size:14px; color:#fff; float:right;padding-right:5px; padding-left:5px;">|</a>
                  <a href="#" style ="font-size:14px; color:#fff; float:right;"  data-toggle="modal" data-target="#createMath">
                    <span class="glyphicon glyphicon-plus"></span>
                  </a>
                  

                  <a style ="font-size:14px; color:#fff; float:right;padding-right:5px; padding-left:5px;">|</a>
                   <?php 
                    #pr($this->params['url']['texMath']);
                  ?>
                  <?php if(!empty($this->params['url']['texMath'])):?>
                    <?php if($this->params['url']['texMath'] == 'enabled'):?>
                      <a href="<?php echo $this->Html->url(array('controller'=> 'topics','action'=>'view',$id,'?' => array('texMath' => 'disabled')));?>" style ="font-size:14px; color:#fff; float:right;" >
                        <span class="glyphicon glyphicon-check"></span>
                      </a>
                    <?php elseif($this->params['url']['texMath'] == 'disabled'):?>
                      <a href="<?php echo $this->Html->url(array('controller'=> 'topics','action'=>'view',$id,'?' => array('texMath' => 'enabled')));?>" style ="font-size:14px; color:#fff; float:right;" >
                        <span class="glyphicon glyphicon-unchecked"></span>
                      </a>
                    <?php endif;?>
                  <?php else:?>
                       <a href="<?php echo $this->Html->url(array('controller'=> 'topics','action'=>'view',$id,'?' => array('texMath' => 'disabled')));?>" style ="font-size:14px; color:#fff; float:right;" >
                            <span class="glyphicon glyphicon-check"></span>
                      </a>
                   <?php endif;?>
                </div>
                <div class="panel-body" style=" height:350px; overflow-y: scroll">
                
                  <ol id="mathEquations">
                            
                            <?php 
                            
                            foreach($mathformulaData as $mfd){
                             $counter += 1;
                              if(!empty($this->params['url']['texMath'])){
                                $str = $mfd['Mathformula']['content'];
                                
                                 $spanStripped = strip_tags($str,'');
                                $ff = htmlspecialchars($spanStripped);

                                if($this->params['url']['texMath'] == 'disabled'){
                                 echo '<li style="align:middle; padding:5px;">';
                                 
                                  echo $ff;
                                  echo '</li>';
                                }else{
                                 echo '<li style="align:middle; padding:5px;">
                                 <button class ="btnConvert'.$counter.'" style="float:right; margin-right:5px;" class="btn btn-default">convert</button>
                                 <font style="padding:10px; text-align:center; font-size:'.$mfd['Mathformula']['size'].'px;" id="mathEquations'.$counter.'">'.$ff.'</font>
                                 
                                 </li>';

                                }
                              }
                                else{
                                echo '<li  style="align:middle; padding:5px;"><p id="mathEquations'.$counter.'">'.$mfd['Mathformula']['content'].'</p>
                                <button class ="btnConvert'.$counter.'" style="float:right; margin-right:5px;" class="btn btn-default">convert</button>
                              </li>';
                                }#pr($mfd['Mathformula']['content']);
                            }
                              if(empty($mathformulaData))
                              echo '<li style="align:middle; padding:5px;"><p style="font-style:italic;">create your formula here.</p></li>';

                            ?>
                  </ol>
                
                </div><!-- end body -->
              </div><!-- end panel -->
            </div><!-- end actions -->
           <div class="actions">
              <div class="panel panel-default">
                <div class="panel-heading">Converted Math Equations to images
                  
                </div>

                  <div class="panel-body">
                    <p id="errCon" style="font-style:italic; font-size:12px; text-align:center;">no converted Math Equations yet.</p>
                  <div id="convertedMath" style="display:none;">
                       <label style="font-size:12px; font-weight:normal;font-style:italic;">Right-Click selected image -> [Save Image As]</label>
                      <hr></hr>
                      <div id="MathEquationsImages"></div>
                        
                      
                   </div>
                   <?php 
                        #echo $counter;
                         echo $this->Html->script('html2canvas/dist/html2canvas');
                        ?>
                        <?php for($i=1;$i<=$counter;$i++){?>
                        <script type="text/javascript">
                                var canvas = document.querySelector("canvas");

                                document.querySelector(".btnConvert<?php echo $i;?>").addEventListener("click", function() {
                                      
                                     html2canvas(document.querySelector("#mathEquations<?php echo $i;?>"), {canvas: canvas}).then(function(canvas) {
                                         
                                          document.getElementById('MathEquationsImages').appendChild(canvas);
                                          $('#MathEquationsImages').append('<hr>');

                                      });
                                  }, true);
                                $('.btnConvert<?php echo $i;?>').click(function(){
                                    $('#errCon').fadeOut(100);
                                    $('#convertedMath').fadeIn(300);

                                });
                        </script>
                        <?php }?>
                  </div><!-- end body -->
              </div><!-- end panel -->
            </div><!-- end actions -->
            <div class="actions">
              <div class="panel panel-default">
                <div class="panel-heading">Math Guide 
                </div>

                  <div class="panel-body">
                      <ul class="nav nav-pills nav-stacked discussions mathguide">
                        <a target="_blank" href="/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/Uploads/Math Formula guide/LaTeXSymbols.pdf">
                          <li style="list-style:none;"><span class="glyphicon glyphicon-file"></span> LaTeX Mathematical Symbols</li>
                        </a>
                          <ul>
                              <li>Basic Usage:</li>
                              <li>{} - <font style="font-size:12px;">group</font></li>
                              <li>\over - <font style="font-size:12px;">fraction number</font></li>
                              <li>\pm - <font style="font-size:12px;">plus and minus</font></li>
                              <li>\div - <font style="font-size:12px;">divide</font></li>
                              <li>\times - <font style="font-size:12px;">multiply</font></li>
                            </ul>
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

                                <?php echo $this->Form->create('Topic', array('role' => 'form')); ?>
                                <li class="student" style="border: 0;">
                                    <img src="<?php echo $this->Html->url('/app/webroot/img/profile_pic/'.$this->Session->read('User.group').'s/'.$this->Session->read('User.id').'.jpg'); ?>" />
                                    <div class="discussion_content">
                                        <input type="text" name="data[Discussion][content]" placeholder="What's on your mind?">
                                    </div>
                                    <br clear="both">
                                </li>
                                <?php echo $this->Form->end(); ?>
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
                                <?php if(!$isMobile):?>
                                <ul style="float:right;">
                                  <a href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'viewpdf',$id));?>"><li  style="float:right;list-style:none;"><span style="font-size:16px; " class="glyphicon glyphicon-download-alt"></span> <font style="font-size:12px;">Convert to PDF</font></li></a>
                                </ul>
                                <?php endif;?>
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
                            <!--
                            <div style="font-style: italic; margin-top: -10px; padding-top: 15px; float: right;">Modified: <?php echo $topic['Topic']['modified']; ?></div>
                        -->
                        </div>
                        <div class="panel-body">
                            <h3 class="topic-title" style="padding: 10px !important;">
                                <?php echo 'Exercises' ?>
                                <?php if(!$isMobile):?>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#quizAddMultibtn"><span class="glyphicon glyphicon-plus"> MC </span></button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#quizAddTorFbtn"><span class="glyphicon glyphicon-plus"> TF </span></button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#quizEditbtn"><span class="glyphicon glyphicon-pencil"></span></button>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#quizDeletebtn"><span class="glyphicon glyphicon-trash"></span></button>
                                <?php endif;?>
                            </h3>
                            <!-- questionaire -->
                            
                                 <?php if($this->request->is('post') && !empty($this->data['ques'])):?>
                                   <?php $countQues = count($this->data['Question']); ?>
                                   <p style="width:100%; text-align:center;">
                                    <?php echo $this->Session->read('User.wholename');?>, you have got <?php 
                                     if($correct == $totalans)
                                     echo 'a perfect score!';
                                     else
                                     echo ' a total score of '.$correct.' out of '.$totalans.'.'; 
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
                                    <p style="width:100%; color:red;text-align:center;">Please answer the following question/s. In order for you to continue to the next chapter.</p>
                                    <?php endif;?>
                                <?php endif;?>
                                <div class="col-md-12 assestmentCss">
                                <?php echo $this->Form->create('topic', array('controller' => 'Topic','action' => 'view/'.$id,'role' => 'form')); ?>
                                
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

                                                                      # echo '<input type="text" class="form-control" aria-label="ques'.$counter.'" name="data[ques]['.$counter.']" value="'.$opt['Option']['options'].'" disabled>';
                                                                       echo '<div style="border:solid 1px #EEEEEE;padding:10px;">'.$opt['Option']['options'].'</div>';

                                                                   echo '</div>';
                                                                echo '</div>';

                                                               }
                                                            }
                                                        
                                                   }
                                                }
                                                
                                             echo '</ol>';

                                            ?>

                                </div>
                                

                                      <?php #echo $questionCount;?>
                                      <?php if($questionCount > 0 && empty($this->data['ques'])):?>
                                       <div class="form-group" style="padding-top:10px;padding-right:10px;float:right;">
                                        <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
                                       </div>
                                     <?php elseif($questionCount > 0 && !empty($this->data['ques']) && $correct != $totalans):?>
                                      <div class="form-group" style="padding-top:10px;padding-right:10px;float:right;">
                                       
                                       <a href="<?php echo $this->Html->url(array('controller' => 'topics','action' => 'view',$id) );?>" class="btn btn-default">Retry</a>
                                       </div>
                                      <?php endif;?>
                                  <?php echo $this->Form->end() ?>
                                </div>
                                <!-- end of questionaire -->
                               
                                
                                <?php echo $this->Form->create('questions', array('role' => 'form','action'=>'.././questions/delete_quiz/'.$id)); ?>
                               
                                <!-- Modal -->
                                <div id="quizDeletebtn" class="modal fade" role="dialog">
                                  <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Delete Excercises:</h4>
                                      </div>
                                      <div class="modal-body">
                                           <?php #pr($questions);
                                            $counter = 0;
                                           ?>
                                           
                                           <?php foreach($questions as $q):?>
                                           <?php 
                                           $counter += 1;
                                           echo '
                                           <div class="checkbox">
                                              <label>
                                                <input type="checkbox" name="data[Question'.$counter.'][id]" value="'.$q['Question']['id'].'">'.$q['Question']['content'].'
                                              </label>
                                            </div>
                                            ';

                                          ?>
                                          <input type="hidden" name="counter" value="<?php echo $counter;?>"/>
                                           <?php endforeach;?>
                                           
                                      </div>
                                      <div class="modal-footer">
                                        <p style="float:left;font-style:italic; font-size:12px; color:red;" >Reminder: The selected question/s will be deleted permanently.</p>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                            <input type="submit" value="Delete" class="btn btn-default" />
                                       
                                      </div>
                                    </div>

                                  </div>
                                </div>
                                 <?php echo $this->Form->end() ?>

                                <?php echo $this->Form->create('assestment', array('role' => 'form','action'=>'.././questions/assestment_edit/'.$id)); ?>
                                <!-- Modal -->
                                <div id="quizEditbtn" class="modal fade" role="dialog">
                                  <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Excercises:</h4>
                                      </div>
                                      <div class="modal-body">
                                         
                                              <h3>Multiple Choice</h3>
                                           
                                            

                                               
                                                <?php 
                                                $counter = 0;
                                                
                                                foreach($questionData_multiEdit as $qme){
                                                  $counter += 1;
                                                  $counter2 = 0;
                                                  echo ' <input type="hidden" name="data[Question'.$counter.'][quiztype1]" value="Multiple Choice"/>';
                                                  echo '<input type="hidden" name="data[Question'.$counter.'][queId'.$counter.']" value="'.$qme['Question']['id'].'"/>';
                                                  echo '<input type="hidden" name="data[Question'.$counter.'][topicID]" value="'.$topics['Topic']['id'].'"/>
                                                    <input type="hidden" name="data[Question'.$counter.'][subjectID]" value="'.$topics['Topic']['subject_id'].'"/>';
                                                  echo '<input type="hidden" name="data[Question'.$counter.'][multiTotal]" value="'.$counter.'"/>';
                                                  
                                                  $qme_q = str_replace('<p>', '', $qme['Question']['content']);
                                                  $qme_q = str_replace('</p>', '', $qme_q);
                                                  echo '<div class="form-group" style="margin-top:10px;">';
                                                   
                                                    echo $this->Form->input('Question '.$counter.':',array('class'=>'form-control','placeholder'=>'write your question here','style'=>'font-style:italic;','value' => $qme_q,'name'=>'data[Question'.$counter.'][ques'.$counter.']'));
                                                  echo '</div>';
                                                   echo '<label>Answers:</label>';
                                                  foreach($optionsData_multiEdit as $ome){
                                                    


                                                    if($ome['Option']['question_id'] == $qme['Question']['id']){
                                                      $counter2 += 1;
                                                 
                                                      echo '<input type="hidden" name="data[Option'.$counter.'][questionID]" value="'.$ome['Option']['question_id'].'"/>';

                                                      echo '<div class="form-group">';
                                                     
                                                      echo '<div class="input-group">';

                                                        echo '<span class="input-group-addon">';
                                                              echo '<input type="radio" aria-label="" name="data[Option'.$counter.'][CorrectAnswer]" value="'.$counter2.'">';
                                                        echo '</span>';

                                                        echo '<input type="text" class="form-control" aria-label="" name="data[Option'.$counter.'][Answers'.$counter2.']" value="'.$ome['Option']['options'].'">';
                                                        echo '<input type="hidden" name="data[Option'.$counter.'][optionId'.$counter.''.$counter2.']" value="'.$ome['Option']['id'].'"/>';
                                                        

                                                      echo '</div>';
                                                      echo '</div>';
                                                    }
                                                  
                                                  }
                                                  echo '<input type="hidden" name="data[Option'.$counter.'][totalOptEvQue]" value="'.$counter2.'"/>';
                                                }

                                                ?>
                                            <h3>True or False</h3>
                                            
                                               
                                                <?php 
                                                $counter3 = $counter;
                                                
                                                foreach($questionData_tofEdit as $qme){
                                                  
                                                  $counter3 += 1;
                                                  $counter4 = 0;
                                                  echo ' <input type="hidden" name="data[Question'.$counter3.'][quiztype2]" value="True or False"/>';
                                                  
                                                  echo '<input type="hidden" name="data[Question'.$counter3.'][topicID]" value="'.$topics['Topic']['id'].'"/>
                                                    <input type="hidden" name="data[Question'.$counter3.'][subjectID]" value="'.$topics['Topic']['subject_id'].'"/>';
                                                  echo '<input type="hidden" name="data[Question'.$counter3.'][tofTotal]" value="'.$counter3.'"/>';


                                                  echo '<input type="hidden" name="data[Question'.$counter3.'][queId'.$counter3.']" value="'.$qme['Question']['id'].'"/>';
                                                  $qme_q = str_replace('<p>', '', $qme['Question']['content']);
                                                  $qme_q = str_replace('</p>', '', $qme_q);
                                                  echo '<div class="form-group" style="margin-top:10px;">';
                                                   
                                                    echo $this->Form->input('Question '.$counter3.':',array('class'=>'form-control','placeholder'=>'write your question here','style'=>'font-style:italic;','value' => $qme_q,'name'=>'data[Question'.$counter3.'][ques'.$counter3.']'));
                                                  echo '</div>';
                                                   echo '<label>Answers:</label>';
                                                  foreach($optionsData_multiEdit as $ome){
                                                    
                                                    if($ome['Option']['question_id'] == $qme['Question']['id']){
                                                      $counter4 += 1;



                                                      echo '<input type="hidden" name="data[Option'.$counter3.'][questionID]" value="'.$ome['Option']['question_id'].'"/>';

                                                      echo '<div class="form-group">';
                                                     
                                                      echo '<div class="input-group">';

                                                        echo '<span class="input-group-addon">';
                                                              echo '<input type="radio" aria-label="" name="data[Option'.$counter3.'][CorrectAnswer]" value="'.$counter4.'">';
                                                        echo '</span>';

                                                        echo '<input type="text" class="form-control" aria-label="" name="data[Option'.$counter3.'][Answers'.$counter4.']" value="'.$ome['Option']['options'].'">';
                                                         echo '<input type="hidden" name="data[Option'.$counter3.'][optionId'.$counter3.''.$counter4.']" value="'.$ome['Option']['id'].'"/>';
                                                        

                                                      echo '</div>';
                                                      echo '</div>';
                                                    }
                                                  
                                                  }
                                                  echo '<input type="hidden" name="data[Option'.$counter3.'][totalOptEvQue]" value="'.$counter4.'"/>';
                                                }
                                                  echo '<input type="hidden" name="totalQuestion" value="'.$counter3.'"/>';
                                                  echo '<input type="hidden" name="totalOption" value="'.$counter3.'"/>';
                                                ?>
                                            
                                          
                                      </div>
                                      <div class="modal-footer">
                                        <p style="float:left;font-style:italic; font-size:12px; color:red;" >Reminder: Please do not forget to choose the correct answer.</p>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                            <input type="submit" value="Update" class="btn btn-default" name="sub-btn"/>
                                       
                                      </div>
                                    </div>

                                  </div>
                                </div>
                                 <?php echo $this->Form->end() ?>
                                 
                                <?php echo $this->Form->create('assestment', array('role' => 'form','action'=>'.././questions/assestment/'.$id)); ?>
                                 <?php if($questionCount > 0):?>
                                   <!-- save quiz -->
                                  <input type="hidden" name="data[saveRecord][Quizzes][teacher_id]" value="<?php echo $this->Session->read('User.id'); ?>"/>
                                  <input type="hidden" name="data[saveRecord][Quizzes][subject_id]" value="<?php echo $questions[0]['Question']['subject_id']; ?>"/>
                                  <input type="hidden" name="data[saveRecord][Quizzes][topic_id]" value="<?php echo $split_id[0];?>"/>
                                  
                                  <?php $questionsArr = '';
                                  for($ct=0;$ct<$questionCount;$ct++){?>
                                  <?php 
                                    $quesArr = array();
                                    
                                    array_push($quesArr, '['.$questions[$ct]['Question']['id'].']');
                                    foreach($quesArr as $q){
                                     # echo $q;
                                      $questionsArr .= $q;
                                    }
                                   # echo $questionsArr;

                                  ?>
                                  
                                  
                                  <?php }?>
                                  <input type="hidden" name="data[saveRecord][Quizzes][questions]" value="<?php echo $questionsArr;?>"/>
                                 
                                 
                                  <!-- end of saving quiz -->
                                <?php endif;?>
                                <!-- Modal -->
                                <div id="quizAddMultibtn" class="modal fade" role="dialog">
                                  <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Create New Assesstment:</h4>
                                      </div>
                                      <div class="modal-body">
                                       
                                            
                                                <p>Multiple Choice</p>
                                                <input type="hidden" name="quiztype" value="Multiple Choice"/>
                                                <div class="form-group">
                                                    <?php echo $this->Form->input('Valid Question:',array('class'=>'form-control','placeholder'=>'write your question here','style'=>'font-style:italic;')); ?>
                                                </div>
                                                <div class="form-group">
                                                     <label>Valid Answers</label>
                                                   <div class="input-group">

                                                        <span class="input-group-addon">
                                                        
                                                       <input type="radio" name="answers" value="1">
                                                        </span>

                                                       <input type="text" class="form-control"name="answers1" >


                                                   </div>
                                                   <div class="input-group">

                                                        <span class="input-group-addon">
                                                        
                                                       <input type="radio" name="answers" value="2">
                                                        </span>

                                                       <input type="text" class="form-control" name="answers2" >

                                                   </div>

                                                    

                                                   <div class="input-group">

                                                        <span class="input-group-addon">
                                                        
                                                       <input type="radio"  name="answers" value="3">
                                                        </span>

                                                       <input type="text" class="form-control" name="answers3">

                                                   </div>
                                                   <div class="input-group">

                                                        <span class="input-group-addon">
                                                        
                                                       <input type="radio" name="answers"value="4">
                                                        </span>

                                                       <input type="text" class="form-control"name="answers4">

                                                   </div>
                                                </div>
                                              
                                       
                                      </div>
                                      <div class="modal-footer">
                                        
                                        
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                            <input type="submit" value="Create" class="btn btn-default" name="sub-btn"/>
                                       

                                      </div>
                                    </div>

                                  </div>
                                </div>
                                 <?php echo $this->Form->end() ?>
                                 <?php echo $this->Form->create('assestment', array('role' => 'form','action'=>'.././questions/assestment/'.$id)); ?>
                                <?php if($questionCount > 0):?>
                                   <!-- save quiz -->
                                  <input type="hidden" name="data[saveRecord][Quizzes][teacher_id]" value="<?php echo $this->Session->read('User.id'); ?>"/>
                                  <input type="hidden" name="data[saveRecord][Quizzes][subject_id]" value="<?php echo $questions[0]['Question']['subject_id']; ?>"/>
                                  <input type="hidden" name="data[saveRecord][Quizzes][topic_id]" value="<?php echo $split_id[0];?>"/>
                                  
                                  <?php $questionsArr = '';
                                  for($ct=0;$ct<$questionCount;$ct++){?>
                                  <?php 
                                    $quesArr = array();
                                    
                                    array_push($quesArr, '['.$questions[$ct]['Question']['id'].']');
                                    foreach($quesArr as $q){
                                     # echo $q;
                                      $questionsArr .= $q;
                                    }
                                   # echo $questionsArr;

                                  ?>
                                  
                                  
                                  <?php }?>
                                  <input type="hidden" name="data[saveRecord][Quizzes][questions]" value="<?php echo $questionsArr;?>"/>
                                 
                                 
                                  <!-- end of saving quiz -->
                                <?php endif;?>
                                <!-- Modal -->
                                <div id="quizAddTorFbtn" class="modal fade" role="dialog">
                                  <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Create New Assesstment:</h4>
                                      </div>
                                      <div class="modal-body">
                                       
                                            <p>True or False</p>
                                            <input type="hidden" name="quiztype" value="True or False"/>
                                                <div class="form-group">
                                                    <?php echo $this->Form->input('Valid Question:',array('class'=>'form-control','placeholder'=>'write your question here','style'=>'font-style:italic;')); ?>
                                                </div>
                                                <div class="form-group">
                                                     <label>Answers:</label>
                                                   <div class="input-group">

                                                        <span class="input-group-addon">
                                                        
                                                       <input type="radio" aria-label="" name="answers" value="1">
                                                        </span>

                                                       <input type="text" class="form-control" aria-label="" name="answers1" value="True">

                                                   </div>
                                                   <div class="input-group">

                                                        <span class="input-group-addon">
                                                        
                                                       <input type="radio" aria-label="" name="answers" value="2">
                                                        </span>

                                                       <input type="text" class="form-control" aria-label="" name="answers2" value="False">

                                                   </div>
                                                   
                                                </div>
                                            
                                       
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                            <input type="submit" value="Create" class="btn btn-default" name="sub-btn"/>
                                      </div>
                                    </div>

                                  </div>
                                </div>
                               <?php echo $this->Form->end() ?>
                               <?php echo $this->Form->create('Mathformula', array('role' => 'form','action'=>'add/'.$id)); ?>
                               
                                <!-- Modal -->
                                <div id="createMath" class="modal fade" role="dialog">
                                  <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Create New Math Equations:</h4>
                                      </div>
                                      <div class="modal-body">
                                       
                                        <div class="form-group">
                                          <input type="hidden" name="data[Mathformula][teacher_id]" value="<?php echo $this->Session->read('User.id');?>"/>
                                          <?php echo $this->Form->input('size', array('class' => 'form-control', 'placeholder' => 'Font Size','value' => '14'));?>
                                          <?php echo $this->Form->input('content', array('class' => 'form-control ckeditor', 'placeholder' => 'Content'));?>
                                        </div>
                                       
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <input type="submit" value="Create" class="btn btn-default" name=""/>
                                           
                                      </div>
                                    </div>

                                  </div>
                                </div>
                               <?php echo $this->Form->end() ;?>
                               <?php echo $this->Form->create('Mathformula', array('role' => 'form','action'=>'delete/'.$id)); ?>
                               
                                <!-- Modal -->
                                <div id="deleteMath" class="modal fade" role="dialog">
                                  <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Are you sure to delete this selected Math Equations?</h4>
                                      </div>
                                      <div class="modal-body">
                                        <div style="width:80%; margin:0 auto;">
                                          <ol>
                                            <?php 
                                              $countFormula = 0;
                                            ?>
                                           <?php foreach($mathformulaData as $mfd2):?>
                                                <?php $countFormula += 1;?>
                                                <li >
                                                  <input type="checkbox" name="math<?php echo $countFormula;?>" value="<?php echo $mfd2['Mathformula']['id']?>" />
                                                  <font style="font-size: 18px !important;">
                                                  <?php echo $mfd2['Mathformula']['content'];?>
                                                  </font>

                                                </li>
                                           <?php endforeach;?>
                                          </ol>
                                      </div>
                                      <input type="hidden" name="" value=""/>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                            <input type="submit" value="Delete" class="btn btn-default" name=""/>
                                      </div>
                                    </div>

                                  </div>
                                </div>
                               <?php echo $this->Form->end() ;?>

                               
                        </div>

                    </div>

                    <?php $topic_map_id = array_search($id, $outline_map); ?>
                    <?php 
                      
                    #pr($this->Session->read('Subject.outline'));
                    ?>
                    <?php if(!empty($this->data['ques'])):?>

                        <?php if (array_key_exists($topic_map_id - 1, $outline_map)): ?>
                        <a style="float: left;" role="button" class="btn btn-default btn-sm" href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'view', $outline_map[$topic_map_id - 1])); ?>">
                                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;
                                Previous Topic
                        </a>
                        <?php endif; ?>
                        
                        <?php if (array_key_exists($topic_map_id + 1, $outline_map)): ?>
                        <a style="float: right;" role="button" class="btn btn-default btn-sm" href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'view', $outline_map[$topic_map_id + 1])); ?>">
                                Next Topic &nbsp;&nbsp;
                                <span class="glyphicon glyphicon-arrow-right"></span>
                        </a>


                        <?php endif; ?>
                  <?php else:?>
                      <?php if($questionCount <= 0):?>
                        <?php if (array_key_exists($topic_map_id - 1, $outline_map)): ?>
                        <a style="float: left;" role="button" class="btn btn-default btn-sm" href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'view', $outline_map[$topic_map_id - 1])); ?>">
                                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;
                                Previous Topic
                        </a>
                        <?php endif; ?>
                        
                        <?php if (array_key_exists($topic_map_id + 1, $outline_map)): ?>
                        <a style="float: right;" role="button" class="btn btn-default btn-sm" href="<?php echo $this->Html->url(array('controller' => 'topics', 'action' => 'view', $outline_map[$topic_map_id + 1])); ?>">
                                Next Topic &nbsp;&nbsp;
                                <span class="glyphicon glyphicon-arrow-right"></span>
                        </a>


                       <?php endif; ?>
                      <?php endif; ?>
                  <?php endif;?>
		</div><!-- end col md 9 -->

	</div>
</div>

<?php if(!empty($this->params['url']['texMath'])):?>

    <?php if($this->params['url']['texMath'] == 'enabled'):?>

      <?php echo $this->Html->script('MathJax/MathJax.js?config=TeX-AMS-MML_HTMLorMML');?>

    <?php endif;?>
<?php else:?>
  <?php echo $this->Html->script('MathJax/MathJax.js?config=TeX-AMS-MML_HTMLorMML');?>
<?php endif;?>

<script>
var roxyFileman = '/<?php echo $folderName;?>/app/webroot/js/ckeditor/plugins/fileman/index.html'; 
$(function(){
   CKEDITOR.replace( 'MathformulaContent',{filebrowserBrowseUrl:roxyFileman, 
                                   filebrowserUploadUrl:roxyFileman,
                                   filebrowserImageBrowseUrl:roxyFileman+'?type=image',
                                   filebrowserImageUploadUrl:null,
                                   filebrowserImageBrowseLinkUrl: false,
                                    toolbar : 'MyMathToolBar'
                                      
                                  }); 
  
});

</script>
<?php if($this->data):?>
<script>
      
  
    $('html,body').animate({scrollTop:document.body.scrollHeight},'slow');
  
</script>
<?php endif;?>

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