<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * RSS 数据查询输出
 */

$from_arr = array(
    'htc'    => 10000007,
    'vrzone' => 10000008,
    'temporary'=>10000010,
    'mofang'=> '10000051,10000052,10000053,10000054,10000055',
    'life'=>'10000051,10000052,10000053,10000054,10000055',
    'gogobox'=>'10000051,10000052,10000053,10000054,10000055',
    'pixnet'=>'10000051,10000052,10000053,10000054,10000055',
    'yahoo'=> '10000051,10000052,10000053,10000054,10000055',
    'jdw00'=>'10000051,10000052,10000053,10000054,10000055',
    'jdw01'=>'10000055',
    'jdw02'=>'10000056',
    'jdw03'=>'10000054',
    'nice01'=>'10000055',
    'nice02'=>'10000056',
    'nice03'=>'10000054',
    'technews'=>'10000037',
    'yahoo3c'=>'10000054',
    'yahoo3cs'=>'10000052,10000053',
    );
$from = strtolower(trim($_GET['from'])); 
if (!array_key_exists($from, $from_arr)) {
    exit('No permission resources.');
}

$db = pc_base::load_model('hits_model');
$db->table_name = 'www_category';
$catinfo = $db->get_one(array('catid'=>$from_arr[$from]),'catname');
$catinfo['description'] = $db->get_one(array('catid'=>$from_arr[$from]),'description');
$lastBuildDate = time();
if($from == 'htc' || $from == 'vrzone' || $from == 'technews') {
    $db->query("SELECT title,content description,inputtime pubDate,'魔方網' author,copyfrom,thumb thumbImgUrl,url link,n.id articleId FROM www_news n LEFT JOIN www_news_data d ON n.id=d.id WHERE catid in ({$from_arr[$from]}) AND inputtime < {$lastBuildDate} AND status=99 ORDER BY inputtime DESC limit 60");
}else if($from == 'yahoo3c'){
    $db->query("SELECT url link,title,description,content  ,'魔方網' author,inputtime pubDate,thumb thumbImgUrl,n.id articleId FROM www_news n LEFT JOIN www_news_data d ON n.id=d.id WHERE catid in ({$from_arr[$from]}) AND inputtime < {$lastBuildDate} AND status=99 AND copyfrom like '%魔方網%' ORDER BY inputtime DESC limit 60");
}
else {
    $db->query("SELECT title,content description,'魔方網' author,inputtime pubDate,thumb thumbImgUrl,n.id articleId FROM www_news n LEFT JOIN www_news_data d ON n.id=d.id WHERE catid in ({$from_arr[$from]}) AND inputtime < {$lastBuildDate} AND status=99 AND copyfrom like '%魔方網%' ORDER BY inputtime DESC limit 60");
}
$info =$db->fetch_array();
$XmlConstruct = new XmlConstruct('rss'); 
$XmlConstruct->setAttribute('version', '2.0');

$XmlConstruct->startElement('channel');
$XmlConstruct->startElement('title');
$XmlConstruct->text($catinfo['catname']);
$XmlConstruct->endElement();
$XmlConstruct->startElement('link');
$XmlConstruct->text('http://www.mofang.com.tw/');
$XmlConstruct->endElement();
$XmlConstruct->startElement('descrpition');
$XmlConstruct->text($catinfo['description']);
$XmlConstruct->endElement();
$XmlConstruct->setElement('lastBuildDate', date(DATE_RSS, $lastBuildDate));

// foreach($info as $value) {
   
//     $XmlConstruct->startElement('item');
//     $value['description'] = preg_replace('/\[page\].*?\[page\]/i','#CONTENTSPLITPAGE#',$value['description']);
//     $value['description'] = preg_replace('/\[page\]/i','#CONTENTSPLITPAGE#',$value['description']);
//     $value['pubDate'] = gmdate("Y-m-d\TH:i:s\Z", $value['pubDate']);
//     if ($from == 'yahoo') {
//         $value['newsimage'] = $value['thumbImgUrl'];
//         $value['SN'] = $value['articleId'];
//         unset($value['thumbImgUrl']);
//         unset($value['articleId']);
//         $data = $value['description'];
//         $value['description'] = strip_tags($data,'<img><br><p>');
//         $value['description'] = preg_replace('/#CONTENTSPLITPAGE#/i','',$value['description']);
//     }
//     $XmlConstruct->fromArray($value);
//     $XmlConstruct->endElement();
// }
foreach($info as $value) {
    // 内容处理
    $value['description']=preg_replace('/\s|　/', '', $value['description']);
    $value['content'] = preg_replace('/\[page\].*?\[page\]/i','#CONTENTSPLITPAGE#',$value['content']);
    $value['content'] = preg_replace('/\[page\]/i','#CONTENTSPLITPAGE#',$value['content']);
    $value['content'] = preg_replace('/>\s+</', '><', $value['content']); // 删除标签间的空白符
    $value['content'] = preg_replace('/<img/', '<img class="editorial" width="500"', $value['content'] ); //修改圖片屬性 
    $value['content'] = preg_replace('/style="width(.*?)"/', '',$value['content'] );  //修改圖片屬性 
    $value['content:encoded'] = preg_replace('/style="height(.*?)"/', '',$value['content'] );  //修改圖片屬性 
    $value['pubDate'] = date(DATE_RSS, $value['pubDate']);
    unset($value['thumbImgUrl']);
    unset($value['content']);
  
    $XmlConstruct->startElement('item');
        $XmlConstruct->startElement('guid');
        $XmlConstruct->text($value['articleId']);
        $XmlConstruct->endElement();
        $XmlConstruct->fromArray($value);
        $XmlConstruct->startElement('category');
        $XmlConstruct->text($catinfo['catname']);
        $XmlConstruct->endElement();
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

        if ($prm_elementName == 'title' || $prm_elementName == 'description'|| $prm_elementName == 'content' || $prm_elementName == 'content:encoded') {
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
        // 去除不可见字符，防止xml报错
        echo preg_replace('/[^\P{C}\n]+/u', '', $this->getDocument());
    }
    

} 
