/**************************************************
 * dom-drag.js
 * 09.25.2001
 * www.youngpup.net
 **************************************************
 * 10.28.2001 - fixed minor bug where events
 * sometimes fired off the handle, not the root.
 **************************************************
 * IPS CHANGES
 * 06.01.2005 - Added "cursorchange" to change
 * 07.18.2005 - Added cookie to store values
 * 07.18.2005 - Made it impossible to drag < 0 height (keeponscreen)
 * mouse cursor when over drag handle
 **************************************************/


var Drag = {

	obj		    : null,
	fx		    : null,
	fy		    : null,
	cookiename  : null,
	keeponscreen: true,
	
	init : function(o, oRoot, minX, maxX, minY, maxY, bSwapHorzRef, bSwapVertRef, fXMapper, fYMapper)
	{
		o.onmousedown	= Drag.start;
		o.onmouseover   = Drag.cursorchange;
		
		o.hmode			= bSwapHorzRef ? false : true ;
		o.vmode			= bSwapVertRef ? false : true ;

		o.root = oRoot && oRoot != null ? oRoot : o ;

		if (o.hmode  && isNaN(parseInt(o.root.style.left  ))) o.root.style.left   = "0px";
		if (o.vmode  && isNaN(parseInt(o.root.style.top   ))) o.root.style.top    = "0px";
		if (!o.hmode && isNaN(parseInt(o.root.style.right ))) o.root.style.right  = "0px";
		if (!o.vmode && isNaN(parseInt(o.root.style.bottom))) o.root.style.bottom = "0px";

		o.minX	= typeof minX != 'undefined' ? minX : null;
		o.minY	= typeof minY != 'undefined' ? minY : null;
		o.maxX	= typeof maxX != 'undefined' ? maxX : null;
		o.maxY	= typeof maxY != 'undefined' ? maxY : null;

		o.xMapper = fXMapper ? fXMapper : null;
		o.yMapper = fYMapper ? fYMapper : null;
		
		//----------------------------------
		// Figure width and height
		//----------------------------------
		
		if ( Drag.keeponscreen )
		{
			Drag.my_width  = 0;
			Drag.my_height = 0;
			
			if ( typeof( window.innerWidth ) == 'number' )
			{
				//----------------------------------
				// Non IE
				//----------------------------------
			  
				Drag.my_width  = window.innerWidth;
				Drag.my_height = window.innerHeight;
			}
			else if ( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) )
			{
				//----------------------------------
				// IE 6+
				//----------------------------------
				
				Drag.my_width  = document.documentElement.clientWidth;
				Drag.my_height = document.documentElement.clientHeight;
			}
			else if ( document.body && ( document.body.clientWidth || document.body.clientHeight ) )
			{
				//----------------------------------
				// Old IE
				//----------------------------------
				
				Drag.my_width  = document.body.clientWidth;
				Drag.my_height = document.body.clientHeight;
			}
		}
		
		o.root.onDragStart	= new Function();
		o.root.onDragEnd	= new Function();
		o.root.onDrag		= new Function();
	},
	
	cursorchange : function(e)
	{
		var o = Drag.obj = this;
		o.style.cursor = 'move';
	},

	start : function(e)
	{
		var o = Drag.obj = this;
		e = Drag.fixE(e);
		var y = parseInt(o.vmode ? o.root.style.top  : o.root.style.bottom);
		var x = parseInt(o.hmode ? o.root.style.left : o.root.style.right );
		o.root.onDragStart(x, y);

		o.lastMouseX	= e.clientX;
		o.lastMouseY	= e.clientY;

		if (o.hmode) {
			if (o.minX != null)	o.minMouseX	= e.clientX - x + o.minX;
			if (o.maxX != null)	o.maxMouseX	= o.minMouseX + o.maxX - o.minX;
		} else {
			if (o.minX != null) o.maxMouseX = -o.minX + e.clientX + x;
			if (o.maxX != null) o.minMouseX = -o.maxX + e.clientX + x;
		}

		if (o.vmode) {
			if (o.minY != null)	o.minMouseY	= e.clientY - y + o.minY;
			if (o.maxY != null)	o.maxMouseY	= o.minMouseY + o.maxY - o.minY;
		} else {
			if (o.minY != null) o.maxMouseY = -o.minY + e.clientY + y;
			if (o.maxY != null) o.minMouseY = -o.maxY + e.clientY + y;
		}

		document.onmousemove	= Drag.drag;
		document.onmouseup		= Drag.end;

		return false;
	},

	drag : function(e)
	{
		e = Drag.fixE(e);
		var o = Drag.obj;

		var ey	= e.clientY;
		var ex	= e.clientX;
		var y = parseInt(o.vmode ? o.root.style.top  : o.root.style.bottom);
		var x = parseInt(o.hmode ? o.root.style.left : o.root.style.right );
		var nx, ny;

		if (o.minX != null) ex = o.hmode ? Math.max(ex, o.minMouseX) : Math.min(ex, o.maxMouseX);
		if (o.maxX != null) ex = o.hmode ? Math.min(ex, o.maxMouseX) : Math.max(ex, o.minMouseX);
		if (o.minY != null) ey = o.vmode ? Math.max(ey, o.minMouseY) : Math.min(ey, o.maxMouseY);
		if (o.maxY != null) ey = o.vmode ? Math.min(ey, o.maxMouseY) : Math.max(ey, o.minMouseY);

		nx = x + ((ex - o.lastMouseX) * (o.hmode ? 1 : -1));
		ny = y + ((ey - o.lastMouseY) * (o.vmode ? 1 : -1));

		if (o.xMapper)		nx = o.xMapper(y)
		else if (o.yMapper)	ny = o.yMapper(x)
		
		//----------------------------------
		// Keep on screen?
		//----------------------------------
		
		if ( Drag.keeponscreen )
		{
			ny = ny < 0 ? 0 : ny;
			nx = nx < 0 ? 0 : nx;
			
			if ( Drag.my_width )
			{
				nx = nx > Drag.my_width - parseInt(o.root.style.width) ? Drag.my_width - parseInt(o.root.style.width) : nx;
			}
		}
		
		Drag.obj.root.style[o.hmode ? "left" : "right"] = nx + "px";
		Drag.obj.root.style[o.vmode ? "top" : "bottom"] = ny + "px";
		Drag.obj.lastMouseX	= ex;
		Drag.obj.lastMouseY	= ey;

		Drag.obj.root.onDrag(nx, ny);
		return false;
	},

	end : function()
	{
		document.onmousemove = null;
		document.onmouseup   = null;
		Drag.obj.root.onDragEnd(	parseInt(Drag.obj.root.style[Drag.obj.hmode ? "left" : "right"]), 
									parseInt(Drag.obj.root.style[Drag.obj.vmode ? "top" : "bottom"]));
		
		var o = Drag.obj;
		
		fy = parseInt( o.root.style.top );
		fx = parseInt( o.root.style.left );
		
		//----------------------------------
		// Store in a cookie?
		//----------------------------------
		
		if ( Drag.cookiename )
		{
			try
			{
				my_setcookie( Drag.cookiename, fx+','+fy, 1 );
			}
			catch(e)
			{
			}
		}
		
		Drag.obj = null;
		
	},

	fixE : function(e)
	{
		if (typeof e == 'undefined') e = window.event;
		if (typeof e.layerX == 'undefined') e.layerX = e.offsetX;
		if (typeof e.layerY == 'undefined') e.layerY = e.offsetY;
		return e;
	}
};