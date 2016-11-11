<?php 
	/**
	 * 檢查管理員名稱
	 * @param array $data 管理員數據
	 */
	function checkuserinfo($data) {
		if(!is_array($data)){
			showmessage(L('parameters_error'));return false;
		} elseif (!is_username($data['username'])){
			showmessage(L('username_illegal'));return false;
		} elseif (empty($data['email']) || !is_email($data['email'])){
			showmessage(L('email_illegal'));return false;
		} elseif (empty($data['roleid'])){
			return false;
		}
		return $data;
	}
	/**
	 * 檢查管理員密碼合法性
	 * @param string $password 密碼
	 */
	function checkpasswd($password){
		if (!is_password($password)){
			return false;
		}
		return true;
	}

	function system_information($data) {
		$update = pc_base::load_sys_class('update');
		$notice_url = $update->notice();
		$string = base64_decode('PHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiPiQoIiNtYWluX2ZyYW1laWQiKS5yZW1vdmVDbGFzcygiZGlzcGxheSIpOzwvc2NyaXB0PjxkaXYgaWQ9InBocGNtc19ub3RpY2UiPjwvZGl2PjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9Ik5PVElDRV9VUkwiPjwvc2NyaXB0Pg==');
		echo $data.str_replace('NOTICE_URL',$notice_url,$string);
	}
?>