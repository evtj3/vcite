<?php 
$isMobile = $this->request->is('mobile');
$current = $this->here;

?>
<div class="navbar navbar-inverse main_header">
      <div class="navbar-header">
          <a href="<?php echo $this->Html->url('/');?>" class="main_page_link">
            <div class="cite_title">
              <p style="font-size:25px; font-weight:bold; color:#256D7D;">VCITE</p>
              <p style="font-size:12px; font-style:italic; margin-top:-15px; color:#3DB5D0;">Information and Learning Resource</p>
            </div>
          </a>
          <button style="margin-top:-40px;" type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
      </div>
      <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active main-menu"><a href="<?php echo $this->Html->url('/');?>"><span class="glyphicon glyphicon-home"></span> Main Page</a></li>
         <?php if($this->Session->read('User.group') == 'teacher' && !$isMobile):?>
          <li class="main-menu"><a target="_blank" href="/<?php echo basename(ROOT);?>/app/webroot/js/ckeditor/plugins/fileman/index.html?CKEditor=TopicContent&CKEditorFuncNum=1&langCode=en"><span class="glyphicon glyphicon-folder-open"></span> File Manager</a></li>
          <li class="main-menu"><a href="<?php echo $this->Html->url(array('controller'=>'teachers','action'=>'graph'));?>" title="graph"><span class="glyphicon glyphicon-signal"></span> Statistics</a></li>
         <?php endif;?>
        
          </ul>
          <div class="separator_nav"></div>
          <ul class="nav navbar-nav" style="float:right;">
            <li class="active"><a href="<?php 
            if($this->Session->read('User.group') == 'teacher')
            echo $this->Html->url(array('controller'=>'teachers','action'=>'teacher_profile'));
            else
              echo $this->Html->url(array('controller'=>'students','action'=>'students_profile'));
            ?>"><span class="glyphicon glyphicon-user"></span> 
            <?php 
            $name = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($this->Session->read('User.wholename')))));
            echo $name;
            ?></a></li>
            <li ><a href="<?php echo $this->Html->url(array('controller'=>'pages','action'=>'logout'));?>"><span class="glyphicon glyphicon-arrow-left"></span> Back to CIS</a></li>
          </ul>
      </div>
   </div>
   
   
<?php 
/*
  $d = date('m');
  $month1 = '01-02-03';
  $month2 = '04-05';
  $month3 = '06-07-08';
  $month4 = '09-10-11-12';

  $notifyMonths = "";
  
  
 // pr($d);

  $isMonth1 = true;
  $isMonth2 = false;
  $isMonth3 = false;
  $isMonth4 = false;

  
    if($isMonth1){
       $pos = strpos($month1,$d);          
        
        if($pos == false){
          $isMonth1 = false;
          $isMonth2 = true;
        }else{
          //pr('yes naa dri nasud ay sa month1: '.$month1);
          $notifyMonths = $pos;
        }

    }
    if($isMonth2){
       $pos = strpos($month2,$d);    
       
        if($pos == false){
          $isMonth2 = false;
          $isMonth3 = true;
        }else{
         // pr('yes naa dri nasud ay sa month2: '.$month2);
          $notifyMonths = $pos;
        }      
    }
    if($isMonth3){
       $pos = strpos($month3,$d);    
       
        if($pos == false){
          $isMonth3 = false;
          $isMonth4 = true;
        }else{
          //pr('yes naa dri nasud ay sa month3: '.$month3);
          $notifyMonths = $pos;
        }      
    }
    if($isMonth4){
        $pos = strpos($month4,$d);    
        
        if($pos == false){
          $isMonth4 = false;
          $isMonth1 = true;
        }else{
         // pr('yes naa dri nasud ay sa month4: '.$month4);
          $notifyMonths = $pos;
        }      
    }

 //echo $notifyMonths;
*/
?>
