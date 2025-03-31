<?php
use sstashy\ZFunctions;

$allUsers = ZFunctions::table('users')->get();
$userCount = count($allUsers);

if (@$_POST['saveBtn']) {
    ZFunctions::updateUser();
    $allUsers = ZFunctions::table('users')->get();
    $userCount = count($allUsers);
}

if (@$_POST['deleteUser']) {
    $id = ZFunctions::filter($_POST['deleteUser']);
    $delete = ZFunctions::table('users')->where('id', $id)->delete();
    if ($delete) {
        $alert = "Kullanıcı başarıyla silindi!";
        $allUsers = ZFunctions::table('users')->get();
        $userCount = count($allUsers);
    } else {
        $alert = "Kullanıcı silinirken bir hata oluştu!";
    }
}

if (@$_POST['createUser']) {
    ZFunctions::createuser();
    $alert = "Başarıyla oluşturuldu!";
    $allUsers = ZFunctions::table('users')->get();
    $userCount = count($allUsers);
}

ZFunctions::adminControl();
$usernamee = ZFunctions::getUserViaSession()['userName'];
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Kayıtlı Kullanıcılar;</h5>
                </div>
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target='#createUser'>Kullanıcı Oluştur</button>
                <div class="modal fade" id="createUser" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="bg-secondary rounded h-100 p-4">
                                <form method="post">
                                    <div class="row g-3">
                                        <div class="col-xxl-12">
                                            <label for="firstName" class="form-label">Kullanıcı Adı</label>
                                            <input type="text" class="form-control" id="firstName" maxlength="11" name="userName" placeholder="Kullanıcı adı giriniz!">
                                        </div>
                                        <div class="col-lg-12">
                                            <label for="genderInput" class="form-label">Üyelik Tipi</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="uyelikTipi" id="inlineRadio1" value="2" checked>
                                                    <label class="form-check-label" for="inlineRadio1">Moderator</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="uyelikTipi" id="inlineRadio2" value="3">
                                                    <label class="form-check-label" for="inlineRadio2">Admin</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="uyelikTipi" id="inlineRadio5" value="6">
                                                    <label class="form-check-label" for="inlineRadio5">Owner</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="uyelikTipi" id="inlineRadio6" value="7">
                                                    <label class="form-check-label" for="inlineRadio6">Senior Mod</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="uyelikTipi" id="inlineRadio3" value="4">
                                                    <label class="form-check-label" for="inlineRadio3">Yönetici</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="uyelikTipi" id="inlineRadio4" value="5">
                                                    <label class="form-check-label" for="inlineRadio4">Head Admin</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="uyelikTipi" id="inlineRadio8" value="8">
                                                    <label class="form-check-label" for="inlineRadio8">Senior Admin</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="uyelikTipi" id="inlineRadio9" value="9">
                                                    <label class="form-check-label" for="inlineRadio9">Senior Leader</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="uyelikTipi" id="inlineRadio10" value="10">
                                                    <label class="form-check-label" for="inlineRadio10">Yardımcı</label>
                                                </div>
                                            </div>
                                        </div>
                                                                                <div class="col-xxl-12">
                                            <input type="hidden" class="form-control" maxlength="11" name="userModerator" value="<?= $usernamee ?>">
                                        </div>
                                        <div class="col-xxl-12">
                                            <button type="submit" name="createUser" value="create" class="btn btn-primary">Oluştur</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kullanıcı Adı</th>
                                <th>Kullanıcı IP</th>
                                <th>Tarayıcı</th>
                                <th>İşletim Sistemi</th>
                                <th>Üyelik Bitiş Tarihi</th>
                                <th>Üyelik Durumu</th>
                                <th>Üyelik Tipi</th>
                                <th>Aksiyon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < $userCount; $i++) {
                                $userRoleInt = $allUsers[$i]->userRole;
                                $roleName = ''; // Default role name

                                if($userRoleInt == 1) {
                                    $roleName = "BABA";
                                } elseif($userRoleInt == 2) {
                                    $roleName = "Moderator";
                                } elseif($userRoleInt == 3) {
                                    $roleName = "Admin";
                                } elseif($userRoleInt == 4) {
                                    $roleName = "Yönetici";
                                } elseif($userRoleInt == 5) {
                                    $roleName = "Head Admin";
                                } elseif($userRoleInt == 6) {
                                    $roleName = "Owner";  
                                } elseif($userRoleInt == 7) {
                                    $roleName = "Senior Mod";  
                                } elseif($userRoleInt == 8) {
                                    $roleName = "Senior Admin";  
                                } elseif($userRoleInt == 9) {
                                    $roleName = "Senior Leader";  
                                } elseif($userRoleInt == 10) {
                                    $roleName = "Yardımcı";  
                                }

                                echo "<tr>";
                                echo "<td>" . $allUsers[$i]->id . "</td>";
                                echo "<td>" . $allUsers[$i]->userName . "</td>";
                                echo "<td>" . $allUsers[$i]->userLog . "</td>";
                                echo "<td>" . $allUsers[$i]->userBrowser . "</td>";
                                echo "<td>" . $allUsers[$i]->userOS . "</td>";
                                echo "<td>" . $allUsers[$i]->userTime . "</td>";
                                $status = $allUsers[$i]->userVerified;
                                $st;
                                if ($status == 1) {
                                    $st = "<span class='badge bg-primary'>Aktif</span>";
                                }
                                if ($status == 0) {
                                    $st = "<span class='badge bg-danger'>Deaktif</span>";
                                }
                                if ($status == 2) {
                                    $st = "<span class='badge bg-warning'>Şüpheli</span>";
                                }
                                echo "<td>" . $st . "</td>";
                                echo "<td>" . htmlspecialchars($roleName) . "</td>";  // Use htmlspecialchars to escape the role name
                                echo "<td><button class='btn btn-sm btn-soft-primary' data-bs-toggle='modal' data-bs-target='#modal$i'>Kullanıcıyı Düzenle</button>";
                                if ($allUsers[$i]->userAuthKey == $_SESSION['authKey']) {
                                    $asd = "disabled";
                                } else {
                                    $asd = "";
                                }
                                echo "<button $asd class='btn btn-sm btn-danger remove-item-btn' data-bs-toggle='modal' data-bs-target='.bs-example-modal-center$i'>Kullanıcıyı Sil</button></td>";
                                echo "</tr>";
                                ?>
                                <div class="modal fade bs-example-modal-center<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center p-5">
                                                <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px"></lord-icon>
                                                <form method="POST">
                                                    <div class="mt-4">
                                                        <h4 class="mb-3">Bunu yapmak istediğine emin misin?</h4>
                                                        <p class="text-muted mb-4"><?= $allUsers[$i]->userName ?> Adlı kullanıcıyı silmek istediğinden emin misin?</p>
                                                        <div class="hstack gap-2 justify-content-center">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                                                            <button name="deleteUser" value="<?= $allUsers[$i]->id ?>" class="btn btn-danger">Sil</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal<?= $i ?>" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="bg-secondary rounded h-100 p-4">
                                                <form method="POST">
                                                    <div class="row g-4">
                                                        <div class="col-xxl-6">
                                                            <label for="username" class="form-label">Kullanıcı Adı</label>
                                                            <input type="text" class="form-control" id="username" name="userNameM" value="<?= $allUsers[$i]->userName ?>">
                                                        </div>
                                                        <div class="col-xxl-6">
                                                            <label for="firstName" class="form-label">Anahtar</label>
                                                            <?php
                                                            $userAuthKey = $allUsers[$i]->userAuthKey;
                                                            if ($allUsers[$i]->userRole == 1) {
                                                                $userAuthKey = "**********";
                                                            }
                                                            ?>
                                                            <input type="text" class="form-control" name="anahtarKey" id="username" value="<?php echo $userAuthKey; ?>" <?php if ($allUsers[$i]->userRole == 1) { echo "readonly"; } ?>>
                                                        </div>
                                                        <div class="col-xxl-6">
                                                            <label for="membership" class="form-label">Yetki Durumu</label>
                                                            <select class="form-select" name="membership" id="membership" required>
                                                                <?php if ($allUsers[$i]->userRole == 1): ?>
                                                                    <option selected value="10">BABA</option>
                                                                <?php else: ?>
                                                                    <option <?php if ($allUsers[$i]->userRole == 2) { echo "selected"; } ?> value="2">Moderator</option>
                                                                    <option <?php if ($allUsers[$i]->userRole == 3) { echo "selected"; } ?> value="3">Admin</option>
                                                                    <option <?php if ($allUsers[$i]->userRole == 6) { echo "selected"; } ?> value="6">Owner</option>
                                                                    <option <?php if ($allUsers[$i]->userRole == 7) { echo "selected"; } ?> value="7">Senior Mod</option>
                                                                    <option <?php if ($allUsers[$i]->userRole == 4) { echo "selected"; } ?> value="4">Yönetici</option>
                                                                    <option <?php if ($allUsers[$i]->userRole == 5) { echo "selected"; } ?> value="5">Head Admin</option>
                                                                    <option <?php if ($allUsers[$i]->userRole == 8) { echo "selected"; } ?> value="8">Senior Admin</option>
                                                                    <option <?php if ($allUsers[$i]->userRole == 9) { echo "selected"; } ?> value="9">Senior Leader</option>
                                                                    <option <?php if ($allUsers[$i]->userRole == 10) { echo "selected"; } ?> value="10">Yardımcı</option>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-xxl-6">
                                                            <label for="multisecureCheck" class="form-label">Multi Secure</label>
                                                            <select class="form-select" name="multisecureCheck" id="multisecureCheck" required>
                                                                <option <?php if($allUsers[$i]->multiCheck == 0) { echo "selected"; } ?> value="0">Aktif</option>
                                                                <option <?php if($allUsers[$i]->multiCheck == 1) { echo "selected"; } ?> value="1">Pasif</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xxl-6">
                                                            <label for="status" class="form-label">Hesap Durumu</label>
                                                            <select class="form-select" name="status" id="status" required>
                                                                <option <?php if ($allUsers[$i]->userVerified == 0) { echo "selected"; } ?> value="0">Pasif</option>
                                                                <option <?php if ($allUsers[$i]->userVerified == 1) { echo "selected"; } ?> value="1">Aktif</option>
                                                                <option <?php if ($allUsers[$i]->userVerified == 2) { echo "selected"; } ?> value="2">Şüpheli</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xxl-6">
                                                            <label for="endTime" class="form-label">Bitiş Tarihi</label>
                                                            <input type="date" class="form-control" name="endTime" id="endTime" value="<?= $allUsers[$i]->userTime ?>">
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kapat</button>
                                                                <button type="submit" name="saveBtn" value="<?=$allUsers[$i]->id?>" class="btn btn-primary">Kaydet</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="resetIp" id="inlineRadio1" value="1">
                                                                <label class="form-check-label" for="inlineRadio1">IP Sıfırla</label>
                                                            </div>
                                                            <button type="button" onclick="copy('Kullanıcı Adı; <?= $allUsers[$i]->userName ?>\nAnahtar; <?= $allUsers[$i]->userAuthKey ?>\nÜyelik Tipi; <?= ZFunctions::converRoleViaInt($allUsers[$i]->userRole); ?> \nDomain; wsglobal.icu');" class="btn btn-primary waves-effect waves-light ri-file-copy-fill"></button>
                                                            <script>
                                                                function copy(text) {
                                                                    navigator.clipboard.writeText(text);
                                                                }
                                                            </script>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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
        $('#alternative-pagination').DataTable();
    });
</script>