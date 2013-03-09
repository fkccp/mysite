<div>30 条回复</div>
<ul>
<?foreach($list as $item):?>
<li><?=$item?></li>
<?endforeach?>
</ul>

<div>
	添加回复：<br />
	<div class="cmt_content" id="cmt_content" contenteditable="true"></div>
	<p class="warn"></p>
	<a href="javascript:;" id="cmt_submit">提交</a>
</div>