<?php
/**
 *  extention.func.php 用户自定义函数库
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-10-27
 */


/**
 * @param $category
 * @param int $is_wap
 * @return string
 */
function get_category_url($category,$is_wap=0) {
    $sub_domain = pc_base::load_config('domains',$category);
    if ($sub_domain) {
        $base_domain = pc_base::load_config('domains','base_domain');
        $web_url='http://' . $sub_domain . $base_domain;
        if($is_wap){
            return wap_url($web_url);
        }else{
            return $web_url;
        }
    } else {
        return '';
    }
}

/**
 * @param $keyword
 * @return string $url
 */
function tag($keyword = '') {
    $keyword = trim($keyword);
    return APP_PATH.'tag/'.strip_tags($keyword).'.html';     
}

/**
 * @param $html
 * @return mixed|string
 */
function html5_convert($html) {

    $config = HTMLPurifier_Config::createDefault();

    // configuration goes here:
    $config->set('Core.Encoding', 'UTF-8'); // replace with your encoding
    $config->set('HTML.Doctype', 'XHTML 1.0 Transitional'); // replace with your doctype
    $config->set('HTML.BlockWrapper', 'p');
    $config->set('AutoFormat.RemoveEmpty', true);
    $config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
    $config->set('AutoFormat.AutoParagraph', true);
    $config->set('HTML.SafeEmbed', true);
    $config->set('HTML.SafeIframe', true);
    $config->set('URI.SafeIframeRegexp', '%^https://(www.youtube.com/embed/|player.vimeo.com/video/)%');
    $config->set('HTML.AllowedElements', array('a', 'p', 'img', 'table', 'thead', 'tbody', 'tr', 'th', 'td', 'div', 'b', 'strong', 'object', 'embed', 'br', 'font', 'iframe', 'span'));
    $config->set('CSS.AllowedProperties', array('text-align', 'width', 'height', 'color'));
    $config->set('HTML.AllowedAttributes', array(
        'a.href',
        'div.style',
        'span.style',
        'embed.src',
        'table.border',
        'th.rowspan',
        'th.colspan',
        'td.rowspan',
        'td.colspan',
        '*.align',
        'img.src',
        'img.alt',
        'font.color',
        'iframe.src',
    ));

    $purifier = new HTMLPurifier($config);

    $html = $purifier->purify($html);
    $html = preg_replace('/<(\/)?div/', '<$1p', $html);
    $html = preg_replace('/pics\.mofang\.com/', 'pic0.mofang.com', $html);
    //$html = preg_replace('/(<img[^>]+)style\=\"[^\"]+\"/', '$1', $html);
    return $html;
}

/**
 * @param $imgurl
 * @param int $width
 * @param int $height
 * @param string $no_pic
 * @return string|图片路径
 */
function qiniuthumb($imgurl, $width = 100, $height = 100, $no_pic = '') {
    if (preg_match('/pic[s\d].mofang.com/', $imgurl)) {
        $n = crc32($imgurl) % 3;
        if ($width == $height) {
            $style = "{$width}";
        } else {
            $style = "{$width}x{$height}";
        }
        return preg_replace('/pics.mofang.com/', "pic$n.mofang.com", $imgurl) . '/' . $style;
    } else {
        return thumb($imgurl, $width, $height, 1, $no_pic);
    }
}

function mf_curl( $url, $data ){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);

    return $response;
}

function mf_curl_get( $url ){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $response = curl_exec($ch);
    return $response;
}

/**
 * Balances tags of string using a modified stack.
 *
 * @since 2.0.4
 *
 * @author Leonard Lin <leonard@acm.org>
 * @license GPL
 * @copyright November 4, 2001
 * @version 1.1
 * @todo Make better - change loop condition to $text in 1.2
 * @internal Modified by Scott Reilly (coffee2code) 02 Aug 2004
 *      1.1  Fixed handling of append/stack pop order of end text
 *           Added Cleaning Hooks
 *      1.0  First Version
 *
 * @param string $text Text to be balanced.
 * @return string Balanced text.
 */
