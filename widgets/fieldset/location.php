<label><?=Language::location()?></label>
<fieldset data-role="controlgroup" data-type="horizontal" class="fieldset-location">
	
	
	<label for="precinct"><?=Language::precinct()?></label>
	<select name="precinct" data-iconpos="noicon" class="field-precinct">
		<?php foreach(array("Blue", "Green", "Orange", "Pink", "Purple", "Red", "Yellow") as $i): ?>
		<option value="<?=$i?>" <?=Widgets::selected($precinct, $i)?>><?=$i?></option>
		<?php endforeach; ?>
	</select>
	
	<label for="building"><?=Language::building()?></label>
	<select name="building" data-iconpos="noicon" class="field-number">
		<?php for($i=1;$i<=20;$i++): ?>
		<option value="<?=$i?>" <?=Widgets::selected($building, $i)?>><?=$i?></option>
		<?php endfor; ?>
	</select>
	
	<label for="floor"><?=Language::floor()?></label>
	<select name="floor" data-iconpos="noicon" class="field-number">
		<?php for($i=1;$i<=3;$i++): ?>
		<option value="<?=$i?>" <?=Widgets::selected($floor, $i)?>><?=$i?></option>
		<?php endfor; ?>
	</select>
	
	<label for="room"><?=Language::room()?></label>
	<select name="room" data-iconpos="noicon" class="field-number">
		<?php for($i=1;$i<=25;$i++): ?>
		<option value="<?=$i?>" <?=Widgets::selected($room, $i)?>><?=$i?></option>
		<?php endfor; ?>
	</select>
</fieldset>
