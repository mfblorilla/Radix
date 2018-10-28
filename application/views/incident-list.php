<div class="content-wrapper">

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-9">
                <h1>Incidents</h1>

            </div>
        </div> <!-- end of row -->
        <div class="col-lg-12">
            <hr>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%" id="dataTable" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Maximo Incident ID</th>
                            <th>Offense ID</th>
                            <th style="width:30%;">Description</th>
                            <th>Incident Type</th>
                            <th>Status</th>
                            <th>Offense Start</th>
                            <th>Created By</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($incidents as $row): ?>
                            <tr>
                                <td><a href="<?php echo base_url('index.php/Incident/view_incident/' . $row->incident_id); ?>"><?php echo $row->maximo_incident_id; ?></a></td>
                                <td><?php echo $row->offense_id; ?></td>
                                <td><?php echo $row->description; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->status; ?></td>
                                <td><?php echo nice_date($row->offense_start, 'M-d-Y , H:i:s') ?></td>
                                <td><?php echo $row->username; ?></td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!--end of container fluid-->
</div>
<!--end of content wrapper-->