function force_balance_tags( $text ) {
    $tagstack = array();
    $stacksize = 0;
    $tagqueue = '';
    $newtext = '';
    // Known single-entity/self-closing tags
    $single_tags = array( 'area', 'base', 'basefont', 'br', 'col', 'command', 'embed', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param', 'source' );
    // Tags that can be immediately nested within themselves
    $nestable_tags = array( 'blockquote', 'div', 'object', 'q', 'span' );

    // WP bug fix for comments - in case you REALLY meant to type '< !--'
    $text = str_replace('< !--', '<    !--', $text);
    // WP bug fix for LOVE <3 (and other situations with '<' before a number)
    $text = preg_replace('#<([0-9]{1})#', '&lt;$1', $text);

    while ( preg_match("/<(\/?[\w:]*)\s*([^>]*)>/", $text, $regex) ) {
        $newtext .= $tagqueue;

        $i = strpos($text, $regex[0]);
        $l = strlen($regex[0]);

        // clear the shifter
        $tagqueue = '';
        // Pop or Push
        if ( isset($regex[1][0]) && '/' == $regex[1][0] ) { // End Tag
            $tag = strtolower(substr($regex[1],1));
            // if too many closing tags
            if( $stacksize <= 0 ) {
                $tag = '';
                // or close to be safe $tag = '/' . $tag;
            }
            // if stacktop value = tag close value then pop
            else if ( $tagstack[$stacksize - 1] == $tag ) { // found closing tag
                $tag = '</' . $tag . '>'; // Close Tag
                // Pop
                array_pop( $tagstack );
                $stacksize--;
            } else { // closing tag not at top, search for it
                for ( $j = $stacksize-1; $j >= 0; $j-- ) {
                    if ( $tagstack[$j] == $tag ) {
                        // add tag to tagqueue
                        for ( $k = $stacksize-1; $k >= $j; $k--) {
                            $tagqueue .= '</' . array_pop( $tagstack ) . '>';
                            $stacksize--;
                        }
                        break;
                    }
                }
                $tag = '';
            }

        } else { // Begin Tag
            $tag = strtolower($regex[1]);

            // Tag Cleaning

            // If it's an empty tag "< >", do nothing
            if ( '' == $tag ) {
                // do nothing
            }
            // ElseIf it presents itself as a self-closing tag...
            elseif ( substr( $regex[2], -1 ) == '/' ) {
                // ...but it isn't a known single-entity self-closing tag, then don't let it be treated as such and
                // immediately close it with a closing tag (the tag will encapsulate no text as a result)
                if ( ! in_array( $tag, $single_tags ) )
                    $regex[2] = trim( substr( $regex[2], 0, -1 ) ) . "></$tag";
            }
            // ElseIf it's a known single-entity tag but it doesn't close itself, do so
            elseif ( in_array($tag, $single_tags) ) {
                $regex[2] .= '/';
            }
            // Else it's not a single-entity tag
            else {
                // If the top of the stack is the same as the tag we want to push, close previous tag
                if ( $stacksize > 0 && !in_array($tag, $nestable_tags) && $tagstack[$stacksize - 1] == $tag ) {
                    $tagqueue = '</' . array_pop( $tagstack ) . '>';
                    $stacksize--;
                }
                $stacksize = array_push( $tagstack, $tag );
            }

            // Attributes
            $attributes = $regex[2];
            if( ! empty( $attributes ) && $attributes[0] != '>' )
                $attributes = ' ' . $attributes;

            $tag = '<' . $tag . $attributes . '>';
            //If already queuing a close tag, then put this tag on, too
            if ( !empty($tagqueue) ) {
                $tagqueue .= $tag;
                $tag = '';
            }
        }
        $newtext .= substr($text, 0, $i) . $tag;
        $text = substr($text, $i + $l);
    }

    // Clear Tag Queue
    $newtext .= $tagqueue;

    // Add Remaining text
    $newtext .= $text;

    // Empty Stack
    while( $x = array_pop($tagstack) )
        $newtext .= '</' . $x . '>'; // Add remaining tags to close

    // WP fix for the bug with HTML comments
    $newtext = str_replace("< !--","<!--",$newtext);
    $newtext = str_replace("<    !--","< !--",$newtext);

    return $newtext;
}

