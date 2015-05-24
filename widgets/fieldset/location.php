<label><?=Language::location()?></label>
<fieldset class="ui-grid-b">
	<label for="precinct"><?=Language::precinct()?></label>
	<select name="precinct">
		<?php foreach(array("Blue", "Green", "Orange", "Pink", "Purple", "Red", "Yellow") as $i): ?>
		<option value="<?=$i?>" <?=Widgets::selected($precinct, $i)?>><?=$i?></option>
		<?php endforeach; ?>
	</select>
	<div class="ui-block-a">
		<label for="building"><?=Language::building()?></label>
		<select name="building">
			<?php for($i=1;$i<=20;$i++): ?>
			<option value="<?=$i?>" <?=Widgets::selected($building, $i)?>><?=$i?></option>
			<?php endfor; ?>
		</select>
	</div>
	<div class="ui-block-b">
		<label for="floor"><?=Language::floor()?></label>
		<select name="floor">
			<?php for($i=1;$i<=3;$i++): ?>
			<option value="<?=$i?>" <?=Widgets::selected($floor, $i)?>><?=$i?></option>
			<?php endfor; ?>
		</select>
	</div>
	<div class="ui-block-c">
		<label for="room"><?=Language::room()?></label>
		<select name="room">
			<?php for($i=1;$i<=25;$i++): ?>
			<option value="<?=$i?>" <?=Widgets::selected($room, $i)?>><?=$i?></option>
			<?php endfor; ?>
		</select>
	</div>
</fieldset>
