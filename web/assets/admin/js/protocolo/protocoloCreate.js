//$( document ).ready(function() {
//     $('.protocoloCreate').on( "submit", function(e) {
//        data.
//        var inforrmes = getInformes();
//       if( informes!== undefined && informes!==null ){
//                  var id_protocolo= createProtocolo();     
//                   setIdInformes();
//         } 
//      });
//              
//              
//          }
//   console.log("holaaaaaaaaaa");
//   
// });
// 
// 
// function createProtocolo(){
//        
//  $.ajax( {
//            url: "index.php?r=protocolo%2Fcreate",
//            type: "POST",
//            data: FormData(this),
//            processData: false,
//            contentType: false,
//            success: function(data) {
//                if(data.status==='error'){
//                    $.each(data, function(i,item){
//                                 $('.field-'+i).removeClass('has-success')
//                               $('.field-'+i).addClass(' has-error');                  
//                    });
//                }else{
//                     $('#activity-modal').modal('toggle');
//                     clearFormInforme();
//                     var input = $('div#InformeData').find('input');
//    //                  $("#etudiosInformeTemp").on("pjax:end", function() {
//    //                     $.pjax.reload({container:"#dataProvider"});  //Reload GridView
//    //                });
//    //                refreshGred();
//                }      
//            },
//            error: function(data) {
//
//             }
//   } );
//        
//        
// }