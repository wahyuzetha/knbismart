
function readCookies() {
      if (!navigator.cookieEnabled) {
    return false;
  }

  
	var cook={
      lat:null,
      lng:null,
      zoom:null,
      svheading:null,
      svpitch:null,
      svzoom:null,
      maptype:null
      };
	var param, val, equally, str;    

    var arr=document.cookie.split(';');
    
    
    for (var i=0;i<arr.length;i++) {
      str=arr[i];
    	equally=str.indexOf('=');
      param=str.substring(0,equally);
      param=param.replace(/\s+/g,'');
      val=str.substring(equally+1);
      if (param=="lat")
       {cook.lat=val};
      if (param=="lng")
       {cook.lng=val};
      if (param=="zoom") 
       {cook.zoom=val};
      if (param=="svheading")
       {cook.svheading=val};
      if (param=="svpitch")
       {cook.svpitch=val};
      if (param=="svzoom") 
       {cook.svzoom=val};
      if (param=="maptype")
       {cook.maptype=val};
    };

  /* ((isNaN(cook.lat)) && (isNaN(cook.lng)) && (isNaN(cook.zoom)) && (isNaN(cook.maptype)) && (isNaN(cook.svheading)) && (isNaN(cook.svpitch)) &&    (isNaN(cook.svzoom))) */
    
     if ((isNaN(cook.lat)) && (isNaN(cook.lng)) ) {   
    
    resetCookies();
    
      return false;
   }
   
     if ((cook.lat==null) && (cook.lng==null) ) {   
    
    resetCookies();
    
      return false;
   }
   
   
   if(isNaN(cook.zoom)) {
    
     cook.zoom=14;
     
   }
   
   if(cook.zoom==null) {
    
     cook.zoom=14;
     
   }

   
    
   if(isNaN(cook.maptype) && (cook.maptype==null)) {
    
     cook.maptype=1;
     
   }

   if(isNaN(cook.svheading) && (cook.svheading==null)) {
    
     cook.svheading=0;
     
   }

   if(isNaN(cook.svpitch) && (cook.svpitch==null)) {
    
     cook.svpitch=0;
     
   }

   if(isNaN(cook.svzoom) && (cook.svzoom==null)) {
    
     cook.svzoom=0;
     
   }
   
   
      cook.lat=1*cook.lat;
      cook.lng=1*cook.lng;
      cook.zoom=1*cook.zoom;
      cook.svheading=1*cook.svheading;
      cook.svpitch=1*cook.svpitch;
      cook.svzoom=1*cook.svzoom;   
      cook.maptype=1*cook.maptype;
      
	return cook;
	
	
}


function resetCookies() {
  document.cookie="lat='';path=/;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
  document.cookie="lng='';path=/;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
  document.cookie="zoom='';path=/;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
  document.cookie="svheading='';path=/;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
  document.cookie="svpitch='';path=/;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
  document.cookie="svzoom='';path=/;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
  document.cookie="maptype='';path=/;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
  
   
}

function saveCookies(obj) {
  
  /*
  
  	 obj={
      lat:null,      // required
      lng:null,      // required
      zoom:null,     // 
      maptype:null,  // 
      svheading:null,
      svpitch:null,
      svzoom:null
      };

  */
  
    if (!navigator.cookieEnabled) {
    return false;
  }
  
  resetCookies();  
  
   if ((isNaN(obj.lat)) && (isNaN(obj.lng)) )
   {
     
      return false;
   }
   
   if ((obj.lat==null) && (obj.lng==null) ) {
    
     return false;
     
   }
   
   if ((obj.maptype==null) && isNaN(obj.maptype)) {
    obj.maptype=1;
    
   }
   
   if ((obj.zoom==null) && isNaN(obj.zoom)) {
    
     obj.zoom=14;
   }
   
     
     var maxDays=1095;
     var date=new Date;
  date.setDate(date.getDate() + maxDays);
  
  document.cookie="lat="+obj.lat+';path=/;expires='+date.toUTCString();
  document.cookie="lng="+obj.lng+';path=/;expires='+date.toUTCString();
  document.cookie="zoom="+obj.zoom+';path=/;expires='+date.toUTCString();
  document.cookie="maptype="+obj.maptype+';path=/;expires='+date.toUTCString();
  

   
  if ((!isNaN(obj.svheading)) && (obj.svheading!=null)) {  
  document.cookie="svheading="+obj.svheading+';path=/;expires='+date.toUTCString();
  }
  
  if ((!isNaN(obj.svpitch)) && (obj.svpitch!=null)) {
  document.cookie="svpitch="+obj.svpitch+';path=/;expires='+date.toUTCString();
  }
  
  if ((!isNaN(obj.svzoom)) && (obj.svzoom!=null) ) {
    document.cookie="svzoom="+obj.svzoom+';path=/;expires='+date.toUTCString();
  }
  
return true;
}