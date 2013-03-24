<div id="left">
	<a href="?readall=true">全部标记为已读</a>
	<ul id='msg_list'>
		<?foreach($list as $item):?>
		<li <?if(!$item['has_read']):?>class="msg_unread"<?endif?>>
			<?if($item['cid']):?>
			<?=$item['name']?>在<?=beautify_time($item['ctime'])?>前回复了您对主题<a class="msg_clk" data-id="<?=$item['id']?>" target="_blank" href="/bbs/post/<?=$item['pid']?>#cmt_<?=$item['cid']?>">《<?=$item['title']?>》</a>的评论，<a class="msg_clk" data-id="<?=$item['id']?>" target="_blank" href="/bbs/post/<?=$item['pid']?>#cmt_<?=$item['cid']?>">点击查看详情</a>。
			<?else:?>
			<?=$item['name']?>在<?=beautify_time($item['ctime'])?>前回复了您的主题<a class="msg_clk" data-id="<?=$item['id']?>" target="_blank" href="/bbs/post/<?=$item['pid']?>">《<?=$item['title']?>》</a>，<a class="msg_clk" data-id="<?=$item['id']?>" target="_blank" href="/bbs/post/<?=$item['pid']?>">点击查看详情</a>。
			<?endif?>
		</li>
		<?endforeach?>
	</ul>
	<div id="pager"><?=$pager?></div>
</div>