<div id="left">
	<div><?=$bc?></div>
	<a href="/index.php/bbs/add/<?=$nodename?>">添加新主题</a>
	<ul>
	<?foreach($list as $item):?>
	<li>
		<div>
			<p><a href="/index.php/bbs/post/<?=$item['id']?>"><?=$item['title']?></a></p>
			<p>
				<a href="/index.php/user/<?=$item['uid']?>"><?=$item['name']?></a>
				发表于<?=beautify_time($item['ctime'])?>前
			</p>
		</div>
	</li>
	<?endforeach?>
	</ul>

	<div id="pager"><?=$pager?></div>
</div>

<?=$sidebar?>