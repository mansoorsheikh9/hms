<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Rizvi">
        <meta name="keyword" content="Php, Hospital, Clinic, Management, Software, Php, CodeIgniter, Hms, Accounting">
        <link rel="shortcut icon" href="uploads/favicon.png">
        <title><?php echo $this->router->fetch_class(); ?> | Hospital Management System</title>
        <!-- Bootstrap core CSS -->
        <link href="common/css/bootstrap.min.css" rel="stylesheet">
        <link href="common/css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="common/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="common/assets/data-tables/DT_bootstrap.css" />
        <!-- Custom styles for this template -->
        <link href="common/css/style.css" rel="stylesheet">
        <link href="common/css/style-responsive.css" rel="stylesheet" />
        <link rel="stylesheet" href="common/assets/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-datetimepicker/css/datetimepicker.css" />
        <link href="common/css/invoice-print.css" rel="stylesheet" media="print">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <?php
    if (!$this->ion_auth->in_group(array('superadmin'))) {
        if ($this->ion_auth->in_group(array('admin'))) {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $hospital_id = $this->db->get_where('hospital', array('ion_user_id' => $current_user_id))->row()->id;
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
            $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
            $group_name = strtolower($group_name);
            $hospital_id = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->hospital_id;
        }
    }
    ?>


    <body>

        <section id="container" class="">
            <!--header start-->
            <header class="header white-bg">
                <div class="sidebar-toggle-box">
                    <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
                </div>
                <!--logo start-->
                <?php if ($this->ion_auth->in_group(array('superadmin'))) { ?> 
                    <a href="" class="logo"> Hospital<span> Systems</span></a>
                <?php } else { ?>
                    <a href="" class="logo"> <?php echo $this->db->get_where('settings', array('hospital_id' => $hospital_id))->row()->title; ?><span></span></a>
                <?php } ?>
                <!--logo end-->
                <div class="nav notify-row" id="top_menu">
                    <!--  notification start -->
                    <ul class="nav top-menu">
                        <!-- Bed Notification start -->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Nurse'))) { ?> 
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-hdd-o"></i>
                                    <span class="badge bg-success">  
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $query = $this->db->get('bed');
                                        $query = $query->result();
                                        foreach ($query as $bed) {
                                            $last_d_time = explode('-', $bed->last_d_time);
                                            if (!empty($last_d_time[1])) {

                                                $last_d_h_am_pm = explode(' ', $last_d_time[1]);

                                                $last_d_h = explode(':', $last_d_h_am_pm[1]);
                                                if ($last_d_h_am_pm[2] == 'AM') {
                                                    $last_d_m = ($last_d_h[0] * 60 * 60) + ($last_d_h[1] * 60);
                                                } else {
                                                    $last_d_m = (12 * 60 * 60) + ($last_d_h[0] * 60 * 60) + ($last_d_h[1] * 60);
                                                }

                                                $last_d_time = strtotime($last_d_time[0]) + $last_d_m;
                                            }

                                            if ((time() > $last_d_time)) {
                                                $data[] = '1';
                                            }
                                        }

                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('bed');
                                        $count = $this->db->count_all_results();

                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->from('alloted_bed');
                                        $count1 = $this->db->count_all_results();

                                        if (!empty($data)) {

                                            echo $available_bed = $count - $count1 + array_sum($data);
                                        } else {

                                            echo $available_bed = $count - $count1;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended tasks-bar">
                                    <div class="notify-arrow notify-arrow-green"></div>
                                    <li>
                                        <p class="green">
                                            <?php
                                            if (!empty($data)) {
                                                echo $available_bed;
                                            } else {
                                                $available_bed = $count - $count1;
                                                echo $available_bed;
                                            }
                                            ?> 
                                            <?php
                                            if ($available_bed <= 1) {
                                                echo 'Bed is Available';
                                            } else {
                                                echo 'Beds Are Available';
                                            }
                                            ?>
                                        </p>
                                    </li>
                                    <?php ?>
                                    <li class="external">
                                        <a href="bed/bedAllotment"><p class="green"><?php
                                                if ($available_bed > 0) {
                                                    echo 'Add a Allotment';
                                                } else {
                                                    echo 'No bed is available for allotment';
                                                }
                                                ?></p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Bed notification end -->
                        <!-- Payment notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?> 
                            <li id="header_inbox_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-money"></i>
                                    <span class="badge bg-important"> 
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $query = $this->db->get('payment');
                                        $query = $query->result();
                                        foreach ($query as $payment) {
                                            $payment_date = date('y/m/d', $payment->date);
                                            if ($payment_date == date('y/m/d')) {
                                                $payment_number[] = '1';
                                            }
                                        }
                                        if (!empty($payment_number)) {
                                            echo $payment_number = array_sum($payment_number);
                                        } else {
                                            $payment_number = 0;
                                            echo $payment_number;
                                        }
                                        ?>        
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended inbox">
                                    <div class="notify-arrow notify-arrow-red"></div>
                                    <li>
                                        <p class="red"> <?php
                                            echo $payment_number . ' ';
                                            if ($payment_number <= 1) {
                                                echo 'Payment Today';
                                            } else {
                                                echo 'Payments Today';
                                            }
                                            ?></p>
                                    </li>
                                    <li>
                                        <a href="finance/payment"><p class="green"> See All Payments</p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- payment notification end -->  
                        <!-- patient notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Doctor', 'Nurse', 'Laboratorist'))) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-user"></i>
                                    <span class="badge bg-warning">   
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->where('add_date', date('m/d/y'));
                                        $query = $this->db->get('patient');
                                        $query = $query->result();
                                        foreach ($query as $patient) {
                                            $patient_number[] = '1';
                                        }
                                        if (!empty($patient_number)) {
                                            echo $patient_number = array_sum($patient_number);
                                        } else {
                                            $patient_number = 0;
                                            echo $patient_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="yellow"><?php
                                            echo $patient_number . ' ';
                                            if ($patient_number <= 1) {
                                                echo 'Patient Registered Today';
                                            } else {
                                                echo 'Patients registered Today';
                                            }
                                            ?> </p>
                                    </li>    
                                    <li>
                                        <a href="patient"><p class="green">See all Patients</p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- patient notification end -->  
                        <!-- donor notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Nurse', 'Laboratorist', 'Patient'))) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-user"></i>
                                    <span class="badge bg-success">       
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->where('add_date', date('m/d/y'));
                                        $query = $this->db->get('donor');
                                        $query = $query->result();
                                        foreach ($query as $donor) {
                                            $donor_number[] = '1';
                                        }
                                        if (!empty($donor_number)) {
                                            echo $donor_number = array_sum($donor_number);
                                        } else {
                                            $donor_number = 0;
                                            echo $donor_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="green"><?php
                                            echo $donor_number . ' ';
                                            if ($donor_number <= 1) {
                                                echo 'Donor Registered Today';
                                            } else {
                                                echo 'Donors Registered Today';
                                            }
                                            ?> </p>
                                    </li>

                                    <li>
                                        <a href="donor"><p class="green">See all Donors</p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?> 
                        <!-- donor notification end -->  
                        <!-- medicine notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor'))) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-medkit"></i>
                                    <span class="badge bg-success">                          
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->where('add_date', date('m/d/y'));
                                        $query = $this->db->get('medicine');
                                        $query = $query->result();
                                        foreach ($query as $medicine) {
                                            $medicine_number[] = '1';
                                        }
                                        if (!empty($medicine_number)) {
                                            echo $medicine_number = array_sum($medicine_number);
                                        } else {
                                            $medicine_number = 0;
                                            echo $medicine_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="yellow"><?php
                                            echo $medicine_number . ' ';
                                            if ($medicine_number <= 1) {
                                                echo 'Medicine Registered Today';
                                            } else {
                                                echo 'Medicines Registered Today';
                                            }
                                            ?> </p>
                                    </li>

                                    <li>
                                        <a href="medicine"><p class="green">See all Medicines</p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?> 
                        <!-- medicine notification end -->  
                        <!-- report notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist', 'Nurse'))) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-hospital-o"></i>
                                    <span class="badge bg-success">                         
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $this->db->where('add_date', date('m/d/y'));
                                        $query = $this->db->get('report');
                                        $query = $query->result();
                                        foreach ($query as $report) {
                                            $report_number[] = '1';
                                        }
                                        if (!empty($report_number)) {
                                            echo $report_number = array_sum($report_number);
                                        } else {
                                            $report_number = 0;
                                            echo $report_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="yellow"><?php
                                            echo $report_number . ' ';
                                            if ($report_number <= 1) {
                                                echo 'Report Added Today';
                                            } else {
                                                echo 'Reports Added Today';
                                            }
                                            ?> </p>
                                    </li>

                                    <li>
                                        <a href="report"><p class="green">See all Reports</p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>


                        <?php if ($this->ion_auth->in_group('Patient')) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-hospital-o"></i>
                                    <span class="badge bg-success">                         
                                        <?php
                                        $this->db->where('hospital_id', $hospital_id);
                                        $query = $this->db->get('report');
                                        $query = $query->result();
                                        foreach ($query as $report) {
                                            if ($this->ion_auth->user()->row()->id == explode('*', $report->patient)[1]) {
                                                $report_number[] = '1';
                                            }
                                        }
                                        if (!empty($report_number)) {
                                            echo $report_number = array_sum($report_number);
                                        } else {
                                            $report_number = 0;
                                            echo $report_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="yellow"><?php
                                            echo $report_number . ' ';
                                            if ($report_number <= 1) {
                                                echo 'Report Is Available for You';
                                            } else {
                                                echo 'Reports are Available for You';
                                            }
                                            ?> </p>
                                    </li>

                                    <li>
                                        <a href="report/myreports"><p class="green">See Your Reports</p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- report notification end -->

                    </ul>
                </div>
                <div class="top-nav ">   
                    <?php
                    $message = $this->session->flashdata('feedback');
                    if (!empty($message)) {
                        ?>
                        <div class="flashmessage pull-left"><i class="fa fa-check"></i> <?php echo $message; ?></div>
                    <?php } ?> 

                    <ul class="nav pull-right top-menu">

                        <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img alt="" src="uploads/favicon.png" width="21" height="23">
                                <span class="username"><?php echo $this->ion_auth->user()->row()->username; ?></span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu extended logout">
                                <div class="log-arrow-up"></div>
                                <?php if (!$this->ion_auth->in_group('admin')) { ?> 
                                    <li><a href=""><i class="fa fa-dashboard"></i> Dashboard</a></li>
                                <?php } ?>
                                <li><a href="profile"><i class=" fa fa-suitcase"></i>Profile</a></li>
                                <?php if ($this->ion_auth->in_group('admin')) { ?> 
                                    <li><a href="settings"><i class="fa fa-cog"></i> Settings</a></li>
                                <?php } ?>

                                <li><a><i class="fa fa-user"></i> <?php echo $this->ion_auth->get_users_groups()->row()->name ?></a></li>
                                <li><a href="auth/logout"><i class="fa fa-key"></i> Log Out</a></li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->
                    </ul>
                </div>
            </header>
            <!--header end-->

            <!--sidebar start-->
            <aside>
                <div id="sidebar"  class="nav-collapse ">
                    <!-- sidebar menu start-->
                    <ul class="sidebar-menu" id="nav-accordion">

                        <li>
                            <a href="">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <?php if ($this->ion_auth->in_group('superadmin')) { ?>
                            <li>
                                <a href="hospital">
                                    <i class="fa fa-sitemap"></i>
                                    <span>All Hospitals</span>
                                </a>
                            </li>
                            <li>
                                <a href="hospital/addNewView">
                                    <i class="fa fa-plus-circle"></i>
                                    <span>Create New Hospital</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <li>
                                <a href="department">
                                    <i class="fa fa-sitemap"></i>
                                    <span>Departments</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <li>
                                <a href="doctor" >
                                    <i class="fa fa-stethoscope"></i>
                                    <span>Doctor</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Nurse', 'Doctor', 'Laboratorist'))) { ?>
                            <li>
                                <a href="patient" >
                                    <i class="fa fa-user"></i>
                                    <span>Patient</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <li> <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-users"></i>
                                    <span>Human Resources</span>
                                </a>
                                <ul class="sub">
                                    <li><a href="nurse"><i class="fa fa-user"></i>Nurse</a></li>
                                    <li><a href="pharmacist"><i class="fa fa-user"></i>Pharmacist</a></li>
                                    <li><a href="laboratorist"><i class="fa fa-user"></i>Laboratorist</a></li>
                                    <li><a href="accountant"><i class="fa fa-user"></i>Accountant</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-dollar"></i>
                                    <span>Financial Activities</span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="finance/payment"><i class="fa fa-money"></i>Payment</a></li>
                                    <li><a  href="finance/addPaymentView"><i class="fa fa-plus-circle"></i>Add Payment</a></li>
                                    <li><a  href="finance/paymentCategory"><i class="fa fa-edit"></i>Payment Category</a></li>
                                    <li><a  href="finance/expense"><i class="fa fa-money"></i>Expense</a></li>
                                    <li><a  href="finance/addExpenseView"><i class="fa fa-plus-circle"></i>Add expense</a></li>
                                    <li><a  href="finance/expenseCategory"><i class="fa fa-edit"></i>Expense Category </a></li>
                                    <li><a  href="finance/financialReport"><i class="fa fa-book"></i>Financial Report</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-medkit"></i>
                                    <span>Medicine</span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="medicine"><i class="fa fa-medkit"></i>Medicine List</a></li>
                                    <li><a  href="medicine/addMedicineView"><i class="fa fa-plus-circle"></i>Add Medicine</a></li>
                                    <li><a  href="medicine/medicineCategory"><i class="fa fa-edit"></i>Medicine Category</a></li>
                                    <li><a  href="medicine/addCategoryView"><i class="fa fa-plus-circle"></i>Add Category</a></li>

                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group(array('admin', 'Laboratorist', 'Doctor'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-user"></i>
                                    <span>Donor</span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="donor"><i class="fa fa-user"></i>Donor List</a></li>
                                    <li><a  href="donor/addDonorView"><i class="fa fa-plus-circle"></i>Add Donor</a></li>


                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-hdd-o"></i>
                                    <span>Bed</span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="bed"><i class="fa fa-hdd-o"></i>Bed List</a></li>
                                    <li><a  href="bed/addBedView"><i class="fa fa-plus-circle"></i>Add bed</a></li>
                                    <li><a  href="bed/bedCategory"><i class="fa fa-edit"></i>Bed Category</a></li>
                                    <li><a  href="bed/bedAllotment"><i class="fa fa-plus-square-o"></i>Bed Allotments</a></li>
                                    <li><a  href="bed/addAllotmentView"><i class="fa fa-plus-circle"></i>Add Allotment</a></li>

                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-hospital-o"></i>
                                    <span>Report</span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="report/birth"><i class="fa fa-smile-o"></i>Birth Report</a></li>
                                    <li><a  href="report/operation"><i class="fa fa-wheelchair"></i>Operation report</a></li>
                                    <li><a  href="report/expire"><i class="fa fa-minus-square-o"></i>Expire Report</a></li>
                                    <li><a  href="report/addReportView"><i class="fa fa-plus-square-o"></i>Add Report</a></li>

                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <li>
                                <a href="settings" >
                                    <i class="fa fa-gears"></i>
                                    <span> Settings </span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group('Accountant')) { ?>
                            <li>
                                <a href="finance/payment" >
                                    <i class="fa fa-money"></i>
                                    <span> Payments </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/addPaymentView" >
                                    <i class="fa fa-plus-circle"></i>
                                    <span> Add Payment </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/paymentCategory" >
                                    <i class="fa fa-edit"></i>
                                    <span> Payment Category </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/expense" >
                                    <i class="fa fa-money"></i>
                                    <span> Expense </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/addExpenseView" >
                                    <i class="fa fa-plus-circle"></i>
                                    <span> Add Expense </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/expenseCategory" >
                                    <i class="fa fa-edit"></i>
                                    <span> Expense Category </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/financialReport" >
                                    <i class="fa fa-book"></i>
                                    <span> Financial Report </span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group('Pharmacist')) { ?>
                            <li>
                                <a href="medicine" >
                                    <i class="fa fa-medkit"></i>
                                    <span> Medicine List </span>
                                </a>
                            </li>
                            <li>
                                <a href="medicine/addMedicineView" >
                                    <i class="fa fa-plus-circle"></i>
                                    <span> Add Medicine </span>
                                </a>
                            </li>
                            <li>
                                <a href="medicine/medicineCategory" >
                                    <i class="fa fa-medkit"></i>
                                    <span> Medicine Category </span>
                                </a>
                            </li>
                            <li>
                                <a href="medicine/addCategoryView" >
                                    <i class="fa fa-plus-circle"></i>
                                    <span> Add Category </span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group('Nurse')) { ?>
                            <li>
                                <a href="bed" >
                                    <i class="fa fa-hdd-o"></i>
                                    <span> Bed List </span>
                                </a>
                            </li>
                            <li>
                                <a href="bed/bedCategory" >
                                    <i class="fa fa-edit"></i>
                                    <span> Bed Category </span>
                                </a>
                            </li>
                            <li>
                                <a href="bed/bedAllotment" >
                                    <i class="fa fa-plus-square-o"></i>
                                    <span> Bed Allotment </span>
                                </a>
                            </li>
                            <li>
                                <a href="donor" >
                                    <i class="fa fa-medkit"></i>
                                    <span> Donor </span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group('Patient')) { ?>
                            <li>
                                <a href="donor" >
                                    <i class="fa fa-user"></i>
                                    <span>Donor</span>
                                </a>
                            </li>
                            <li>
                                <a href="report/myreports" >
                                    <i class="fa fa-user"></i>
                                    <span> My Report </span>
                                </a>
                            </li>

                        <?php } ?>

                        <li>
                            <a href="profile" >
                                <i class="fa fa-user"></i>
                                <span> Profile </span>
                            </a>
                        </li>

                    </ul>
                    <!-- sidebar menu end-->
                </div>
            </aside>
            <!--sidebar end-->




