<?php
defined('IN_PHPCMS') or exit('No permission resources.');
define('DATE_FORMAT', 'D, d M Y H:i:s T');
/**
 * RSS 數據查詢輸出
 */

$catids = '125,126,122,82,109,934';

$db = pc_base::load_model('hits_model');
$db->table_name = 'www_category';
$catinfo = $db->get_one(array('catid'=>$from_arr[$from]),'catname');
$lastBuildDate = time();
$subsqls[] = "(SELECT title,'' link,content description,inputtime pubDate,'魔方網' source,thumb thumbImgUrl,catid, n.id FROM www_news n LEFT JOIN www_news_data d ON n.id=d.id WHERE catid in ({$catids}) AND inputtime < {$lastBuildDate} AND status=99 and d.copyfrom like '魔方網|_' ORDER BY inputtime DESC limit 60)";
$subsqls[] = "(SELECT title,'' link,content description,inputtime pubDate,'魔方網' source,thumb thumbImgUrl,catid, n.id FROM www_review n LEFT JOIN www_review_data d ON n.id=d.id WHERE catid in ({$catids}) AND inputtime < {$lastBuildDate} AND status=99 ORDER BY inputtime DESC limit 60)";
$sql = 'SELECT * FROM (' . join(' UNION ', $subsqls) . ') a order by pubDate desc limit 100';
//$sql = "SELECT title,'' link,content description,inputtime pubDate,'魔方網' source,thumb thumbImgUrl,catid, n.id FROM www_news n LEFT JOIN www_news_data d ON n.id=d.id WHERE catid in ({$catids}) AND inputtime < {$lastBuildDate} AND status=99 and d.copyfrom like '魔方網|_' ORDER BY inputtime DESC limit 60";
$db->query($sql);
$info =$db->fetch_array();

$XmlConstruct = new XmlConstruct('rss');
$XmlConstruct->setAttribute('version', '2.0');

$XmlConstruct->startElement('channel');
$XmlConstruct->startElement('title');
$XmlConstruct->text('魔方網');
$XmlConstruct->endElement();
$XmlConstruct->setElement('link', 'http://www.mofang.com/');
$XmlConstruct->startElement('description');
$XmlConstruct->text('每日最新蘋果安卓手機遊戲排行榜下載及手遊產業新聞資訊，全視頻化手遊前瞻評測攻略，最強手機網遊資料庫魔方攻略助手APP，盡在專業手遊媒體平台魔方網！');
$XmlConstruct->endElement();
$XmlConstruct->setElement('pubDate', gmdate(DATE_FORMAT, $lastBuildDate));
$XmlConstruct->startElement('image');
$XmlConstruct->startElement('title');
$XmlConstruct->text('魔方網');
$XmlConstruct->endElement();
$XmlConstruct->setElement('url', 'http://sts0.mofang.com/mofang_logo_toutiao.png');
$XmlConstruct->setElement('link', 'http://www.mofang.com');
$XmlConstruct->setElement('width', '159');
$XmlConstruct->setElement('height', '56');
$XmlConstruct->startElement('description');
$XmlConstruct->text('www.mofang.com logo');
$XmlConstruct->endElement();
$XmlConstruct->endElement();

foreach($info as $value) {
    $XmlConstruct->startElement('item');
    $value['description'] = preg_replace('/\[page\].*?\[page\]/i','',$value['description']);
    $value['description'] = preg_replace('/\[page\]/i','',$value['description']);
    $value['pubDate'] = gmdate(DATE_FORMAT, $value['pubDate']);
    $value['link'] = sprintf("http://m.mofang.com/toutiao/show_%d_%d.html", $value['catid'], $value['id']);
    $value['description'] = preg_replace('/>\s+</', '><', $value['description']);
    unset($value['catid']);
    unset($value['id']);
    $XmlConstruct->fromArray($value);
    $XmlConstruct->endElement();
}

$XmlConstruct->endElement();
$XmlConstruct->output();


class XmlConstruct extends XMLWriter
{

    /**
     * Constructor.
     * @param string $prm_rootElementName A root element's name of a current xml document
     * @param string $prm_xsltFilePath Path of a XSLT file.
     * @access public
     * @param null
     */
    public function __construct($prm_rootElementName, $prm_xsltFilePath=''){
        $this->openMemory();
        $this->setIndent(true);
        $this->setIndentString(' ');
        $this->startDocument('1.0', 'UTF-8');

        if($prm_xsltFilePath){
            $this->writePi('xml-stylesheet', "type='text/xsl' href='{$prm_xsltFilePath}'");
        }

        $this->startElement($prm_rootElementName);
    }

    public function setAttribute($prm_attributeName, $prm_attributeText) {
        $this->startAttribute($prm_attributeName);
        $this->text($prm_attributeText);
        $this->endAttribute();
    }


    /**
     * Set an element with a text to a current xml document.
     * @access public
     * @param string $prm_elementName An element's name
     * @param string $prm_ElementText An element's text
     * @return null
     */
    public function setElement($prm_elementName, $prm_ElementText){
        $this->startElement($prm_elementName);
        if ($prm_elementName == 'title' || $prm_elementName == 'description') {
            $this->writeCData($prm_ElementText);
        } else {
            $this->text($prm_ElementText);
        }
        $this->endElement();
    }

    /**
     * Construct elements and texts from an array.
     * The array should contain an attribute's name in index part
     * and a attribute's text in value part.
     * @access public
     * @param array $prm_array Contains attributes and texts
     * @return null
     */
    public function fromArray($prm_array){
        if(is_array($prm_array)){
            foreach ($prm_array as $index => $text){
                $this->setElement($index, $text);
            }
        }
    }

    /**
     * Return the content of a current xml document.
     * @access public
     * @param null
     * @return string Xml document
     */
    public function getDocument(){
        $this->endElement();
        $this->endDocument();
        return $this->outputMemory();
    }

    /**
     * Output the content of a current xml document.
     * @access public
     * @param null
     */
    public function output(){
        header('Content-type: text/xml');
        echo $this->getDocument();
    }


}
