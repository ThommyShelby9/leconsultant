function AfficherServ(){
    var idAc= document.getElementById('autorite').value;


    if(idAc != 0){

       col='<option value="Toutes les directions">Toutes les directions</option>';
       $("#service").empty();
       $("#service").append(col);

        $(function(){

            var _token = '<?php echo csrf_token(); ?>';


            $.ajax({
                url:'{{ route("ajax-direction") }}',
                data:{
                    idAc: idAc,
                    _token
                },
                dataType: 'JSON',
                type:'POST',
                encode  : true,
                success:function(data){
                    //alert(data);
                    //console.log("Debut");
                    var col ;
                    data.forEach(element => {



                        col='<option value="'+element['abreviation']+'">'+element['name']+'</option>';

                        $("#service").append(col);
                        console.log(col);

                    });
                    //console.log("Fin debug");

                },
                failure: function(){
                    alert("Error Direc");
                }
            });

        })

    }else{

        $("#service").empty();
    }
}


function AfficherAC(){
    var idCateg = document.getElementById('categorie').value;

    if(idCateg != 0){

       col='<option value="null">Choisir A.C</option>';
       $("#autorite").empty();
       $("#autorite").append(col);

        $(function(){
            var _token = '<?php echo csrf_token(); ?>';
            console.log("AC Debut ajax");
            $.ajax({
                url:'{{ route("ajax-ac") }}',
                data:{
                    idCateg: idCateg,
                    _token
                },
                dataType: 'JSON',
                type:'POST',
                encode  : true,
                success:function(data){
                   //console.log("AC Ca marche 1");
                    var col ;
                    data.forEach(element => {
                        col='<option value="'+element['id']+'">'+element['name']+'</option>';


                        $("#autorite").append(col);
                        //console.log(col);


                    });

                },
                 failure: function(){
                    alert("Error AC");
                }
            });
            //console.log("AC Fin ajax");
        })

    }else{

        $("#autorite").empty();
        $("#service").empty();
    }
}
