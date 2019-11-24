/************************************************************
Sortable Tables Library
Copyright � 2002 Gavin Kistner and Refinery, Inc. -- http://www.refinery.com
Reuse and modification permitted provided the previous line is included in full
v 1.1    20020731 -- initial librarization
v 1.2    20020805 -- added defaultSort option for th
v 1.3    20020822 -- slam rows post-sort to have 'row0' or 'row1' classes assigned
v 1.5    20030326 -- added 'ischild' attribute for paired rows; added 'price' type
v 1.5.1  20030527 -- number comparisons treat NaN as 0 now.
v 1.5.2  20030618 -- fixed AttachEvent calls to work for Safari
v 1.5.3  20030729 -- rows may be class="ischild" in addition to ischild="true"
v 1.5.4  20030801 -- date comparisons also treat NaN as 0; TH no longer select when multiply clicked
v 1.6    20060824 -- added secondarySort attribute; fixed FF compat; sped up value lookup using caches
*************************************************************/

//debugLevel=1;
SortTables = {};
SortTables.sortTypes = { textual:1, numeric:2, date:3, time:4, text:1, number:2, price:5 },
SortTables.Init = function(){
	var tables = document.getElementsByTagName('table');
	for (var i=0,len=tables.length;i<len;i++){
		var t = tables[i];
		var tRef = VirtualPointer.create(t);
		if (!HasClass(t,"sortable")) continue;

		var sortBody = t.getAttribute("sortBody");
		if (sortBody && sortBody!="") sortBody=document.getElementById(sortBody);
		else sortBody = t.tBodies[0];

		var sortBodyRef = VirtualPointer.create(sortBody);

		t.sortHeads = t.tHead.getElementsByTagName('th');
		for (var j=0,len2=t.sortHeads.length;j<len2;j++){
			var th = t.sortHeads[j];
			var thRef = VirtualPointer.create(th);
			var compareMethod = th.getAttribute('compareMethod');
			if (compareMethod && compareMethod!="") th.compareMethod = SortTables.sortTypes[compareMethod];
			if (!compareMethod) continue;

			AddClass(th,'sortHead');
			th.style.cursor=document.getElementById?'pointer':'hand'; //should be 'pointer', which is W3C, IE6+ NS6+ compat, but not IE4/5.x
			th.origName = th.innerHTML;
			AttachEvent(th,'click',new Function('evt',"SortTables.SortRows("+tRef+","+sortBodyRef+","+thRef+","+j+","+th.compareMethod+")"), true );
			AttachEvent(th,'selectstart',PreventDefault);
			th.defaultSortDescFlag = th.getAttribute('sortDescending') && ( th.getAttribute('sortDescending').toLowerCase() == "true" );
			if (th.getAttribute('secondarySort') && th.getAttribute('secondarySort').toLowerCase()=='true') t.secondarySortColumn = j;
			if (th.getAttribute('defaultSort') && th.getAttribute('defaultSort').toLowerCase()=='true') SortTables.SortRows(tRef,sortBodyRef,thRef,j,compareMethod);
		}
	}
}

SortTables.SortRows = function(tRef,tbodyRef,thRef,colNum,inCompareMethod){
	var table = VirtualPointer.follow(tRef);
	var tbody = VirtualPointer.follow(tbodyRef);
	var th    = VirtualPointer.follow(thRef);

	SortTables.GetVal = table.getAttribute('getValueFunction');
	if (SortTables.GetVal && SortTables.GetVal!="") SortTables.GetVal=window[SortTables.GetVal];
	else SortTables.GetVal=SortTables.TDVal;

	//sets some globals for use in the comparison function
	SortTables.tableToSort   = table;
	SortTables.headToSort    = th;
	SortTables.colToSort     = colNum;
	SortTables.sortAscending = th.sortedFlag ? th.lastSortDescFlag : !th.defaultSortDescFlag;
	SortTables.compareMethod = inCompareMethod;

	var allRowNodes=[],ct=0,childRows=[],childCt=0;
	var lastParent;
	var theRowNodes = tbody.getElementsByTagName( 'tr' );
	for (var i=0,len=theRowNodes.length;i<len;i++){
		var tr = theRowNodes[ i ];
		if (tr.getAttribute("ischild") || HasClass(tr,'ischild')){
			if (!lastParent) continue;
			lastParent.childRows[lastParent.childRows.length]=tr;
			tr.rowParent = lastParent;
			childRows[childCt++]=tr;
		} else {
			lastParent = allRowNodes[ct++] = tr;
			lastParent.childRows=[];
		}
	}
	for (var i=0;i<childCt;i++) tbody.removeChild(childRows[i]);
	for (var i=0;i<ct;i++) tbody.removeChild(allRowNodes[i]);
	allRowNodes.sort( SortTables.CompareTDs );
	for (var i=0;i<ct;i++){
		var tr=allRowNodes[i];
		KillClass(tr,'row[01]');
		AddClass(tr,"row"+(i%2));
		for (var j=0,len2=tr.childRows.length;j<len2;j++){
			KillClass(tr.childRows[j],'row[01]');
			AddClass(tr.childRows[j],"row"+(i%2));
		}
		tbody.appendChild(tr);
	}
	for (var i=0;i<childCt;i++){
		var childRow = childRows[i];
		tbody.insertBefore(childRow,childRow.rowParent.nextSibling);
	}

	SortTables.SelectHead(th,table.getAttribute("showSortDirection") && table.getAttribute("showSortDirection").toLowerCase()=="true");
}

