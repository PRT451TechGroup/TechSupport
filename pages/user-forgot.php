<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::forgot_password()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<form action="<?=APPDIR?>/user/forgot/submit" method="POST">
			<ul data-role="listview" data-inset="true">
				<li class="ui-field-contain">
					<label for="username"><?=Language::username()?></label>
					<input type="text" name="username" />
				</li>
				<li class="ui-field-contain">
					<label for="email"><?=Language::email()?></label>
					<input type="email" name="email" />
				</li>
				<li>
					<input type="submit" value="<?=Language::reset_password()?>" data-icon="action" />
				</li>
			</ul>
		</form>
	</div>
</div>
