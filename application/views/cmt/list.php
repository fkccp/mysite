<div><?=$total?> 条回复</div>
<div>
	<?foreach($list as $k=>$item):?>
	<div>
		<a name="cmt_<?=$item['id']?>"></a>
		<p>
			<a href="/index.php/user/<?=$item['uid']?>"><?=$item['name']?></a>
			发表于<?=beautify_time($item['ctime'])?>前
			<span><?=$k+1?></span>
		</p>
		<p><?=$item['content']?></p>
		<p>
			<a href="javascript:;" class="action" data-type="cmt|like|<?=$item['id']?>"><?if($item['has_like']):?>取消<?endif?>赞</a>
			<a href="javascript:;">回复</a>

			<span class="n_like"><?=$item['n_like']?>赞</span>
		</p>
		<p><?=cmt_seainfo($k+1)?></p>
	</div>
	<?endforeach?>
</div>

<div>
	添加回复：<br />
	<div class="cmt_content" id="cmt_content" contenteditable="true"></div>
	<p class="warn"></p>
	<a href="javascript:;" id="cmt_submit">提交</a>
</div>