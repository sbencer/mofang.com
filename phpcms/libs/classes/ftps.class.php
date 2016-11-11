<?php
/**
 * FTP操作類
 * @author chenzhouyu
 *
 *使用$ftps = pc_base::load_sys_class('ftps');進行初始化。
 *首先通過　$ftps->connect($host,$username,$password,$post,$pasv,$ssl,$timeout);進行FTP服務器連接。
 *通過具體的函數進行FTP的操作。
 *$ftps->mkdir() 創建目錄，可以創建多級目錄以“/abc/def/higk”的形式進行多級目錄的創建。
 *$ftps->put()上傳文件
 *$ftps->rmdir()刪除目錄
 *$ftps->f_delete()刪除文件
 *$ftps->nlist()列出指定目錄的文件
 *$ftps->chdir()變更當前文件夾
 *$ftps->get_error()獲取錯誤信息
 */
class ftps {
	//FTP 連接資源
	private $link;
	//FTP連接時間
	public $link_time;
	//錯誤代碼
	private $err_code = 0;
	//傳送模式{文本模式:FTP_ASCII, 二進制模式:FTP_BINARY}
	public $mode = FTP_BINARY;
	
	/**
	 * 連接FTP服務器
	 * @param string $host    　　 服務器地址
	 * @param string $username　　　用戶名
	 * @param string $password　　　密碼
	 * @param integer $port　　　　   服務器端口，默認值為21
	 * @param boolean $pasv        是否開啟被動模式
	 * @param boolean $ssl　　　　 　是否使用SSL連接
	 * @param integer $timeout     超時時間　
	 */
	public function connect($host, $username = '', $password = '', $port = '21', $pasv = false, $ssl = false, $timeout = 30) {
		$start = time();
		if ($ssl) {
			if (!$this->link = @ftp_ssl_connect($host, $port, $timeout)) {
				$this->err_code = 1;
				return false;
			}
		} else {
			if (!$this->link = @ftp_connect($host, $port, $timeout)) {
				$this->err_code = 1;
				return false;
			}
		}
		
		if (@ftp_login($this->link, $username, $password)) {
			if ($pasv) ftp_pasv($this->link, true);
			$this->link_time = time()-$start;
		   return true;
		} else {
			$this->err_code = 1;
		   return false;
		}
		register_shutdown_function(array(&$this,'close'));
	}
	
	/**
	 * 創建文件夾
	 * @param string $dirname 目錄名，
	 */
	public function mkdir($dirname) {
		if (!$this->link) {
			$this->err_code = 2;
			return false;
		} 
		$dirname = $this->ck_dirname($dirname);
		$nowdir = '/';
		foreach ($dirname as $v) {
			if ($v && !$this->chdir($nowdir.$v)) {
				if ($nowdir) $this->chdir($nowdir);
				@ftp_mkdir($this->link, $v);
			}
			if($v) $nowdir .= $v.'/';
		}
		return true;
	}
	
	/**
	 * 上傳文件
	 * @param string $remote 遠程存放地址
	 * @param string $local 本地存放地址
	 */
	public function put($remote, $local) {
		if (!$this->link) {
			$this->err_code = 2;
			return false;
		} 
		$dirname = pathinfo($remote,PATHINFO_DIRNAME);
		if (!$this->chdir($dirname)) {
			$this->mkdir($dirname);
		}
		if (@ftp_put($this->link, $remote, $local, $this->mode)) {
			return true;
		} else {
			$this->err_code = 7;
			return false;
		}
	}
	
	/**
	 * 刪除文件夾
	 * @param string $dirname  目錄地址
	 * @param boolean $enforce 強制刪除
	 */
	public function rmdir($dirname, $enforce = false) {
		if (!$this->link) {
			$this->err_code = 2;
			return false;
		} 
		$list = $this->nlist($dirname);
		if ($list && $enforce) {
			$this->chdir($dirname);
			foreach ($list as $v) {
				$this->f_delete($v);
			}
		} elseif ($list && !$enforce) {
			$this->err_code = 3;
			return false;
		}
		@ftp_rmdir($this->link, $dirname);
		return true;
	}
	
	/**
	 * 刪除指定文件
	 * @param string $filename 文件名
	 */
	public function f_delete($filename) {
		if (!$this->link) {
			$this->err_code = 2;
			return false;
		} 
		if (@ftp_delete($this->link, $filename)) {
			return true;
		} else {
			$this->err_code = 4;
			return false;
		}
	}
	
	/**
	 * 返回給定目錄的文件列表
	 * @param string $dirname  目錄地址
	 * @return array 文件列表數據
	 */
	public function nlist($dirname) {
		if (!$this->link) {
			$this->err_code = 2;
			return false;
		} 
		if ($list = @ftp_nlist($this->link, $dirname)) {
			return $list;
		} else {
			$this->err_code = 5;
			return false;
		}
	}
	
	/**
	 * 在 FTP 服務器上改變當前目錄
	 * @param string $dirname 修改服務器上當前目錄
	 */
	public function chdir($dirname) {
		if (!$this->link) {
			$this->err_code = 2;
			return false;
		} 
		if (@ftp_chdir($this->link, $dirname)) {
			return true;
		} else {
			$this->err_code = 6;
			return false;
		}
	}
	
	/**
	 * 獲取錯誤信息
	 */
	public function get_error() {
		if (!$this->err_code) return false;
		$err_msg = array(
			'1'=>'Server can not connect',
			'2'=>'Not connect to server',
			'3'=>'Can not delete non-empty folder',
			'4'=>'Can not delete file',
			'5'=>'Can not get file list',
			'6'=>'Can not change the current directory on the server',
			'7'=>'Can not upload files'
		);
		return $err_msg[$this->err_code];
	}
	
	/**
	 * 檢測目錄名
	 * @param string $url 目錄
	 * @return 由 / 分開的返回數組
	 */
	private function ck_dirname($url) {
		$url = str_replace('\\', '/', $url);
		$urls = explode('/', $url);
		return $urls;
	}
	
	/**
	 * 關閉FTP連接
	 */
	public function close() {
		return @ftp_close($this->link);
	}
}