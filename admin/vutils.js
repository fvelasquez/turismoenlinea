/*
Hecho por: Fradique Lee
Fecha: 09/12/2003
Ultima Modificacion: 05/01/2004
Libreria de ulitidades
1. VentanaMensaje(xMensaje,[xTitulo],[xFlash])  Muestra la ventanita de mensajes en el centro de la pantalla
   --si se deja en blanco ("") el parametro de mensajes, el mensaje desaparece
   --si se omite el titulo el valor por defecto es: ""
	 si se envia una cadena en el parametro titulo, este sera el titulo de la ventana
	 si se envia un numero tomara los siguientes valores:
	 var stdMensajes=["","","INFORMACION","ADVERTENCIA"]
	 0 ""
	 1 "ERROR !!!" este valor por default tiene el efecto de flashing
	 2 "INFORMACION"
	 3 "ADVERTENCIA"
   --si al ultimo parametro se le asigna true el titulo tendra el efecto de flashing si se omite o es falso
     el titulo sera normal
      
   se debe de poner el txtMensaje en hidden, pueden agregar lo siguiente al style del mensaje: VISIBILITY: hidden;
   o bien convertirlo en un hidden
   
   Ya que la ventana soporta HTML, tendremos que tener cuidado con los braces de HTML < > si necesitaramos
   escribir cualquiera de estos dos signos los podemos escribir como &lt;  y  &gt; respectivamente
  
2. Procesando()  Muestra la ventanita de mensajes en el centro de la pantalla, sin titulo y con el mensaje
   de: "Procesando datos......" con los puntos animados
   
3. ValidaNum(campo,[max]) //valida un numero con un maximo, solo soporta 2 digitos
    si se omite el segundo campo solo valida normalmente un numero, esta funcion evita que se otra cosa que no 
    sea numeros en un campo, inlcuir esta linea en los campos: onkeypress="return ValidaNum(this)"
    
    NOTA: si modificamos la variable global xenter, 
   
*/


var	ie=document.all
	var	dom=document.getElementById
	var mShow=false
	var proc=false
	var xenter=false

function ValidaDec(campo,decimales)
{       mensaje=document.all.txtMensaje
		var keycode = event.keyCode
		var realkey = String.fromCharCode(event.keyCode)
		
		if ((keycode<48||keycode>57)&&keycode!=46)
			{				
				mensaje.value =	"Debe Ingresar Datos Numericos"	
				event.returnValue=false
				return;
			}
		if (keycode==46) 
		    {
		        if (campo.value.indexOf(".")>-1)
		           {
		           mensaje.value =	"Debe Ingresar Datos Numericos"	
		           event.returnValue=false
				   return;
		           }
		    }
		    else
		    {
		       puntito=campo.value.indexOf(".")
		       if (puntito>-1)
		         {
		           ndec=campo.value.length-1-puntito
		           if (ndec>=decimales)
		            {
		            mensaje.value =	"Solo soporta "+decimales+" decimales."	
		           event.returnValue=false
				   return;
		            }
		         }
		    }
		
	mensaje.value =	""
}

function validaNum(campo,max) {ValidaNum(campo,max)} //para compatibilidad con las primeras versiones
function ValidaNum(campo,max) //valida un numero con un maximo, solo soporta 2 digitos
		{		
		//mensaje=document.getElementById("txtMensaje")
		var keycode = event.keyCode
		var realkey = String.fromCharCode(event.keyCode)
		if (keycode==13) return
		if (keycode!=13&&max) document.selection.clear()
		
			if (keycode<48||keycode>57)
			{				
				//mensaje.value =	"Debe Ingresar Datos Numericos"	
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
				//mensaje.value =	"El valor maximo de este campo es: "+max	
				campo.select()
				return false;
				}				
			}
				//mensaje.value ="";				
			}        
		}	


		
		if (typeof imgDir == "undefined") 
		imgDir = "/sud/principal/imagenes/";			// directorio de imagenes ...ejm  "/sud/principal/imagenes/"
		
//xTrampa="<input style='Position:absolute;left:-2000;top:-2000' id=txtTrampa value='Esta es una trampa para el cursor'>"
//document.write (xTrampa)

