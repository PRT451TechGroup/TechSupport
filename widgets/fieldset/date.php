<label><?=$label?></label>
<fieldset data-role="controlgroup" data-type="horizontal" class="fieldset-date">
	<label for="<?=$prefix?>year"><?=Language::year()?></label>
	<select name="<?=$prefix?>year" data-iconpos="noicon" class="field-year">
		<?php for($i=2015;$i<=2020;$i++): ?>
		<option value="<?=$i?>"<?=Widgets::selected($year, $i)?>><?=$i?></option>
		<?php endfor; ?>
	</select>
	
	<label for="<?=$prefix?>month"><?=Language::month()?></label>
	<select name="<?=$prefix?>month" data-iconpos="noicon" class="field-month">
		<?php for($i=1;$i<=12;$i++): ?>
		<option value="<?=$i?>"<?=Widgets::selected($month, $i)?>><?=Language::monthat(array("month" => $i-1))?></option>
		<?php endfor; ?>
	</select>
	
	<label for="<?=$prefix?>day"><?=Language::day()?></label>
	<select name="<?=$prefix?>day" data-iconpos="noicon" class="field-day">
		<?php for($i=1;$i<=31;$i++): ?>
		<option value="<?=$i?>"<?=Widgets::selected($day, $i)?>><?=$i?></option>
		<?php endfor; ?>
	</select>
</fieldset>
