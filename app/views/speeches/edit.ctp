<div id="create" class="mainform">
<h1>Editar Charla</h1>

	<?php echo $form->create('Speech', array('action' => 'edit')); ?>
		<p>
			<?php echo $form->input('Speech.title', array('size' => '20',
														'label' => 'Título'))?>
			<?php echo $form->isFieldError('Speech.title') ?>
		</p>
		<p>
			<!-- Presentadores -->
			<label for="SpeechSpeakers">Presentadores:</label><br />
			<?php
				echo $form->textarea('Speech.speakers', array('rows'=>'5'));
				echo $form->isFieldError('Speech.speakers');
			?>
		</p>
		<p>
			<!-- Descripción -->
			<label for="SpeechDescription">Descripción:</label><br />
			<?php
				echo $form->textarea('Speech.description', array('rows'=>'10'));
				echo $form->isFieldError('Speech.description');
			?>
		</p>
		<p>
			<!-- Lugar -->
			<?php
				echo $form->input('Speech.location', array('size' => '20',
															'label' => 'Lugar'));
				echo $form->isFieldError('Speech.location');
			?>
		</p>
		<p>
			<!-- Fecha -->
			<?php
				echo $form->input('Speech.date', array('size' => '1',
															'label' => 'Fecha'));
				echo $form->isFieldError('Speech.date');
			?>
		</p>

		<?php $tags = $this->requestAction('/tags/getTags');
				echo $form->input('Tag', array('label' => 'Categorías',
											   'multiple' => 'checkbox',
											   'options' => $tags));
		?>

		<p>
			<?php echo $form->submit('Guardar') ?>
		</p>
	<?php echo $form->input('id', array('type'=>'hidden'));
	$form->end();
	?>
</div>