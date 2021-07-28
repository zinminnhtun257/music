<?php include "template/header.php"?>
    <div class="row">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb bg-white mb-4">
                    <li class="breadcrumb-item"><a href="<?php echo $url; ?>/index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $url; ?>/item_list.php">Item List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Item</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="feather-plus-circle text-primary"></i>Add Item
                        </h4>
                        <a href="<?php echo $url; ?>/item_list.php" class="btn btn-outline-primary pb-0">
                            <i class="feather-list"></i>
                        </a>
                    </div>
                    <hr>
                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="photo">
                                        Photo Upload
                                    </label> <i class="feather-info" title="Only support Jpg,png"></i>
                                    <input type="file" accept="image/*" multiple name="photo" id="photo" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Item Name</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="t">Item Type</label>
                                    <select name="t" class="form-control custom-select" id="t">
                                        <option value="0">ကုန်စို</option>
                                        <option value="1">ကုန်ခြောက်</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="c">Category</label>
                                    <select name="c" class="form-control custom-select" id="c">
                                        <option value="" selected>Select Category</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sc">Sub Category</label>
                                    <select name="sc" class="form-control custom-select" id="sc">
                                        <option value="" selected>Select Sub Category</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="q">Item Quantity</label>
                                        <input type="text" name="q" class="form-control" id="q">
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="type">Unit</label>
                                            <select name="type" class="form-control custom-select" id="type">
                                                <option value="0">ကုန်စို</option>
                                                <option value="1">ကုန်ခြောက်</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" id="price" name="price" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="des">Description</label>
                                    <textarea type="text" id="des" name="des" rows="8" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <button class="btn btn-primary">Add Item</button>
                </div>
            </div>
        </div>
    </div>
<?php include "template/footer.php"?>
<script src="<?php echo $url; ?>/assets/js/app.js"></script>
<script>
    let category = ["phone","computer","TV"];
    let subCatagory =[
        {name:"Sumsang",category_id : 0},
        {name:"Mi",category_id : 0},
        {name:"Hp",category_id : 1},
        {name:"Acer",category_id : 1},
        {name:"panasonic",category_id : 2}
    ];
    category.map(function (el,index) {
        $("#c").append( `<option value="${index}">${el}</option>`)
    });

    subCatagory.map(function (el,index) {
        $("#sc").append(`<option value="${index}" data-category="${el.category_id}">${el.name}</option>`)
    });

    $("#c").on("change",function () {
        currentCategoryId = $(this).val();
        $("#sc option").hide();
        $(`[data-category = ${currentCategoryId}]`).show()
    })



