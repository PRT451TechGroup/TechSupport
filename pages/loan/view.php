<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::loan_view()?></h1>
		<a href="<?=$APPLET_ROOT.'/'.$loanid?>" class="ui-btn-right ui-btn ui-icon-edit ui-btn-icon-notext ui-corner-all">Edit</a>
		<?=Widgets::back($back)?>
	</div>
	<?php
	$loandate = new FSDateTime($loan["loandate"]);
	$returndate = new FSDateTime($loan["returndate"]);
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
			<li data-role="list-divider">Loan</li>
			<?php
				listEntry(Language::creditor(), $loan["creditor"]);
				listEntry(Language::debtor(), $loan["debtor"]);
				listEntry(Language::loandate(), date('Y-m-d', strtotime($loan["loandate"])));
				listEntry(Language::returndate(), date('Y-m-d', strtotime($loan["returndate"])));
				listEntry(Language::completion2(), intval($loan["completion"]) ? "Yes" : "No");
				listEntry(Language::priority(), intval($loan["priority"]) ? "Yes" : "No");
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
