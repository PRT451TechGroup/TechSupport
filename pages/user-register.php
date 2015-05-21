<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::register()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<form action="<?=APPDIR?>/user/register/submit" method="POST">
			<ul data-role="listview" data-inset="true">
				<li class="ui-field-contain">
					<label for="username"><?=Language::username()?></label>
					<input type="text" name="username" />
				</li>
				<li class="ui-field-contain">
					<label for="password"><?=Language::password()?></label>
					<input type="password" name="password" />
				</li>
				<li class="ui-field-contain">
					<label for="vpassword"><?=Language::confirm_password()?></label>
					<input type="password" name="vpassword" />
				</li>
				<li>
					<input type="submit" value="<?=Language::register()?>" data-icon="user" />
				</li>
			</ul>
		</form?
	</div>
</div>
