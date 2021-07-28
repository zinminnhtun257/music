<?php
    //common start

    function alert($data,$color="danger"){
        return "<p class='alert text-danger alert-$color'>$data</p>";
    }

    function runquery($sql){
        $con = con();
        if (mysqli_query($con,$sql)) {
            return true;
        } else {
            die("Querry Fail:". mysqli_error($con));
        }
    }

    function fetch($sql){
        $query = mysqli_query(con(),$sql);
        $row = mysqli_fetch_assoc($query);
        return $row;
    }

    function fetchAll($sql){
        $query = mysqli_query(con(),$sql);
        $rows =[];
        while ($row = mysqli_fetch_assoc($query)){
            array_push($rows,$row);
        }
        return $rows;
    }

    function redirect($l){
        header("location:$l");
    }

    function linkTo($l){
        echo "<script>location.href='$l'</script>";
    }

    function showTime($timeStamp,$format= "j M Y (g:i a)"){
       return date($format,strtotime($timeStamp));
    }

    function countTotal($table){
        $sql = "SELECT COUNT(id) FROM $table";
        $total = fetch($sql);
        return $total["COUNT(id)"];
    }

    function short($str,$length=150){
        if(strlen($str) > $length){
            return substr($str,0,$length)."...";
        }else{
            return substr($str,0,strlen($str));
        }

    }

    function textFilter($text){
        $text = trim($text);
        $text = htmlentities($text,ENT_QUOTES);
        $text = stripcslashes($text);
        return $text;
    }
    //common end

    //auth start

    function register(){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        if ($password == $cpassword){
            $sPass = password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name,email,password) VALUES ('$name','$email','$sPass')";
            if (runquery($sql)){
                return redirect("login.php");
            }
        }else{
            return alert("Passwords do not match");
        }
    }

    function login(){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $query = mysqli_query(con(),$sql);
        $row = mysqli_fetch_assoc($query);

        if(!$row){
            return alert("Email or Password does not match");
        }else{
            if (!password_verify($password,$row['password'])){
                return alert("Email or Password does not matchrerdg");
            }else{
                session_start();
                $_SESSION["user"] = $row;
                redirect("dashboard.php");
            }
        }
    }

    //auth end

    //user start

    function user($id){
        $sql = "SELECT * FROM users WHERE id='$id'";
        return fetch($sql);
    }

    function users(){
        $sql = "SELECT * FROM users";
        return fetchAll($sql);
    }

    //user end

    //catogory start
        function categoryAdd(){
            $title = textFilter($_POST["title"]);
            $user_id = $_SESSION["user"]['id'];
            $sql = "INSERT INTO categories (title,user_id) VALUES ('$title','$user_id')";
            if (runquery($sql)){
                linkTo('category_add.php');
            };
        }

        function category($id){
            $sql = "SELECT * FROM categories WHERE id='$id'";
            return fetch($sql);
        }

        function categories(){
            $sql = "SELECT * FROM categories ORDER BY ordering DESC";
            return fetchAll($sql);
        }

        function categoryDelete($id){
            $sql = "DELETE FROM categories WHERE id='$id'";
            return runquery($sql);
        }

        function categoryUpdate(){
            $title = textFilter($_POST['title']);
            $id = $_POST['id'];
            $sql = "UPDATE categories SET title='$title' WHERE id='$id'";
            return runquery($sql);
        }

        function categoryPinToTop($id){
            $sql = "UPDATE categories SET ordering = '0'";
            mysqli_query(con(),$sql);
            $sql = "UPDATE categories SET ordering = '1' WHERE id='$id'";
            return runquery($sql);
        }

        function categoryRemovePin(){
            $sql = "UPDATE categories SET ordering = '0'";
            return runquery($sql);
        }
    //category end

    //post start

        function postAdd(){

            if ($_FILES['image_upload']['name'][0] == ""){

                $title = textFilter($_POST['title']);
                $description = textFilter($_POST['description']);
                $category_id = $_POST['category_id'];
                $user_id = $_SESSION["user"]['id'];





                $file2 = $_FILES['music_upload'];


                $fileNameArr2 = $file2["name"][0];


                $fileTmpArr2 = $file2["tmp_name"][0];

                $saveFolder1 = "assets/img/";
                $saveFolder2 = "media/store/music/";
                $saveFolder3 = "media/store/video/";
                $newName1 = $saveFolder1."default.png";
                $newName2 = $saveFolder2.$fileNameArr2;

                $sql = "INSERT INTO posts (title,description,category_id,user_id,image_link,music_link) VALUES ('$title','$description','$category_id','$user_id','$newName1','$newName2')";

                if(runquery($sql) && move_uploaded_file($fileTmpArr2,$newName2)){
                    linkTo('post_add.php');
                }
            }else{
                $title = textFilter($_POST['title']);
                $description = textFilter($_POST['description']);
                $category_id = $_POST['category_id'];
                $user_id = $_SESSION["user"]['id'];




                $file1 = $_FILES['image_upload'];
                $file2 = $_FILES['music_upload'];
//            $file3 = $_FILES['video_upload'];
                $fileNameArr1 = $file1["name"][0];
                $fileNameArr2 = $file2["name"][0];
//            $fileNameArr3 = $file3["name"][0];
                $fileTmpArr1 = $file1["tmp_name"][0];
                $fileTmpArr2 = $file2["tmp_name"][0];
//            $fileTmpArr3 = $file3["tmp_name"][0];
                $saveFolder1 = "media/store/image/";
                $saveFolder2 = "media/store/music/";
                $saveFolder3 = "media/store/video/";
                $newName1 = $saveFolder1.$fileNameArr1;
                $newName2 = $saveFolder2.$fileNameArr2;
//            $newName3 = $saveFolder3.$fileNameArr3;

                $sql = "INSERT INTO posts (title,description,category_id,user_id,image_link,music_link) VALUES ('$title','$description','$category_id','$user_id','$newName1','$newName2')";

                if(runquery($sql) && move_uploaded_file($fileTmpArr1,$newName1) && move_uploaded_file($fileTmpArr2,$newName2)){
                    linkTo('post_add.php');
                }
            }
        }

        function post($id){
            $sql = "SELECT * FROM posts WHERE id='$id'";
            return fetch($sql);
        }

        function posts(){
            if ($_SESSION['user']['role'] == 2){
                $current_user_id = $_SESSION['user']['id'];
                $sql = "SELECT * FROM posts WHERE user_id = '$current_user_id'";
            }else{
                $sql = "SELECT * FROM posts";
            }
            return fetchAll($sql);
        }

    function postDelete($id){
        $image_link = html_entity_decode(post($id)['image_link']);
        $music_link = html_entity_decode(post($id)['music_link']);
        $sql = "DELETE FROM posts WHERE id='$id'";
        if ($image_link != "assets/img/default.png"){
            if (unlink($image_link) && unlink($music_link)){
                return runquery($sql);
            }
        }else{
            if (unlink($music_link)){
                return runquery($sql);
            }
        }



    }

    function postUpdate(){
        $id = $_POST['id'];
        $title = textFilter($_POST['title']);
        $description = textFilter($_POST['description']);
        $category_id = $_POST["category_id"];
        if ($_FILES['music_upload']['name'][0] == "" && $_FILES['image_upload']['name'][0] == ""){

            $sql = "UPDATE posts SET title='$title', description='$description', category_id='$category_id' WHERE id='$id'";
            return runquery($sql);
        }elseif ($_FILES['music_upload']['name'][0] != "" && $_FILES['image_upload']['name'][0] != ""){
            $image_link = html_entity_decode(post($id)['image_link']);
            $music_link = html_entity_decode(post($id)['music_link']);
            $file1 = $_FILES['image_upload'];
            $file2 = $_FILES['music_upload'];
//            $file3 = $_FILES['video_upload'];
            $fileNameArr1 = $file1["name"][0];
            $fileNameArr2 = $file2["name"][0];
//            $fileNameArr3 = $file3["name"][0];
            $fileTmpArr1 = $file1["tmp_name"][0];
            $fileTmpArr2 = $file2["tmp_name"][0];
//            $fileTmpArr3 = $file3["tmp_name"][0];
            $saveFolder1 = "media/store/image/";
            $saveFolder2 = "media/store/music/";
            $saveFolder3 = "media/store/video/";
            $newName1 = $saveFolder1.$fileNameArr1;
            $newName2 = $saveFolder2.$fileNameArr2;
//            $newName3 = $saveFolder3.$fileNameArr3;

            $sql = "UPDATE posts SET title='$title', description='$description', category_id='$category_id', image_link='$newName1', music_link='$newName2' WHERE id='$id'";

           if (unlink($image_link) && unlink($music_link) &&  move_uploaded_file($fileTmpArr1,$newName1) && move_uploaded_file($fileTmpArr2,$newName2)){
                return runquery($sql);
            }

        }elseif ($_FILES['music_upload']['name'][0] != "" && $_FILES['image_upload']['name'][0] == ""){
            $music_link = html_entity_decode(post($id)['music_link']);
            $file2 = $_FILES['music_upload'];
            $fileNameArr2 = $file2["name"][0];
            $fileTmpArr2 = $file2["tmp_name"][0];
            $saveFolder2 = "media/store/music/";
            $newName2 = $saveFolder2.$fileNameArr2;

            $sql = "UPDATE posts SET title='$title', description='$description', category_id='$category_id', music_link='$newName2' WHERE id='$id'";
            if (unlink($music_link) && move_uploaded_file($fileTmpArr2,$newName2)){
                return runquery($sql);
            }

        }elseif ($_FILES['music_upload']['name'][0] == "" && $_FILES['image_upload']['name'][0] != ""){
            $image_link = html_entity_decode(post($id)['image_link']);

            $file1 = $_FILES['image_upload'];
            $fileNameArr1 = $file1["name"][0];
            $fileTmpArr1 = $file1["tmp_name"][0];
            $saveFolder1 = "media/store/image/";
            $newName1 = $saveFolder1.$fileNameArr1;

            $sql = "UPDATE posts SET title='$title', description='$description', category_id='$category_id', image_link='$newName1' WHERE id='$id'";
            if ($image_link != "assets/img/default.png"){
                if (unlink($image_link) && move_uploaded_file($fileTmpArr1,$newName1)){
                    return runquery($sql);
                }
            }else{
                if (move_uploaded_file($fileTmpArr1,$newName1)){
                    return runquery($sql);
                }
            }
        }


    }

