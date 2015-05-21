<div data-role="page" data-redirect="<?=$redirect?>" data-history="false">
	<div data-role="header">
		<h1><?=$redirect?></h1>
	</div>
	<div data-role="content">
		<ul data-role="listview">
			<li><?=Language::redirecting_to()?></li>
			<li><a href="<?=$redirect?>"><?=htmlspecialchars($redirect)?></a></li>
		</ul>
	</div>
</div>
