$(function(){
	/* bbs-add */
	if($('#bbs-add').length)
	{
		$('#bbs-add').click(function(){
			var data = {}, items = ['node', 'title', 'content']
			for (k in items)
			{
				var obj = $('#bbs-'+items[k]),
				 	val = $.trim(obj.val() + obj.html())
				if('' == val)
				{
					$('.warn').html('请把数据填写完整')
					return
				}
				data[items[k]] = val
			}
			$('.warn').html('发布中....')
			$.post('/index.php/bbs/ajax_add', data, function(r){
				if(!isNaN(r))
					location = "/index.php/bbs/post/" + r
			})
		})
	}

	/* cmt-add */
	if($('#cmt_submit').length)
	{
		var cnt_obj = $('#cmt_content'), warn = $('.warn')
		cnt_obj.focus(function(){ warn.html('') })	
		$('#cmt_submit').click(function(){
			var cnt = cnt_obj.html()
			if('' == cnt)
			{
				warn.html('请把数据填写完整')
				return false
			}
			warn.html('发布中....')
			$.post('/index.php/utils/bbs_cmt_add', {cnt:cnt}, function(r){
				location.reload()
			})
		})
	}

	/* action */
	if($('.action').length)
	{
		var type_map = {like:'赞', mark:'收藏'}
		$('.action').click(function(){
			var obj = $(this), data_arr = obj.attr('data-type').split('|'), act = obj.html().search('取消')+1, n_obj = obj.siblings('.n_' + data_arr[1]), n_origin = parseInt(n_obj.html())

			data = {model: data_arr[0], type: data_arr[1], id: data_arr[2], action: act}
			if(act)
			{
				n_origin -= 1
				obj.html(type_map[data.type])
			}
			else
			{
				n_origin += 1
				obj.html('取消' + type_map[data.type])
			}
			if(n_origin < 0) n_origin = 0
			n_obj.html(n_origin + type_map[data.type])

			$.post('/index.php/utils/action', data)
		})
	}
})