//    post end

//music and video start

    function audio($id){
        $sql = "SELECT * FROM audios WHERE id='$id'";
        return fetch($sql);
    }
    function video($id){
        $sql = "SELECT * FROM videos WHERE id='$id'";
        return fetch($sql);
    }

    function audioadd(){
        $title = textFilter($_POST['title']);
        $category_id = $_POST['category_id'];
        $user_id = $_SESSION["user"]['id'];
        $sql = "INSERT INTO audios (title,category_id,user_id) VALUES ('$title','$category_id','$user_id')";
        return fetch($sql);
    }

    function videoadd(){
        $title = textFilter($_POST['title']);
        $category_id = $_POST['category_id'];
        $user_id = $_SESSION["user"]['id'];
        $sql = "INSERT INTO videos (title,category_id,user_id) VALUES ('$title','$category_id','$user_id')";
        return fetch($sql);
    }

//music and video end



//front panel start
    function fPosts($orderCol="id",$orderType="DESC"){
        $sql = "SELECT * FROM posts ORDER BY $orderCol $orderType";
        return fetchAll($sql);
    }

    function fCategories(){
        $sql = "SELECT * FROM categories ORDER BY ordering DESC";
        return fetchAll($sql);
    }

    function fPostsBYCat($category_id,$limit = 99999999,$post_id = 0){
        $sql = "SELECT * FROM posts WHERE category_id = '$category_id' AND id != '$post_id' ORDER BY id DESC LIMIT $limit";
        return fetchAll($sql);
    }

    function fSearch($search_key){
        $sql = "SELECT * FROM posts WHERE title LIKE '%$search_key%' OR description LIKE '%$search_key%' ORDER BY id DESC ";
        return fetchAll($sql);
    }

    function fSearchByDate($start,$end){
        $sql = "SELECT * FROM posts WHERE created_at BETWEEN '$start' AND '$end' ORDER BY id DESC";
        return fetchAll($sql);
    }
//front panel end

