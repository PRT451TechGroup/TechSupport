<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::login()?></h1>
	</div>
	<div data-role="content">
		<form action="<?=APPDIR?>/user/login" method="POST">
			<ul data-role="listview" data-inset="true">
				<li class="ui-field-contain">
					<label for="username"><?=Language::username()?></label>
					<input type="text" name="username" />
				</li>
				<li class="ui-field-contain">
					<label for="password"><?=Language::password()?></label>
					<input type="password" name="password" />
				</li>
				
				<li>
					<input type="submit" value="<?=Language::login()?>" data-icon="lock" />
				</li>
				<li>
					<a class="ui-btn ui-icon-user ui-btn-icon-left" href="<?=APPDIR?>/user/register"><?=Language::register()?></a>
				</li>
				<li>
					<a class="ui-btn ui-icon-refresh ui-btn-icon-left" href="<?=APPDIR?>/user/forgot"><?=Language::forgot_password()?></a>
				</li>
			</ul>
		</form?
	</div>
</div>
