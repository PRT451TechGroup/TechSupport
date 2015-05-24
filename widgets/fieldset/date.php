<label><?=$label?></label>
<fieldset class="ui-grid-a">
		<label for="<?=$prefix?>year"><?=Language::year()?></label>
		<select name="<?=$prefix?>year">
			<?php for($i=2015;$i<=2020;$i++): ?>
			<option value="<?=$i?>"<?=Widgets::selected($year, $i)?>><?=$i?></option>
			<?php endfor; ?>
		</select>
	<div class="ui-block-a">
		<label for="<?=$prefix?>month"><?=Language::month()?></label>
		<select name="<?=$prefix?>month">
			<?php for($i=1;$i<=12;$i++): ?>
			<option value="<?=$i?>"<?=Widgets::selected($month, $i)?>><?=Language::monthat(array("month" => $i-1))?></option>
			<?php endfor; ?>
		</select>
	</div>
	<div class="ui-block-b">
		<label for="<?=$prefix?>day"><?=Language::day()?></label>
		<select name="<?=$prefix?>day">
			<?php for($i=1;$i<=31;$i++): ?>
			<option value="<?=$i?>"<?=Widgets::selected($day, $i)?>><?=$i?></option>
			<?php endfor; ?>
		</select>
	</div>
</fieldset>
