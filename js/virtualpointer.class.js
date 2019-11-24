/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * VirtualPointer Class
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *  $RCSfile: VirtualPointer.class.js,v $
 * $Revision: 1.1 $
 *     $Name:  $
 *     $Date: 2002/07/20 04:38:03 $
 *   $Author: drlion $
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Copyright (c) 2002 Daniel Brockman.  All rights reserved.
 * Tersified by Gavin Kistner, added Array.push() prototype for non-supporting browsers, made IEMac compat

 * This class hands out ID numbers (integers) for arbitrary objects.
 * These ID numbers can later be used to retrieve the stored objects
 * (although they are obviously only valid during the current lifetime
 * of this class).
 */
if (!Array.prototype.push || ([0].push(true)==true)) Array.prototype.push = function(){
	for(var i=0,len=arguments.length,oLen=this.length;i<len;i++) this[oLen+i] = arguments[i];
	return oLen+len;
}
 
var VirtualPointer = {
  _pool:[null],
  create:function(o){ return this._pool.push(o)-1 },
  follow:function(id){ return this._pool[id] },
  resolve:function(id){ var result=this.follow(id); delete this._pool[id]; return result; }
};
