<div id="create" class="mainform">
	<form method="post" action="<?php echo $html->url('/speeches/subscribe/'.$speech['Speech']['id'])?>">
		<h1><?php __('suscribe_title')?><?php echo $speech['Speech']['title']?></h1>
		<p>
			<?php echo $form->input('SpeechesUser.resend_in',
				array('label' => __('remember_at', true),
													'options' => array(0 => __('never', true),
						1 => __('one_day', true),
						7 => __('one_week', true),
						15 => __('fifteen_days', true),
						30 => __('one_month', true))));?>
		</p>
		<p><?php echo $form->submit(__('subscribe_button', true)) ?></p>
	</form>
</div>