xVentana="<div id='mensajes' onclick='mShow=true;' style='z-index:999;position:absolute;visibility:hidden'>"
xVentana+="<table  width=220 style='font-family:arial;font-size:11px;border-width:1;border-style:solid;border-color:#a0a0a0;font-family:arial; font-size:11px}' bgcolor='#ffffff'>"
xVentana+="<tr bgcolor=darkblue><td><table width='100%'><tr><td style='padding:2px; font-size:11px;'>"
xVentana+="<font color='#ffffff'><B><span  id='msgTitulo'></span></B></font></td><td align=right>"
xVentana+="<IMG id=btnClose SRC='"+imgDir+"close.gif' WIDTH='15' HEIGHT='13' BORDER='0' ALT='Cerrar el mensaje' onclick='javascript:EscondeMensaje()'></td></tr></table></td></tr>"
xVentana+="<tr><td style='padding:5px ' bgcolor=#ffffff><span  id='msgContenido' style='OVERFLOW: auto' ></span></td></tr></table></div>"

		document.write (xVentana)
		mensajes.style.left=document.body.offsetWidth/2-16-mensajes.offsetWidth/2
		mensajes.style.top=document.body.offsetHeight/2-mensajes.offsetHeight/2-40
		window.onresize=function()
		{
		EscondeMensaje()
		mensajes.style.left=document.body.offsetWidth/2-16-mensajes.offsetWidth/2
		mensajes.style.top=document.body.offsetHeight/2-mensajes.offsetHeight/2-40
		}

		if (document.onkeypress)
		{
		document.onkeytemp=document.onkeypress
		}
		
		document.onkeypress=function()
		{
		if (event.keyCode==27) 
			{		
			if (!proc) EscondeMensaje()
			if (document.onkeytemp) document.onkeytemp()
			}
		if (event.keyCode==13) 
			{		
			if (!proc&&!xenter) EscondeMensaje()
			
			}
		}
xRetornoTrampa=0
						
		ggg=setInterval("msgCopia()",250)
		
		/*funcion encargada de verificar constantemente el estado del control txtMensaje*/		
