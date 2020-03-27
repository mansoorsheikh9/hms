
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- invoice start-->
        <section>
            <div class="panel panel-primary">
                <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                <div class="panel-body">
                    <div class="row invoice-list">     
                        <div class="text-center corporate-id">
                            <h1>
                                <?php echo $settings->title ?>
                            </h1>
                            <h4>
                                <?php echo $settings->address ?>
                            </h4>
                            <h4>
                                Tel: <?php echo $settings->phone ?>
                            </h4>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <h4>PAYMENT TO:</h4>
                            <p>
                                <?php echo $settings->title; ?> <br>
                                <?php echo $settings->address; ?><br>
                                Tel:  <?php echo $settings->phone; ?>
                            </p>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <h4>BILL TO:</h4>
                            <p>
                                <?php
                                $patient_info = $this->db->get_where('patient', array('id' => $patient_id))->row();
                                echo $patient_info->name . ' <br>';
                                echo $patient_info->address . '  <br/>';
                                P: echo $patient_info->phone
                                ?>
                            </p>
                        </div>

                        <div class="col-lg-4 col-sm-4">
                            <h4>INVOICE INFO</h4>
                            <ul class="unstyled">
                                <li>Invoice Status		: <strong style="color: maroon"><?php
                                        if (!empty($payments)) {
                                            echo 'Unpaid';
                                        } else {
                                            echo 'No Due';
                                        }
                                        ?></strong> </li>
                            </ul>
                        </div>

                    </div>
                    <table class="table table-striped table-hover">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            foreach ($payments as $payment) {
                                $gross_total[] = $payment->gross_total;
                                $amount[] = $payment->amount;
                                $flat_vat[] = $payment->flat_vat;
                                $discount[] = $payment->flat_discount;
                            }
                            ?>



                            <?php
                            foreach ($payments as $payment) {
                                if (!empty($payment->category_name)) {
                                    $category_name = $payment->category_name;
                                    $category_name1 = explode(',', $category_name);
                                    $i = 0;
                                    foreach ($category_name1 as $category_name2) {
                                        $category_name3 = explode('*', $category_name2);
                                        if ($category_name3[1] > 0) {
                                            ?>                
                                            <tr>
                                                <td><?php echo $i = $i + 1; ?></td>
                                                <td><?php echo $category_name3[0]; ?> </td>
                                                <td><?php echo date('m/d/y', $payment->date); ?> </td>
                                                <td class=""><?php echo $settings->currency; ?> <?php echo $category_name3[1]; ?> </td>
                                            </tr> 
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>

                        </tbody>

                    </table>

                    <div class="row">
                        <div class="col-lg-4 invoice-block pull-right">
                            <ul class="unstyled amounts">
                                <li><strong>Sub - Total amount : </strong><?php echo $settings->currency; ?> <?php
                                    if (!empty($amount)) {
                                        echo array_sum($amount);
                                    }
                                    ?></li>
                                <?php if (!empty($discount)) { ?>
                                    <li><strong>Discount</strong> <?php
                                    ?> <?php echo array_sum($discount); ?> </li>
                                <?php } ?>
                                <?php if (!empty($flat_vat)) { ?>
                                    <li><strong>VAT :</strong>   <?php ?> % = <?php echo $settings->currency . ' ' . array_sum($flat_vat); ?></li>
                                <?php } ?>
                                <li><strong>Grand Total : </strong><?php echo $settings->currency; ?> <?php
                                    if (!empty($gross_total)) {
                                        echo array_sum($gross_total);
                                    }
                                    ?></li>
                            </ul>
                        </div>
                    </div>

                    <div class="text-center invoice-btn">
                        <?php if (!empty($payments)) { ?>
                            <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                <a href="finance/makePaidByPatientIdByStatus?id=<?php echo $patient_id; ?>" class="btn btn-info btn-lg invoice_button">Make Paid</a>
                                <?php
                            }
                        }
                        ?>
                        <a class="btn btn-info btn-lg invoice_button" onclick="javascript:window.print();"><i class="fa fa-print"></i> Print </a>
                    </div>
                    <h1>
                        <a href="finance/lastPaidInvoice?id=<?php echo $patient_id; ?>" class="btn btn-info btn-lg invoice_button">Last Paid Invoice</a>
                    </h1>

                </div>
            </div>
        </section>
        <!-- invoice end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
