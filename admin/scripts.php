<script src="../js/jquery-3.6.1.min.js"></script>

<script type="text/javascript">
    function insetOBJchelt(){
        $(document).ready(function(){
                var data = {
                object : $('#insertC').val(),
                action : "insertC"
            };
            console.log(data);
            $.ajax({
                url: 'adminfunction.php',
                type: 'post',
                data: data,
                success:function(response){
                if(response.replace(/\s/g, '') == "Insert"){
                    window.location.reload();
                }
                }
            });
    });
    }


    function insetOBJvenit(){
        $(document).ready(function(){
            var data = {
                object : $('#insertV').val(),
                action : "insertV"
            };
            $.ajax({
                url: 'adminfunction.php',
                type: 'post',
                data: data,
                success:function(response){
                if(response.replace(/\s/g, '') == "Insert"){
                    window.location.reload();
                }
                }
            });
        });
    }

    function editOBJVenit(id){
        $(document).ready(function(){
            var data = {
                id_obj : id,
                object : $('#venit'.concat(id)).val(),
                action : "editOBJVenit"
            };
            console.log(data);
            $.ajax({
                url: 'adminfunction.php',
                type: 'post',
                data: data,
                success:function(response){
                if(response.replace(/\s/g, '') == "Edit"){
                    window.location.reload();
                }
                }
            });
     });
    }

    function deleteOBJVenit(id){
        $(document).ready(function(){
            var data = {
                id_obj : id,
                action : "deleteOBJVenit"
            };
            $.ajax({
                url: 'adminfunction.php',
                type: 'post',
                data: data,
                success:function(response){
                if(response.replace(/\s/g, '') == "Delete"){
                    window.location.reload();
                }
                }
            });
        });
    }

    function editOBJChelt(id){
        $(document).ready(function(){
            var data = {
                id_obj : id,
                object : $('#chelt'.concat(id)).val(),
                action : "editOBJChelt"
            };
            console.log(data);
            $.ajax({
                url: 'adminfunction.php',
                type: 'post',
                data: data,
                success:function(response){
                if(response.replace(/\s/g, '') == "Edit"){
                    window.location.reload();
                }
                }
            });
     });
    }

    function deleteOBJChelt(id){
        $(document).ready(function(){
            var data = {
                id_obj : id,
                action : "deleteOBJChelt"
            };
            $.ajax({
                url: 'adminfunction.php',
                type: 'post',
                data: data,
                success:function(response){
                if(response.replace(/\s/g, '') == "Delete"){
                    window.location.reload();
                }
                }
            });
        });
    }

    function userinfo(id){
        $(document).ready(function(){
            var data = {
                id_user : id,
                action : "userinfo"
            };

            $.ajax({
                url: '../php/function.php',
                type: 'post',
                data: data,
                success:function(response){
                if(response == "userinfo"){
                    window.location.replace("userinfo.php");
                }
                }
            });
        });
    }

</script>