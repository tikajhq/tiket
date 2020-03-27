<!-- Dashboard Counts Section-->
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><?= $title ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsiveW">
                                <?php
                                if (is_array($tickets) && count($tickets) > 0) {
                                    ?>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Ticket Number</th>
                                            <th>Purpose</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                            <th>Created On</th>
                                            <th>Options</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        foreach ($tickets as $ticket) {
                                            echo '
                                            <tr>
                                                <td>' . $a++ . '</td>
                                                <td>
                                                    <a href="' . BASE_URL . 'tickets/view_ticket/' . $ticket['ticket_no'] . '" style="color: gray; text-decoration:none;">' . $ticket['ticket_no'] . '</a>
                                                </td>
                                                <td>' . substr($ticket['purpose'], 0, 25) . '</td>
                                                <td>' . substr($ticket['subject'], 0, 25) . '</td>
                                                <td>' . STATUS_MAP[$ticket['status']] . '</td>
                                                <td>' . toDate($ticket['created']) . '</td>
                                                <td>
                                                    <a href="' . BASE_URL . 'tickets/view_ticket/' . $ticket['ticket_no'] . '" class="badge badge-info p-1" data-toggle="tooltip" title="View Ticket" data-placement="left"><i class="fa fa-eye"></i></a>
                                                    <a href="' . BASE_URL . 'tickets/close_ticket/' . $ticket['ticket_no'] . '" class="badge badge-warning p-1" data-toggle="tooltip"  data-placement="left" title="Close Ticket"><i class="fa fa-close"></i></a>
                                                    <a href="' . BASE_URL . 'api/assign_ticket/' . $ticket['ticket_no'] . '" class="badge badge-primary p-1 assign_to_modal" data-toggle="tooltip"  data-placement="left" title="Assign to Someone"><i class="fa fa-check"></i></a>
                                                </td>
                                            </tr>
                                            ';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php
                                } else {
                                    ?>
                                    <div class="alert alert-info">No record found</div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(".table").DataTable();
</script>