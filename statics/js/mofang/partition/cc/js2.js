// JavaScript Document


function g(o){return document.getElementById(o);}
function HoverLi(n){
//如果有N个标签,就将i<=N;

for(var i=1;i<=5;i++){g('tb_'+i).className='normaltab';g('tbc_0'+i).className='undis';}g('tbc_0'+n).className='dis';g('tb_'+n).className='hovertab';
}
//如果要做成点击后再转到请将<li>中的onmouseover 改成 onclick;
//]]>

function g1(o){return document.getElementById(o);}
function HoverLi1(n){
//如果有N个标签,就将i<=N;

for(var i=1;i<=5;i++){g1('tb1_'+i).className='normaltab';g1('tbc1_0'+i).className='undis';}g1('tbc1_0'+n).className='dis';g1('tb1_'+n).className='hovertab';
}
//如果要做成点击后再转到请将<li>中的onmouseover 改成 onclick;
//]]>

function g2(o){return document.getElementById(o);}
function HoverLi2(n){
//如果有N个标签,就将i<=N;

for(var i=1;i<=5;i++){g2('tb2_'+i).className='normaltab';g2('tbc2_0'+i).className='undis';}g2('tbc2_0'+n).className='dis';g2('tb2_'+n).className='hovertab';
}
//如果要做成点击后再转到请将<li>中的onmouseover 改成 onclick;
//]]>

function g3(o){return document.getElementById(o);}
function HoverLi3(n){
//如果有N个标签,就将i<=N;

for(var i=1;i<=5;i++){g3('tb3_'+i).className='normaltab';g3('tbc3_0'+i).className='undis';}g3('tbc3_0'+n).className='dis';g3('tb3_'+n).className='hovertab';
}
//如果要做成点击后再转到请将<li>中的onmouseover 改成 onclick;
//]]>

jQuery(function() {
		jQuery(".button_hide").toggle(
		  function () {
			jQuery(this).removeClass("button_hide").addClass("button_hide2");
			jQuery("#button_Box").slideDown(600);
		  },
		  function () {
			jQuery(this).removeClass("button_hide2").addClass("button_hide");
			jQuery("#button_Box").slideUp(600);
		  }
		); 
}) 

jQuery(function() {
		jQuery(".button_hide1").toggle(
		  function () {
			jQuery(this).removeClass("button_hide1").addClass("button_hide2");
			jQuery("#button_Box1").slideDown(600);
		  },
		  function () {
			jQuery(this).removeClass("button_hide2").addClass("button_hide1");
			jQuery("#button_Box1").slideUp(600);
		  }
		); 
}) 

jQuery(function() {
		jQuery(".button_hide3").toggle(
		  function () {
			jQuery(this).removeClass("button_hide3").addClass("button_hide2");
			jQuery("#button_Box2").slideDown(600);
		  },
		  function () {
			jQuery(this).removeClass("button_hide2").addClass("button_hide3");
			jQuery("#button_Box2").slideUp(600);
		  }
		); 
}) 

jQuery(function() {
		jQuery(".button_hide4").toggle(
		  function () {
			jQuery(this).removeClass("button_hide4").addClass("button_hide2");
			jQuery("#button_Box3").slideDown(10);
		  },
		  function () {
			jQuery(this).removeClass("button_hide2").addClass("button_hide4");
			jQuery("#button_Box3").slideUp(10);
		  }
		); 
}) 