<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header" data-position="fixed">
		<h1><?=$calendar_title?></h1>
		 <?=Widgets::home()?> 
		<?=Widgets::back($back)?>
	</div>
	<?php
		$prevdiff = false;
		function getTheme($daydiff)
		{
			$themes = "cdefg";
			$daydiff = intval($daydiff) + 1;
			if ($daydiff < 0)
				$daydiff = 0;
			elseif ($daydiff >= strlen($themes))
				$daydiff = strlen($themes)-1;

			return $themes{$daydiff}; 
		}
		function diff_pos($x)
		{
			return ($x >= 0) ? intval($x) : -1;
		}
		function requestname($request)
		{
			return (strlen($request["staffname"]) > 0) ? $request["staffname"] : ("Request #" . $request["requestid"]);
		}
	?>
	<div data-role="content">
		<ul data-role="listview" class="requestreview">
			<?php foreach($requests as $request): ?>
				<?php if (diff_pos($request["daydiff"]) !== $prevdiff): ?>
					<?php
						$prevdiff = diff_pos($request["daydiff"]);
						$theme = getTheme($prevdiff);
					?>
					<?php if ($prevdiff < 0): ?>
						<li data-theme="<?=$theme?>" data-role="list-divider"><?=Language::request_overdue()?></li>
					<?php elseif ($prevdiff == 0): ?>
						<li data-theme="<?=$theme?>" data-role="list-divider"><?=Language::today()?></li>
					<?php elseif ($prevdiff == 1): ?>
						<li data-theme="<?=$theme?>" data-role="list-divider"><?=Language::tomorrow()?></li>
					<?php else: ?>
						<li data-theme="<?=$theme?>" data-role="list-divider"><?=date('l, jS \of F, Y', strtotime($request["duedate"]))?></li>
					<?php endif; ?>
				<?php endif; ?>
				
				<li>
					<a data-transition="slide" href="<?=$APPLET_ROOT.'/'.$calendar_mode.'/'.$request['requestid']?>">
						<h2><?=requestname($request)?></h2>
						<p><strong>Request Due <?=date('d M y', strtotime($request["duedate"]))?></strong></p>
						<?php if (intval($request["priority"]) > 0): ?>
							<span class="ui-li-count">!</span>
						<?php endif; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>