<?php
header("Content-type: text/css; charset: UTF-8");

$CSSdata= '
.gotoGr_A,.gotoGr_B,.gotoGr_C,.gotoGr_D{
    /* background: #eee; */
    position: absolute;
}

.gotoGr_A{
	height: '.(28-0).'px;
}
.gotoGr_B{
	height: '.(28-5*1).'px;
}
.gotoGr_C{
	height: '.(28-5*2).'px;
}

.gotoGr_D{
	height: '.(28-5*3).'px;
}



/* su loro stessi AtoA BtoB et */
.gotoGr_A1TOA, .gotoGr_B1TOB, .gotoGr_C1TOC, .gotoGr_D1TOD{
	width: '.(39-0).'px;	
	left: '.(14+0).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;
}

.gotoGr_A2TOA, .gotoGr_B2TOB, .gotoGr_C2TOC, .gotoGr_D2TOD{
	width: '.(39-26).'px;
	left: '.(14+26).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;
}

.gotoGr_A3TOA, .gotoGr_B3TOB, .gotoGr_C3TOC, .gotoGr_D3TOD{
    width: '.(39-26).'px;
    right: '.(15+26).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;

}

.gotoGr_A4TOA, .gotoGr_B4TOB, .gotoGr_C4TOC, .gotoGr_D4TOD{
    width: '.(39-0).'px;
    right: '.(15+0).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
}

/* A to B */

.gotoGr_A1TOB{
	width: '.(39-0+150).'px;	
	left: '.(14+0).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;
}

.gotoGr_A2TOB{
	width: '.(39-26+150).'px;	
	left: '.(14+26).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;
}


.gotoGr_A3TOB{
	width: '.(39-(26*2)+150).'px;	
	left: '.(14+26*2).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;

}

.gotoGr_A4TOB{
	width: '.(39-(26*3)+150).'px;	
	left: '.(14+26*3).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;
}



/* A to C */

.gotoGr_A1TOC{
	width: '.(39-0+150*2).'px;	
	left: '.(14+0).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;
}

.gotoGr_A2TOC{
	width: '.(39-26+150*2).'px;	
	left: '.(14+26).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;
}


.gotoGr_A3TOC{
	width: '.(39-(26*2)+150*2).'px;	
	left: '.(14+26*2).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;

}

.gotoGr_A4TOC{
	width: '.(39-(26*3)+150*2).'px;	
	left: '.(14+26*3).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;
}

/* A to D 	+150*/

.gotoGr_A1TOD{
	width: '.(39-0+150*3).'px;	
	left: '.(14+0).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;
}

.gotoGr_A2TOD{
	width: '.(39-26+150*3).'px;	
	left: '.(14+26).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;
}


.gotoGr_A3TOD{
	width: '.(39-(26*2)+150*3).'px;	
	left: '.(14+26*2).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;

}

.gotoGr_A4TOD{
	width: '.(39-(26*3)+150*3).'px;	
	left: '.(14+26*3).'px;
	border-width: 0 0 2px 2px;
    border-style: solid;
}

/* C to A*/
.gotoGr_C1TOA{
	width: '.(39-(26*3)+150*2).'px;	
	right: '.(15+26*3).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
}

.gotoGr_C2TOA{
	width: '.(39-(26*2)+150*2).'px;	/* 288 */
	right: '.(15+26*2).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;

}

.gotoGr_C3TOA{
	width: '.(39-(26*1)+150*2).'px;	/* 288 */
	right: '.(15+26*1).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;


}

.gotoGr_C4TOA{
	width: '.(39-0+150*2).'px;	
	right: '.(14+0).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
}



/* C to B*/
.gotoGr_C1TOB{
	width: '.(39-(26*3)+150*1).'px;	
	right: '.(15+26*3).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	
}

.gotoGr_C2TOB{
	width: '.(39-(26*2)+150*1).'px;	
	right: '.(15+26*2).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;

}

.gotoGr_C3TOB{
	width: '.(39-(26*1)+150*1).'px;	
	right: '.(15+26*1).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;

}

.gotoGr_C4TOB{
	width: '.(39-0+150*1).'px;	
	right: '.(14+0).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;

}




/*C to D */
.gotoGr_C1TOD{
	width: '.(39-(26*0)+(150*1)	).'px;	
	left: '.(15+26*0).'px;
	border-width: 0 0px 2px 2px;
	 border-style: solid;

}
.gotoGr_C2TOD{
	width: '.(39-(26*1)+(150*1)	).'px;	
	left: '.(15+26*1).'px;
	border-width: 0 0px 2px 2px;
     border-style: solid;

}

.gotoGr_C3TOD{
	width: '.(39-(26*2)+(150*1)	).'px;	
	left: '.(15+26*2).'px;
	border-width: 0 0px 2px 2px;
    border-style: solid;

}


.gotoGr_C4TOD{
	width: '.(39-(26*3)+150*1).'px;	
	left: '.(15+26*3).'px;
	border-width: 0 0px 2px 2px;
    border-style: solid;
	

}


