
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($patient->id))
                    echo 'Edit Patient';
                else
                    echo 'Add New Patient';
                ?>
            </header>

            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">

                        <div class="col-lg-12">

                            <section class="panel">

                                <div class="panel-body">
                                    <?php echo $this->session->flashdata('feedback'); ?>
                                    <div class="col-lg-12">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <?php echo validation_errors(); ?>

                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>

                                    <form role="form" action="patient/addNew" method="post" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <div class="col-md-12">     
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-6">
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
                                                <div class="col-md-3">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                            if (!empty($patient->name)) {
                                                echo $patient->name;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Password</label>
                                            <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='<?php
                                            if (!empty($patient->email)) {
                                                echo $patient->email;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Address</label>
                                            <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php
                                            if (!empty($patient->address)) {
                                                echo $patient->address;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Phone</label>
                                            <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='<?php
                                            if (!empty($patient->phone)) {
                                                echo $patient->phone;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Sex</label>
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
                                            <input class="form-control form-control-inline input-medium default-date-picker" type="text" name="birthdate" value="<?php
                                            if (!empty($patient->birthdate)) {
                                                echo $patient->birthdate;
                                            }
                                            ?>" placeholder="">

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

                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($patient->id)) {
                                            echo $patient->id;
                                        }
                                        ?>'>
                                        <input type="hidden" name="p_id" value='<?php
                                        if (!empty($patient->patient_id)) {
                                            echo $patient->patient_id;
                                        }
                                        ?>'>

                                        <section class="">
                                            <button type="submit" name="submit" class="btn btn-info">Submit</button>
                                        </section>
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
