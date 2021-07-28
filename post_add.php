<?php include "core/auth.php"?>
<?php include "template/header.php"?>
<!--<link rel="stylesheet" href="--><?php //echo $url;?><!--/assets/vendor/bootstrap/bootstrapv4.0.0-beta/css/bootstrap.min.css">-->
<div class="row">
    <div class="col-12">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-2">
                <li class="breadcrumb-item"><a href="<?php echo $url; ?>/dashboard.php">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $url; ?>/post_list.php">Post</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Post</li>
            </ol>
        </nav>
    </div>
</div>
<?php
if(isset($_POST['addPost'])){
//echo "<pre>";
    $jpg = strpos($_FILES['image_upload']['name'][0],'.jpg');
    $png = strpos($_FILES['image_upload']['name'][0],'.png');
    $mp3 = strpos($_FILES['music_upload']['name'][0],'.mp3');
    $jpgpng =$_FILES['image_upload']['name'][0];
    $mp33 =$_FILES['music_upload']['name'][0];


    if ((($jpg == false && $png == false) && $jpgpng != "" ) || ($mp3 == false && $mp33 != "")){
    echo alert("သီချင်းထည့်ရမည့်နေရာ (သို့မဟုတ်) ပုံထည့်ရမည့်နေရာမှားနေတယ်");
    }else{
        postAdd();
    }
}
?>
<form class="row" action="" method="post" enctype="multipart/form-data">
    <div class="col-12 col-xl-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="feather-plus-circle text-primary"></i>Create New Post
                    </h4>
                    <a href="<?php echo $url; ?>/post_list.php" class="btn btn-outline-primary pb-0">
                        <i class="feather-list"></i>
                    </a>
                </div>
                <hr>
                    <div class="my-3">
                        <label for="">Song Name</label>
                        <input type="text" name="title" class="form-control" placeholder="သီချင်းအမည်လေး ရေးပေးပါ😍" required>
                    </div>




                    <div class="mb-3">
                        <label for="" class="text-warning">အကြိုက်ဆုံးသီချင်းကို upload တင်ပေးပါ</label>
                        <div class="d-flex justify-content-between">
                        <input type="file" name="music_upload[]" accept="audio/*" class="form-control text-warning" required>
                        <!--                            <button class="btn btn-primary ml-3" name="upload_music">Upload</button>-->
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="text-info">သီချင်းစာသား ‌ရှိရင်တင်ပေးပါ</label>
                        <div class="d-flex justify-content-between">
                            <input type="file" name="image_upload[]" accept="image/jpeg,image/png" class="form-control text-info">
                            <!--                            <button class="btn btn-primary ml-3" name="upload_image">Upload</button>-->
                        </div>
                    </div>



                    <div class="mb-0">
                        <label for="">Post Description</label>
                        <textarea name="description" rows="15" id="description" class="form-control"><?php echo html_entity_decode("<p><b><font color=\"#0000ff\">တေးဆို </font></b>-&nbsp;&nbsp;</p><p><font color=\"#ff9c00\"><b>တေးရေး </b></font>-&nbsp;</p>")?></textarea>
                    </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="feather-layers text-primary"></i>Select Category
                    </h4>
                    <a href="<?php echo $url; ?>/category_add.php" class="btn btn-outline-primary pb-0">
                        <i class="feather-list"></i>
                    </a>
                </div>
                <hr>
                <div class="my-3">
                        <?php
                        foreach (categories() as $key=>$c ){
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category_id" value="<?php echo $c['id']; ?>" id="flexRadioDefault<?php echo $c['id']; ?>" required>
                                <label class="form-check-label" for="flexRadioDefault<?php echo $c['id']; ?>">
                                    <?php echo $c['title']; ?>
                                </label>
                            </div>
                        <?php } ?>
                </div>
                <button class="btn btn-primary w-100" name="addPost">Add Song</button>
            </div>
        </div>
    </div>
</form>
<div class="row justify-content-between align-content-around">
    <h5 class="font-weight-bold">Your Uploaded Music</h5>

    <?php
    if (!posts()){
        echo "သင်တင်ထားသော သီချင်း မရှိသေးပါ.🎶🎶🎶🎶";
    }
    foreach(posts() as $key=>$s) {
        ?>
        <div class="col-4 col-lg-3">
            <div class="card mb-1">
                <div class="card-body p-2 ">
                    <img src="<?php echo $url;?>/<?php echo $s['image_link'] ?>" class="w-100" alt="">
                    <audio controls="" class="w-100">
                        <source src="<?php echo $url;?>/<?php echo $s['music_link'] ?>" type="audio/mp3" >
                    </audio>
<!--                    <a href="media/delete.php?id=--><?php //echo $s['id'] ?><!--">Delete</a>-->
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<?php include "template/footer.php"?>
<script src="<?php echo $url; ?>/assets/vendor/bootstrap/bootstrapv4.0.0-beta/js/bootstrap.min.js"></script>
<script>
    $("#description").summernote({
        placeholder : "ဒီသီချင်းလေးရဲ့တေးရေး၊ တေးဆို သိရင် ကျေးဇူးပြု၍ ရေးခဲ့ပေးပါ😍",
        tabsize : 2,
        height : 200
    });
</script>
<script src="<?php echo $url; ?>/assets/js/app.js"></script>




