<div class="learn-press-question" id="learn-press-question-<?php echo $this->id;?>" data-type="<?php echo str_replace( '_', '-', $this->type );?>" data-id="<?php echo $this->id;?>">
	<p class="question-bottom-actions">
		<?php
		$top_buttons = array(
			'change_type' => learn_press_dropdown_question_types(array('echo' => false, 'id' => 'learn-press-dropdown-question-types-' . $this->id, 'selected' => $this->type ))
		);
		$top_buttons = apply_filters(
			'learn_press_question_top_buttons',
			$top_buttons,
			$this
		);
		echo join( "\n", $top_buttons );
		?>
	</p>
	<table class="lp-sortable lp-list-options" id="learn-press-list-options-<?php echo $this->id;?>">
		<thead>
		<th><?php _e( 'Answer Text', 'learnpress' ); ?></th>
		<th><?php _e( 'Is Correct?', 'learnpress' ); ?></th>
		
		</thead>
		<tbody>

		<?php $answers = $this->answers; if ( $answers ): ?>
			<?php foreach ( $answers as $answer ): ?>
				<?php
				$value = $this->_get_option_value( $answer['value'] );
				$id = $value;
				?>

				<?php do_action( 'learn_press_before_question_answer_option', $this ); ?>

				<tr class="lp-list-option lp-list-option-<?php echo $id;?>" data-id="<?php echo $id;?>">
					<td>
                                            <input class="lp-answer-text no-submit key-nav" type="text" name="learn_press_question[<?php echo $this->id; ?>][answer][text][]" value="Essay" disabled="" />
					</td>
					<th class="lp-answer-check">
						<input type="hidden" name="learn_press_question[<?php echo $this->id; ?>][answer][value][]"  value="Essay" />
						<input type="radio" name="learn_press_question[<?php echo $this->id; ?>][checked][]" <?php checked( $answer['is_true'] == 'yes', true ); ?> value="<?php echo $value; ?>" />
					</th>
					
				</tr>

				<?php do_action( 'learn_press_after_question_answer_option', $this ); ?>

			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	
</div>
