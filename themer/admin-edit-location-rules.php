<?php
/**
 * Location rules meta box template for WSBB Themer.
 *
 * @since 1.0
 * @var array $locations All available location groups.
 * @var array $saved_locations Currently saved location strings.
 */

defined( 'ABSPATH' ) || exit;
?>
<table class="wsbb-locations-form form-table">
	<tr>
		<th scope="row">
			<label><?php esc_html_e( 'Location', 'wsbb' ); ?></label>
		</th>
		<td>
			<div class="wsbb-saved-locations">
				<?php if ( ! empty( $saved_locations ) ) : ?>
					<?php foreach ( $saved_locations as $saved ) : ?>
						<div class="wsbb-location-rule">
							<input type="text" name="wsbb_locations[]" value="<?php echo esc_attr( $saved ); ?>" readonly />
							<button type="button" class="button wsbb-remove-location"><?php esc_html_e( 'Remove', 'wsbb' ); ?></button>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<div class="wsbb-add-location-row">
				<select class="wsbb-location-group">
					<option value=""><?php esc_html_e( 'Select Group...', 'wsbb' ); ?></option>
					<?php foreach ( $locations as $group_key => $group ) : ?>
						<option value="<?php echo esc_attr( $group_key ); ?>"><?php echo esc_html( $group['label'] ); ?></option>
					<?php endforeach; ?>
				</select>

				<select class="wsbb-location-type" disabled>
					<option value=""><?php esc_html_e( 'Select Location...', 'wsbb' ); ?></option>
				</select>

				<select class="wsbb-location-object" disabled style="display:none;">
					<option value=""><?php esc_html_e( 'Select Specific...', 'wsbb' ); ?></option>
				</select>

				<button type="button" class="button wsbb-add-location"><?php esc_html_e( 'Add', 'wsbb' ); ?></button>
			</div>

			<p class="description">
				<?php esc_html_e( 'Choose where this layout should appear. Multiple locations can be added.', 'wsbb' ); ?>
			</p>
		</td>
	</tr>
</table>

<script>
(function() {
	// Location data from PHP.
	var locationsData = <?php echo json_encode( $locations ); ?>;

	var groupSelect = document.querySelector('.wsbb-location-group');
	var typeSelect = document.querySelector('.wsbb-location-type');
	var objectSelect = document.querySelector('.wsbb-location-object');
	var addBtn = document.querySelector('.wsbb-add-location');
	var savedContainer = document.querySelector('.wsbb-saved-locations');

	// Populate type select based on group.
	groupSelect.addEventListener('change', function() {
		var groupKey = this.value;
		typeSelect.innerHTML = '<option value=""><?php esc_html_e( 'Select Location...', 'wsbb' ); ?></option>';
		typeSelect.disabled = true;
		objectSelect.style.display = 'none';
		objectSelect.disabled = true;

		if (!groupKey || !locationsData[groupKey]) return;

		var group = locationsData[groupKey];
		typeSelect.disabled = false;

		group.locations.forEach(function(loc) {
			var opt = document.createElement('option');
			opt.value = loc.value;
			opt.textContent = loc.label;
			opt.dataset.type = loc.type || '';
			opt.dataset.hasObjects = loc.hasObjects ? '1' : '0';
			typeSelect.appendChild(opt);
		});
	});

	// Show object select when location type supports it.
	typeSelect.addEventListener('change', function() {
		var opt = this.options[this.selectedIndex];
		var hasObjects = opt.dataset.hasObjects === '1';

		if (hasObjects && opt.value) {
			objectSelect.style.display = 'inline-block';
			objectSelect.disabled = false;
			objectSelect.innerHTML = '<option value=""><?php esc_html_e( 'Select Specific...', 'wsbb' ); ?></option>';

			var objects = locationsData[groupSelect.value].objects || {};
			var typeKey = opt.value;

			if (objects[typeKey]) {
				objects[typeKey].forEach(function(obj) {
					var o = document.createElement('option');
					o.value = obj.value;
					o.textContent = obj.label;
					objectSelect.appendChild(o);
				});
			}
		} else {
			objectSelect.style.display = 'none';
			objectSelect.disabled = true;
		}
	});

	// Add location.
	addBtn.addEventListener('click', function() {
		var typeVal = typeSelect.value;
		if (!typeVal) return;

		var location = typeVal;
		var objVal = objectSelect.value;
		if (objVal) {
			location += ':' + objVal;
		}

		// Check for duplicates.
		var existing = savedContainer.querySelectorAll('input[name="wsbb_locations[]"]');
		for (var i = 0; i < existing.length; i++) {
			if (existing[i].value === location) return;
		}

		var div = document.createElement('div');
		div.className = 'wsbb-location-rule';
		div.innerHTML = '<input type="text" name="wsbb_locations[]" value="' + location + '" readonly /> ' +
			'<button type="button" class="button wsbb-remove-location"><?php esc_html_e( 'Remove', 'wsbb' ); ?></button>';
		savedContainer.appendChild(div);

		// Reset selects.
		groupSelect.value = '';
		typeSelect.innerHTML = '<option value=""><?php esc_html_e( 'Select Location...', 'wsbb' ); ?></option>';
		typeSelect.disabled = true;
		objectSelect.style.display = 'none';
		objectSelect.disabled = true;
	});

	// Remove location (event delegation).
	savedContainer.addEventListener('click', function(e) {
		if (e.target.classList.contains('wsbb-remove-location')) {
			e.target.parentNode.remove();
		}
	});
})();
</script>
<style>
.wsbb-location-rule {
	display: flex;
	align-items: center;
	gap: 8px;
	margin-bottom: 6px;
}
.wsbb-location-rule input[readonly] {
	background: #f0f0f1;
	flex: 1;
	max-width: 400px;
}
.wsbb-add-location-row {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 8px;
	margin-top: 8px;
}
.wsbb-add-location-row select {
	max-width: 250px;
}
</style>
