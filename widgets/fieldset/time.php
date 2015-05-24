<label><?=$label?></label>
<fieldset data-role="controlgroup" data-type="horizontal" class="fieldset-time">
	
	<label for="<?=$prefix?>hour"><?=Language::hour()?></label>
	<select name="<?=$prefix?>hour" data-iconpos="noicon" class="field-number">
		<?php for($i=0;$i<24;$i++): ?>
		<option value="<?=$i?>" <?=Widgets::selected($hour, $i)?>><?=$i?></option>
		<?php endfor; ?>
	</select>
	
	<label for="<?=$prefix?>minute"><?=Language::minute()?></label>
	<select name="<?=$prefix?>minute" data-iconpos="noicon" class="field-number">
		<?php for($i=0;$i<60;$i++): ?>
		<option value="<?=$i?>" <?=Widgets::selected($minute, $i)?>><?=$i?></option>
		<?php endfor; ?>
	</select>
</fieldset>
