<?php echo $this->Form->create('Page'); ?>
<!--login modal-->
<div id="loginModal" class="" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <?php echo $this->Session->flash(); ?>
            <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
            <h2 class="text-center">Login</h2>
        </div>
        <div class="modal-body">
            <form class="form col-md-12 center-block">
              <div class="form-group">
                <?php echo $this->Form->input('emailadd', array('class' => 'form-control input-lg', 'placeholder' => 'I.D Number', 'label' => false));?>
              </div>
              <div class="form-group">
                <?php echo $this->Form->password('password', array('class' => 'form-control input-lg', 'placeholder' => 'Password', 'label' => false));?>
              </div>
              <div class="form-group">
                <button class="btn btn-primary btn-block">Sign In</button>
                <div style="margin-top: 10px;">
                  <p style="font-style:italic; font-size:12px; text-align:right;">Ask the administrator for the account. If you don't have one.</p>
                <div>
              </div>
            </form>
        </div>
    </div>
  </div>
</div>
<?php echo $this->Form->end(); ?>