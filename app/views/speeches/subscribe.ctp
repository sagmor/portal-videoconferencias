<div id="create" class="mainform">
	<form method="post" action="<?php echo $html->url('/speeches/subscribe/'.$speech['Speech']['id'])?>">
			<h1>Subscribirse a la charla <?php echo $speech['Speech']['title']?></h1>
		    <p>
			    <?php echo $form->input('SpeechesUser.resend_in',
					                    array('label' => 'Recordar cada ',
					                    'options' => array(0 => 'Nunca',
					                                       7 =>'1 semana',
					                                       15 => '15 días',
					                                       30 => '1 mes')));?>
			</p>
			<p><?php echo $form->submit('Subscribirse') ?></p>
	</form>
</div>
