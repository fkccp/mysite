<div id="left">
	<div id="bc"><?=$bc?></div>
	<div><?=$title?></div>
	<div>
		<a href="/index.php/user/<?=$uid?>"><?=$username?></a>
		发表于<?=beautify_time($ctime)?>前
	</div>
	<div><?=$content?></div>
	<div>
			<a href="javascript:;" class="action" data-type="bbs|like|<?=$id?>"><?if($has_like):?>取消<?endif?>赞</a>
			<a href="javascript:;" class="action" data-type="bbs|mark|<?=$id?>"><?if($has_mark):?>取消<?endif?>收藏</a>
			<span><?=$n_click?>点击</span>
			<span class="n_like"><?=$n_like+1?>赞</span>
			<span class="n_mark"><?=$n_mark+1?>收藏</span>
	</div>

	<div><?=$cmts?></div>
</div>

<?=$sidebar?>