<?php
include dirname(__FILE__).'/item.preprocessing.js.php';
include dirname(__FILE__).'/editabletable.js.php';
?>
<script type="text/x-jquery-tmpl" id="custom_intervals_row">
	<tr class="form_row">
		<td>
			<ul class="<?= ZBX_STYLE_RADIO_SEGMENTED ?>" id="delay_flex_#{rowNum}_type">
				<li>
					<input type="radio" id="delay_flex_#{rowNum}_type_0" name="delay_flex[#{rowNum}][type]" value="0" checked="checked">
					<label for="delay_flex_#{rowNum}_type_0"><?= _('Flexible') ?></label>
				</li><li>
					<input type="radio" id="delay_flex_#{rowNum}_type_1" name="delay_flex[#{rowNum}][type]" value="1">
					<label for="delay_flex_#{rowNum}_type_1"><?= _('Scheduling') ?></label>
				</li>
			</ul>
		</td>
		<td>
			<input type="text" id="delay_flex_#{rowNum}_delay" name="delay_flex[#{rowNum}][delay]" maxlength="255" placeholder="<?= ZBX_ITEM_FLEXIBLE_DELAY_DEFAULT ?>">
			<input type="text" id="delay_flex_#{rowNum}_schedule" name="delay_flex[#{rowNum}][schedule]" maxlength="255" placeholder="<?= ZBX_ITEM_SCHEDULING_DEFAULT ?>" style="display: none;">
		</td>
		<td>
			<input type="text" id="delay_flex_#{rowNum}_period" name="delay_flex[#{rowNum}][period]" maxlength="255" placeholder="<?= ZBX_DEFAULT_INTERVAL ?>">
		</td>
		<td>
			<button type="button" id="delay_flex_#{rowNum}_remove" name="delay_flex[#{rowNum}][remove]" class="<?= ZBX_STYLE_BTN_LINK ?> element-table-remove"><?= _('Remove') ?></button>
		</td>
	</tr>
</script>
<script type="text/javascript">
	jQuery(function($) {
		$('#visible_type, #visible_interface').click(function() {
			// if no item type is selected, reset the interfaces to default
			if (!$('#visible_type').is(':checked')) {
				var itemInterfaceTypes = <?= CJs::encodeJson(itemTypeInterface()) ?>;
				organizeInterfaces(itemInterfaceTypes[<?= CJs::encodeJson($data['initial_item_type']) ?>]);
			}
			else {
				$('#type').trigger('change');
			}
		});

		$('#type')
			.change(function() {
				// update the interface select with each item type change
				var itemInterfaceTypes = <?= CJs::encodeJson(itemTypeInterface()) ?>;
				organizeInterfaces(itemInterfaceTypes[parseInt(jQuery(this).val())]);
			})
			.trigger('change');

		$('#custom_intervals').on('click', 'input[type="radio"]', function() {
			var rowNum = $(this).attr('id').split('_')[2];

			if ($(this).val() == <?= ITEM_DELAY_FLEXIBLE; ?>) {
				$('#delay_flex_' + rowNum + '_schedule').hide();
				$('#delay_flex_' + rowNum + '_delay').show();
				$('#delay_flex_' + rowNum + '_period').show();
			}
			else {
				$('#delay_flex_' + rowNum + '_delay').hide();
				$('#delay_flex_' + rowNum + '_period').hide();
				$('#delay_flex_' + rowNum + '_schedule').show();
			}
		});

		$('#custom_intervals').dynamicRows({
			template: '#custom_intervals_row'
		});

		$('input[name=massupdate_app_action]').change(function() {
			var massupdate_app_action = $('input[name=massupdate_app_action]:checked').val(),
				add_new = !(massupdate_app_action == <?= ZBX_MULTISELECT_REMOVE ?>);

			$('#applications_').multiSelect('modify', {'addNew': add_new});
		});

		<?php if (array_key_exists('parent_discoveryid', $data)): ?>
			$('input[name=massupdate_app_prot_action]').change(function() {
				var massupdate_app_prot_action = $('input[name=massupdate_app_prot_action]:checked').val(),
					add_new = !(massupdate_app_prot_action == <?= ZBX_MULTISELECT_REMOVE ?>);

				$('#application_prototypes_').multiSelect('modify', {'addNew': add_new});
			});
		<?php endif ?>
	});
</script>
