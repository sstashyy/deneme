<?php
use sstashy\System;
use sstashy\ZFunctions;

if (!isset($_SESSION['authKey'])) {
    header("Location: /login");
    exit();
}

$userDetails = ZFunctions::getUserViaSession();

if (!empty($userDetails) && isset($userDetails['userName'])) {
    $userName = $userDetails['userName'];

    function kullanicirol(){
        global $db;
        if (isset($_COOKIE["userName"]) && isset($_COOKIE["userAuthKey"])) {
            $kadi = $_COOKIE["userName"];
            $sifre = $_COOKIE["userAuthKey"];
            $query = $db->prepare("SELECT * FROM users WHERE userName = :userName AND userAuthKey = :userAuthKey");
            $query->execute(array(':userName' => $kadi, ':userAuthKey' => $sifre));
            $kullanicibilgisi = $query->fetch(PDO::FETCH_ASSOC);
            return $kullanicibilgisi;
        } else {
            return false;
        }
    }

    function GetIP() {
        $ip = '';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $ip = explode(',', $ip);
        $ip = trim($ip[0]);
        return $ip;
    }

    function logCommand($commandId, $commandName, $commandCode, $arguments, $output) {
        global $db, $userName; // Use the global $userName to log the username of the person executing the command
        $tarih = date('Y-m-d H:i:s');
        $query = $db->prepare("INSERT INTO command_logs (command_id, command_name, command_code, arguments, output, executed_at, executed_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $query->execute([$commandId, $commandName, $commandCode, json_encode($arguments), $output, $tarih, $userName]);
    }


    function listCommands() {
        global $db;
        $query = $db->query("SELECT * FROM commands ORDER BY id DESC", PDO::FETCH_ASSOC);
        return $query->fetchAll();
    }
    
    function deleteCommand($id) {
        global $db;
        $query = $db->prepare("DELETE FROM commands WHERE id = ?");
        return $query->execute([$id]);
    }

    function addCommand($commandName, $commandCode, $description, $allowedRoles) {
        global $db;
        $query = $db->prepare("INSERT INTO commands (command_name, command_code, description, allowed_roles, created_at) VALUES (?, ?, ?, ?, NOW())");
        return $query->execute([$commandName, $commandCode, $description, $allowedRoles]);
    }

    function executeCommand($commandId, $arguments) {
        global $db, $userName;

        // Komutu veritabanından çek
        $query = $db->prepare("SELECT command_name, command_code FROM commands WHERE id = ?");
        $query->execute([$commandId]);
        $command = $query->fetch(PDO::FETCH_ASSOC);

        if (!$command) {
            return "Hata: Komut bulunamadı!";
        }

        // Komut kodunu al
        $commandCode = $command['command_code'];

        // Komuttaki argümanları değiştir
        foreach ($arguments as $key => $value) {
            $commandCode = str_replace("($key)", escapeshellcmd($value), $commandCode);
        }

        // cURL işlemini başlat
        $ch = curl_init();

        // URL'yi bul
        preg_match('/https?:\/\/[^\s"]+/', $commandCode, $urlMatch);
        if (empty($urlMatch)) {
            return "Hata: Geçerli bir URL bulunamadı!";
        }
        $url = $urlMatch[0];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // HTTP Metodunu Bul
        if (preg_match('/(-X|--request) (\w+)/', $commandCode, $methodMatch)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($methodMatch[2]));
        }

        // Header'ları Bul
        if (preg_match_all('/(-H|--header) "([^"]+)"/', $commandCode, $headerMatches)) {
            $headers = $headerMatches[2];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        // Body Verisini Bul
        if (preg_match('/(-d|--data) \'([^\']+)\'/', $commandCode, $dataMatch)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataMatch[2]);
        }

        // cURL isteğini çalıştır
        $output = curl_exec($ch);

        // Hata kontrolü
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            logCommand($commandId, $command['command_name'], $commandCode, $arguments, $error_msg, $userName);
            return "cURL Hatası: " . $error_msg;
        }
        else{
            
            logCommand($commandId, $command['command_name'], $commandCode, $arguments, $output, $userName);
        }

        curl_close($ch);

        // Komut çıktısını logla

        return $output ? $output : "Komut çalıştırıldı, ancak bir çıktı alınamadı.";
    }
}
?>