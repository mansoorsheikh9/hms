
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Patient
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group">
                                <button id="" class="btn green">
                                    <i class="fa fa-plus-circle"></i> Add New Patient 
                                </button>
                            </div>
                        </a>
                        <button class="export" onclick="javascript:window.print();">Print</button>  
                    </div>
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>Patient Id</th>                        
                                <th>Image</th>
                                <th>Name</th>
                                <th class="center">Email</th>
                                <th>Doctor</th>
                                <th>Birth Date</th>
                                <th>Phone</th>
                                <th>Blood Group</th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                    <th>Due Balance</th>
                                <?php } ?>
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

                        <?php foreach ($patients as $patient) { ?>
                            <tr class="">
                                <td> <?php echo $patient->patient_id; ?></td>
                                <td style="width:10%;"><img style="width:95%;" src="<?php echo $patient->img_url; ?>"></td>
                                <td> <?php echo $patient->name; ?></td>
                                <td><?php echo $patient->email; ?></td>
                                <td> <?php echo $patient->doctor; ?></td>
                                <td class="center"><?php echo $patient->birthdate; ?></td>
                                <td><?php echo $patient->phone; ?></td>
                                <td><?php echo $patient->bloodgroup; ?></td>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                    <td> <?php echo $settings->currency; ?>
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
                                        ?>
                                    </td>
                                <?php } ?>
                                <td>
                                    <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $patient->id; ?>"><i class="fa fa-edit"></i></button>   
                                    <a class="" href="patient/patientDetails?id=<?php echo $patient->id; ?>"><button type="button" class="btn btn-info btn-xs btn_width"><i class="fa fa details">details</i></button></a>   
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                        <a class="btn btn-info btn-xs btn_width delete_button" href="finance/invoicePatientTotal?id=<?php echo $patient->id; ?>">Invoice</a>
                                    <?php } ?>
                                    <a class="btn btn-info btn-xs btn_width delete_button" href="patient/delete?id=<?php echo $patient->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i></a>

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
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Add Patient</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <div class="col-md-12">     
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <div class="col-md-3 payment_label"> 
                                    <label for="exampleInputEmail1">Doctor</label>
                                </div>
                                <div class="col-md-9"> 
                                    <select class="form-control m-bot15" name="doctor" value=''> 
                                        <?php foreach ($doctors as $doctor) { ?>
                                            <option value="<?php echo $doctor->name; ?>" <?php
                                            if (!empty($patient->doctor)) {
                                                if ($patient->doctor == $doctor->name) {
                                                    echo 'selected';
                                                }
                                            }
                                            ?> ><?php echo $doctor->name; ?> </option>
                                                <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Address</label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone</label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Gender</label>
                        <select class="form-control m-bot15" name="sex" value=''>

                            <option value="Male" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Male') {
                                    echo 'selected';
                                }
                            }
                            ?> > Male </option>
                            <option value="Female" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Female') {
                                    echo 'selected';
                                }
                            }
                            ?> > Female </option>
                            <option value="Others" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Others') {
                                    echo 'selected';
                                }
                            }
                            ?> > Others </option>


                        </select>
                    </div>
                    <div class="form-group">
                        <label>Birth Date</label>
                        <input class="form-control form-control-inline input-medium default-date-picker" type="text" name="birthdate" value="" placeholder="">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Blood Group</label>
                        <select class="form-control m-bot15" name="bloodgroup" value=''>
                            <?php foreach ($groups as $group) { ?>
                                <option value="<?php echo $group->group; ?>" <?php
                                if (!empty($patient->bloodgroup)) {
                                    if ($group->group == $patient->bloodgroup) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $group->group; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Image</label>
                        <input type="file" name="img_url">
                    </div>

                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="p_id" value=''>

                    <section class="">
                        <button type="submit" name="submit" class="btn btn-info">Submit</button>
                    </section>
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
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Patient</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editPatientForm" action="patient/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <div class="col-md-12">     
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <div class="col-md-3 payment_label"> 
                                    <label for="exampleInputEmail1">Doctor</label>
                                </div>
                                <div class="col-md-9"> 
                                    <select class="form-control m-bot15" name="doctor" value=''> 
                                        <?php foreach ($doctors as $doctor) { ?>
                                            <option value="<?php echo $doctor->name; ?>" <?php
                                            if (!empty($patient->doctor)) {
                                                if ($patient->doctor == $doctor->name) {
                                                    echo 'selected';
                                                }
                                            }
                                            ?> ><?php echo $doctor->name; ?> </option>
                                                <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="********">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Address</label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone</label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Gender</label>
                        <select class="form-control m-bot15" name="sex" value=''>

                            <option value="Male" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Male') {
                                    echo 'selected';
                                }
                            }
                            ?> > Male </option>
                            <option value="Female" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Female') {
                                    echo 'selected';
                                }
                            }
                            ?> > Female </option>
                            <option value="Others" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Others') {
                                    echo 'selected';
                                }
                            }
                            ?> > Others </option>


                        </select>
                    </div>
                    <div class="form-group">
                        <label>Birth Date</label>
                        <input class="form-control form-control-inline input-medium default-date-picker" type="text" name="birthdate" value="" placeholder="">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Blood Group</label>
                        <select class="form-control m-bot15" name="bloodgroup" value=''>
                            <?php foreach ($groups as $group) { ?>
                                <option value="<?php echo $group->group; ?>" <?php
                                if (!empty($patient->bloodgroup)) {
                                    if ($group->group == $patient->bloodgroup) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $group->group; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Image</label>
                        <input type="file" name="img_url">
                    </div>

                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="p_id" value=''>

                    <section class="">
                        <button type="submit" name="submit" class="btn btn-info">Submit</button>
                    </section>
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
                                                $('#editPatientForm').trigger("reset");
                                                $('#myModal2').modal('show');
                                                $.ajax({
                                                    url: 'patient/editPatientByJason?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).success(function (response) {
                                                    // Populate the form fields with the data returned from server
                                                    $('#editPatientForm').find('[name="id"]').val(response.patient.id).end()
                                                    $('#editPatientForm').find('[name="doctor"]').val(response.patient.doctor).end()
                                                    //   $('#editEventForm').find('[name="p_id"]').val(response.client.client_id).end()
                                                    $('#editPatientForm').find('[name="name"]').val(response.patient.name).end()
                                                    $('#editPatientForm').find('[name="password"]').val(response.patient.password).end()
                                                    $('#editPatientForm').find('[name="email"]').val(response.patient.email).end()
                                                    $('#editPatientForm').find('[name="address"]').val(response.patient.address).end()
                                                    $('#editPatientForm').find('[name="phone"]').val(response.patient.phone).end()
                                                    $('#editPatientForm').find('[name="sex"]').val(response.patient.email).end()
                                                    $('#editPatientForm').find('[name="birthdate"]').val(response.patient.birthdate).end()
                                                    $('#editPatientForm').find('[name="bloodgroup"]').val(response.patient.bloodgroup).end()
                                                    $('#editPatientForm').find('[name="p_id"]').val(response.patient.patient_id).end()
                                                });

                                            });
                                        });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
