<div data-role="page" data-back="<?=APPDIR?>/user">
	<div data-role="header">
		<h1><?=Language::login()?></h1>
		<a href="#" data-rel="back" class="ui-btn-left ui-btn ui-icon-back ui-btn-icon-notext ui-shadow ui-corner-all"><?=Language::back()?></a>
	</div>
	<div data-role="content">
		<form action="<?=APPDIR?>/user/login/submit" method="POST">
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
			</ul>
		</form?
	</div>
</div>
