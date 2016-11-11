	function linktag($field, $value, $fieldinfo) {
			$this->position_data_db = pc_base::load_model('linktag_to_content_model');
			$result = $this->position_data_db->select(array('content_id'=>$this->id, 'catid'=>$this->data['catid']),'linktag_id');
			foreach ($result as $tag) {
			$tags_arr[] = $tag['linktag_id'];
			}
			$this->position_data_db = pc_base::load_model('linktag_model');
			$position = $this->position_data_db->listinfo(array('delete_flag'=>0,'parent_id'=>0),'sort',0,100);
			foreach($position as $key=>$v){	
				$tags = $this->position_data_db->listinfo(array('delete_flag'=>0,'parent_id'=>$v['tag_id']),'sort',0,100);
				if ($key < 3) {
					$form .= "<ul style='display:block;clear:both;width:645px;' class='J_radio'><li style='float:left;'><b>【{$v['tag_name']}】:</b></li>";
					foreach($tags as $_key=>$_v) {
						if (in_array($_v['tag_id'], $tags_arr)) {
							$form .= "<li style='margin:3px 3px;line-height:16px;display:inline;cursor:pointer;'><a href='javascript:;' data='{$v['tag_id']}-{$_v['tag_id']}' class='linktag hover'>{$_v['tag_name']}</a></li>";
						} else {
							$form .= "<li style='margin:3px 3px;line-height:16px;display:inline;cursor:pointer;'><a href='javascript:;' data='{$v['tag_id']}-{$_v['tag_id']}' class='linktag'>{$_v['tag_name']}</a></li>";
						}
					}
					$form .= "</ul>";
				} else if ($key < 7) {
					$form .= "<ul style='display:block;clear:both;width:645px;' class='J_multiple'><li style='float:left;'><b>【{$v['tag_name']}】:</b></li>";
					foreach($tags as $_key=>$_v) {
						if ($_v['tag_id'] == 43) {
							if (in_array($_v['tag_id'], $tags_arr)) {
								$form .= "<li><a href='javascript:;' data='{$v['tag_id']}-{$_v['tag_id']}' class='linktag tafang hover'>{$_v['tag_name']}</a></li>";
							} else {
								$form .= "<li><a href='javascript:;' data='{$v['tag_id']}-{$_v['tag_id']}' class='linktag tafang'>{$_v['tag_name']}</a></li>";
							}
						} else if ($_v['tag_id'] == 14) {
							if (in_array($_v['tag_id'], $tags_arr)) {
								$form .= "<li><a href='javascript:;' data='{$v['tag_id']}-{$_v['tag_id']}' class='linktag sanxiao hover'>{$_v['tag_name']}</a></li>";
							} else {
								$form .= "<li><a href='javascript:;' data='{$v['tag_id']}-{$_v['tag_id']}' class='linktag sanxiao'>{$_v['tag_name']}</a></li>";
							}
						}else {
							if (in_array($_v['tag_id'], $tags_arr)) {
								$form .= "<li><a href='javascript:;' data='{$v['tag_id']}-{$_v['tag_id']}' class='linktag hover'>{$_v['tag_name']}</a></li>";
							} else {
								$form .= "<li><a href='javascript:;' data='{$v['tag_id']}-{$_v['tag_id']}' class='linktag'>{$_v['tag_name']}</a></li>";
							}
						}
					}
					$form .= "</ul>";
				} else {

					$display = '';
					if ($v['tag_id'] == 85){
						$tag_tag = 'tafangList';
						if (in_array(43, $tags_arr)){
							$display = 'blk';
						}
					} else if($v['tag_id'] == 140) {
						$tag_tag = 'sanxiaoList';
						if (in_array(14, $tags_arr)){
							$display = 'blk';
						}
					}

					$form .= "<ul style='display:none; clear:both;width:645px;' class='J_radio clearfix {$tag_tag} {$display}'><li style='float:left;'><b>【{$v['tag_name']}】:</b></li>";
					foreach($tags as $_key=>$_v) {
						if (in_array($_v['tag_id'], $tags_arr)) {
							$form .= "<li style='margin:3px 3px; line-height:16px; display:inline; cursor:pointer;'><a href='javascript:;' data='{$v['tag_id']}-{$_v['tag_id']}' class='linktag hover'>{$_v['tag_name']}</a></li>";
						} else {
							$form .= "<li style='margin:3px 3px; line-height:16px; display:inline; cursor:pointer;'><a href='javascript:;' data='{$v['tag_id']}-{$_v['tag_id']}' class='linktag'>{$_v['tag_name']}</a></li>";
						}
					}
					$form .= "</ul>";
				}
			}			
			$str = "<style type='text/css'>
				.hover{background: #AECDE5;border:1px solid #007EDF;font-weight:bold;color:#fff;padding:2px;text-decoration:none;border-radius:3px;}
				a{text-decoration:none;color:#2B333F;}
				.J_radio, .J_multiple {list-style:none; position:relative; padding: 6px 10px; border-top: 1px solid #DDD;}
				.J_radio, .J_multiple li {margin:3px 3px; line-height:26px; display:inline; cursor:pointer;}
				.tags-bd {background: #90C979;border:1px solid #3A9F10;border-radius:3px;padding:2px;font-size:12px;color:#fff;text-align:center;margin:3px 3px;line-height:16px;display:block;float:left;cursor:pointer;}
				.radio-bd {background: #F78888 !important;border:1px solid #E52121;}
				.clearfix:after {display:block;clear:both;height:0;}
				.clearfix {*zoom:1;}
				.tags-bd span {cursor:pointer;}
				#add_othors_tags {padding-top:3px;margin-top:3px;white-space:nowrap;position:relative;border-top: 1px solid #DDD;}
				.blk {display: block !important;}
			</style>
			<script type='text/javascript'>
			 //tag page
			(function() {
				$(function () {
				var J_radio = $('.J_radio'),
					J_multiple = $('.J_multiple'),
					RadioLinktag = J_radio.find('.linktag'),
					MultipleLinktag = J_multiple.find('.linktag');

				var len  = $('.J_radio').length;
				/*$('ul').not($('#add_othors_tags')).each(function (idx) {
					if(idx % 2 == 0) {
						$(this).css('background','#eee');
					}
				})*/
				
				$('#myform').submit(function () {
					var isAllSelected = true;
					$('.J_multiple, .J_radio').each(function(v, i) {
						if($(i).is(':visible')) {
						var a = $(i).find('.hover');
						return isAllSelected = !!a.length;
						}
					});
					if(!isAllSelected) {
						alert('你有未選擇的標簽');
						return false;
					} else {
						return true;
					}
			})
				//radio 單選
				RadioLinktag.bind('click', function() {
					var a = $('#add_othor_tag').clone(true);
						a.addClass('radio-bd');
						tag_id = $(this).attr('data'),
						tag_name = $(this).html(),
					a.attr('id', '');
					a.css('display', 'inline');
					a.children('span').html(tag_name);
					a.children('input').val(tag_id);
					//上邊點擊屬性
					var dataType = parseInt($(this).attr('data'));
					if($('#'+dataType).text() ==''){
							a.attr('id',dataType);
							$('#add_othors_tags').append(a);
					} else {
							$('#'+dataType).html(a.html());
					}

					$(this).addClass('hover').parent().siblings().find('a').removeClass('hover');
				})

				//其它
				$('.other').each(function () {
					var self = $(this);
					self.click(function () {
						$('.linktag',self.parents('ul')).removeClass('hover');
						$('#add_othors_tags li').each(function(idx, obj) {
							var dataOne = parseInt(($(obj).find('input').val()));
							var dataTwo = parseInt(self.parent().next().children().attr('data'));
							if(dataOne == dataTwo) {
								$(this).remove();
							}
						})
					})
				})

				/*自動選擇
				$('.J_radio .linktag').each(function (idx,obj) {
					if($(obj).hasClass('hover')) {
					var a = $('#add_othor_tag').clone(true);
						a.addClass('radio-bd');
						tag_id = $(this).attr('data'),
						tag_name = $(this).html();
						self = $(this);
						a.attr('id', '');
						a.children('span').html(tag_name);
						a.children('input').val(tag_id);
						//上邊點擊屬性
						var dataType = parseInt(self.attr('data'));
						if($('#'+dataType).text() ==''){
								a.attr('id',dataType);
								$('#add_othors_tags').append(a);
						} else {
								$('#'+dataType).html(a.html());
						}
						$(this).addClass('hover').parent().siblings().find('a').removeClass('hover');
					}
				 })
				

				$('.J_multiple .linktag').each(function (idx,obj) {
					if($(obj).hasClass('hover')) {
					var a = $('#add_othor_tag').clone(true);
						a.addClass('radio-bd');
						tag_id = $(this).attr('data'),
						tag_name = $(this).html();
						self = $(this);
						a.attr('id', '');
						a.children('span').html(tag_name);
						a.children('input').val(tag_id);
						$('#add_othors_tags').append(a);
					}
				})*/

				//multiple
				MultipleLinktag.bind('click', function() {
					var self = $(this),
						a = $('#add_othor_tag').clone(true),
						tag_id = $(this).attr('data'),
						tag_name = $(this).html(),
						str = $('#add_othors_tags').children().text(),
						f = str.match(tag_name);

						a.attr('id', '');
						a.css('display', 'inline');
						a.children('span').html(tag_name);
						a.children('input').attr('value', tag_id);
					
						if (!f && tag_name != '0') {
							$('#add_othors_tags').append(a);
							//$('#add_othors_tags').
						}
					$(this).toggleClass('hover');

					if (!$(this).hasClass('hover')) {
						//todo
						$('#add_othors_tags li').each(function(idx, obj) {
							if ($(this).find('span').text() == self.text()) {
								$(this).remove();
							}
						})
					}
				});
				
				//塔防
				$('.tafang').click(function () {
					$('.tafangList').toggleClass('blk');
				})

				//三消
				$('.sanxiao').click(function () {
					$('.sanxiaoList').toggleClass('blk');
				})

				})
			})();
				//刪除
			function remove_tag(curr) {
				var curr = $(curr);
					curr.parent().remove();
				$('.J_multiple li,.J_radio li').each(function(idx, obj) {
						if ($(this).find('a').text() == curr.text()) {
						//	console.log($(this))
							$(this).find('a').removeClass('hover');
					}
				})
			}
			</script>";
			if(ROUTE_A == 'edit') {
				$tag_list = "<ul id='add_othors_tags' style='display:block;clear:both;width:645px;'><li style='float:left;'>&nbsp;&nbsp;<b>【已選標簽】:&nbsp;</b></li>";
				$this->position_data_db = pc_base::load_model('linktag_to_content_model');
				$tags = pc_base::load_model('linktag_model');
				$result = $this->position_data_db->select(array('content_id'=>$this->id, 'catid'=>$this->data['catid']));
				foreach ($result as $linktag) {
					$tag = $tags->get_one(array('tag_id'=>$linktag['linktag_id']));
					$tag_list.="<li id='{$tag[parent_id]}' class='tags-bd' style='display:inline;'>
									<input class='edit_linktag_checkbox'  type='hidden' name='info[linktag][]' value='{$tag[parent_id]}-{$tag[tag_id]}'/>
									<span onclick='remove_tag(this)'>{$tag['tag_name']}</span>
								</li>";
				}
				$tag_list.="</ul>";
				$tag_module = "<li id='add_othor_tag' class='tags-bd' style='display:none;'>
									<input type='hidden' name='info[linktag][]' value=''>
									<span onclick='remove_tag(this)'></span>
								</li>";
			} else{
				$tag_module = "<ul id='add_othors_tags' style='display:block;clear:both;width:645px;'>
								<li style='float:left;'>&nbsp;&nbsp;<b>【已選標簽】:&nbsp;</b></li>
								<li id='add_othor_tag' class='tags-bd' style='display:none;'>
									<input type='hidden' name='info[linktag][]' value=''>
									<span onclick='remove_tag(this)'></span>
								</li>
							</ul>";
			} 
			$form .=$tag_list .  $str . $tag_module ;
			return $form;
	}
