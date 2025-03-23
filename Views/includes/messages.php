<?php  if (count($errors) > 0) : ?>
  <div class="msg">
   <?php foreach ($errors as $error) : ?>
     <span><?php echo $error ?><br /></span>
   <?php endforeach ?>
  </div>
<?php  endif ?>