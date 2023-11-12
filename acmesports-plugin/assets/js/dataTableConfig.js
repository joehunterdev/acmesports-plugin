/*$(document).ready(function () {



});
*/

jQuery(document).ready(function($){

    //var jsonData = [{ meta: { version: 1, type: "test" } }];
   /*
    $("#nfl-table").DataTable({
        data: jsonData,
        columns: [{ data: "meta.type" }, { data: "meta.version" }],
      });
    */
         $("#nfl-table").DataTable( {
            "id": [[ 3, "desc" ]]
        } );
 });