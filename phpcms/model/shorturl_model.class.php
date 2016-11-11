<?php
/**
 * 短连接表
 */
define('IN_CHECKCODE',true);
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class shorturl_model extends model {
    protected $map = array(
        0 => 'K',
        1 => 'g',
        2 => '7',
        3 => 'k',
        4 => 'n',
        5 => '3',
        6 => 'y',
        7 => 'G',
        8 => '9',
        9 => 'w',
        10 => 'b',
        11 => 'D',
        12 => 'o',
        13 => '0',
        14 => 'S',
        15 => 'i',
        16 => 'C',
        17 => 'R',
        18 => 'B',
        19 => 'P',
        20 => 'h',
        21 => 'X',
        22 => 'r',
        23 => 'l',
        24 => 'Z',
        25 => '2',
        26 => 'd',
        27 => '1',
        28 => 'q',
        29 => 'V',
        30 => 'm',
        31 => 'J',
        32 => 'p',
        33 => 'e',
        34 => 'x',
        35 => 'c',
        36 => 'L',
        37 => 'O',
        38 => '6',
        39 => 'f',
        40 => '4',
        41 => 'A',
        42 => 'F',
        43 => 'H',
        44 => 'z',
        45 => 'T',
        46 => 'Y',
        47 => 'M',
        48 => 'Q',
        49 => 'N',
        50 => 'v',
        51 => 'U',
        52 => '5',
        53 => 'a',
        54 => '8',
        55 => 'W',
        56 => 'j',
        57 => 'u',
        58 => 'I',
        59 => 'E',
        60 => 't',
        61 => 's',
    );
    /**
     * 常规构造函数
     */
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'default';
        $this->table_name = 'shorturl';
        $this->is_master = 'yes';
        parent::__construct();
    }

    /**
     * 10进制转换为62进制
     * @param $n
     * @return string
     */
    public function tenTo62($n) {
        $res = '';
        do {
            $tmp = $n%62;
            $res = $this->map[$tmp] . $res;
            $n = ($n-$tmp)/62;
        } while ($n);
        return $res;
    }

}
?>