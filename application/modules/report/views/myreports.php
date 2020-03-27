
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
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
                            if ($user_id == explode('*', $report->patient)[1]) {
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
