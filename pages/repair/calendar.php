<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=Language::repair_calendar()?></h1>
		 <?=Widgets::home()?> 
		<?=Widgets::back($back)?>
	</div>
	<?php
		$prevdate = false;
		function getTheme($completion)
		{
			$themes = "cdefg";
			$completion = intval($completion);
			if ($completion < 0)
				$completion = 0;
			elseif ($completion >= strlen($themes))
				$completion = strlen($themes)-1;

			return $themes{$completion}; 
		}
		function datediff($a, $b)
		{
			if (!is_string($a) || !is_string($b))
				return true;
			$ae = explode(" ", $a, 2);
			$be = explode(" ", $b, 2);

			return $ae[0] != $be[0];
		}
	?>
	<div data-role="content">
		<ul data-role="listview" class="requestreview">
			<?php foreach($repairs as $repair): ?>
				<?php if (datediff($repair["duedate"], $prevdate)): ?>
					<?php
						$prevdate = $repair["duedate"];
					?>
					<li data-role="list-divider"><?=date('l, jS \of F, Y', strtotime($repair["duedate"]))?></li>
				<?php endif; ?>
				
				<li data-theme="<?=getTheme($repair['completion'])?>">
					<a data-transition="slide" href="<?=$APPLET_ROOT.'/view/'.$repair['repairid']?>">
						<h2><?=htmlspecialchars($repair["name"])?></h2>
						<p><strong><?=date('H:i', strtotime($repair["duedate"]))?></strong></p>
						<p>Equipment: <?=$repair["equipmentcount"]?></p>
						<?php if (intval($repair["priority"]) > 0): ?>
							<span class="ui-li-count">!</span>
						<?php endif; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>