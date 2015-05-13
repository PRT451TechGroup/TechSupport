<div data-role="page" data-back="<?=APPDIR.Bean::back()?>" data-force-refresh="true">
	<div data-role="header">
		<h1><?=Language::equipment()?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back()?>
	</div>
	<?php
		function equipname($eq)
		{
			$aa = $eq["assetno"];
			$ee = $eq["equipmentname"];
			$a = strlen($aa) > 0;
			$e = strlen($ee) > 0;
			if ($a && $e)
			{
				return $ee." - ".$aa;
			}
			else if ($a)
			{
				return $aa;
			}
			else if ($e)
			{
				return $ee;
			}
			else
			{
				return Language::nonameset();
			}
		}
	?>
	<div data-role="content">
		<ul data-role="listview">
			<li data-icon="plus"><a href="<?=APPDIR.Bean::back()?>/equipment/create" data-transition="slide"><?=Language::newequip()?></a></li>
			<?php foreach(Bean::equipment() as $equipment): ?>
			<li><a href="<?=APPDIR.Bean::back()?>/equipment/<?=$equipment['equipmentid']?>" data-transition="slide"><?=equipname($equipment)?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
