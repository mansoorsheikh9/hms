
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($report->id))
                    echo 'Edit Report';
                else
                    echo 'Add New Report';
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">

                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form" action="report/addReport" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Select Type</label>
                                            <select class="form-control m-bot15" name="type" value=''>
                                                <option value="birth" <?php
                                                if (!empty($report->report_type)) {
                                                    if ($report->report_type == 'birth') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>>Birth</option>
                                                <option value="operation" <?php
                                                if (!empty($report->report_type)) {
                                                    if ($report->report_type == 'operation') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>>Operation</option>
                                                <option value="expire" <?php
                                                if (!empty($report->report_type)) {
                                                    if ($report->report_type == 'expire') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>>Expire</option>
                                            </select>
                                        </div>
                                        <div class="form-group">


                                            <label for="exampleInputEmail1">Description</label>
                                            <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='<?php
                                            if (!empty($report->description)) {
                                                echo $report->description;
                                            }
                                            ?>' placeholder="">

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Patient</label>
                                            <select class="form-control m-bot15" name="patient" value=''> 
                                                <?php foreach ($patients as $patient) { ?>
                                                    <option value="<?php echo $patient->name . '*' . $patient->ion_user_id; ?>" <?php
                                                    if (!empty($report->patient)) {
                                                        if (explode('*', $report->patient)[1] == $patient->ion_user_id) {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?> ><?php echo $patient->name; ?> </option>
                                                        <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Doctor</label>
                                            <select class="form-control m-bot15" name="doctor" value=''> 
                                                <?php foreach ($doctors as $doctor) { ?>
                                                    <option value="<?php echo $doctor->name; ?>" <?php
                                                    if (!empty($report->doctor)) {
                                                        if ($report->doctor == $doctor->name) {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?> ><?php echo $doctor->name; ?> </option>
                                                        <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Date</label>
                                            <input class="form-control form-control-inline input-medium default-date-picker" name="date"  size="16" type="text" value="<?php
                                            if (!empty($report->date)) {
                                                echo $report->date;
                                            }
                                            ?>" />

                                        </div>

                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($report->id)) {
                                            echo $report->id;
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
