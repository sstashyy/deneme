<?php

require_once "ayar.php";
use sstashy\ZFunctions;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $commandName = trim($_POST["command_name"]);
    $commandCode = trim($_POST["command_code"]);
    $description = trim($_POST["description"]);
    $allowedRoles = isset($_POST["allowed_roles"]) ? implode(",", $_POST["allowed_roles"]) : "";

    if (!empty($commandName) && !empty($commandCode)) {
        if (addCommand($commandName, $commandCode, $description, $allowedRoles)) {
            echo "<script>alert('Komut başarıyla eklendi.'); window.location.href='/addcmd';</script>";
        } else {
            echo "<script>alert('Komut eklenirken hata oluştu.');</script>";
        }
    } else {
        echo "<script>alert('Lütfen tüm zorunlu alanları doldurun.');</script>";
    }
}
ZFunctions::adminControl();
?>

<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-8 mx-auto">
            <div class="bg-secondary rounded h-100 p-4 shadow">
                <h6 class="mb-4 text-center">Komut Ekle</h6>
                <form method="POST">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="align-middle"><label for="floatingName">Komut İsmi</label></td>
                                <td>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="command_name" id="floatingName" placeholder="Komut İsmi" required>
                                        <label for="floatingName">Komut İsmi</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle"><label for="floatingDesc">Komut Açıklaması</label></td>
                                <td>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="description" id="floatingDesc" placeholder="Komut Açıklaması">
                                        <label for="floatingDesc">Komut Açıklaması</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle"><label>Hangi Yetkiler Kullanabilecek</label></td>
                                <td>
                                    <!-- Yetki Seçimi -->
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allowed_roles[]" value="10" id="role1">
                                            <label class="form-check-label" for="role1">Yardımcı</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allowed_roles[]" value="9" id="role2">
                                            <label class="form-check-label" for="role2">Senior Leader</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allowed_roles[]" value="8" id="role3">
                                            <label class="form-check-label" for="role3">Senior Admin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allowed_roles[]" value="7" id="role4">
                                            <label class="form-check-label" for="role4">Senior Mod</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allowed_roles[]" value="6" id="role5">
                                            <label class="form-check-label" for="role5">Owner</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allowed_roles[]" value="5" id="role6">
                                            <label class="form-check-label" for="role6">Head Admin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allowed_roles[]" value="4" id="role7">
                                            <label class="form-check-label" for="role7">Yönetici</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allowed_roles[]" value="3" id="role8">
                                            <label class="form-check-label" for="role8">Admin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allowed_roles[]" value="2" id="role9">
                                            <label class="form-check-label" for="role9">Mod</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle"><label for="floatingTextarea">Curl Komudu</label></td>
                                <td>
                                    <div class="form-floating">
                                        <textarea class="form-control" name="command_code" placeholder="Leave a comment here" id="floatingTextarea" style="height: 150px;" required></textarea>
                                        <label for="floatingTextarea">Curl Komudu</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <!-- Form Gönderme Butonu -->
                                    <button type="submit" class="btn btn-primary py-3 w-100 mt-4">Komut Ekle</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>