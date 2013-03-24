<div id="left">
	<a href="/bbs/add/<?=$nodename?>">添加新主题</a>
	<ul>
	<?foreach($list as $item):?>
	<li>
		<div>
			<p><a href="/bbs/post/<?=$item['id']?>"><?=$item['title']?></a></p>
			<p>
				<a href="/user/<?=$item['uid']?>"><?=$item['name']?></a>
				发表于<?=beautify_time($item['ctime'])?>前
			</p>
		</div>
	</li>
	<?endforeach?>
	</ul>

	<div id="pager"><?=$pager?></div>
</div>

<?=$sidebar?>