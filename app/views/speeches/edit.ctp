<div id="create" class="mainform">
<h1><?php __('title_edit') ?></h1>

	<?php echo $form->create('Speech', array('action' => 'edit')); ?>
		<p>

			<?php
				echo $form->input('Speech.title', array('size' => '20',
														'label' => __('title', true)));
				echo $form->isFieldError('Speech.title');
			?>
		</p>
		<p>
			<!-- Presentadores -->
			<label for="SpeechSpeakers"><?php __('speakers')?>:</label><br />
			<?php
				echo $form->textarea('Speech.speakers', array('rows'=>'5'));
				echo $form->isFieldError('Speech.speakers');
			?>
		</p>
		<p>
			<!-- Descripción -->
			<label for="SpeechDescription"><?php __('description')?>:</label><br />
			<?php
				echo $form->textarea('Speech.description', array('rows'=>'10'));
				echo $form->isFieldError('Speech.description');
			?>
		</p>
		<p>
			<!-- Lugar -->
			<?php
				echo $form->input('Speech.location', array('size' => '20',
														'label' => __('location', true)));
				echo $form->isFieldError('Speech.location');
			?>
		</p>
		<p>
			<!-- Fecha -->
			<?php
				echo $form->input('Speech.date', array('size' => '1',
														'label' => __('date', true)));
				echo $form->isFieldError('Speech.date');
			?>
		</p>

			<!-- Categorías -->
			<?php $tags = $this->requestAction('/tags/getTags');
				echo '<div id="tags">';
					echo $form->input('Tag', array('label' => __('tags', true),
												   'multiple' => 'checkbox',
												   'options' => $tags));
				echo '</div>'
			?>

		<p>
			<?php echo $form->submit(__('save',true)) ?>
		</p>
	<?php echo $form->input('id', array('type'=>'hidden'));
	$form->end();
	?>
</div>