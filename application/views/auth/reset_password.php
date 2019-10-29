<div class="container py-4 my-4 text-center">
  <div class="w-50 m-auto box-shadow py-3">
      <h1><?php echo lang('reset_password_heading');?></h1>
      <div id="infoMessage"><?php echo $message;?></div>

      <?php echo form_open('home/reset_password/' . $code);?>

        <p>
          <label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
          <?php echo form_input($new_password);?>
        </p>

        <p>
          <?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
          <?php echo form_input($new_password_confirm);?>
        </p>

        <?php echo form_input($user_id);?>
        <?php echo form_hidden($csrf); ?>

        <p><?php echo form_submit('submit', "reset_password");?></p>

      <?php echo form_close();?>
  </div>
</div>