

    function sendInforme(){
  
        //agregar el campo tanda al modelo            
        var form = $("#form-informe-complete");

        // submit form
        $.ajax({ 
            url : 'index.php?r=informe/finalizarcarga',
            type : "post",
            dataType: "JSON",
            data : form.serialize(),
            success: function (response)
            {
               alert("entree");
               console.log("eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee");

            },
            error : function ()
            {

                console.log("internal server error");
            }
        });
        return false;
    };  
         
    function sendPrint($id){
  
        //agregar el campo tanda al modelo            
        //ar form = $("#form-informe-complete");
        alert($id);

        // submit form
        $.ajax({ 
            url : 'index.php?r=informe/printpap',
            type : "post",            
            data :  {'id' : $id },
            success: function (response)
            {
              
               console.log("eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee");

            },
            error : function ()
            {

                console.log("internal server error");
            }
        });
        return false;
    }; 
    
    function addNomenclador($id){
  
        //agregar el campo tanda al modelo            
        //ar form = $("#form-informe-complete");
        alert($id);

        // submit form
        $.ajax({ 
            url : 'index.php?r=informe/printpap',
            type : "post",            
            data :  {'id' : $id },
            success: function (response)
            {
              
               console.log("eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee");

            },
            error : function ()
            {

                console.log("internal server error");
            }
        });
        return false;
    }; 
          