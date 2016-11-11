<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 點擊統計
 */

$catid_arr = array(81,82,83,101,102,103,796,797);
$catid = intval($_GET['catid']); 
if (!in_array($catid, $catid_arr)) {
    exit;
}

$db = pc_base::load_model('hits_model');
$db->table_name = 'www_category';
$catinfo = $db->get_one(array('catid'=>$catid),'catname');
$lastBuildDate = time()-3600*8;
$db->query("SELECT title,content,inputtime pubDate,catid columnId,'魔方網' sourceName,'http://www.mofang.com/' sourceUrl,thumb thumbImgUrl,url articleUrl,keywords tags,n.id articleId FROM www_news n LEFT JOIN www_news_data d ON n.id=d.id WHERE catid={$catid} AND inputtime < {$lastBuildDate} AND status=99 ORDER BY inputtime DESC limit 60");
$info =$db->fetch_array();

if($_GET['type'] == 'json') {
    echo json_encode($info, JSON_HEX_TAG);
} else {
    //$XmlConstruct = new XmlConstruct('rss', 'http://21cn.dynamic.feedsportal.com/xsl/eng/rss.xsl'); 
    $XmlConstruct = new XmlConstruct('rss'); 
    $XmlConstruct->setAttribute('xmlns:itunes', 'http://www.itunes.com/dtds/podcast-1.0.dtd');
    $XmlConstruct->setAttribute('xmlns:dc', 'http://purl.org/dc/elements/1.1/');
    $XmlConstruct->setAttribute('xmlns:taxo', 'http://purl.org/rss/1.0/modules/taxonomy/');
    $XmlConstruct->setAttribute('xmlns:rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
    $XmlConstruct->setAttribute('version', '2.0');

    $XmlConstruct->startElement('channel');
    $XmlConstruct->startElement('title');
    $XmlConstruct->text($catinfo['catname']);
    $XmlConstruct->endElement();
    $XmlConstruct->setElement('lastBuildDate', date("Y-m-d H:i:s", $lastBuildDate));

    foreach($info as $value) {
        $XmlConstruct->startElement('item');
        $value['content'] = preg_replace('/\[page\].*?\[page\]/i','#CONTENTSPLITPAGE#',$value['content']);
        $value['content'] = preg_replace('/\[page\]/i','#CONTENTSPLITPAGE#',$value['content']);
        $value['pubDate'] = date("Y-m-d H:m:s", $value['pubDate']);
        $XmlConstruct->fromArray($value);
        $XmlConstruct->endElement();
    }

    $XmlConstruct->endElement();
    $XmlConstruct->output();
}

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
        if ($prm_elementName == 'title' || $prm_elementName == 'content') {
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
