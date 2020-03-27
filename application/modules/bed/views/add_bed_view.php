
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($bed->id))
                    echo 'Edit Bed';
                else
                    echo 'Add New Bed';
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">

                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form" action="bed/addBed" method="post" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Bed Category</label>
                                            <select class="form-control m-bot15" name="category" value=''>
                                                <?php foreach ($categories as $category) { ?>
                                                    <option value="<?php echo $category->category; ?>" <?php
                                                    if (!empty($bed->category)) {
                                                        if ($category->category == $bed->category) {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?> > <?php echo $category->category; ?> </option>
                                                        <?php } ?> 
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Bed Number</label>
                                            <input type="text" class="form-control" name="number" id="exampleInputEmail1" value='<?php
                                            if (!empty($bed->number)) {
                                                echo $bed->number;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Description</label>
                                            <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='<?php
                                            if (!empty($bed->description)) {
                                                echo $bed->description;
                                            }
                                            ?>' placeholder="">
                                        </div>

                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($bed->id)) {
                                            echo $bed->id;
                                        }
                                        ?>'>
                                        <button type="submit" name="submit" class="btn btn-info">Submit</button>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
