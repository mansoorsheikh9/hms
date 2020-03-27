<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Donor 
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                            <a data-toggle="modal" href="#myModal">
                                <div class="btn-group">
                                    <button id="" class="btn green">
                                        <i class="fa fa-plus-circle"></i> Add Donor 
                                    </button>
                                </div>
                            </a>
                        <?php } ?>
                        <button class="export" onclick="javascript:window.print();">Print</button>  
                    </div>
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Blood Group</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Last Donation Date</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor'))) { ?>
                                    <th>Options</th>
                                <?php } ?>
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
                        <?php foreach ($donors as $donor) { ?>
                            <tr class="">
                                <td><?php echo $donor->name; ?></td>
                                <td> <?php echo $donor->group; ?></td>
                                <td><?php echo $donor->age; ?></td>
                                <td class="center"><?php echo $donor->sex; ?></td>
                                <td><?php echo $donor->ldd; ?></td>
                                <td><?php echo $donor->phone; ?></td>
                                <td><?php echo $donor->email; ?></td>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor'))) { ?>
                                    <td>
                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $donor->id; ?>"><i class="fa fa-edit"></i></button>   
                                        <a class="btn btn-info btn-xs btn_width delete_button" href="donor/delete?id=<?php echo $donor->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                <?php } ?>
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
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Add New Donor</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="donor/addDonor" method="post" enctype="multipart/form-data">
                    <div class="form-group">


                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Blood Group</label>
                        <select class="form-control m-bot15" name="group" value=''>
                            <?php foreach ($groups as $group) { ?>
                                <option value="<?php echo $group->group; ?>" <?php
                                if (!empty($donor->group)) {
                                    if ($group->group == $donor->group) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $group->group; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Age</label>
                        <input type="text" class="form-control" name="age" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sex</label>
                        <select class="form-control m-bot15" name="sex" value=''>

                            <option value="Male" <?php
                            if (!empty($donor->sex)) {
                                if ($donor->sex == 'Male') {
                                    echo 'selected';
                                }
                            }
                            ?> > Male </option>
                            <option value="Female" <?php
                            if (!empty($donor->sex)) {
                                if ($donor->sex == 'Female') {
                                    echo 'selected';
                                }
                            }
                            ?> > Female </option>
                            <option value="Others" <?php
                            if (!empty($donor->sex)) {
                                if ($donor->sex == 'Others') {
                                    echo 'selected';
                                }
                            }
                            ?> > Others </option>


                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Last Donation Date</label>
                        <input class="form-control form-control-inline input-medium default-date-picker" type="text" name="ldd" value="" placeholder="">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone</label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
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
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Donor</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editDonorForm" action="donor/addDonor" method="post" enctype="multipart/form-data">
                    <div class="form-group">


                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Blood Group</label>
                        <select class="form-control m-bot15" name="group" value=''>
                            <?php foreach ($groups as $group) { ?>
                                <option value="<?php echo $group->group; ?>" <?php
                                if (!empty($donor->group)) {
                                    if ($group->group == $donor->group) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $group->group; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Age</label>
                        <input type="text" class="form-control" name="age" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sex</label>
                        <select class="form-control m-bot15" name="sex" value=''>

                            <option value="Male" <?php
                            if (!empty($donor->sex)) {
                                if ($donor->sex == 'Male') {
                                    echo 'selected';
                                }
                            }
                            ?> > Male </option>
                            <option value="Female" <?php
                            if (!empty($donor->sex)) {
                                if ($donor->sex == 'Female') {
                                    echo 'selected';
                                }
                            }
                            ?> > Female </option>
                            <option value="Others" <?php
                            if (!empty($donor->sex)) {
                                if ($donor->sex == 'Others') {
                                    echo 'selected';
                                }
                            }
                            ?> > Others </option>


                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Last Donation Date</label>
                        <input class="form-control form-control-inline input-medium default-date-picker" type="text" name="ldd" value="" placeholder="">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone</label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
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
                                            $('#editDonorForm').trigger("reset");
                                            $('#myModal2').modal('show');
                                            $.ajax({
                                                url: 'donor/editDonorByJason?id=' + iid,
                                                method: 'GET',
                                                data: '',
                                                dataType: 'json',
                                            }).success(function (response) {
                                                // Populate the form fields with the data returned from server
                                                $('#editDonorForm').find('[name="id"]').val(response.donor.id).end()
                                                //   $('#editEventForm').find('[name="p_id"]').val(response.client.client_id).end()
                                                $('#editDonorForm').find('[name="name"]').val(response.donor.name).end()
                                                $('#editDonorForm').find('[name="bloodgroup"]').val(response.donor.bloodgroup).end()
                                                $('#editDonorForm').find('[name="age"]').val(response.donor.age).end()
                                                $('#editDonorForm').find('[name="sex"]').val(response.donor.sex).end()
                                                $('#editDonorForm').find('[name="ldd"]').val(response.donor.ldd).end()
                                                $('#editDonorForm').find('[name="phone"]').val(response.donor.phone).end()
                                                $('#editDonorForm').find('[name="email"]').val(response.donor.email).end()
                                            });

                                        });
                                    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
