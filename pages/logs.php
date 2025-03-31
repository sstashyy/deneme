<?php include "ayar.php"; 
use sstashy\ZFunctions;
ZFunctions::adminControl();
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">LOG'lar</h5>
                </div>

                <?php
                global $db;
                $kullanici = kullanicirol();

                $sorgu = $db->prepare("SELECT COUNT(*) FROM command_logs");
                $sorgu->execute();
                $say = $sorgu->fetchColumn();
                if ($say == 0) {
                    echo "No logs found.";
                } else {
                    $id = 1;
                    echo '<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Command Name</th>
                                    <th>Command Code</th>
                                    <th>Arguments</th>
                                    <th>Output</th>
                                    <th>Executed At</th>
                                    <th>Executed By</th>
                                </tr>
                            </thead>
                            <tbody>';

                    $query = $db->query("SELECT * FROM command_logs ORDER BY id DESC", PDO::FETCH_ASSOC);
                    if ($query->rowCount()) {
                        foreach ($query as $row) {
                            echo '
                                <tr class="odd gradeX">
                                    <td>' . $id . '</td>
                                    <td>' . htmlspecialchars($row["command_name"]) . '</td>
                                    <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal' . $id . '">View Code</button></td>
                                    <td>' . htmlspecialchars($row["arguments"]) . '</td>
                                    <td>' . htmlspecialchars($row["output"]) . '</td>
                                    <td>' . date("d.m.Y H:i:s", strtotime($row["executed_at"])) . '</td>
                                    <td>' . htmlspecialchars($row["executed_by"]) . '</td>
                                </tr>';

                            echo '
                                <div class="modal fade" id="modal' . $id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-dark text-white">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Command Code</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <pre>' . htmlspecialchars($row["command_code"]) . '</pre>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            $id++;
                        }
                    }

                    echo '</tbody>
                        </table>';
                }

                ?>

            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap.min.css"/>

<!-- Custom CSS for Dark Theme -->
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #fff !important;
        background-color: #333 !important;
        border: 1px solid #444 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #555 !important;
        border: 1px solid #666 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        color: #666 !important;
    }
    .modal-content {
        background-color: #333 !important;
        color: #fff !important;
    }
    .btn-close-white {
        filter: invert(1);
    }
    .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
        color: #fff !important;
    }
</style>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable();
    });
</script>