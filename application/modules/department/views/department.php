<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Department 
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group">
                                <button id="" class="btn green">
                                    <i class="fa fa-plus-circle"></i>  Add Department 
                                </button>
                            </div>
                        </a>
                        <button class="export" onclick="javascript:window.print();">Print</button>  
                    </div>
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($departments as $department) { ?>
                                <tr class="">
                                    <td><?php echo $department->name; ?></td>
                                    <td><?php echo $department->description; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $department->id; ?>"><i class="fa fa-edit"></i></button>   
                                        <a class="btn btn-info btn-xs btn_width delete_button" href="department/delete?id=<?php echo $department->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i></a>
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






<!-- Add Area Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Add Department</h4>
            </div> 
            <div class="modal-body">
                <form role="form" action="department/addNew" method="post">
                    <div class="form-group col-md-12">
                        <label class="control-label col-md-3">Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                        </div>

                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label col-md-3"></label>
                        <div class="col-md-9">

                        </div>

                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label col-md-3">Description</label>
                        <div class="col-md-9">
                            <textarea class="ckeditor form-control" name="description" value="" rows="10"></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="id" value=''>

                    <button type="submit" name="submit" class="btn btn-info">Submit</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Area Modal-->

<!-- Edit Area Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Department</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editDepartmentForm" action="department/addNew" method="post">
                    <div class="form-group col-md-12">
                        <label class="control-label col-md-3">Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                        </div>

                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label col-md-3"></label>
                        <div class="col-md-9">

                        </div>

                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label col-md-3">Description</label>
                        <div class="col-md-9">
                            <textarea class="ckeditor form-control" id="editor" name="description" value="" rows="10"></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="id" value=''>

                    <button type="submit" name="submit" class="btn btn-info">Submit</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".editbutton").click(function (e) {
                                                e.preventDefault(e);
                                                // Get the record's ID via attribute  
                                                var iid = $(this).attr('data-id');
                                                $('#myModal2').modal('show');
                                                $.ajax({
                                                    url: 'department/editDepartmentByJason?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).success(function (response) {
                                                    // Populate the form fields with the data returned from server
                                                    $('#editDepartmentForm').find('[name="id"]').val(response.department.id).end()
                                                    $('#editDepartmentForm').find('[name="name"]').val(response.department.name).end()
                                                    CKEDITOR.instances['editor'].setData(response.department.description)
                                                });
                                            });
                                        });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

