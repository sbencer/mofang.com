<?php
class shorturlDefine {
     const MOFANG = 1;
     const SHORTMF = 2;

    public static $webs = array(
        self::MOFANG => 'http://www.mofang.com.tw',
        self::SHORTMF => MCDomain::SHORT_LINK,
    );
}