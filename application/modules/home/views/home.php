<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!--state overview start-->
        <div class="row state-overview">

            <?php if (!$this->ion_auth->in_group('superadmin')) { ?>
                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                            <a href="doctor">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol terques">
                                    <i class="fa fa-stethoscope"></i>
                                </div>
                                <div class="value"> 
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('doctor');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Doctor</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist'))) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <a href="patient">
                            <section class="panel">
                                <div class="symbol blue">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('patient');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Patient</p>
                                </div>
                            </section>
                        </a>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <a href="nurse">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol yellow">
                                    <i class="fa fa-female"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('nurse');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Nurse</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <a href="pharmacist">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol terques">
                                    <i class="fa  fa-medkit"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('pharmacist');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Pharmacist</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <a href="laboratorist">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol blue">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('laboratorist');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Laboratorist</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <a href="accountant">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol yellow">
                                    <i class="fa fa-money"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('accountant');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Accountant</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <a href="finance/payment">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol blue">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('payment');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Payment</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <a href="medicine">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol yellow">
                                    <i class="fa fa-plus-square-o"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('medicine');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Medicine</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <a href="report/operation">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol terques">
                                    <i class="fa  fa-wheelchair"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        echo $this->db
                                                ->where('report_type', 'operation')
                                                ->count_all_results('report');
                                        ?>
                                    </h1>
                                    <p>Operation Report</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <a href="report/birth">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol blue">
                                    <i class="fa fa-smile-o"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        echo $this->db
                                                ->where('report_type', 'birth')
                                                ->count_all_results('report');
                                        ?>
                                    </h1>
                                    <p>Birth Report</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                            <a href="donor">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol yellow">
                                    <i class="fa fa-briefcase"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('donor');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Donor</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <a href="bed">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol terques">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="value">
                                    <h1 class=" count13">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('bed');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Total Bed</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <a href="finance/payment">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol blue">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('expense');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Expense</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                    <div class="col-lg-6 col-sm-6">    
                        <a href="finance/payment">
                            <section class="panel">
                                <div class="symbol terques">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="value">
                                    <h1 class=" count14">
                                        <?php echo $settings->currency; ?> 
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->where('status', 'unpaid');
                                        $query = $this->db->get('payment');
                                        $query = $query->result();
                                        $total_payment = array();
                                        foreach ($query as $payment) {
                                            $total_payment[] = $payment->gross_total;
                                        }
                                        $this->db->where('hospital_id', $hospital_id);
                                        $query1 = $this->db->get('payment');
                                        $query1 = $query1->result();
                                        $total_payment1 = array();
                                        foreach ($query1 as $payment1) {
                                            $total_payment1[] = $payment1->gross_total;
                                        }
                                        echo array_sum($total_payment1) - array_sum($total_payment);
                                        ?>
                                    </h1>
                                    <p>Total Payment</p>
                                </div>
                            </section>         
                        </a>     
                    </div>
                <?php } ?>
                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Accountant', 'Nurse', 'Laboratorist'))) { ?>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <a href="department">
                            <?php } ?>
                            <section class="panel">
                                <div class="symbol blue">
                                    <i class="fa fa-dashboard"></i>
                                </div>
                                <div class="value">
                                    <h1 class="">
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('department');
                                        $count = $this->db->count_all_results();
                                        echo $count;
                                        ?>
                                    </h1>
                                    <p>Departments</p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <section class="col-md-12">
                    <div class="col-lg-6 col-sm-6">
                        <h1><span class="livee">Live</span> Hospitals</h1>
                    </div>
                </section>
                <?php foreach ($hospitals as $hospital) { ?>    
                    <div class="col-lg-6 col-sm-6">
                        <section class="panel">
                            <div class="symbol terques super">
                                <?php echo $hospital->name; ?>
                            </div>
                            <div class="value"> 
                                <p class="">
                                    Email:   <?php echo $hospital->email; ?>
                                </p>
                                <p class="">
                                    Address:   <?php echo $hospital->address; ?>
                                </p>
                                <p class="">
                                    Phone:  <?php echo $hospital->phone; ?>
                                </p>
                            </div>
                        </section>
                    </div>
                <?php } ?>
            <?php } ?>
            <?php if ($this->ion_auth->in_group('Patient')) { ?>
                <?php
                $user_idd = $this->ion_auth->user()->row()->id;
                $this->db->where('ion_user_id', $user_idd);
                $patient = $this->db->get('patient')->row();
                if (!empty($patient)) {
                    $this->db->where('name', $patient->doctor);
                    $doctor_details = $this->db->get('doctor')->row();
                }
                ?>
                <div class="col-lg-4">
                    <!--user info table start-->
                    <section class="panel">
                        <header class="panel-heading">
                            My Profile
                        </header>
                        <div class="panel-body">
                            <a href="#" class="task-thumb">
                                <img src="<?php echo $patient->img_url; ?>" alt="" height="50px">
                            </a>
                            <div class="task-thumb-details">
                                <h1><a href="#"><?php echo $patient->name; ?></a></h1>
                                <p><?php echo $patient->phone; ?></p>
                            </div>
                        </div>
                        <table class="table table-hover personal-task">
                            <tbody>
                                <tr>
                                    <td>
                                        <i class=" fa fa-envelope"></i>
                                    </td>
                                    <td> Email</td>
                                    <td> <?php echo $patient->email; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-phone"></i>
                                    </td>
                                    <td> Phone</td>
                                    <td> <?php echo $patient->phone; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-calendar"></i>
                                    </td>
                                    <td>Birth Date</td>
                                    <td> <?php echo $patient->birthdate; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class=" fa fa-tint"></i>
                                    </td>
                                    <td>Blood Group</td>
                                    <td> <?php echo $patient->bloodgroup; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                    <!--user info table end-->
                </div>
                <div class="col-lg-4">
                    <!--user info table start-->
                    <section class="panel">
                        <header class="panel-heading">
                            My Consultant
                        </header>
                        <div class="panel-body">
                            <a href="#" class="task-thumb">
                                <img src="<?php echo $doctor_details->img_url; ?>" height="50px" alt="hgh">
                            </a>
                            <div class="task-thumb-details">
                                <h1><a href="#"><?php echo $doctor_details->name; ?></a></h1>
                                <p><?php echo $doctor_details->profile; ?></p>
                            </div>
                        </div>
                        <table class="table table-hover personal-task">
                            <tbody>
                                <tr>
                                    <td>
                                        <i class=" fa fa-envelope"></i>
                                    </td>
                                    <td> Email</td>
                                    <td> <?php echo $doctor_details->email; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-phone"></i>
                                    </td>
                                    <td> Phone</td>
                                    <td> <?php echo $doctor_details->phone; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-sitemap"></i>
                                    </td>
                                    <td>Department</td>
                                    <td> <?php echo $doctor_details->department; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class=" fa fa-briefcase"></i>
                                    </td>
                                    <td>Profie</td>
                                    <td>  <?php echo $doctor_details->profile; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                    <!--user info table end-->
                </div>

                <div class="col-lg-4">
                    <!--user info table start-->
                    <section class="panel">
                        <header class="panel-heading">
                            My Due Balance
                        </header>
                        <div class="panel-body">
                            <div class="task-thumb-details">
                                <h1><?php echo $settings->currency; ?>
                                    <?php
                                    $query = $this->db->get_where('payment', array('patient' => $patient->id, 'status' => 'unpaid'))->result();
                                    $balance = array();
                                    foreach ($query as $gross) {
                                        $balance[] = $gross->gross_total;
                                    }
                                    if (!empty($balance)) {
                                        echo array_sum($balance);
                                    } else {
                                        echo '0';
                                    }
                                    ?></a></h1>
                            </div>
                        </div>

                        </table>
                    </section>

                    <section class="panel">
                        <header class="panel-heading">
                            My Last Login
                        </header>
                        <div class="panel-body">
                            <div class="task-thumb-details">
                                <h1>
                                    <?php
                                    $timestamp = $this->db->get_where('users', array('id' => $user_idd))->row()->last_login;
                                    $date = date('d-m-Y', $timestamp);
                                    $time = date('H:i:s', $timestamp);
                                    echo $date . ' ' . $time;
                                    ?>
                                </h1>
                            </div>
                        </div>

                        </table>
                    </section>
                    <!--user info table end-->
                </div>



                <!--sidebar end-->
                <!--main content start-->
                <section id=" col-md-12">
                    <section class="wrapper" style='margin-top:-10px;'>
                        <!-- page start-->
                        <section class="panel">
                            <header class="panel-heading">
                                My Reports
                            </header>
                            <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <button class="export" onclick="javascript:window.print();">Print</button>  
                                    </div>
                                    <div class="space15"></div>
                                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                        <thead>
                                            <tr>
                                                <th>Patient</th>
                                                <th>Type</th>
                                                <th>Description</th>
                                                <th>Doctor</th>
                                                <th>Date</th>
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

                                        </style>
                                        <?php
                                        foreach ($reports as $report) {
                                            if ($user_id_for_report == explode('*', $report->patient)[1]) {
                                                ?>
                                                <tr class="">
                                                    <td><?php echo explode('*', $report->patient)[0]; ?></td>
                                                    <td> <?php echo $report->report_type; ?></td>
                                                    <td> <?php echo $report->description; ?></td>
                                                    <td><?php echo $report->doctor; ?></td>
                                                    <td class="center"><?php echo $report->date; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
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
            <?php } ?>
        </div>
        <!--state overview end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->

<!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->

<script src="common/js/jquery.sparkline.js" type="text/javascript"></script>
<script src="common/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="common/js/owl.carousel.js" ></script>
<script src="common/js/jquery.customSelect.min.js" ></script>
<script src="common/js/respond.min.js" ></script>

<!--common script for all pages-->
<script src="common/js/common-scripts.js"></script>

<!--script for this page-->
<script src="common/js/sparkline-chart.js"></script>
<script src="common/js/easy-pie-chart.js"></script>
<script src="common/js/count.js"></script>

<script>

                                            //owl carousel

                                            $(document).ready(function () {
                                                $("#owl-demo").owlCarousel({
                                                    navigation: true,
                                                    slideSpeed: 300,
                                                    paginationSpeed: 400,
                                                    singleItem: true,
                                                    autoPlay: true

                                                });
                                            });

                                            //custom select box

                                            $(function () {
                                                $('select.styled').customSelect();
                                            });

</script>

</body>
</html>
