<div data-role="page" data-back="<?=APPDIR?>/">
	<div data-role="header">
		<h1>User</h1>
		<a href="#" data-rel="back" class="ui-btn-left ui-btn ui-icon-back ui-btn-icon-notext ui-shadow ui-corner-all">Back</a>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true">
			<li data-icon="user"><a href="<?=Document::val('AppletDir')?>/login">Login</a></li>
			<li data-icon="user"><a href="<?=Document::val('AppletDir')?>/register">Register</a></li>
		</ul>
	</div>
</div>
