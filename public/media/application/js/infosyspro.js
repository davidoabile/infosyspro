
dojo.addOnLoad(function() {
  //render each tooltip
  dojo.require("dijit.Tooltip");
  var i = 0;
  dojo.query(".hasTip").forEach(function(node) {   
      if(!node.title)
          return; // don't do anything if there is no title
      if(!node.id) // Dojo requires an ID for the element
      {
          node.id = "dojoToolTip-"+i;
          i++;
      }
      var tt = new dijit.Tooltip({label:node.title, connectId:[node.id]});
      node.title = ""; // remove the Browsers standard title tag
  });
  
 
});

function submitFormProcess(id, formID) {
    var node = dojo.byId(id);  
    if(id == 'toolbar-help') {
        alert('help coming soon');
    } else if (id == 'toolbar-cancel'){
        alert('cancelled');
    } else {
          var handle =  dojo.connect(node, "onclick", function(e){   
              tinyMCE.triggerSave();
                dojo.stopEvent(e);
                dojo.xhrPost({
                    form: formID,
                    handleAs: 'text',
                    load: function(data) {
                        if(data) {
                           window.location.reload();                        
                        }
                    },
                    error: function(error) {
                    console.log(error);
                    }
                })
                //connect.disconnect(handle);
            });
    }
 
}



/*
dojo.addOnLoad(
    
    function() {      
        dojo.connect(dojo.byId('iform_title'), 'onkeydown', function(event){
            
            if (event.keyCode == dojo.keys.SPACE) {
                node = dojo.byId('iform_title');
                alert($(this).val());
                 var value = dojo.query("#iform_title").val();
                 alert(value);
                dojo.query("#iform_alias").text(value);
 
                //dojo.stopEvent(event);
            }
        });
    }
    );
*/

 
function test() {

/*
 * key imput
 */
$("#iform_title").keyup(function () {
      var value = $(this).val();
      $("#iform_alias").text(value);
    }).keyup();
}