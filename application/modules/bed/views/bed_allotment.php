<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Alloted Beds  
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group">
                                <button id="" class="btn green">
                                   <i class="fa fa-plus-circle"></i> Add Allotment 
                                </button>
                            </div>
                        </a>
                        <button class="export" onclick="javascript:window.print();">Print</button>  
                    </div>
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>Bed Id</th>
                                <th>Patient</th>
                                <th>Alloted Time</th>
                                <th>Discharge Time</th>
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
                        <?php foreach ($alloted_beds as $alloted_bed) { ?>
                            <tr class="">
                                <td><?php echo $alloted_bed->bed_id; ?></td>
                                <td><?php echo $alloted_bed->patient; ?></td>             
                                <td><?php echo $alloted_bed->a_time; ?></td>
                                <td><?php echo $alloted_bed->d_time; ?></td>
                                <td>
                                    <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $alloted_bed->id; ?>"><i class="fa fa-edit"></i></button>   
                                    <a class="btn btn-info btn-xs btn_width delete_button" href="bed/deleteAllotment?id=<?php echo $alloted_bed->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i></a>
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
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Add New Allotment</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="bed/addAllotment" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Bed Id</label>
                        <select class="form-control m-bot15" name="bed_id" value=''>
                            <?php foreach ($beds as $bed) { ?>
                                <option value="<?php echo $bed->bed_id; ?>" <?php
                                if (!empty($allotment->bed_id)) {
                                    if ($allotment->bed_id == $bed->bed_id) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $bed->bed_id; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Patient</label>
                        <select class="form-control m-bot15" name="patient" value=''> 
                            <?php foreach ($patients as $patient) { ?>
                                <option value="<?php echo $patient->name; ?>" <?php
                                if (!empty($allotment->patient)) {
                                    if ($allotment->patient == $patient->name) {
                                        echo 'selected';
                                    }
                                }
                                ?> ><?php echo $patient->name; ?> </option>
                                    <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Alloted Time</label>
                        <div data-date="" class="input-group date form_datetime-meridian">
                            <div class="input-group-btn"> 
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="text" class="form-control" readonly="" name="a_time" id="exampleInputEmail1" value='' placeholder="">


                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Discharge Time</label>
                        <div data-date="" class="input-group date form_datetime-meridian">
                            <div class="input-group-btn"> 
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="text" class="form-control" name="d_time" id="exampleInputEmail1" value='' placeholder="">


                        </div>
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
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Allotment</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editBedAllotmentform" action="bed/addAllotment" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Bed Id</label>
                        <select class="form-control m-bot15" name="bed_id" value=''>
                            <?php foreach ($beds as $bed) { ?>
                                <option value="<?php echo $bed->bed_id; ?>" <?php
                                if (!empty($allotment->bed_id)) {
                                    if ($allotment->bed_id == $bed->bed_id) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $bed->bed_id; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Patient</label>
                        <select class="form-control m-bot15" name="patient" value=''> 
                            <?php foreach ($patients as $patient) { ?>
                                <option value="<?php echo $patient->name; ?>" <?php
                                if (!empty($allotment->patient)) {
                                    if ($allotment->patient == $patient->name) {
                                        echo 'selected';
                                    }
                                }
                                ?> ><?php echo $patient->name; ?> </option>
                                    <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Alloted Time</label>
                        <div data-date="" class="input-group date form_datetime-meridian">
                            <div class="input-group-btn"> 
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="text" class="form-control" readonly="" name="a_time" id="exampleInputEmail1" value='' placeholder="">


                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Discharge Time</label>
                        <div data-date="" class="input-group date form_datetime-meridian">
                            <div class="input-group-btn"> 
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="text" class="form-control" name="d_time" id="exampleInputEmail1" value='' placeholder="">


                        </div>
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
                                            $('#editBedAllotmentform').trigger("reset");
                                            $('#myModal2').modal('show');
                                            $.ajax({
                                                url: 'bed/editAllotmentByJason?id=' + iid,
                                                method: 'GET',
                                                data: '',
                                                dataType: 'json',
                                            }).success(function (response) {
                                                // Populate the form fields with the data returned from server
                                                $('#editBedAllotmentform').find('[name="id"]').val(response.allotment.id).end()
                                                //   $('#editEventForm').find('[name="p_id"]').val(response.client.client_id).end()
                                                $('#editBedAllotmentform').find('[name="bed_id"]').val(response.allotment.bed_id).end()
                                                $('#editBedAllotmentform').find('[name="patient"]').val(response.allotment.patient).end()
                                                $('#editBedAllotmentform').find('[name="a_time"]').val(response.allotment.a_time).end()
                                                $('#editBedAllotmentform').find('[name="d_time"]').val(response.allotment.d_time).end()
                                                
                                            });

                                        });
                                    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
