<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::review_user()?></h1>
		<?=Widgets::home()?>
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
			<li data-role="list-divider">User</li>
			<?php
				listEntry(Language::username(), $user["username"]);
				listEntry(Language::email(), $user["email"]);
			?>
			<li data-icon="delete"><a href="<?="$APPLET_ROOT/approve/$userid/reject"?>"><?=Language::reject()?></a></li>
			<li data-icon="check"><a href="<?="$APPLET_ROOT/approve/$userid/approve"?>"><?=Language::approve()?></a></li>
		</ul>
	</div>
</div>
