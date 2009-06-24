<div id="create" class="mainform">
	<form method="post" action="<?php echo $html->url('/speeches/subscribe/'.$speech['Speech']['id'])?>">
		<h1><?php __('Subscribirse a la conferencia ')?><?php echo $speech['Speech']['title']?></h1>
		<p>
			<?php echo $form->input('SpeechesUser.resend_in',
				array('label' => __('Recordar cada ', true),
													'options' => array(0 => __('Nunca', true),
						1 => __('1 día', true),
						7 => __('1 semana', true),
						15 => __('15 días', true),
						30 => __('1 mes', true))));?>
		</p>
		<p><?php echo $form->submit(__('Subscribir', true)) ?></p>
	</form>
</div>
