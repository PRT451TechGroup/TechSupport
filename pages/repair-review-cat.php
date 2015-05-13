<div data-role="page" data-back="<?=APPDIR.Bean::back()?>">
	<div data-role="header">
		<h1><?=Language::completion(array("completion" => Bean::completion()))?></h1>
		<?=Widgets::logout()?>
		<?=Widgets::back()?>
	</div>
	<?php
		$theme = "cdefgh";
		$theme = $theme{Bean::completion()};
		function jobname($repair)
		{
			return (strlen($repair["name"]) > 0) ? $repair["name"] : ("Job #" . $repair["repairid"]);
		}
	?>
	<div data-role="content">
		<ul data-role="listview" class="jobreview" data-theme="<?=$theme?>">
			
			<?php $i = true; ?>
			<?php foreach(Bean::repairs() as $repairid => $repair): ?>
			<?php if ($repair["priority"]): ?>
			<?php if ($i): ?>
				<?php $i = false; ?>
				<li data-role="list-divider"><?=Language::job_priority()?></li>
			<?php endif; ?>
			<li>
				<a href="<?=APPDIR?>/repair/review/<?=Bean::completion().'/'.$repairid?>" data-transition="slide">
					<?=jobname($repair)?><span class="ui-li-count"><?=$repair["location"]?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php endforeach; ?>
			
			<?php $i = true; ?>
			<?php foreach(Bean::repairs() as $repairid => $repair): ?>
			<?php if (!$repair["priority"]): ?>
			<?php if ($i): ?>
				<?php $i = false; ?>
				<li data-role="list-divider"><?=Language::job_normal()?></li>
			<?php endif; ?>
			<li>
				<a href="<?=APPDIR?>/repair/review/<?=Bean::completion().'/'.$repairid?>" data-transition="slide">
					<?=jobname($repair)?><span class="ui-li-count"><?=$repair["location"]?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php endforeach; ?>
			<?php if (count(Bean::repairs()) == 0): ?>
				<li data-role="list-divider"><?=Language::job_none()?></li>
				<li>
					<a href="<?APPDIR.Bean::back()?>" data-rel="back" class="ui-btn-icon-left ui-btn ui-icon-back"><?=Language::back()?></a>;
				</li>
			<?php endif; ?>
		</ul>
	</div>
</div>