function msgCopia()
{		
	txt=document.getElementById("txtMensaje")		
	if (txt)
	{
		if (txt.value.length>0)
		{		    
			if (txt.title.length==0)
			{
				txt.title="ERROR !!!"
				txt.flash=true
			}
			hideElement( 'SELECT', document.getElementById("mensajes") );			
			if (mensajes.style.visibility=="hidden")
			{	
				if (txt.value.substr(0,1)=="&")
				{
					txt.value=txt.value.replace(/^&/,"")
					txt.title=" "
					txt.flash=false
				}
				msgContenido.innerHTML=txt.value.fontsize(2).fontcolor("red")
				if (mensajes.offsetHeight>172)
				{		
					msgContenido.style.width="100%"
					msgContenido.style.height="128"
					msgContenido.style.overflow="auto"
					mensajes.grande=true						
				}		
				mensajes.style.visibility=""
				
				
				//hideElement( 'SELECT', document.getElementById("mensajes") );
				//hideElement( 'APPLET', document.getElementById("mensajes") );
				txt.anterior=txt.value
			}
			else
			{
				if (txt.anterior!=txt.value)
				{
					msgContenido.innerHTML=txt.value.fontsize(2).fontcolor("red")
					txt.anterior=txt.value			  
				}					  
			}
			
		
		if (txt.flash)
		{
			if (txt.xflash)			
			txt.tempo=txt.title				
			else
			txt.tempo=""			
			txt.xflash=!txt.xflash
			msgTitulo.innerHTML=txt.tempo.fontsize(2).bold()			
		}
		else
			msgTitulo.innerHTML=txt.title.fontsize(2).bold()
			
	}
	else
	EscondeMensaje()				
	//evita cuando hay back
if (txt.title=="ERROR !!!"&&txt.value.substr(0,6)=="Proces")
EscondeMensaje()				
	}							
}		
		
		/*Muestra la ventana en un intento por hacerla modal*/
		function VentanaMensajeModal(xControl,xMensaje,xTitulo,xFlash)
		{
		  var stdMensajes=[" ","ERROR !!!","INFORMACION","ADVERTENCIA"]
			if (typeof xTitulo=="string") 
			{
				stdMensajes[0]=xTitulo
				xTitulo=0
			}
			EscondeMensaje()				
			txt=document.all.txtMensaje
			txt.value=xMensaje		
			if (typeof xTitulo=="undefined") xTitulo=1				
				txt.title=stdMensajes[xTitulo] ? stdMensajes[xTitulo] : " "
							
			if (xTitulo==1&&(typeof xFlash=="undefined")) xFlash=true
				txt.flash=xFlash		
			mShow=true		
//			ActivaTrampa(xControl)
		}

		/*Muestra la ventana*/
		function VentanaMensaje(xMensaje,xTitulo,xFlash)
		{
		var stdMensajes=[" ","ERROR !!!","INFORMACION","ADVERTENCIA"]
		if (typeof xTitulo=="string") 
		  {
		  stdMensajes[0]=xTitulo
		  xTitulo=0
		  }
		EscondeMensaje()				
		txt=document.all.txtMensaje
		txt.value=xMensaje		
		if (typeof xTitulo=="undefined") xTitulo=1				
		txt.title=stdMensajes[xTitulo] ? stdMensajes[xTitulo] : " "
		
		if (xTitulo==1&&(typeof xFlash=="undefined")) xFlash=true
		txt.flash=xFlash		
		mShow=true
		
		}
		/*Esconde la ventana y muestra los controles que habian atras*/
		function EscondeMensaje()
		{
		document.all.txtMensaje.value=""
		document.all.txtMensaje.title=""		
          if(mensajes.style.visibility!="hidden")
          {
		    hideElement('SELECT', document.all.mensajes ,true);
			//hideElement('APPLET', document.getElementById("mensajes"),true);		    
		  }

		mensajes.style.visibility="hidden"
			if (mensajes.grande) 
			{			
			msgContenido.style.height=""
			mensajes.grande=false
			}	
//			ActivaTrampa()
		}
		
		/* esconde <select> y <applet>  debajo de overdiv y si se esconde o no en el
		ultimo parametro */
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
          { if (unHide)
			obj.style.visibility = "";
            else
            obj.style.visibility = "hidden";
          }
        }
      }
    }
    /*
    * muestra <select> y <applet> 's
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

		
  
  //heredo document.click y agrego la funcion de escondemensaje
  
  if (document.onclick)  //esconde con hacer click fuera del mensaje
  {
   document.onclick2=document.onclick   
   document.onclick=function onclick() 
			{					
				if (!mShow)	
				{
				//setTimeout("EscondeMensaje();",1000)	
				EscondeMensaje()
				}
				mShow=false
				
				document.onclick2() 								
			}
   }
   else
   document.onclick=function onclick() 
			{	
			    
			    if (!mShow)	
			    {
				EscondeMensaje()
				}
				mShow=false		
				
			}
	/*
	document.onkeypress=function onkeypress() //esconde mensaje con precionar una tecla
	{
	
			    if (!mShow)	
			    {
				EscondeMensaje()
				}
				mShow=false		
	}
   	*/		
	   var puntos=6
	   var yanoproc=false
	   
	   
	   function Procesando(para)
	   {
	   if (para) 
	   {
	   EscondeMensaje()	
	   yanoproc=true
	   }
	   else
	   {
	   		if (!yanoproc)
	   		{
			sPuntos=""
			for (j=0;j<puntos;j++)
			sPuntos+=" ."
			puntos=puntos<7 ? puntos+1 : 0	   
			document.forms(0).txtMensaje.value='Procesando datos '+sPuntos.bold()
			msgContenido.innerHTML=('Procesando datos '+sPuntos.bold()).fontsize(2).fontcolor("red")
			document.forms(0).txtMensaje.title=' '			
			hideElement( 'SELECT', document.getElementById("mensajes") );
			//hideElement( 'APPLET', document.getElementById("mensajes") );
			mensajes.style.visibility=""	   	   
	
			setTimeout("Procesando()",500) 	   
			proc=true
			document.getElementById("btnClose").onclick=''
			document.onclick=null
			mShow=true
			}
			yanoproc=false
		}
	
	   }
	   
	 