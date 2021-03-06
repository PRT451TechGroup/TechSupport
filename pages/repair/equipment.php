<div data-role="page" data-back="<?=APPDIR.$back?>" data-force-refresh="true">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::equipment()?></h1>
		 <?=Widgets::home()?> 
		<?=Widgets::back($back)?>
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
			<li data-icon="plus"><a href="<?=$APPLET_ROOT.'/'.$repairid?>/equipment/create" data-transition="slide"><?=Language::newequip()?></a></li>
			<?php foreach($equipment as $equip): ?>
			<li><a href="<?=$APPLET_ROOT.'/'.$repairid?>/equipment/<?=$equip['equipmentid']?>" data-transition="slide"><?=equipname($equip)?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>