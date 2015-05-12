<div data-role="page" data-redirect="<?=Bean::redirect()?>" data-history="false">
	<div data-role="header">
		<h1><?=Language::redirect()?></h1>
	</div>
	<div data-role="content">
		<ul data-role="listview">
			<li><?=Language::redirecting_to()?></li>
			<li><a href="<?=Bean::redirect()?>"><?=Bean::text("redirect")?></a></li>
		</ul>
	</div>
</div>
