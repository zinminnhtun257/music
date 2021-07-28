<div class="col-12 col-md-4">
    <div class="front-panel-right-sidebar">
        <h4>Category List</h4>
        <div class="list-group shadow-sm mb-4">
            <a href="<?php echo $url; ?>/index.php" class="list-group-item list-group-item-action <?php echo isset($_GET['category_id']) ? '':'active'; ?>">
                All Categories
            </a>
            <?php foreach (fCategories() as $c){?>
                <a href="category_based_post.php?category_id=<?php echo $c['id']?>" class="list-group-item list-group-item-action <?php echo isset($_GET['category_id']) ? ($_GET['category_id'] == $c['id']?'active':'') : ''; ?>">
                    <?php echo $c['ordering']==1 ? '<i class="feather-paperclip fa-fw text-info"></i>':''; ?>
                    <?php echo $c['title']?>
                </a>
            <?php  } ?>
        </div>
        <div class="mb-4">
            <h4>advertisement</h4>
            <!--        <img src="--><?php //echo $url; ?><!--/assets/img/ad1.jpg" class="w-100" alt="">-->
        </div>
        <div class="">
            <h4>Search By Date</h4>
            <div class="card">
                <div class="card-body">
                    <form action="search_by_date.php" method="post">
                        <div class="mb-2">
                            <label for="">Start Date</label>
                            <input type="date" name="start" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label for="">End Date</label>
                            <input type="date" name="end" class="form-control" required>
                        </div>
                        <button class="btn btn-primary">
                            <i class="feather-calendar"></i>Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>