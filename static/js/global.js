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
			$.post('/bbs/ajax_add', data, function(r){
				if(!isNaN(r))
					location = "/bbs/post/" + r
			})
		})
	}

	/* bs-append */
	if($('#bbs-append').length)
	{
		$('#bbs-append').click(function(){
			var o = $('#bbs-content')
			if('' == o.html())
			{
				$('.warn').html('请把数据填写完整')
				return
			}
			$('.warn').html('发布中....')
			$.post('/bbs/ajax_append', {cnt: o.html()}, function(r){
				if(!isNaN(r))
					location = "/bbs/post/" + r
			})
		})
	}

	/* cmt-add */
	if($('.cmt_submit').length)
	{
		(function(){
			var init_cmt_box = function(box, cmtid)
			{
				var warn = box.find('.warn'),
					cnt_obj = box.find('.cmt_content').focus(function(){warn.html('')}),
					cmtid = cmtid || 0

				if(cmtid)
					cnt_obj.focus()

				box.find('.cmt_submit').click(function(){
					var cnt = cnt_obj.html()
					if('' == cnt)
					{
						warn.html('请把数据填写完整')
						return false
					}
					warn.html('发布中....')
					$.post('/utils/bbs_cmt_add', {cnt:cnt, cmtid:cmtid}, function(r){
							location.reload()
						})
				})
			}
			init_cmt_box($('#cmt_box'))

			$('.cmt_reply').click(function(){
				var reply_box = $(this).parent().siblings('.cmt_reply_box'),
					tpl = $('#cmt_box').clone().attr('id', ''),
					cmtid = $(this).attr('data-cmtid')

				if(!reply_box.children().length)
				{
					$('<a href="javascript:;">取消</a>').click(function(){
						$(this).parent().parent().html('')
					}).appendTo(tpl)
					reply_box.append(tpl)
					init_cmt_box(reply_box, cmtid)
				}
			})
		})()
	}

	/* action */
	if($('.action').length)
	{
		(function(){
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

				$.post('/utils/action', data)
			})
		})()
	}

	/* choose city */
	if($('#choose_city').length)
	{
		(function(){
			var choose_city = $('#choose_city'), mod_city = $('.mod_city'), citybox = $('#citybox'), uls = citybox.children('ul'), ul0 = $(uls.get(0)), warn = $('.warn'), city_type = 0, ul_index = 0, ids = [], names = []
			mod_city.click(function(){
				ids = [], names = []
				city_type = mod_city.index(this)
				if(0 == city_type)
					choose_city.css('top', 160)
				else
					choose_city.css('top', 215)
				ul0.children().removeClass('on')
				uls.not(ul0).html('')
				choose_city.show().focus()
			})

			choose_city.blur(function(){choose_city.hide()})

			uls.children().click(click_func)

			function click_func()
			{
				var o = $(this), next_ul = null
				ul_index = o.parent().index(uls)
				ul_index = uls.index(o.parent())
				o.addClass('on').siblings().removeClass('on')
				next_ul = $(uls.get(ul_index+1))

				ids[ul_index] = o.children().attr('data-id')
				ids = ids.splice(0, ul_index+1)
				names[ul_index] = o.children().html()
				names = names.splice(0, ul_index+1)

				for(i = ul_index+1; i < 4; i++)
				{
					uls.get(i).innerHTML = ''
				}

				if(ul_index < 3)
				{
					warn.html('数据载入中……')
					$.get('/utils/city', {ids:ids, index:ul_index}, function(r){
						if(0 != r.length)
							render(next_ul, r)
						else
							choose_city.hide()
					}, 'json')
				}
				else
					choose_city.hide()

				$(mod_city.get(city_type)).siblings('input[type=text]').val(names.join(' '))
				$(mod_city.get(city_type)).siblings('input[type=hidden]').val(ids.join(''))

				return false
			}

			function render(o, data)
			{
				var s = '';
				for(i in data)
				{
					s += '<li><a href="javascript:;" data-id="'+i+'">'+data[i]+'</a></li>';
				}
				o.html(s).children().click(click_func)
				warn.html(' ')
			}
		})()
	}

	if($('#msg_list').length)
	{
		(function(){
			$('.msg_clk').click(function(){
				
			})
		})()
	}

})