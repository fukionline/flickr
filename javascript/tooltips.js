var g_tooltip_elm = null;
var g_tooltip_showing = 0;
var g_tooltip_link_elm = null;
var g_tooltip_previous_click = null;
var g_tip_elm = null;

function init_tooltip(){
	g_tooltip_elm = document.createElement('DIV');
	g_tooltip_elm.className = 'ToolTip';
	g_tooltip_elm.style.display = 'none';
	document.body.appendChild(g_tooltip_elm);
}

function show_tooltip(link, text, len){

	if (!g_tooltip_elm){
		init_tooltip();
	}
	if (g_tooltip_showing){
		if (g_tooltip_link_elm == link){
			hide_tooltip();
			return;
		}
		hide_tooltip();
	}

	var x = tooltip_findPosX(link);
	var y = tooltip_findPosY(link);

	if (len > 200){
		g_tooltip_elm.style.width = '300px';
	}else if (len > 100){
		g_tooltip_elm.style.width = '200px';
	}else{
		g_tooltip_elm.style.width = '150px';
	}

	g_tooltip_elm.style.left = x+'px';
	g_tooltip_elm.style.top = (y+20)+'px';

	g_tip_elm = document.getElementById(text);

	move_children(g_tip_elm, g_tooltip_elm);


	g_tooltip_showing = 1;
	g_tooltip_elm.style.display = 'block';
	g_tooltip_link_elm = link;

	document.onmousedown = doc_mousedown;
}

function doc_mousedown(e){
	if (getEventSrc(e) == g_tooltip_link_elm){
		document.onmousedown = function(){};
	}else{
		hide_tooltip();
	}
}

function hide_tooltip(){

	document.onmousedown = function(){};

	if (!g_tooltip_elm){
		return false;
	}

	g_tooltip_showing = 0;
	g_tooltip_elm.style.display = 'none';
	g_tooltip_link_elm = 'null';

	move_children(g_tooltip_elm, g_tip_elm);

	return false
}

function move_children(e_from, e_to){

	while(e_from.childNodes.length){
		e_to.appendChild(e_from.removeChild(e_from.childNodes[0]));
	}
}




// findPosX & findPosY courtesy PPK
// http://www.quirksmode.org/js/findpos.html
function tooltip_findPosX(obj) {
	var curleft = 0;
	if (obj.offsetParent) {
		while (obj.offsetParent) {
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x) curleft += obj.x;
	return curleft;
}

function tooltip_findPosY(obj) {
	var curtop = 0;
	if (obj.offsetParent) {
		while (obj.offsetParent) {
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y) curtop += obj.y;
	return curtop;
}