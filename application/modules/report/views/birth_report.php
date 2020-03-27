
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Birth Report
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group">
                                <button id="" class="btn green">
                                   <i class="fa fa-plus-circle"></i> Add New Report
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
                                <th>Description</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Options</th>
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

                        <?php foreach ($reports as $report) { ?>
                            <tr class="">
                                <td><?php echo explode('*', $report->patient)[0]; ?></td>
                                <td> <?php echo $report->description; ?></td>
                                <td><?php echo $report->doctor; ?></td>
                                <td class="center"><?php echo $report->date; ?></td>
                                <td>
                                    <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $report->id; ?>"><i class="fa fa-edit"></i></button>   
                                    <a class="btn btn-info btn-xs btn_width delete_button" href="report/delete?id=<?php echo $report->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i></a>
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
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Add Birth Report</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="report/addReport" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Select Type</label>
                        <select class="form-control m-bot15" name="type" value=''>
                            <option value="birth" selected="">Birth</option>
                            <option value="operation">Operation</option>
                            <option value="expire">Expire</option>
                        </select>
                    </div>
                    <div class="form-group">


                        <label for="exampleInputEmail1">Description</label>
                        <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='' placeholder="">

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
                        <input class="form-control form-control-inline input-medium default-date-picker" name="date"  size="16" type="text" value="" />

                    </div>

                    <input type="hidden" name="id" value=''>

                    <button type="submit" name="submit" class="btn btn-info">Submit</button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Event Modal-->

<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Birth Report</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editBirthReportForm" action="report/addReport" method="post" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='' placeholder="">

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
                        <input class="form-control form-control-inline input-medium default-date-picker" name="date"  size="16" type="text" value="" />

                    </div>

                    <input type="hidden" name="id" value=''>

                    <button type="submit" name="submit" class="btn btn-info">Submit</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
                                    $(document).ready(function () {
                                        $(".editbutton").click(function (e) {
                                            e.preventDefault(e);
                                            // Get the record's ID via attribute  
                                            var iid = $(this).attr('data-id');
                                            $('#editBirthReportForm').trigger("reset");
                                            $('#myModal2').modal('show');
                                            $.ajax({
                                                url: 'report/editReportByJason?id=' + iid,
                                                method: 'GET',
                                                data: '',
                                                dataType: 'json',
                                            }).success(function (response) {
                                                // Populate the form fields with the data returned from server
                                                $('#editBirthReportForm').find('[name="id"]').val(response.report.id).end()
                                                //   $('#editEventForm').find('[name="p_id"]').val(response.client.client_id).end()
                                                $('#editBirthReportForm').find('[name="type"]').val(response.report.type).end()
                                                $('#editBirthReportForm').find('[name="description"]').val(response.report.description).end()
                                                $('#editBirthReportForm').find('[name="patient"]').val(response.report.patient).end()
                                                $('#editBirthReportForm').find('[name="doctor"]').val(response.report.doctor).end()
                                                $('#editBirthReportForm').find('[name="date"]').val(response.report.date).end()
                                            });

                                        });
                                    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
