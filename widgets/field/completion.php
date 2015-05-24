<?php
$theme = "cdefg";
$completion = intval($completion);

if ($completion < 0)
	$completion = 0;
elseif ($completion >= strlen($theme))
	$completion = strlen($theme)-1;

$theme = $theme{$completion};
?>
<label for="completion"><?=Language::completion_label()?></label>
<select name="completion" data-theme="<?=$theme?>">
	<?php for($i=0;$i<5;$i++): ?>
	<option value="<?=$i?>" <?=Widgets::selected($completion, $i)?>><?=Language::completion(array("completion" => $i))?></option>
	<?php endfor; ?>
</select>
