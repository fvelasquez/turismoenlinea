//Adaptado por Fradique Lee Salazar
//07/Noviembre/2003
	var	fixedX = -1;			// posicion x de la pantalla (-1 Abajo del control)
	var	fixedY = -1;			// posicion y de la pantalla (-1 Abajo del control)
	var startAt = 1;			// 0 - Domingo ; 1 - Lunes
	var showWeekNumber = 0;	// 0 - No muestra; 1 - muestra
	var showToday = 1;		// 0 - No muestra; 1 - muestra
	var imgDir = "/sud/principal/imagenes/";			// directorio de imagenes ...ejm  "/sud/principal/imagenes/"
	var format = 'dd/mm/yyyy';                           //formato de fecha  mmmm si quiere usar el mes como nombre ejm NOV

	var gotoString = "Ir al mes actual";
	var todayString = "Hoy es";
	var weekString = "Sem";
	var scrollLeftMessage = "Haga Click para desplazarce al mes anterior. Mantenga presionado para despazarce automaticamente.";
	var scrollRightMessage = "Haga Click para desplazarce al siguiente mes. Mantenga presionado para despazarce automaticamente.";
	var selectMonthMessage = "Haga Click para seleccionar un mes.";
	var selectYearMessage = "Haga Click para seleccionar un a"+String.fromCharCode(241)+"o.";
	var selectDateMessage = "Seleccionar [date].";

	var	crossobj, crossMonthObj, crossYearObj, monthSelected, yearSelected, dateSelected, omonthSelected, oyearSelected, odateSelected, monthConstructed, yearConstructed, intervalID1, intervalID2, timeoutID1, timeoutID2, ctlToPlaceValue, ctlNow, dateFormat, nStartingYear
	var objDia,objMes,objAno
	var	bPageLoaded=false
	var	ie=document.all
	var	dom=document.getElementById

	var	ns4=document.layers
	var	today =	new	Date()
	var	dateNow	 = today.getDate()
	var	monthNow = today.getMonth()
	var	yearNow	 = today.getYear()
	var	imgsrc = new Array("drop1.gif","drop2.gif","left1.gif","left2.gif","right1.gif","right2.gif")
	var	img	= new Array()
	var bShow = false;

     function RestaFechas(minuendo,sustraendo,ConHoras) //resta fecha devuelve dias recibe el numero de fecha ej. txtDia1,txtMes1,txtAno1 seria 1 
     {
	min=new Date()
	min.setDate(document.getElementById("txtDia"+minuendo).value)
	min.setMonth(document.getElementById("txtMes"+minuendo).value-1)
	min.setFullYear(document.getElementById("txtAno"+minuendo).value)
		
	sust=new Date()

	sust.setDate(document.getElementById("txtDia"+sustraendo).value)
	sust.setMonth(document.getElementById("txtMes"+sustraendo).value-1)
	sust.setFullYear(document.getElementById("txtAno"+sustraendo).value)
    if (ConHoras)
		{
		min.setHours(document.getElementById("txtHora"+minuendo).value,document.getElementById("txtMinuto"+minuendo).value)
		sust.setHours(document.getElementById("txtHora"+sustraendo).value,document.getElementById("txtMinuto"+sustraendo).value)		
		}    
    
		diferencia=(min-sust)/1000/60/60/24
		if (diferencia>-0.00001&&diferencia<0)		
		diferencia=0
		return diferencia
	

     }
     //NOTA: en la version final se debe de eliminar esta funcion asumiendo que todas las paginas
     //incluyen la libreria vutils.js
		function ValidaNum(campo,max) //valida un numero con un maximo, solo soporta 2 digitos
		{		
		mensaje=document.getElementById("txtMensaje")
		var keycode = event.keyCode
		var realkey = String.fromCharCode(event.keyCode)
		if (keycode==13) return
		if (keycode!=13&&max) document.selection.clear()
		
			if (keycode<48||keycode>57)
			{				
				
				VentanaMensaje("Debe Ingresar Datos Numericos")						
				return false;
			}
			else
			{
			 if (max) //sin este parametro evalua un numero cualquiera
			 {
				if (campo.value==""&&realkey>Math.floor(max/10))
				{
				campo.value=0;
				}
			
				if (campo.value>Math.floor(max/10)||campo.value==Math.floor(max/10)&&realkey>max % 10) 
				{				
				VentanaMensaje("El valor maximo de este campo es: "+max)						
				
				campo.select()
				return false;
				}				
			}
				mensaje.value ="";				
				
			}        
		}	

