<?php
$theme = "cdefg";
$theme = $theme{intval($completion)};
?>
<label for="completion"><?=Language::completion_label()?></label>
<select name="completion" data-theme="<?=$theme?>">
	<?php for($i=0;$i<5;$i++): ?>
	<option value="<?=$i?>" <?=Widgets::selected($completion, $i)?>><?=Language::completion(array("completion" => $i))?></option>
	<?php endfor; ?>
</select>
