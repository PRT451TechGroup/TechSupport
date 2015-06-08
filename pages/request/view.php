<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::request_view()?></h1>
		<a href="<?=$APPLET_ROOT.'/'.$requestid?>" class="ui-btn-right ui-btn ui-icon-edit ui-btn-icon-notext ui-corner-all">Edit</a>
		<?=Widgets::back($back)?>
	</div>
	<?php
	function listEntry($name, $value)
	{
		echo '<li class="ui-grid-a propertylist"><div class="ui-block-a">'.htmlspecialchars($name).'</div><div class="ui-block-b">'.htmlspecialchars($value).'</div></li>';
	}
	?>
	<div data-role="content">
		<ul data-role="listview" data-inset="false">
			<li data-role="list-divider">Loan</li>
			<?php
				listEntry(Language::techname(), $request["techname"]);
				listEntry(Language::staffname(), $request["staffname"]);
				listEntry(Language::location(), $request["location"]);
				listEntry(Language::duedate(), date('Y-m-d H:i', strtotime($request["duedate"])));
				listEntry(Language::completion2(), intval($request["completed"]) ? "Yes" : "No");
				listEntry(Language::priority(), intval($request["priority"]) ? "Yes" : "No");
			?>
		</ul>
	</div>
</div>
