<div id="left">
	<div>
		<p>基本信息：</p>
		<img src="aa" alt="">
		<p><?=$name?>, 第<?=$id?>号会员，注册于<?=date('Y-m-d H:i', $created)?>, 在<?=date('Y-m-d H:i', $last_login_time)?>最后登入。</p>
		<table>
			<tr>
				<th>性别：</th>
				<td><?=$sex?></td>
			</tr>
			<tr>
				<th>生日：</th>
				<td><?=$birth?></td>
			</tr>
			<tr>
				<th>来自：</th>
				<td><?=$from?></td>
			</tr>
			<tr>
				<th>现居：</th>
				<td><?=$live?></td>
			</tr>
			<tr>
				<th>婚姻状况：</th>
				<td><?=$married?></td>
			</tr>
			<tr>
				<th>职业：</th>
				<td><?=$job?></td>
			</tr>
			<tr>
				<th>个性签名：</th>
				<td><?=$sign?></td>
			</tr>
		</table>
	</div>
	
	<hr>
	
	<div>
		<?if($n_bbs_post):?>
		<h3><?=$name?>最近创建的主题：</h3>
		<ul>
			<?foreach($bbs_posts as $post):?>
			<li>
				<?=beautify_time($post['ctime'])?>前创建了主题 <a target="_blank" href="/bbs/post/<?=$post['id']?>"><?=$post['title']?></a>
			</li>
			<?endforeach?>
		</ul>
		<?else:?>
		<p><?=$name?>还没创建过任何主题。</p>
		<?endif?>

		<?if($n_bbs_cmt):?>
		<h3><?=$name?>最近发表的评论：</h3>
		<ul>
			<?foreach($bbs_cmts as $cmt):?>
			<li>
				<p>在<?=beautify_time($cmt['ctime'])?>前回复主题：<a target="_blank" href="/bbs/post/<?=$cmt['pid']?>#cmt_<?=$cmt['id']?>"><?=$cmt['title']?></a></p>
				<p><?=$cmt['content']?></p>
			</li>
			<?endforeach?>
		</ul>
		<?else:?>
		<p><?=$name?>还没发表过任何评论。</p>
		<?endif?>
	</div>

</div>