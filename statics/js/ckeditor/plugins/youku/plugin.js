/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.plugins.add('youku',{requires:['iframedialog'],init:function(a){var b=300,c=660;CKEDITOR.dialog.addIframe('YouKuDialog','插入优酷视频','index.php?m=video&c=video_for_ck&a=youku',c,b,function(){},{onOk:function(){}});a.addCommand('YouKu',new CKEDITOR.dialogCommand('YouKuDialog'));a.ui.addButton('YouKu',{label:'插入优酷视频',command:'YouKu',icon:this.path+'youku.png'});}});
