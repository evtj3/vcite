<!DOCTYPE html>
<html lang="en">
  <head>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

    echo $this->Html->css('bootstrap');
    echo $this->Html->css('bootstrap-switch');
    #echo $this->Html->css('bootstrap-datetimepicker');
    echo $this->Html->css('bootstrap-spinedit');
    echo $this->Html->css('custom');
    echo $this->Html->css('style');
   # echo $this->Html->css('demo');
    #echo $this->Html->script('jquery.min-1.10.2');
    
      echo $this->Html->script('jquery-1.11.3.min');
     echo $this->Html->script('json2html');
      echo $this->Html->script('jquery.json2html');
      
   # echo $this->Html->script('scriptaculous');
   # echo $this->Html->script('prototype_latest');
    echo $this->Html->script('bootstrap.min');
    echo $this->Html->script('bootstrap-switch');
    #echo $this->Html->script('moment');
    #echo $this->Html->script('bootstrap-datetimepicker');
    echo $this->Html->script('bootstrap-spinedit');
    
    #echo $this->Html->script('MathJax');
    
    echo $this->Html->script('customization');
    
	?>

  	<!-- Latest compiled and minified CSS -->
  	<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">-->

  	<!-- Latest compiled and minified JavaScript -->
  	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
    	body{ padding: 70px 0px; }
    </style>

  </head>

  <body>
    <?php echo $this->Element('navigation'); ?>

    <div class="container">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>

    </div><!-- /.container -->
    <script>
        $("#flashMessage").click(function(){
            $("#flashMessage").fadeOut(500);
        });
    </script>
    <?php echo $this->Html->script('highcharts');?>
    <?php echo $this->Html->script('exporting');?>
  </body>
</html>

