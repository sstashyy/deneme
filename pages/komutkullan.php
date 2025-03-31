<?php
require_once "ayar.php";
use sstashy\ZFunctions;
$userDetails = ZFunctions::getUserViaSession();
// Kullanılabilir komutları çek
$userRole = $userDetails['userRole'];
$query = $db->query("SELECT id, command_name, command_code, allowed_roles FROM commands");
$commands = $query->fetchAll(PDO::FETCH_ASSOC);

// Komutu çalıştırma fonksiyonu
$result = "";
$lastCommand = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $commandId = $_POST['command_id'];
    $arguments = isset($_POST['arguments']) ? $_POST['arguments'] : [];

    // Seçilen komutun izin verilen rollerini al
    $selectedCommand = array_filter($commands, function($command) use ($commandId) {
        return $command['id'] == $commandId;
    });

    if (!empty($selectedCommand)) {
        $selectedCommand = array_shift($selectedCommand);
        $allowedRoles = explode(',', $selectedCommand['allowed_roles']);

        // Kullanıcı rolü izin verilen rollerin içinde mi kontrol et
        if (in_array($userRole, $allowedRoles)) {
            // Komutu çalıştır
            $result = executeCommand($commandId, $arguments);
        } else {
            $result = "Bu komutu kullanma yetkiniz yok.";
        }
    }
}
?>

<!-- Komut Çalıştırma Tablosu -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Komut Listesi</h5>
                </div>
                <table class="table table-striped table-bordered table-hover" id="dataTables-command">
                    <thead>
                        <tr>
                            <th>Komut İsmi</th>
                            <th>Kullanabilirlik</th>
                            <th>Kullan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commands as $command) { 
                            $allowedRoles = explode(',', $command['allowed_roles']);
                            $isUsable = in_array($userRole, $allowedRoles) ? "Evet" : "Hayır";
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($command['command_name']) ?></td>
                            <td>
                                <?php if ($isUsable == "Evet") { ?>
                                    <button class="btn btn-outline-success btn-sm disabled">Evet</button>
                                <?php } else { ?>
                                    <button class="btn btn-outline-danger btn-sm disabled">Hayır</button>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($isUsable == "Evet") { ?>
                                <button class="btn btn-primary btn-sm" data-id="<?= $command['id'] ?>" data-code="<?= htmlspecialchars($command['command_code']) ?>">Kullan</button>
                                <?php } else { ?>
                                <button class="btn btn-secondary btn-sm" disabled>Kullan</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <!-- Komut Çalıştırma Formu -->
                <form method="POST" id="commandForm" style="display: none;">
                    <input type="hidden" name="command_id" id="commandId">
                    <!-- Dinamik argüman giriş alanları buraya eklenecek -->
                    <div id="argumentsContainer"></div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mt-4">execute</button>
                </form>

                <!-- Çıktı Gösterme Alanı -->
                <?php if (!empty($result)) { ?>
                    <div class="form-floating mt-4">
                        <textarea class="form-control" id="outputTextarea" style="height: 200px;" readonly><?= htmlspecialchars($result) ?></textarea>
                        <label for="outputTextarea">Sonuç</label>
                    </div>
                <?php } ?>

                <!-- En Son Kullanılan Komut Alanı -->
                <?php if (!empty($lastCommand)) { ?>
                    <div class="form-floating mt-4">
                        <textarea class="form-control" id="lastCommandTextarea" style="height: 200px;" readonly><?= htmlspecialchars($lastCommand) ?></textarea>
                        <label for="lastCommandTextarea">En Son Kullanılan Komut</label>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-primary').forEach(button => {
    button.addEventListener('click', function() {
        var commandId = this.getAttribute('data-id');
        var commandCode = this.getAttribute('data-code');

        // (arg) formatında değişkenleri bul
        var matches = commandCode.match(/\((.*?)\)/g);
        var container = document.getElementById("argumentsContainer");
        container.innerHTML = ""; // Önceki inputları temizle

        if (matches) {
            matches.forEach(function(arg) {
                var argName = arg.replace(/\(|\)/g, ""); // Parantezleri kaldır
                var div = document.createElement("div");
                div.className = "form-floating mb-3";
                div.innerHTML = `<input type="text" class="form-control" name="arguments[${argName}]" required>
                                 <label for="argInput">${argName} Girin</label>`;
                container.appendChild(div);
            });
        }

        document.getElementById("commandId").value = commandId;
        document.getElementById("commandForm").style.display = "block";
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>