//<![CDATA[

window.onload=function() {
   var elems = null;
   var labels = null;
   if (document.querySelectorAll) {
      elems = document.querySelectorAll('.elements');
      labels = document.querySelectorAll('.label');
   } else if (document.getElementsByClassName) {
       elems = document.getElementsByClassName('elements');
       labels = document.getElementsByClassName('label');
   }
   if (elems) {
      for (var i = 0; i < elems.length; i++) {
         elems[i].style.display="none";
      }
      for (var i = 0; i < labels.length; i++) {
        labels[i].onclick=showBlock;
      }
   }

}
function showBlock(evnt) {

   var theEvent = evnt ? evnt : window.event;
   var theSrc = theEvent.target ? theEvent.target : theEvent.srcElement;
   var itemId = "elements" + theSrc.id.substr(5,1);
   var item = document.getElementById(itemId);
   if (item.style.display=='none') {
       item.style.display='block';
   } else {
       item.style.display='none';
   }
}
//]]>