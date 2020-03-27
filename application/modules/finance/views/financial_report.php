
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="col-md-12">
            <div class="col-md-7">
                <section>
                    <form role="form" action="finance/financialReport" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <!--     <label class="control-label col-md-3">Date Range</label> -->
                            <div class="col-md-6">
                                <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                                    <input type="text" class="form-control dpd1" name="date_from" value="<?php
                                    if (!empty($from)) {
                                        echo $from;
                                    }
                                    ?>" placeholder="Date From">
                                    <span class="input-group-addon">To</span>
                                    <input type="text" class="form-control dpd2" name="date_to" value="<?php
                                    if (!empty($to)) {
                                        echo $to;
                                    }
                                    ?>" placeholder="Date To">
                                </div>
                                <div class="row"></div>
                                <span class="help-block"></span> 
                            </div>
                            <div class="col-md-6">
                                <button type="submit" name="submit" class="btn btn-info range_submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
            <div class="col-md-5">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">

                <section class="panel">
                    <header class="panel-heading">
                        Payment Report  <?php
                        if (!empty($from) && !empty($to)) {
                            echo ' (from ' . $from . ' to ' . $to . ') ';
                        }
                        ?> 
                    </header>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa fa-bullhorn"></i> Category</th>
                                <th class="hidden-phone"><i class="fa fa-question-circle"></i> Amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payment_categories as $category) { ?>
                                <tr class="">
                                    <td><?php echo $category->category ?></td>
                                    <td><?php echo $settings->currency; ?> <?php
                                        foreach ($payments as $payment) {
                                            if ($payment->status != 'unpaid') {
                                                $category_names_and_amounts = $payment->category_name;
                                                $category_names_and_amounts = explode(',', $category_names_and_amounts);
                                                foreach ($category_names_and_amounts as $category_name_and_amount) {
                                                    $category_name = explode('*', $category_name_and_amount);
                                                    if (($category->category == $category_name[0])) {
                                                        $amount_per_category[] = $category_name[1];
                                                    }
                                                }
                                            }
                                        }
                                        if (!empty($amount_per_category)) {
                                            echo array_sum($amount_per_category);
                                            $total_payment_by_category[] = array_sum($amount_per_category);
                                        } else {
                                            echo '0';
                                        }

                                        $amount_per_category = NULL;
                                        ?>
                                    </td>
                                </tr>


                            <?php } ?>

                        </tbody>
                        <tbody>
                            <tr>
                                <td><h3>Sub Total </h3></td>
                                <td>
                                    <?php echo $settings->currency; ?>
                                    <?php
                                    if (!empty($total_payment_by_category)) {
                                        echo array_sum($total_payment_by_category);
                                    } else {
                                        echo '0';
                                    }
                                    ?> 
                                </td>
                            </tr>
                            <tr>
                                <td><h5>Total Discount</h5></td>
                                <td>
                                    <?php echo $settings->currency; ?>
                                    <?php
                                    if (!empty($payments)) {
                                        foreach ($payments as $payment) {
                                            $discount[] = $payment->flat_discount;
                                        }
                                        echo array_sum($discount);
                                    } else {
                                        echo '0';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h5>Total Vat</h5></td>
                                <td>
                                    <?php echo $settings->currency; ?>
                                    <?php
                                    if (!empty($payments)) {
                                        foreach ($payments as $payment) {
                                            $vat[] = $payment->flat_vat;
                                        }
                                        echo array_sum($vat);
                                    } else {
                                        echo '0';
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section></section>

                <section class="panel">
                    <header class="panel-heading">
                        Expense Report
                    </header>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa fa-bullhorn"></i> Category</th>
                                <th class="hidden-phone"><i class="fa fa-question-circle"></i> Amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($expense_categories as $category) { ?>
                                <tr class="">
                                    <td><?php echo $category->category ?></td>
                                    <td>
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        foreach ($expenses as $expense) {
                                            $category_name = $expense->category;


                                            if (($category->category == $category_name)) {
                                                $amount_per_category[] = $expense->amount;
                                            }
                                        }
                                        if (!empty($amount_per_category)) {
                                            $total_expense_by_category[] = array_sum($amount_per_category);
                                            echo array_sum($amount_per_category);
                                        } else {
                                            echo '0';
                                        }

                                        $amount_per_category = NULL;
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </section>
            </div>

            <div class="col-lg-5">

                <section class="panel">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-money"></i>
                                    Gross Payment
                                </div>
                                <div class="col-xs-8">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        if (!empty($total_payment_by_category)) {
                                            $gross = array_sum($total_payment_by_category) - array_sum($discount) + array_sum($vat);
                                            echo $gross;
                                        } else {
                                            echo '0';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-money"></i>
                                    Gross Expense
                                </div>
                                <div class="col-xs-8">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        if (!empty($total_expense_by_category)) {
                                            echo array_sum($total_expense_by_category);
                                        } else {
                                            echo '0';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-money"></i>
                                    Profit
                                </div>
                                <div class="col-xs-8">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        if (empty($total_payment_by_category)) {
                                            if (empty($total_expense_by_category)) {
                                                echo '0';
                                            } else {
                                                $profit = 0 - array_sum($total_expense_by_category);
                                                echo $profit;
                                            }
                                        }
                                        if (empty($total_expense_by_category)) {
                                            if (empty($total_payment_by_category)) {
                                                echo '0';
                                            } else {
                                                $profit = $gross - 0;
                                                echo $profit;
                                            }
                                        } else {
                                            if (!empty($gross)) {
                                                $profit = $gross - array_sum($total_expense_by_category);
                                                echo $profit;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