function ValidarFecha(cDia,cMes,cAno)
{
	var aNumDays = Array (0,31,28,31,30,31,30,31,31,30,31,30,31)
	mensaje=document.getElementById('txtMensaje')
	var dHoy=new Date()
	
		
	var flgResultado = true;

	anocorrecto=/([1|2|3]\d)\d{2}/.exec(cAno.value)
	if (!anocorrecto)
	{cAno.value=dHoy.getFullYear()
	
	VentanaMensaje("El a"+String.fromCharCode(241)+"o es incorrecto.")						
	event.returnValue=false;
	}
	else
	{	if ((cMes.value < 1) || (cMes.value > 12)||cMes.value.length==0) 
		{cMes.value=dHoy.getMonth()+1;
		
		VentanaMensaje("El mes es incorrecto.")						
		event.returnValue=false;
		}
		else
		{	if ((cDia.value < 1) || (cDia.value > 31)||cDia.value.length==0) 
			{cDia.value=dHoy.getDate();
			VentanaMensaje("El dia es incorrecto.")						
			
			event.returnValue=false;
			}
			else //fecha lexicamente correcta
			{
		        if (cMes.value==2)
					{		
					if (cAno.value % 4 == 0) aNumDays[2]++;			 
					}		
				numDaysInMonth = aNumDays[parseInt(cMes.value,10)];					
				
				if (cDia.value>numDaysInMonth)
					{cDia.value=numDaysInMonth;					
					event.returnValue=false;
					cDia.select();
					cDia.focus();
					VentanaMensaje("El dia no corresponde al mes, ese mes solo tiene: "+numDaysInMonth+" dias.")						
					

					}		
				else //fecha semanticamente correcta
				{
				mensaje.value=""		
				cDia.value*=1
				cMes.value*=1
				cDia.value=cDia.value<10 ? "0"+cDia.value:cDia.value ;
		        cMes.value=cMes.value<10?"0"+cMes.value:cMes.value;
		
				return true
				}
				
			}
		}
	}	

}	//funcion

	

    /* hides <select> and <applet> objects (for IE only) debajo del overDiv*/
    function hideElement( elmID, overDiv ,unHide)
    {
      if( ie )
      {
        for( i = 0; i < document.all.tags( elmID ).length; i++ )
        {
          obj = document.all.tags( elmID )[i];
          if( !obj || !obj.offsetParent )
          {
            continue;
          }
      
      //encuentra la posicion relativa desde el body          
          objLeft   = obj.offsetLeft;
          objTop    = obj.offsetTop;
          objParent = obj.offsetParent;
          
          while( objParent.tagName.toUpperCase() != "BODY" )
          {
            objLeft  += objParent.offsetLeft;
            objTop   += objParent.offsetTop;
            objParent = objParent.offsetParent;
          }
      
          objHeight = obj.offsetHeight;
          objWidth = obj.offsetWidth;
      
          if(( overDiv.offsetLeft + overDiv.offsetWidth ) <= objLeft );
          else if(( overDiv.offsetTop + overDiv.offsetHeight ) <= objTop );
          else if( overDiv.offsetTop >= ( objTop + objHeight ));
          else if( overDiv.offsetLeft >= ( objLeft + objWidth ));
          else
          {
            if (unHide)
            obj.style.visibility = "";
            else
            obj.style.visibility = "hidden";
          }
        }
      }
    }
    /*
    * unhides <select> and <applet> en todo el documento objects (for IE only)
    */
    function showElement( elmID )
    {
      if( ie )
      {
        for( i = 0; i < document.all.tags( elmID ).length; i++ )
        {
          obj = document.all.tags( elmID )[i];
          
          if( !obj || !obj.offsetParent )
          {
            continue;
          }
        
          obj.style.visibility = "";
        }
      }
    } 
    

	function HolidayRec (d, m, y, desc)
	{
		this.d = d
		this.m = m
		this.y = y
		this.desc = desc
	}

	var HolidaysCounter = 0
	var Holidays = new Array()

	function addHoliday (d, m, y, desc)
	{
		Holidays[HolidaysCounter++] = new HolidayRec ( d, m, y, desc )
	}

	if (dom)
	{
		for	(i=0;i<imgsrc.length;i++)
		{
			img[i] = new Image
			img[i].src = imgDir + imgsrc[i]
		}
		document.write ("<div onclick='bShow=true;' id='calendar' style='z-index:999;position:absolute;visibility:hidden;'><table	width="+((showWeekNumber==1)?250:220)+" style='font-family:arial;font-size:11px;border-width:1;border-style:solid;border-color:#a0a0a0;font-family:arial; font-size:11px}' bgcolor='#ffffff'><tr bgcolor=darkblue><td><table width='"+((showWeekNumber==1)?248:218)+"'><tr><td style='padding:2px;font-family:arial; font-size:11px;'><font color='#ffffff'><B><span id='caption'></span></B></font></td><td align=right><a href='javascript:hideCalendar()'><IMG SRC='"+imgDir+"close.gif' WIDTH='15' HEIGHT='13' BORDER='0' ALT='Cerrar el calendario'></a></td></tr></table></td></tr><tr><td style='padding:5px' bgcolor=#ffffff><span id='content'></span></td></tr>")
			
		if (showToday==1)
		{
			document.write ("<tr bgcolor=#f0f0f0><td style='padding:5px' align=center><span id='lblToday'></span></td></tr>")
		}
			
		document.write ("</table></div><div id='selectMonth' style='z-index:999;position:absolute;visibility:hidden;'></div><div id='selectYear' style='z-index:999;position:absolute;visibility:hidden;'></div>");
	}

	var	monthName =	new	Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septimbre","Octubre","Noviembre","Diciembre")
	var	monthName2 = new Array("ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SEP","OCT","NOV","DIC")
	if (startAt==0)
	{
		dayName = new Array	("Dom","Lun","Mar","Mie","Jue","Vie","Sab")
		dayName2 = new Array	("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado")
	}
	else
	{
		dayName = new Array	("Lun","Mar","Mie","Jue","Vie","Sab","Dom")
		dayName2 = new Array ("Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo")
	}
	var	styleAnchor="text-decoration:none;color:black;"
	var	styleLightBorder="border-style:solid;border-width:1px;border-color:#a0a0a0;"

	function swapImage(srcImg, destImg){
		if (ie)	{ document.getElementById(srcImg).setAttribute("src",imgDir + destImg) }
	}

	function init()	{
		if (!ns4)
		{
			if (!ie) { yearNow += 1900	}

			crossobj=(dom)?document.getElementById("calendar").style : ie? document.all.calendar : document.calendar
			hideCalendar()

			crossMonthObj=(dom)?document.getElementById("selectMonth").style : ie? document.all.selectMonth	: document.selectMonth

			crossYearObj=(dom)?document.getElementById("selectYear").style : ie? document.all.selectYear : document.selectYear

			monthConstructed=false;
			yearConstructed=false;

			if (showToday==1)
			{
				document.getElementById("lblToday").innerHTML =	todayString + " <a onmousemove='window.status=\""+gotoString+"\"' onmouseout='window.status=\"\"' title='"+gotoString+"' style='"+styleAnchor+"' href='javascript:monthSelected=monthNow;yearSelected=yearNow;constructCalendar();'>"+dayName2[(today.getDay()-startAt==-1)?6:(today.getDay()-startAt)]+", " + dateNow + " / " + (monthNow+1)+ " / " +	yearNow	+ "</a>"; //monthName[monthNow].substring(0,3)
			}

			sHTML1="<span id='spanLeft'	style='border-style:solid;border-width:1;border-color:#3366FF;cursor:pointer' onmouseover='swapImage(\"changeLeft\",\"left2.gif\");this.style.borderColor=\"#88AAFF\";window.status=\""+scrollLeftMessage+"\"' onclick='javascript:decMonth()' onmouseout='clearInterval(intervalID1);swapImage(\"changeLeft\",\"left1.gif\");this.style.borderColor=\"#3366FF\";window.status=\"\"' onmousedown='clearTimeout(timeoutID1);timeoutID1=setTimeout(\"StartDecMonth()\",500)'	onmouseup='clearTimeout(timeoutID1);clearInterval(intervalID1)'>&nbsp<IMG id='changeLeft' SRC='"+imgDir+"left1.gif' width=10 height=11 BORDER=0>&nbsp</span>&nbsp;"
			sHTML1+="<span id='spanRight' style='border-style:solid;border-width:1;border-color:#3366FF;cursor:pointer'	onmouseover='swapImage(\"changeRight\",\"right2.gif\");this.style.borderColor=\"#88AAFF\";window.status=\""+scrollRightMessage+"\"' onmouseout='clearInterval(intervalID1);swapImage(\"changeRight\",\"right1.gif\");this.style.borderColor=\"#3366FF\";window.status=\"\"' onclick='incMonth()' onmousedown='clearTimeout(timeoutID1);timeoutID1=setTimeout(\"StartIncMonth()\",500)'	onmouseup='clearTimeout(timeoutID1);clearInterval(intervalID1)'>&nbsp<IMG id='changeRight' SRC='"+imgDir+"right1.gif'	width=10 height=11 BORDER=0>&nbsp</span>&nbsp"
			sHTML1+="<span id='spanMonth' style='border-style:solid;border-width:1;border-color:#3366FF;cursor:pointer'	onmouseover='swapImage(\"changeMonth\",\"drop2.gif\");this.style.borderColor=\"#88AAFF\";window.status=\""+selectMonthMessage+"\"' onmouseout='swapImage(\"changeMonth\",\"drop1.gif\");this.style.borderColor=\"#3366FF\";window.status=\"\"' onclick='popUpMonth()'></span>&nbsp;"
			sHTML1+="<span id='spanYear' style='border-style:solid;border-width:1;border-color:#3366FF;cursor:pointer' onmouseover='swapImage(\"changeYear\",\"drop2.gif\");this.style.borderColor=\"#88AAFF\";window.status=\""+selectYearMessage+"\"'	onmouseout='swapImage(\"changeYear\",\"drop1.gif\");this.style.borderColor=\"#3366FF\";window.status=\"\"'	onclick='popUpYear()'></span>&nbsp;"
			
			document.getElementById("caption").innerHTML  =	sHTML1

			bPageLoaded=true
		}
	}

	function hideCalendar()	{
	//showElement( 'SELECT' )
	//showElement( 'APPLET' )
	if (crossobj.visibility!="hidden")
	{
		hideElement( 'SELECT', crossobj,true );			
		hideElement( 'APPLET', crossobj,true );				    
	}
		crossobj.visibility="hidden"
		if (crossMonthObj != null){crossMonthObj.visibility="hidden"}
		if (crossYearObj !=	null){crossYearObj.visibility="hidden"}		
	 //esconde mensaje si lo hay
	 //if (document.all.txtMensaje) document.all.txtMensaje.value="";
		///mostrar barra divflota, si la hay	
	if (typeof divflota!="undefined") divflota.style.visibility="visible";
	///
	}

	function padZero(num) {
		return (num	< 10)? '0' + num : num ;
	}

	function constructDate(d,m,y)
	{
		sTmp = dateFormat
		sTmp = sTmp.replace	("dd","<e>")
		sTmp = sTmp.replace	("d","<d>")
		sTmp = sTmp.replace	("<e>",padZero(d))
		sTmp = sTmp.replace	("<d>",d)
		sTmp = sTmp.replace	("mmmm","<p>")
		sTmp = sTmp.replace	("mmm","<o>")
		sTmp = sTmp.replace	("mm","<n>")
		sTmp = sTmp.replace	("m","<m>")
		sTmp = sTmp.replace	("<m>",m+1)
		sTmp = sTmp.replace	("<n>",padZero(m+1))
		sTmp = sTmp.replace	("<o>",monthName[m])
		sTmp = sTmp.replace	("<p>",monthName2[m])
		sTmp = sTmp.replace	("yyyy",y)
		return sTmp.replace ("yy",padZero(y%100))
	}

	function closeCalendar() {
		var	sTmp

		hideCalendar();
		//ctlToPlaceValue.value =	constructDate(dateSelected,monthSelected,yearSelected)
		objDia.value=dateSelected<10 ? "0"+dateSelected:dateSelected ;
		objMes.value=++monthSelected<10?"0"+monthSelected:monthSelected;
		objAno.value=yearSelected;
	}

	/*** Month Pulldown	***/

	function StartDecMonth()
	{
		intervalID1=setInterval("decMonth()",80)
	}

	function StartIncMonth()
	{
		intervalID1=setInterval("incMonth()",80)
	}

	function incMonth () {
		monthSelected++
		if (monthSelected>11) {
			monthSelected=0
			yearSelected++
		}
		constructCalendar()
	}

	function decMonth () {
		monthSelected--
		if (monthSelected<0) {
			monthSelected=11
			yearSelected--
		}
		constructCalendar()
	}

	function constructMonth() {
		popDownYear()
		if (!monthConstructed) {
			sHTML =	""
			for	(i=0; i<12;	i++) {
				sName =	monthName[i];
				if (i==monthSelected){
					sName =	"<B>" +	sName +	"</B>"
				}
				sHTML += "<tr><td id='m" + i + "' onmouseover='this.style.backgroundColor=\"#FFCC99\"' onmouseout='this.style.backgroundColor=\"\"' style='cursor:pointer' onclick='monthConstructed=false;monthSelected=" + i + ";constructCalendar();popDownMonth();event.cancelBubble=true'>&nbsp;" + sName + "&nbsp;</td></tr>"
			}

			document.getElementById("selectMonth").innerHTML = "<table width=70	style='font-family:arial; font-size:11px; border-width:1; border-style:solid; border-color:#a0a0a0;' bgcolor='#FFFFDD' cellspacing=0 onmouseover='clearTimeout(timeoutID1)'	onmouseout='clearTimeout(timeoutID1);timeoutID1=setTimeout(\"popDownMonth()\",100);event.cancelBubble=true'>" +	sHTML +	"</table>"

			monthConstructed=true
		}
	}

	function popUpMonth() {
		constructMonth()
		crossMonthObj.visibility = (dom||ie)? "visible"	: "show"
		crossMonthObj.left = parseInt(crossobj.left) + 50
		crossMonthObj.top =	parseInt(crossobj.top) + 26

		hideElement( 'SELECT', document.getElementById("selectMonth") );
		hideElement( 'APPLET', document.getElementById("selectMonth") );			
	}

	function popDownMonth()	{
		crossMonthObj.visibility= "hidden"
	}

	/*** Year Pulldown ***/

	function incYear() {
		for	(i=0; i<7; i++){
			newYear	= (i+nStartingYear)+1
			if (newYear==yearSelected)
			{ txtYear =	"&nbsp;<B>"	+ newYear +	"</B>&nbsp;" }
			else
			{ txtYear =	"&nbsp;" + newYear + "&nbsp;" }
			document.getElementById("y"+i).innerHTML = txtYear
		}
		nStartingYear ++;
		bShow=true
		
	}

	function decYear() {
		for	(i=0; i<7; i++){
			newYear	= (i+nStartingYear)-1
			if (newYear==yearSelected)
			{ txtYear =	"&nbsp;<B>"	+ newYear +	"</B>&nbsp;" }
			else
			{ txtYear =	"&nbsp;" + newYear + "&nbsp;" }
			document.getElementById("y"+i).innerHTML = txtYear
		}
		nStartingYear --;
		bShow=true
		
	}

	function selectYear(nYear) {
		yearSelected=parseInt(nYear+nStartingYear);
		yearConstructed=false;
		constructCalendar();
		popDownYear();
	}

	function constructYear() {
		popDownMonth()
		sHTML =	""
		if (!yearConstructed) {

			sHTML =	"<tr><td align='center'	onmouseover='this.style.backgroundColor=\"#FFCC99\"' onmouseout='clearInterval(intervalID1);this.style.backgroundColor=\"\"' style='cursor:pointer'	onmousedown='clearInterval(intervalID1);intervalID1=setInterval(\"decYear()\",30)' onmouseup='clearInterval(intervalID1)'>-</td></tr>"

			j =	0
			nStartingYear =	yearSelected-3
			for	(i=(yearSelected-3); i<=(yearSelected+3); i++) {
				sName =	i;
				if (i==yearSelected){
					sName =	"<B>" +	sName +	"</B>"
				}

				sHTML += "<tr><td id='y" + j + "' onmouseover='this.style.backgroundColor=\"#FFCC99\"' onmouseout='this.style.backgroundColor=\"\"' style='cursor:pointer' onclick='selectYear("+j+");event.cancelBubble=true'>&nbsp;" + sName + "&nbsp;</td></tr>"
				j ++;
			}

			sHTML += "<tr><td align='center' onmouseover='this.style.backgroundColor=\"#FFCC99\"' onmouseout='clearInterval(intervalID2);this.style.backgroundColor=\"\"' style='cursor:pointer' onmousedown='clearInterval(intervalID2);intervalID2=setInterval(\"incYear()\",30)'	onmouseup='clearInterval(intervalID2)'>+</td></tr>"

			document.getElementById("selectYear").innerHTML	= "<table width=44 style='font-family:arial; font-size:11px; border-width:1; border-style:solid; border-color:#a0a0a0;'	bgcolor='#FFFFDD' onmouseover='clearTimeout(timeoutID2)' onmouseout='clearTimeout(timeoutID2);timeoutID2=setTimeout(\"popDownYear()\",100)' cellspacing=0>"	+ sHTML	+ "</table>"

			yearConstructed	= true
		}
	}

	function popDownYear() {
		clearInterval(intervalID1)
		clearTimeout(timeoutID1)
		clearInterval(intervalID2)
		clearTimeout(timeoutID2)
		crossYearObj.visibility= "hidden"
	}

	function popUpYear() {
		var	leftOffset

		constructYear()
		crossYearObj.visibility	= (dom||ie)? "visible" : "show"
		leftOffset = parseInt(crossobj.left) + document.getElementById("spanYear").offsetLeft
		if (ie)
		{
			leftOffset += 6
		}
		crossYearObj.left =	leftOffset
		crossYearObj.top = parseInt(crossobj.top) +	26
	}

	/*** calendar ***/
   function WeekNbr(n) {
      
	  /*
       a = (14-month) / 12
       y = year + 4800 - a
       m = month + 12a - 3
       J = day + (153m + 2) / 5 + 365y + y / 4 - y / 100 + y / 400 - 32045
       d4 = (J + 31741 - (J mod 7)) mod 146097 mod 36524 mod 1461
       L = d4 / 1460
       d1 = ((d4 - L) mod 365) + L
       WeekNumber = d1 / 7 + 1
 */
      year = n.getFullYear();
      month = n.getMonth() + 1;
      if (startAt == 0) {
         day = n.getDate() + 1;
      }
      else {
         day = n.getDate();
      }
 
      a = Math.floor((14-month) / 12);
      y = year + 4800 - a;
      m = month + 12 * a - 3;
      b = Math.floor(y/4) - Math.floor(y/100) + Math.floor(y/400);
      J = day + Math.floor((153 * m + 2) / 5) + 365 * y + b - 32045;
      d4 = (((J + 31741 - (J % 7)) % 146097) % 36524) % 1461;
      L = Math.floor(d4 / 1460);
      d1 = ((d4 - L) % 365) + L;
      week = Math.floor(d1/7) + 1;
 
      return week;
   }

	function constructCalendar () {
		var aNumDays = Array (31,28,31,30,31,30,31,31,30,31,30,31)

		var dateMessage
		var	startDate =	new	Date (yearSelected,monthSelected,1)
		var endDate

		if (monthSelected==1)
		{		
			if (yearSelected % 4 == 0) aNumDays[monthSelected]++;			 
		}
		
		numDaysInMonth = aNumDays[monthSelected];
		

		datePointer	= 0
		dayPointer = startDate.getDay() - startAt
		
		if (dayPointer<0)
		{
			dayPointer = 6
		}

		sHTML =	"<table	 border=0 style='font-family:verdana;font-size:10px;'><tr>"

		if (showWeekNumber==1)
		{
			sHTML += "<td width=27><b>" + weekString + "</b></td><td width=1 rowspan=7 bgcolor='#d0d0d0' style='padding:0px'><img src='"+imgDir+"divider.gif' width=1></td>"
		}

		for	(i=0; i<7; i++)	{
			sHTML += "<td width='27' align='right'><B>"+ dayName[i]+"</B></td>"
		}
		sHTML +="</tr><tr>"
		
		if (showWeekNumber==1)
		{
			sHTML += "<td align=right>" + WeekNbr(startDate) + "&nbsp;</td>"
		}

		for	( var i=1; i<=dayPointer;i++ )
		{
			sHTML += "<td>&nbsp;</td>"
		}
	
		for	( datePointer=1; datePointer<=numDaysInMonth; datePointer++ )
		{
			dayPointer++;
			sHTML += "<td align=right>"
			sStyle=styleAnchor
			if ((datePointer==odateSelected) &&	(monthSelected==omonthSelected)	&& (yearSelected==oyearSelected))
			{ sStyle+=styleLightBorder }

			sHint = ""
			for (k=0;k<HolidaysCounter;k++)
			{
				if ((parseInt(Holidays[k].d)==datePointer)&&(parseInt(Holidays[k].m)==(monthSelected+1)))
				{
					if ((parseInt(Holidays[k].y)==0)||((parseInt(Holidays[k].y)==yearSelected)&&(parseInt(Holidays[k].y)!=0)))
					{
						sStyle+="background-color:#FFDDDD;"
						sHint+=sHint==""?Holidays[k].desc:"\n"+Holidays[k].desc
					}
				}
			}

			var regexp= /\"/g
			sHint=sHint.replace(regexp,"&quot;")

			dateMessage = "onmousemove='window.status=\""+selectDateMessage.replace("[date]",constructDate(datePointer,monthSelected,yearSelected))+"\"' onmouseout='window.status=\"\"' "

			if ((datePointer==dateNow)&&(monthSelected==monthNow)&&(yearSelected==yearNow))
			{ sHTML += "<b><a "+dateMessage+" title=\"" + sHint + "\" style='"+sStyle+"' href='javascript:dateSelected="+datePointer+";closeCalendar();'><font color=#ff0000>&nbsp;" + datePointer + "</font>&nbsp;</a></b>"}
			else if	(dayPointer % 7 == (startAt * -1)+1)
			{ sHTML += "<a "+dateMessage+" title=\"" + sHint + "\" style='"+sStyle+"' href='javascript:dateSelected="+datePointer + ";closeCalendar();'>&nbsp;<font color=#909090>" + datePointer + "</font>&nbsp;</a>" }
			else
			{ sHTML += "<a "+dateMessage+" title=\"" + sHint + "\" style='"+sStyle+"' href='javascript:dateSelected="+datePointer + ";closeCalendar();'>&nbsp;" + datePointer + "&nbsp;</a>" }

			sHTML += ""
			if ((dayPointer+startAt) % 7 == startAt) { 
				sHTML += "</tr><tr>" 
				if ((showWeekNumber==1)&&(datePointer<numDaysInMonth))
				{
					sHTML += "<td align=right>" + (WeekNbr(new Date(yearSelected,monthSelected,datePointer+1))) + "&nbsp;</td>";
				}
			}
		}

		document.getElementById("content").innerHTML   = sHTML;
		document.getElementById("spanMonth").innerHTML = "&nbsp;" +	monthName[monthSelected] + "&nbsp;<IMG id='changeMonth' SRC='"+imgDir+"drop1.gif' WIDTH='12' HEIGHT='10' BORDER=0>";
		document.getElementById("spanYear").innerHTML =	"&nbsp;" + yearSelected	+ "&nbsp;<IMG id='changeYear' SRC='"+imgDir+"drop1.gif' WIDTH='12' HEIGHT='10' BORDER=0>";
	}

	function popUpCalendar(anfitrion, tdia,tmes,tano) {
	///esconder barra divflota, si la hay		
	if (tano.disabled) return
	
	if (typeof divflota!="undefined") divflota.style.visibility="hidden";
	///
	    
		var	leftpos=0;
		var	toppos=0;

		if (bPageLoaded)
		{
			if ( crossobj.visibility ==	"hidden" ) {
				//ctlToPlaceValue	= ctl2;
				objDia=tdia;
				objMes=tmes;
				objAno=tano;
				dateFormat=format;

				formatChar = " ";
				aFormat	= dateFormat.split(formatChar);
				if (aFormat.length<3)
				{
					formatChar = "/";
					aFormat	= dateFormat.split(formatChar)
					if (aFormat.length<3)
					{
						formatChar = ".";
						aFormat	= dateFormat.split(formatChar)
						if (aFormat.length<3)
						{
							formatChar = "-";
							aFormat	= dateFormat.split(formatChar);
							if (aFormat.length<3)
							{
								// invalid date	format
								formatChar="";
							}
						}
					}
				}

				tokensChanged =	0
				if ( formatChar	!= "" )
				{
					// use user's date
					if (tdia.value>0&&tmes.value>0&&tano.value>0)
				    inifecha=tdia.value+"/"+tmes.value+"/"+tano.value;
				    else
				    inifecha="";
					aData =	inifecha.split(formatChar);

					for	(i=0;i<3;i++)
					{
						if ((aFormat[i]=="d") || (aFormat[i]=="dd"))
						{
							dateSelected = parseInt(aData[i], 10);
							tokensChanged ++;
						}
						else if	((aFormat[i]=="m") || (aFormat[i]=="mm"))
						{
							monthSelected =	parseInt(aData[i], 10) - 1;
							tokensChanged ++;
						}
						else if	(aFormat[i]=="yyyy")
						{
							yearSelected = parseInt(aData[i], 10);
							tokensChanged ++;
						}
						else if	(aFormat[i]=="mmm")
						{
							for	(j=0; j<12;	j++)
							{
								if (aData[i]==monthName[j])
								{
									monthSelected=j;
									tokensChanged ++;
								}
							}
						}
						else if	(aFormat[i]=="mmmm")
						{
							for	(j=0; j<12;	j++)
							{
								if (aData[i]==monthName2[j])
								{
									monthSelected=j;
									tokensChanged ++;
								}
							}
						}
					}
				}

				if ((tokensChanged!=3)||isNaN(dateSelected)||isNaN(monthSelected)||isNaN(yearSelected))
				{
					dateSelected = dateNow;
					monthSelected =	monthNow;
					yearSelected = yearNow;
				}

				odateSelected=dateSelected;
				omonthSelected=monthSelected;
				oyearSelected=yearSelected;

				aTag = anfitrion;
				do {
					aTag = aTag.offsetParent;
					leftpos	+= aTag.offsetLeft;
					toppos += aTag.offsetTop;
				} while(aTag.tagName!="BODY");
                
				oCalen=document.getElementById("calendar")
				
				
				//para el left
				anteLeft= fixedX==-1 ? anfitrion.offsetLeft	+ leftpos :	fixedX;							
				//si se sale
				if (anteLeft+oCalen.offsetWidth>document.body.offsetWidth)				
				anteLeft=document.body.offsetWidth-oCalen.offsetWidth-20
				crossobj.left = anteLeft		
				
				//para el top
				anteTop= fixedY==-1 ?	anfitrion.offsetTop + toppos + anfitrion.offsetHeight +	2 :	fixedY;
				//si se sale
				if (anteTop+oCalen.offsetHeight>document.body.offsetHeight)				
				anteTop=document.body.offsetHeight-(oCalen.offsetHeight<120? 174: oCalen.offsetHeight)-20
				crossobj.top = anteTop			
				
				
				constructCalendar (1, monthSelected, yearSelected)
				crossobj.visibility=(dom||ie)? "visible" : "show"

				hideElement( 'SELECT', document.getElementById("calendar") )
				hideElement( 'APPLET', document.getElementById("calendar") )			

				bShow = true;
				
				
			}
			else
			{
				hideCalendar();
				if (ctlNow!=anfitrion) {popUpCalendar(anfitrion, tdia,tmes,tano);}
			}
			ctlNow = anfitrion;
		}
	
	}

	document.onkeypress = function hidecal1 () { 
		if (event.keyCode==27) 
		{
			hideCalendar();
		}
	}
	document.onclick = function hidecal2 () { 		
      
		
		if (!bShow)
		{		
			hideCalendar();
			
		}
		bShow = false;
	}

	window.onscroll = function hidecal3 () { 				
			hideCalendar();		
	}
	
	if(ie)
	{
		init();
	}
	else
	{
		window.onload=init;
	}
	addHoliday(25,12,2003,'Navidad');
	addHoliday(25,12,2004,'Navidad');