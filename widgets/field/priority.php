<label for="priority"><?=Language::priority()?></label>
<select name="priority" data-role="flipswitch">
	<option value="0" <?=Widgets::selected($priority, 0)?>><?=Language::priority_off()?></option>
	<option value="1" <?=Widgets::selected($priority, 1)?>><?=Language::priority_on()?></option>
</select>
