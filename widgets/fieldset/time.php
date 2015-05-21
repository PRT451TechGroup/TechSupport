<label><?=$label?></label>
<fieldset class="ui-grid-a">
	<div class="ui-block-a">
		<label for="<?=$prefix?>hour"><?=Language::hour()?></label>
		<select name="<?=$prefix?>hour">
			<?php for($i=0;$i<24;$i++): ?>
			<option value="<?=$i?>" <?=Widgets::selected($hour, $i)?>><?=$i?></option>
			<?php endfor; ?>
		</select>
	</div>
	<div class="ui-block-b">
		<label for="<?=$prefix?>minute"><?=Language::minute()?></label>
		<select name="<?=$prefix?>minute">
			<?php for($i=0;$i<60;$i++): ?>
			<option value="<?=$i?>" <?=Widgets::selected($minute, $i)?>><?=$i?></option>
			<?php endfor; ?>
		</select>
	</div>
</fieldset>
