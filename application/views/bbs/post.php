<div id="left">
	<div id="bc"><?=$bc?></div>
	<div><?=$title?></div>
	<div>
		<a href="/index.php/user/<?=$uid?>"><?=$username?></a>
		发表于<?=beautify_time($ctime)?>前
	</div>
	<div><?=$content?></div>
	<div>
		<div>
			<a href="javascript:;">赞/取消赞</a>
			<a href="javascript:;">收藏/取消收藏</a>
		</div>
		<div>
			<span><?=$n_click?>点击</span>
			<span><?=$n_like?>赞</span>
			<span><?=$n_mark?>收藏</span>
		</div>
	</div>

	<div><?=$cmts?></div>
</div>

<?=$sidebar?>