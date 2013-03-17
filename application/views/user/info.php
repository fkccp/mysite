<div id="left">
	<div id="bc"><?=$bc?></div>
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

	<div>
		<p>bbs动态：</p>
	</div>
</div>