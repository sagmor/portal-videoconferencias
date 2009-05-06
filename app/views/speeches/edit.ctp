	<h1>Editar Charla</h1>

	<?php echo $form->create('Speech', array('action' => 'edit')); ?>
		<p>
			<?php echo $form->input('Speech.title', array('size' => '20'))?>
			<?php echo $form->isFieldError('Speech.title') ?>
		</p>
		<p>
			<table>
				<tr>
					<td>
						Presentadores:
					</td>
					<td>
						<?php echo $form->textarea('Speech.speakers', array('rows'=>'5')) ?>
						<?php echo $form->isFieldError('Speech.speakers') ?>
					</td>
				</tr>
			</table>
		</p>
		<p>
			<table>
				<tr>
					<td>
						Descripción:
					</td>
					<td>
						<?php echo $form->textarea('Speech.description', array('rows'=>'10')) ?>
						<?php echo $form->isFieldError('Speech.description') ?>
					</td>
				</tr>
			</table>
		</p>
		<p>
			<?php echo $form->input('Speech.location', array('size' => '20'))?>
			<?php echo $form->isFieldError('Speech.location') ?>
		</p>
		<p>
			<?php echo $form->input('Speech.date', array('size' => '1'))?>
			<?php echo $form->isFieldError('Speech.date') ?>
		</p>

		<?php $tags = $this->requestAction('/tags/getTags');
				echo $form->input('Tag', array('label' => 'Categorías',
											   'multiple' => 'checkbox',
											   'options' => $tags));
		?>

		<p>
			<?php echo $form->submit('Guardar') ?>
		</p>
	<?php echo $form->input('id', array('type'=>'hidden')); ?>
