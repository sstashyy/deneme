<?php
use sstashy\ZFunctions;

include "ayar.php";

$commands = listCommands();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {
    $deleteId = intval($_POST["delete_id"]);
    if (deleteCommand($deleteId)) {
        echo "<script>alert('Komut başarıyla silindi.'); window.location.href='/delcmd';</script>";
    } else {
        echo "<script>alert('Silme işlemi başarısız.');</script>";
    }
}
ZFunctions::adminControl();
?>

<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Komut Sil</h6>
                <table class="table table-striped table-bordered table-hover" id="dataTables-command">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Komut</th>
                            <th>Açıklama</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commands as $command): ?>
                            <tr>
                                <td><?= htmlspecialchars($command['id']) ?></td>
                                <td><?= htmlspecialchars($command['command_name']) ?></td>
                                <td><?= htmlspecialchars($command['description']) ?></td>
                                <td><?= htmlspecialchars($command['created_at']) ?></td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="delete_id" value="<?= $command['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
        $('#dataTables-command').DataTable();
    });
</script>