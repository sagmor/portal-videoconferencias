<h2><b class="text1"><?php __('user_in') ?></b></h2>
  <?php echo $form->create('User', array('url' =>
  											  array('controller' => 'users', 'action' => 'login'),
  											  'id' => 'login'));?>
	<fieldset>
	  <?php
      	echo $form->input('User.email', array('label' => __('email', true)));
     	 	echo $form->input('User.password', array('label' => __('password', true)));
    ?>
	  <input type="submit" value="Ingresar" />
	  <?php echo $html->link(__('register', true), array('controller' => 'users',
	                                      'action' => 'register')); ?>
  </form>