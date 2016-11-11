	function sarcasm($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$setting = string2array($setting);
		$size = $setting['size'];
		$errortips = $this->fields[$field]['errortips'];
		if($errortips || $minlength) $this->formValidator .= '$("#'.$field.'").formValidator({onshow:"",onfocus:"'.$errortips.'"}).inputValidator({min:1,onerror:"'.$errortips.'"});';
		if($_GET['a']=='add'){
			$str = '<input type="text" name="info['.$field.']" id="'.$field.'" size="'.$size.'" value="" class="input-text" '.$formattribute.' '.$css.'><ul id="add_sarcasms" class="list-dot-othors">
			<li id="add_sarcasm" style="display:none;width:100%;"><input type="hidden" name="info['.$field.'][]" value=""><span></span><a onclick="del_sarcasm(this)" class="close" href="javascript:;"></a></li>';

			if($default = $setting['defaultvalue']){
				$default = preg_split('/\s*(,|，)\s*/', $default);
				$default = array_filter($default,trim);
				foreach($default as $val){
					$str .= '<li id="" style="width:100%;"><input type="hidden" name="info['.$field.'][]" value="'.$val.'"><span>'.$val.'</span><a onclick="del_sarcasm(this)" class="close" href="javascript:;"></a></li>';
				}
			}

			$str .= "</ul><script>

				$('#{$field}').bind('keydown',function(event){
					if(event.keyCode==13){	
						var tag_selects_v = $(this).val();
						
	             		var s = $('#add_sarcasm').clone(true);
						s.attr('id','');
						s.css('display','inline');
								
						s.children('span').html(tag_selects_v);
						s.children('input').attr('value',tag_selects_v);
						var str = $('#add_sarcasms').children().text();
						var f = str.match(tag_selects_v);
						if(!f && tag_selects_v != '0'){
							$('#add_sarcasms').append(s);
						}
		             
		             	$(this).val('');
		             	return false;
					}	
									
				});			
				function del_sarcasm(obj){

					var obj = $(obj);
					obj.parent().remove();

				}
			</script>";

			return $str;
		}else{
			return false;
		}
	}
