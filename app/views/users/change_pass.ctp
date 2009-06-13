<h2><b class="text1"><?php __('title_change_pass')?></b></h2>
<?php echo $form->create('User', array('url' =>
									   array('controller' => 'users', 'action' => 'changePass')));?>
	<?php
   	 	echo $form->input('User.0.password', array( 'label' => __('new_pass', true)));
    	echo $form->input('User.1.password', array( 'label' => __('confirm_new_pass', true)));
	?>
<?php echo $form->end(__('change_pass_button', true));?>
