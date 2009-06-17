<div id="create" class="mainform">
	<form method="post" action="<?php echo $html->url('/speeches/add')?>">
			<h1><?php __('title_add') ?></h1>
			<p>
				<!--Título de la charla -->
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

			<!-- Tags -->
			<?php $tags = $this->requestAction('/tags/getTags');
					echo $form->input('Tag', array('label' => __('tags', true),
												   'multiple' => 'checkbox',
												   'options' => $tags));
			?>
			<p>
				<?php echo $form->submit(__('save',true)) ?>
			</p>
	</form>
</div>