/* B to A*/
.gotoGr_B1TOA{
	width: '.(39-(26*3)+150*1).'px;	
	right: '.(15+26*3).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
}

.gotoGr_B2TOA{
	width: '.(39-(26*2)+150*1).'px;	
	right: '.(15+26*2).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	

}

.gotoGr_B3TOA{
	width: '.(39-(26*1)+150*1).'px;	
	right: '.(15+26*1).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	


}

.gotoGr_B4TOA{
	width: '.(39-0+150*1).'px;	
	right: '.(14+0).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	
}

/*  */

/* B to C*/
.gotoGr_B1TOC{
	width: '.(39-(26*0)+(150*1)	).'px;	
	left: '.(15+26*0).'px;
	border-width: 0 0px 2px 2px;
	 border-style: solid;
	 

}
.gotoGr_B2TOC{
	width: '.(39-(26*1)+(150*1)	).'px;	
	left: '.(15+26*1).'px;
	border-width: 0 0px 2px 2px;
     border-style: solid;

}

.gotoGr_B3TOC{
	width: '.(39-(26*2)+(150*1)	).'px;	
	left: '.(15+26*2).'px;
	border-width: 0 0px 2px 2px;
    border-style: solid;

}


.gotoGr_B4TOC{
	width: '.(39-(26*3)+150*1).'px;	
	left: '.(15+26*3).'px;
	border-width: 0 0px 2px 2px;
    border-style: solid;
	
}

/*  */
/* B to D*/
.gotoGr_B1TOD{
	width: '.(39-(26*0)+(150*2)	).'px;	
	left: '.(15+26*0).'px;
	border-width: 0 0px 2px 2px;
	 border-style: solid;
	 

}
.gotoGr_B2TOD{
	width: '.(39-(26*1)+(150*2)	).'px;	
	left: '.(15+26*1).'px;
	border-width: 0 0px 2px 2px;
     border-style: solid;

}

.gotoGr_B3TOD{
	width: '.(39-(26*2)+(150*2)	).'px;	
	left: '.(15+26*2).'px;
	border-width: 0 0px 2px 2px;
    border-style: solid;

}


.gotoGr_B4TOD{
	width: '.(39-(26*3)+150*2).'px;	
	left: '.(15+26*3).'px;
	border-width: 0 0px 2px 2px;
    border-style: solid;
	
}

/* D to A */

.gotoGr_D1TOA{
	width: '.(39-(26*3)+150*3).'px;	
	right: '.(14+26*3).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	
}

.gotoGr_D2TOA{
	width: '.(39-(26*2)+150*3).'px;	
	right: '.(14+26*2).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	
}


.gotoGr_D3TOA{
	width: '.(39-26*1+150*3).'px;	
	right: '.(14+26).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	

}

.gotoGr_D4TOA{ 
	width: '.(39-26*0+150*3).'px;	
	right: '.(14+0).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;


}
/* D to B */
 
.gotoGr_D1TOB{
	width: '.(39-(26*3)+150*2).'px;	
	right: '.(14+26*3).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;

	
}

.gotoGr_D2TOB{
	width: '.(39-(26*2)+150*2).'px;	
	right: '.(14+26*2).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	
}


.gotoGr_D3TOB{
	width: '.(39-26*1+150*2).'px;	
	right: '.(14+26).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	

}

.gotoGr_D4TOB{ 
	width: '.(39-26*0+150*2).'px;	
	right: '.(14+0).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;


}


/* D to C  border-color:red;z-index:1; */
 
.gotoGr_D1TOC{
	width: '.(39-(26*3)+150*1).'px;	
	right: '.(14+26*3).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	
	
}

.gotoGr_D2TOC{
	width: '.(39-(26*2)+150*1).'px;	
	right: '.(14+26*2).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	
}


.gotoGr_D3TOC{
	width: '.(39-26*1+150*1).'px;	
	right: '.(14+26).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;
	

}

.gotoGr_D4TOC{ 
	width: '.(39-26*0+150*1).'px;	
	right: '.(14+0).'px;
	border-width: 0 2px 2px 0px;
    border-style: solid;


}

';

























function CSScleaner($CSSdata){
	//return $CSSdata;
	$search=array("\n", "\r", "\t");
	$CSSdata =str_replace($search, '', $CSSdata);
	$CSSdata = preg_replace('#/\*[^(\*/)]*\*/#', '', $CSSdata);
	$CSSdata=preg_replace('/(?:\s\s+|\n|\t)/', ' ', $CSSdata);
	$CSSdata =str_replace("{ ", '{', $CSSdata);
	$CSSdata =str_replace(" }", '}', $CSSdata);
	$CSSdata =str_replace(": ", ':', $CSSdata);
	$CSSdata =str_replace("; ", ';', $CSSdata);
	$CSSdata =str_replace(" .", '.', $CSSdata);
	return $CSSdata;
}



echo CSScleaner($CSSdata);



?>