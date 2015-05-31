<label for="completion"><?=Language::completion2()?></label>
<select name="completion" data-role="flipswitch">
	<option value="0" <?=Widgets::selected($completion, 0)?>><?=Language::completion_no()?></option>
	<option value="1" <?=Widgets::selected($completion, 1)?>><?=Language::completion_yes()?></option>
</select>
