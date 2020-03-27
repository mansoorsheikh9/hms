
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($payment->id))
                    echo 'Edit Payment';
                else
                    echo 'Add New Payment';
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">

                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <form role="form" action="finance/addPayment" method="post" enctype="multipart/form-data">

                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-3 payment_label"> 
                                                <label for="exampleInputEmail1">Patient</label>
                                            </div>
                                            <div class="col-md-9"> 
                                                <select class="form-control m-bot15" name="patient" value=''> 
                                                    <?php foreach ($patients as $patient) { ?>
                                                        <option value="<?php echo $patient->id; ?>" <?php
                                                        if (!empty($payment->patient)) {
                                                            if ($payment->patient == $patient->id) {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?> ><?php echo $patient->name; ?> </option>
                                                            <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                        <div class="row">
                                        </div>
                                        <div class="col-md-12 payment">
                                            <div class="col-md-3 payment_label">   
                                                <label class="payment_label"><strong>PAYMENT CATEGORIES</strong></label>
                                            </div>
                                            <div class="col-md-3 payment_label">

                                                <label class="payment_label"><strong>AMOUNT</strong></label>
                                            </div>        

                                        </div>
                                        <?php foreach ($categories as $category) { ?>

                                            <div class="col-md-12 payment">
                                                <div class="col-md-3 payment_label">   
                                                    <label for="exampleInputEmail1"><?php echo $category->category ?></label> 
                                                </div>
                                                <div class="col-md-9"> 
                                                    <input type="text" class="form-control pay_in" name="category_amount[]" id="exampleInputEmail1" value='<?php
                                                    if (!empty($payment->category_name)) {
                                                        $category_name = $payment->category_name;
                                                        $category_name1 = explode(',', $category_name);
                                                        foreach ($category_name1 as $category_name2) {
                                                            $category_name3 = explode('*', $category_name2);
                                                            if ($category_name3[0] == $category->category) {
                                                                echo $category_name3[1];
                                                            }
                                                        }
                                                    }
                                                    ?>' placeholder="<?php echo $settings->currency; ?>"> 
                                                    <input type="hidden" class="form-control pay_in" name="category_name[]" id="exampleInputEmail1" value='<?php echo $category->category ?>' placeholder=""> 

                                                </div>        

                                            </div>
                                        <?php } ?> 

                                        <div class="col-md-12 payment">
                                            <div class="col-md-3 payment_label"> 
                                                <label for="exampleInputEmail1">Discount  <?php
                                                    if ($discount_type == 'percentage') {
                                                        echo ' (%)';
                                                    }
                                                    ?> </label>
                                            </div>
                                            <div class="col-md-9"> 
                                                <input type="text" class="form-control pay_in" name="discount" id="exampleInputEmail1" value='<?php
                                                if (!empty($payment->discount)) {
                                                    $discount = explode('*', $payment->discount);
                                                    echo $discount[0];
                                                }
                                                ?>' placeholder="Discount">
                                            </div>
                                        </div>
                                        <div class="col-md-12 payment">
                                            <div class="col-md-3 payment_label"> 
                                                <label for="exampleInputEmail1">Vat (%)</label>
                                            </div>
                                            <div class="col-md-9"> 
                                                <input type="text" class="form-control pay_in" name="vat" id="exampleInputEmail1" value='<?php
                                                if (!empty($payment->vat)) {
                                                    echo $payment->vat;
                                                }
                                                ?>' placeholder="%">
                                            </div>
                                        </div>

                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($payment->id)) {
                                            echo $payment->id;
                                        }
                                        ?>'>

                                        <div class="row">

                                        </div>

                                        <div class="form-group">
                                        </div>

                                        <div class="form-group">

                                            <div class="col-md-12">

                                                <div class="col-md-3"> 
                                                   <i class='fa fa-plus'></i>  <a href='finance/addPaymentCategoryView'>Add More Categories</a>
                                                </div>  
                                                <div class="col-md-6"> 
                                                    <button type="submit" name="submit" class="btn btn-info">Submit</button>
                                                </div>
                                                <div class="col-md-3"> 
                                                </div> 


                                            </div>

                                        </div>

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
