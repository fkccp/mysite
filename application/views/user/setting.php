<div id="left">
	<div class="setting">
		<form action="" method="post">
		<table border="0">
			<tr>
				<th width="80px">性别：</th>
				<td width="150px">
					<label> <input type="radio" name="sex" value="m" <?if(1 == $sex):?>checked<?endif?>> 男</label>
					&nbsp; &nbsp;
					<label> <input type="radio" name="sex" value="w" <?if(1 != $sex):?>checked<?endif?>> 女</label>
					&nbsp; &nbsp;
					<label> <input type="checkbox" name="sex_pub" <?if(0 == $sex_pub):?>checked<?endif?>> 不公开</label>
				</td>
			</tr>
			<tr>
				<th>生日：</th>
				<td>
					<input type="text" name="birth" value="<?=$birth?>">
					&nbsp;&nbsp;<label> <input type="checkbox" name="birth_pub" <?if(0 == $birth_pub):?>checked<?endif?>> 不公开</label>
					&nbsp;&nbsp;(格式：19851231)
				</td>
			</tr>
			<tr>
				<th>来自：</th>
				<td>
					<input type="text" class="wid" readonly value="<?=$from?>">
					<a href="javascript:;" class="mod_city">更改</a>
					<input type="hidden" name="from_id">
				</td>
			</tr>
			<tr>
				<th>现居：</th>
				<td>
					<input type="text" class="wid" readonly value="<?=$live?>">
					<a href="javascript:;" class="mod_city">更改</a>
					<input type="hidden" name="live_id">
				</td>
			</tr>
			<tr>
				<th>婚姻状况：</th>
				<td>
					<label> <input type="radio" name="ma" value="s" <?if(1 == $married):?>checked<?endif?>> 单身</label>
					&nbsp; &nbsp;
					<label> <input type="radio" name="ma" value="l" <?if(2 == $married):?>checked<?endif?>> 热恋中</label>
					&nbsp; &nbsp;
					<label> <input type="radio" name="ma" value="m" <?if(3 == $married):?>checked<?endif?>> 已婚</label>
					&nbsp; &nbsp;
					<label> <input type="checkbox" name="ma_pub" <?if(0 == $married_pub):?>checked<?endif?>> 不公开</label>
				</td>
			</tr>
			<tr>
				<th>职业：</th>
				<td><input type="text" name="job" class="wid" value="<?=$job?>"></td>
			</tr>
			<tr>
				<th style="vertical-align: top">个性签名：</th>
				<td>
					<textarea name="sign" cols="50" rows="5"><?=$sign?></textarea>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="保存" style="width:70px"></td>
			</tr>
		</table>
		</form>
	</div>

	<table id="choose_city" tabindex="0">
		<tr><th><div>&lt;</div></th>
		<td>
			<div id="citybox">
				<ul>
					<?foreach($states as $state):?>
					<li><a href="javascript:;" data-id="<?=$state['sid']?>"><?=$state['name']?></a></li>
					<?endforeach?>
				</ul>
				<ul></ul>
				<ul></ul>
				<ul></ul>
				<p class="warn"> &nbsp; </p>
				<div class="clear"></div>
			</div>
		</td></tr>
	</table>
</div>