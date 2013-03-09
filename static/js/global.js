/* bbs */

(function(){
	$(function(){
		/* bbs-add */
		if($('#bbs-title').length)
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
				$.post('/index.php/utils/cmt_add', {cnt:cnt}, function(r){
					console.log(r)
				})
			})
		}
	})
})()