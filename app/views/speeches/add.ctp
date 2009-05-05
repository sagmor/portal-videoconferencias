<div id="create" class="mainform">
	<form method="post" action="<?php echo $html->url('/speeches/add')?>">
			<h1>Agregar nueva charla</h1>
			<p>
				<!--Título de la charla -->
				<?php
					echo $form->input('Speech.title', array('size' => '20'));
					echo $form->isFieldError('Speech.title');
				?>
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
					echo $form->input('Speech.location', array('size' => '20'));
					echo $form->isFieldError('Speech.location');
				?>
			</p>
			<p>
				<!-- Fecha -->
				<?php
					echo $form->input('Speech.date', array('size' => '1'));
					echo $form->isFieldError('Speech.date');
				?>
			</p>

			<!-- Tags -->
			<?php $tags = $this->requestAction('/tags/getTags');
					echo $form->input('Tag', array('label' => 'Subscripciones',
												   'multiple' => 'checkbox',
												   'options' => $tags));
			?>
			<p><?php echo $form->submit('Guardar') ?></p>
	</form>
</div>
