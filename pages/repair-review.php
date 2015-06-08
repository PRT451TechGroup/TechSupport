<div data-role="page" data-back="<?=APPDIR.$back?>">
	<div data-role="header">
		<h1><?=Language::repair_review()?></h1>
		 <?=Widgets::home()?> 
		<?=Widgets::back($back)?>
	</div>
	<div data-role="content">
		<ul data-role="listview">
			<?php for($i=0;$i<5;$i++): ?>
			<?php
			$text = Language::completion(array("completion" => $i));
			$bc = $completion;
			$theme = "cdefg";
			$theme = $theme{$i};
			if (isset($bc[$i]))
				$priority = intval($bc[$i]["prioritycount"]);
			else
				$priority = 0;
			?>
			<li data-theme="<?=$theme?>"><a href="<?=APPDIR?>/repair/review/<?=$i?>" data-transition="slide"><?=$text?><?php if ($priority):?><span class="ui-li-count"><?=$priority?></span><?php endif; ?></a></li>
			<?php endfor; ?>
		</ul>
	</div>
</div>