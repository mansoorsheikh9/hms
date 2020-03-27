<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Payments
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group">
                                <button id="" class="btn green">
                                    <i class="fa fa-plus-circle"></i>  Add Payment 
                                </button>
                            </div>
                        </a>
                        <button class="export" onclick="javascript:window.print();">Print</button>     
                    </div>
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Sub Total</t>
                                <th>Discount</th>
                                <th>vat</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="option_th">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                        <style>
                            .img_url{
                                height:20px;
                                width:20px;
                                background-size: contain; 
                                max-height:20px;
                                border-radius: 100px;
                            }
                            .option_th{
                                width:18%;
                            }
                        </style>
                        <?php foreach ($payments as $payment) { ?>
                            <?php $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row(); ?>
                            <tr class="">
                                <td><?php echo $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone; ?></td>
                                <td><?php echo date('m/d/Y', $payment->date); ?></td>
                                <td><?php echo $settings->currency; ?> <?php echo $payment->amount; ?></td>              
                                <td><?php echo $settings->currency; ?> <?php
                                    if (!empty($payment->flat_discount)) {
                                        echo $payment->flat_discount;
                                    } else {
                                        echo '0';
                                    }
                                    ?></td>
                                <td><?php echo $settings->currency; ?> <?php echo $payment->flat_vat; ?></td>
                                <td><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></td>
                                <td><?php
                                    if ($payment->status == 'unpaid') {
                                        echo 'Unpaid';
                                    } else {
                                        echo 'Paid';
                                    }
                                    ?></td>
                                <td> 
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?> 
                                        <a class="btn btn-info btn-xs btn_width" href="finance/editPayment?id=<?php echo $payment->id; ?>">Edit <i class="fa fa-edit"></i></a>
                                        <a class="btn btn-info btn-xs btn_width delete_button" href="finance/delete?id=<?php echo $payment->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i></a>
                                    <?php } ?>
                                    <a class="" href="finance/invoice?id=<?php echo $payment->id; ?>"><button id="" class="btn btn-info btn-xs btn_width delete_button">Invoice</button></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<!-- Add Event Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Add New Payment</h4>
            </div>
            <div class="modal-body">
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
                                <input type="text" class="form-control pay_in" name="category_amount[]" id="exampleInputEmail1" value='' placeholder="<?php echo $settings->currency; ?>"> 
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
                            <input type="text" class="form-control pay_in" name="vat" id="exampleInputEmail1" value='' placeholder="%">
                        </div>
                    </div>
                    <input type="hidden" name="id" value=''>
                    <div class="row">
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-3"> 
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Event Modal-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
                                    $(document).ready(function () {
                                        $(".flashmessage").delay(3000).fadeOut(100);
                                    });
</script>
