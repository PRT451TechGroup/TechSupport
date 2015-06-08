<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::change_password()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<form action="<?=APPDIR?>/user/change" method="POST">
			<ul data-role="listview" data-inset="true">
				<li class="ui-field-contain">
					<label for="oldpassword"><?=Language::old_password()?></label>
					<input type="password" name="oldpassword" />
				</li>
				<li class="ui-field-contain">
					<label for="password"><?=Language::new_password()?></label>
					<input type="password" name="password" />
				</li>
				<li class="ui-field-contain">
					<label for="vpassword"><?=Language::new_password_confirm()?></label>
					<input type="password" name="vpassword" />
				</li>
				<li>
					<input type="submit" value="<?=Language::change_password()?>" data-icon="user" />
				</li>
			</ul>
		</form>
	</div>
</div>
