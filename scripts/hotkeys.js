/*
 * Hotkeys
 * Copyright 2019, Terry Kelleher
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Hotkeys support providing key assignments and bulk removal.
 *
 * Keys accepted are simple printable characters only.
 * Keys 'b' and 'c' are reserved. These are permanently set for
 * manual breath and start/stop compressions.
 */
 
var hotkeys =
{
	version: "0.1",
	
	table: {},
	
	catchKeys : function (e)
	{
		var str = String.fromCharCode(e.keyCode);
		if ( str == 'b' )
		{
			$('.breath-link')[0].click();
		}
		else if ( str == 'c' )
		{
			$('.cpr-link')[0].click();
		}
		else if ( this.table.hasOwnProperty(str ) )
		{
			this.table[str]();
		}
	},
	
	clearAll : function()
	{
		this.table = {};
	},
	
	addKey : function(keyString, keyHandle )
	{
		if ( keyString.length != 1 )
		{
			console.log("addKey: keyString length must be 1" );
		}
		else 
		{
			var code = keyString.charCodeAt(0);

			if (  (code <= 31) || (code >=  127))
			{
				console.log("addKey: keyString is not a simple ascii character" );
			}
			else
			{
				this.table[keyString] = keyHandle;
			}
		}

	},
	
	init : function()
	{
		$(window).keypress(function(e)
		{
			var target = e.target;
			// We skip hotkeys if focus is in an input box
			if ( ! $(target).is('input' ) )
			{
				hotkeys.catchKeys(e);
			}
		});
	}
};

