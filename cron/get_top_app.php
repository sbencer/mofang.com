<?php
require 'simple_html_dom.php';
$andriod_url = "https://play.google.com/store/apps/category/GAME/collection/topselling_new_free?num=8";
$ios_url = 'http://www.apple.com/tw/itunes/charts/free-apps/';

getAndriod_top();
getIOS_top();
	
function getAndriod_top() {
    Global $andriod_url;
    $html = file_get_html($andriod_url);
    //   echo strlen($html);
    $count = 1;
    
    if($html=="") return ;
    
    $rv_json = '[';
    foreach ($html->find('.id-card-list .card') as $div) {
        if ($count > 8)
            break;

        // $num = $count;
        $img_alt = $div->find(".title", 0)->title;
        $url = 'https://play.google.com' . $div->find(".title", 0)->href;
        $img_url = $div->find("img", 0)->src;
       //$tmp =  '<table><tr><td><img src="' . $img_url . '" /></a> </td></tr><tr><td><a href="' . $url . '">'  . $img_alt . '</a></td></tr></table>';
      
       $rv_json .= '{"img_alt":"' . $img_alt . '","url":"' . $url . '","img_url":"' . $img_url . '"},';
       
        //echo $div;
        $count++;
    }
    		$rv_json = substr($rv_json,0,strlen($rv_json)-1);
    		$rv_json .= ']';
        $file = fopen("top_andriod.js","w");
				echo fwrite($file,$rv_json);
				fclose($file);
}

function getIOS_top() {
    Global $ios_url;
    $html = file_get_html($ios_url);
		if($html=="") return ;
		
    $count = 1;
     $rv_json = '[';
    foreach ($html->find('.section-content li') as $li) {
        if ($count > 8)
            break;

        if ($li->find("h4", 0)->plaintext != "遊戲")
            continue;
        //$num = $li->find("strong", 0)->plaintext; //序號
        //$num = $count;
        //echo $li->find("h4", 0)->plaintext;
        $url = $li->find("a", 0)->href; //鏈結
        $img_url = $li->find("img", 0)->src; //圖片鏈結
        $img_alt = $li->find("img", 0)->alt; //圖片名稱
        // echo $img_alt;
        //echo '<table><tr><td><img src="' . $img_url . '" /></a> </td></tr><tr><td><a href="' . $url . '">' . $img_alt . '</a></td></tr></table>';
        // echo $li;
				 $rv_json .= '{"img_alt":"' . $img_alt . '","url":"' . $url . '","img_url":"' . $img_url . '"},';
        $count++;
    }
    
    $rv_json = substr($rv_json,0,strlen($rv_json)-1);
		$rv_json .= ']';
    $file = fopen("top_ios.js","w");
		echo fwrite($file,$rv_json);
		fclose($file);
}
        
?>