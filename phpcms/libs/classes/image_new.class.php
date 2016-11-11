<?php
/**
 * 新的圖像處理
 * 王官慶 9.29號
 */
class image_new { 

    public function __construct() {

    }

	//根據提供的寬、高進行等比切割，最後返回數組形式
	public function cut_img($img,$save_path,$w,$h,$start_x,$start_y){//要裁減的圖片，寬度，高度
	    $s = imagecreatefromjpeg($img);//這裡以jpg圖片為例，其他圖片要修改這個方法名稱，可以上網參考（就是後面那個後綴名不一樣）
	    // $w = imagesx($s)<$w?imagesx($s):$w;        //如果圖片的寬比要求的小，則以原圖寬為準
	    // $h = imagesy($s)<$w?imagesy($s):$h;
	    $start_y = intval($start_y);
	    $start_x = intval($start_x);
	    $bg = imagecreatetruecolor($w,$h);        //創建$w*$h的空白圖像
	    if(imagecopy($bg,$s,0,0,$start_x,$start_y,$w,$h)){
	        $new_img_name = microtime_float().'.jpg';
	        if(imagejpeg($bg,$save_path.DIRECTORY_SEPARATOR.$new_img_name,100)){  //將生成的圖片保存到img目錄，文件名，隨機
	    		return $save_path.DIRECTORY_SEPARATOR.$new_img_name;
	        }else{
	            return '';
	        }
	    }else{
	        return '';
	    }
	    /*
	    *imagecopy ($dst_im,$src_im,$dst_x,$dst_y,$src_x,$src_y,$src_w,$src_h)
	    將 src_im 圖像中坐標從 src_x，src_y 開始，寬度為 src_w，高度為 src_h 的一部分拷貝到 dst_im 圖像中坐標為 dst_x 和 dst_y 的位置上。 
	    */
	    imagedestroy($s);                //關閉圖片
	    imagedestroy($bg); 

	}

	//對大圖進行裁切，並返回數組
	public function cut_images($img,$save_path,$h){
	  //判斷圖片是否存在
	  @$SIZE=getimagesize($img);
	  if(!$SIZE){
	   exit('圖片不存在，請檢查 ');
	  }
	  //計算需要切多少次
	  $s = imagecreatefromjpeg($img); //這裡以jpg圖片為例，其他圖片要修改這個方法名稱，可以上網參考（就是後面那個後綴名不一樣）
	  //設置切圖的寬、高
	  $w = imagesx($s); //寬度就取圖片的寬度
	  $h = $h ? $h : 100; //默認一張圖的高度為100像素
	  
	  $img_height = imagesy($s);
	  $cut_num = ceil($img_height/$h);
	  //最後要切的高度
	  $last_height = $img_height - ($cut_num-1)*$h;
	  $array = array();
	  $return_array = array();
	  $start_x = 0;
	  $start_y = 0;
	  for ($i=0; $i < $cut_num; $i++) { 
	    # code...
	    if($i==($cut_num-1)){//最後一次切的高度
	      $cut_h =  $last_height;
	    }else{
	      $cut_h = $h;
	    }
	    $array['url'] = $this->cut_img($img,$save_path,$w,$cut_h,$start_x,$start_y);
	    $array['height'] = $cut_h;
	    $return_array[] = $array;
	    $start_y = ($i+1)*$h+1;//多一個像素切圖 
	  }
	  //返回
	  return $return_array;
	}

}
?>