var floatRE = /-?(\d+(\.\d+)?|\.\d+)/;

SortTables.CompareTDs = function(row1,row2,inColNum,inCompareMethod,inSortAscending){
	var theColToSort     = (inColNum!=null) ? inColNum : SortTables.colToSort;
	var theCompareMethod = (inCompareMethod!=null) ? inCompareMethod : SortTables.compareMethod;
	var theSortAscending = (inSortAscending!=null) ? inSortAscending : SortTables.sortAscending;

	var row1val = SortTables.GetVal(row1,theColToSort);
	var row2val = SortTables.GetVal(row2,theColToSort);

	if (theCompareMethod==SortTables.sortTypes.numeric) { isNaN(row1val*=1)?row1val=0:null; isNaN(row2val*=1)?row2val=0:null; }
	else if (theCompareMethod==SortTables.sortTypes.price) { row1val=row1val.match(floatRE)[0]*1; row2val=row2val.match(floatRE)[0]*1; }
	else if (theCompareMethod==SortTables.sortTypes.date) { row1val = new Date(row1val); row2val = new Date(row2val); if (isNaN(row1val)) row1val=0; if (isNaN(row2val)) row2val=0 }
	else if (theCompareMethod==SortTables.sortTypes.time) {
		var rowPieces=row1val.split(":"),newVal=0;
		for (var i=0,len=rowPieces.length;i<len;i++)newVal+=(parseInt(rowPieces[i])*Math.pow(60,len-i-1));
		if (row1val.toLowerCase().indexOf("pm")!=-1)newVal+=12*Math.pow(60,len-1);
		row1val=newVal;

		rowPieces=row2val.split(":"),newVal=0;
		for (var i=0,len=rowPieces.length;i<len;i++)newVal+=(parseInt(rowPieces[i])*Math.pow(60,len-i-1));
		if (row2val.toLowerCase().indexOf("pm")!=-1)newVal+=12*Math.pow(60,len-1);
		row2val=newVal;
	}else{
		row1val=row1val.toLowerCase();
		row2val=row2val.toLowerCase();
	}
	if (theSortAscending ? (row1val>row2val) : (row1val<row2val)) return 1;
	else if (theSortAscending ? (row1val<row2val) : (row1val>row2val)) return -1;
	else if (theColToSort==SortTables.colToSort && SortTables.tableToSort.secondarySortColumn ){
		var theColNum = SortTables.tableToSort.secondarySortColumn;
		var theSecondarySortHead = SortTables.tableToSort.sortHeads[ theColNum ];
		return SortTables.CompareTDs( row1, row2, theColNum,theSecondarySortHead.compareMethod, !theSecondarySortHead.defaultSortDescFlag );
	}
	else return 0;
}

SortTables.TDVal = function(tr,colNum){
	if (!tr) return null;
	if (!tr.valCache) tr.valCache = [];
	if (tr.valCache[colNum]==null){

		tr.valCache[colNum] = tr.getElementsByTagName( 'td' )[ colNum ].innerText;
	}
	return tr.valCache[colNum];
}

SortTables.SelectHead = function(th,inShowDir){
	if (SortTables.sortHead){
		SortTables.sortHead.sortedFlag = false;
		KillClass( SortTables.sortHead, 'sorted' );
		if (inShowDir) SortTables.sortHead.innerHTML = SortTables.sortHead.origName;
		SortTables.sortHead=null;
	}
	th.sortedFlag = true;
	AddClass(th,'sorted');
	if (inShowDir) th.innerHTML=th.origName+'<span class="sortindicator">&#'+( SortTables.sortAscending ? 9650 : 9660 )+';</span>';
	SortTables.sortHead=th;
	th.lastSortDescFlag = !SortTables.sortAscending;
}

AttachEvent(window,'load',SortTables.Init,true);


/*************************************************************************************
The following is copied from generic_library.js; it should be checked for currentness
*************************************************************************************/

function PreventDefault(evt){
	if (!evt && window.event) evt=window.event;
	if (evt.preventDefault) evt.preventDefault();
	else evt.returnValue=false;
	return false;
}

function AttachEvent(obj,evt,fnc,useCapture){
	if (!useCapture) useCapture=false;
	if (obj.addEventListener){
		obj.addEventListener(evt,fnc,useCapture);
		return true;
	} else if (obj.attachEvent) return obj.attachEvent("on"+evt,fnc);
	else obj['on'+evt]=fnc;
}

function HasClass(obj,cName){ return (!obj || !obj.className)?false:(new RegExp("\\b"+cName+"\\b")).test(obj.className) }
function AddClass(obj,cName){ if (!obj) return; if (obj.className==null) obj.className=''; return obj.className+=(obj.className.length>0?' ':'')+cName; }
function KillClass(obj,cName){ if (!obj) return; return obj.className=obj.className.replace(RegExp("^"+cName+"\\b\\s*|\\s*\\b"+cName+"\\b",'g'),''); }

var VirtualPointer = {
  _pool:[null],
  create:function(o){ return this._pool.push(o)-1 },
  follow:function(id){ return this._pool[id] },
  resolve:function(id){ var result=this.follow(id); delete this._pool[id]; return result; }
};

if( window.HTMLElement && HTMLElement.prototype.__defineGetter__ ){
	HTMLElement.prototype.__defineGetter__( "innerText", function(){
		var r = this.ownerDocument.createRange();
		r.selectNodeContents(this);
		return r.toString();
	});
}
