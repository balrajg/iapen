
/*---------------------------------------------
  MAIAN SURVEY v1.1
  Written by David Ian Bennett
  E-Mail: N/A
  Website: www.maiansurvey.com
----------------------------------------------*/

function selectAll() {
  for (var i=0;i<document.MyForm.elements.length;i++) {
    var e = document.MyForm.elements[i];
    if ((e.name != 'log') && (e.type=='checkbox')) {
      e.checked = document.MyForm.log.checked;
    }
  }
}
function submit_confirm(txt,url) {
  var txt;
  var url;
  var confirmSub = confirm(txt);
  if (confirmSub) {
    window.location = url;
  } else { 
    return false;
  }
}

function delete_confirm(txt) {
  var txt;
  var confirmSub = confirm(txt);
  if (confirmSub) { 
    return true;
  } else { 
    return false; 
  }
}
