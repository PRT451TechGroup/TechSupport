<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::repair_view()?></h1>
		<a href="<?=$APPLET_ROOT.'/'.$repairid?>" class="ui-btn-right ui-btn ui-icon-edit ui-btn-icon-notext ui-corner-all">Edit</a>
		<?=Widgets::back($back)?>
	</div>
	<?php
	function listEntry($name, $value)
	{
		echo '<li class="ui-grid-a propertylist"><div class="ui-block-a">'.htmlspecialchars($name).'</div><div class="ui-block-b">'.htmlspecialchars($value).'</div></li>';
	}
	function equipmentEntry($equipment)
	{
		$name = $equipment["equipmentname"];
		$assetno = $equipment["assetno"];
		$lname = strlen($name) !== 0;
		$lasset = strlen($assetno) !== 0;
		$ret = "";

		if ($lname && $lasset)
		{
			$ret = "$name - $assetno";
		}
		elseif ($lname && !$lasset)
		{
			$ret = $lname;
		}
		elseif (!$lname && $lasset)
		{
			$ret = $lasset;
		}
		else if (!$lname && !$lasset)
		{
			$ret = "Equipment #" . $equipment["equipmentid"];
		}
		
		return htmlspecialchars($ret);
	}
	?>
	<div data-role="content">
		<ul data-role="listview" data-inset="false">
			<li data-role="list-divider">Repair</li>
			<?php
				listEntry(Language::jobname(), $repair["name"]);
				listEntry(Language::complainer(), $repair["complainer"]);
				listEntry(Language::location(), $repair["location"]);
				listEntry(Language::duedate(), date('Y-m-d H:i', strtotime($repair["duedate"])));
				listEntry(Language::priority(), intval($repair["priority"]) ? "Yes" : "No");
				listEntry(Language::completion_label(), Language::completion(array("completion" => $repair["completion"])));
			?>
			<li data-role="list-divider">Equipment</li>
			<?php foreach($equipment as $equip): ?>
				<li><?=equipmentEntry($equip)?></li>
			<?php endforeach; ?>
			<?php if(count($equipment) === 0): ?>
				<li>None</li>
			<?php endif; ?>
		</ul>
	</div>
</div>
