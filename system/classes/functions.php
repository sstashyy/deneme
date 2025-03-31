<?php

namespace sstashy;


class ZFunctions extends System{

	public static function checkSession() {
    if (!isset($_SESSION['userName'])) {
        http_response_code(401); 
        echo "o ananı bi sikerim varya UFFF TG: @sstashy";
        exit();
    }

}

public static function getUserViaSession() {

    
    $user = self::table('users')->where('userName', $_SESSION['userName'])->first();

    $adminURLs = array(
        "http://localhost/admin-users",
        "http://localhost/admin-create",
		"http://localhost/announcement"
    );

    if (in_array("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], $adminURLs) && (!$user || !in_array($user->userRole, [1, 10]))) {
        http_response_code(403); 
        echo "Erişim reddedildi!";
        exit();
    }

    $array = [
        'userName' => $user->userName,
        'userVerified' => $user->userVerified,
        'userModerator' => $user->userModerator,
        'userOS' => $user->userOS,
        'userBrowser' => $user->userBrowser,
        'userTime' => $user->userTime,
        'userRole' => $user->userRole,
        'userLog' => $user->userLog
    ];

    return $array;
}


    public static function convertUserRole() {
        $user = self::table('users')->where('userName', $_SESSION['userName'])->first();
        $userRoleInt = $user->userRole;

        $roleName = "";

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
            $roleName = "Senior Mod ";  
        } elseif($userRoleInt == 8) {
            $roleName = "Senior Admin ";  
        } elseif($userRoleInt == 9) {
            $roleName = "Senior Leader ";  
        } elseif($userRoleInt == 10) {
            $roleName = "Yardımcı";  
        }

        return $roleName;
    }

    public static function convertUserRoleViaId($id) {
        $idd = self::filter($id);
        $user = self::table('users')->where('id', $idd)->first();
        $userRoleInt = $user->userRole;

        $roleName = "";

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
            $roleName = "Senior Mod ";  
        } elseif($userRoleInt == 8) {
            $roleName = "Senior Admin ";  
        } elseif($userRoleInt == 9) {
            $roleName = "Senior Leader ";  
        } elseif($userRoleInt == 10) {
            $roleName = "Yardımcı";  
        }

        return $roleName;
    }

    public static function converRoleViaInt($x)
    {
        $x = self::filter($x);
        if ($x == 1) {
            $roleName = "BABA";
        }
        if ($x == 2) {
            $roleName = "Moderator";
        }
        if ($x == 3) {
            $roleName = "Admin";
        }
        if ($x == 4) {
            $roleName = "Yönetici";
        }
        if ($x == 5) {
            $roleName = "Head Admin";
        }
        if ($x == 6) {
            $roleName = "Owner";
        }
        if ($x == 7) {
            $roleName = "Senior Mod";
        }
        if ($x == 8) {
            $roleName = "Senior Admin";
        }
        if ($x == 9) {
            $roleName = "Senior Leader";
        }
        if ($x == 10) {
            $roleName = "Yardımcı";
        }

        return $roleName;
    }
    
    public static function updateUser() {
        $name = self::filter($_POST['userNameM']);
        $anahtar = self::filter($_POST['anahtarKey']);
        $id = self::filter($_POST['saveBtn']);
        $yetki = self::filter($_POST['membership']);
        $hesapDurumu = self::filter($_POST['status']);
        $endTime = self::filter($_POST['endTime']);
        $resetIp = isset($_POST['resetIp']) ? self::filter($_POST['resetIp']) : null; // Handle optional field
        $multiCheck = isset($_POST['multisecureCheck']) ? self::filter($_POST['multisecureCheck']) : 0; // Default to 0 if not set

        $today = date('Y-m-d');

        switch ($yetki) {
            case 2:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 3:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 4:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 5:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 6:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 7:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 8:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 9:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 10:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
        }

        $updateData = [
            'userAuthKey' => $anahtar,
            'userName' => $name,
            'userVerified' => $hesapDurumu,
            'userTime' => $endTime,
            'userRole' => $yetki,
            'multiCheck' => $multiCheck
        ];

        if ($resetIp) {
            $updateData['userLog'] = null;
        }

        self::table('users')->where('id', $id)->update($updateData);
        return "Başarılı";
    }
    
    public static function deleteUser($id) {
        $id = self::filter($id);
        self::table('users')->where('id', $id)->delete();
        return "Başarılı";
    }

    public static function createuser() {
        $kullaniciAdi = self::filter($_POST['userName']);
        $uyelikTipi = self::filter($_POST['uyelikTipi']);
        $moderator = isset($_POST['userModerator']) ? self::filter($_POST['userModerator']) : 'default_moderator_value'; // Add default value
        $authAnahtar = bin2hex(random_bytes(length: 7));
        $endTime = "";

        $today = date('Y-m-d');
        $private = date('');

        switch ($uyelikTipi) {
            case 2:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 3:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 4:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 5:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 6:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 7:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 8:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 9:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
            case 10:
                $endTime = date('9999-09-09', strtotime($today . ''));
                break;
        }

        $createUser = self::table('users')->create([
            'userName' => $kullaniciAdi,
            'userRole' => $uyelikTipi,
            'userModerator' => $moderator,
            'userAuthKey' => $authAnahtar,
            'userTime' => $endTime,
            'userVerified' => 1
        ]);
    }


public static function adminControl() {
    if (!isset($_SESSION['userName'])) {
        http_response_code(401); 
        echo "Yetkisiz erişim!";
        exit();
        die();
    }

    $User = self::filter($_SESSION['userName']);
    $userInfo = self::table('users')->where('userName', $User)->first();

    if (!$userInfo || !in_array($userInfo->userRole, [1])) {
        http_response_code(403); 
        echo "Erişim reddedildi!";
        exit();
        die();
    }
}





    public static function roleControl() {
        $User = self::filter(@$_SESSION['userName']);
        $userInfo = self::table('users')->where('userName', $User)->first();
        if($userInfo->userRole == 0 || $userInfo->userVerified == 0){
            header("Location: /login");
            session_destroy();
            @ob_clean();
            exit();
        }
    }

    public static function authControl() {
        $User = self::filter(@$_SESSION['userName']);
        if($User) {
            return true;
        } else {
            header("Location: /login");
            session_destroy();
            @ob_clean();
            exit();
        }
        $userInfo = self::table('users')->where('userName', $User)->first();
        if(!$userInfo) {
            header("Location: /login");
            session_destroy();
            @ob_clean();
            exit();
        }
    }
    public static function getUserID($name) {
        // Roblox profil sayfasına yapılan istek
        $url = "https://www.roblox.com/users/profile?username=" . urlencode($name);
        
        // cURL başlat
        $ch = curl_init($url);
        
        // cURL ayarları
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  // Yönlendirmeleri takip et
        $response = curl_exec($ch);
        
        // cURL hatası kontrolü
        if(curl_errno($ch)) {
            curl_close($ch);
            return null; // Hata durumunda null döndür
        }
        
        // HTTP durum kodu kontrolü
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            curl_close($ch);
            return null; // Geçersiz yanıt durumunda null döndür
        }
        
        // cURL işlem tamamlandığında, URL'yi al
        $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        
        // Kullanıcı ID'sini URL'den çek
        preg_match('/\d+/', $finalUrl, $matches);
        
        // Eğer ID bulunursa, döndür
        if (!empty($matches)) {
            curl_close($ch);
            return $matches[0];
        } else {
            curl_close($ch);
            return null; // ID bulunamazsa null döndür
        }
    }
    public static function getAvatarImageUrl($userId) {
        // Profil resmini almak için URL
        $url = "https://thumbnails.roblox.com/v1/users/avatar-headshot?userIds=" . urlencode($userId) . "&size=48x48&format=Png&isCircular=false";
        
        // cURL başlat
        $ch = curl_init($url);
        
        // cURL ayarları
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  // Yönlendirmeleri takip et
        $response = curl_exec($ch);
        
        // cURL hatası kontrolü
        if(curl_errno($ch)) {
            curl_close($ch);
            return null; // Hata durumunda null döndür
        }
        
        // HTTP durum kodu kontrolü
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            curl_close($ch);
            return null; // Geçersiz yanıt durumunda null döndür
        }
        
        // JSON yanıtını çözümle
        $data = json_decode($response, true);
        
        // Eğer veri varsa ve 'imageUrl' mevcutsa, döndür
        if (isset($data['data'][0]['imageUrl'])) {
            curl_close($ch);
            return $data['data'][0]['imageUrl'];
        } else {
            curl_close($ch);
            return null; // imageUrl bulunamazsa null döndür
        }
    }
    
    
    public static function apiControl() {
        session_start();
        $User = self::filter(@$_SESSION['userName']);
        if($User) {
            return true;
        } else {
            return false;
        }
    }

    public static function logOut() {
        session_destroy();
        @ob_clean();
        header("Location: /login");
        exit();
    }

    public static function isAllowed($ip) {
        $whitelist = array('45.141.149.219');

        if(in_array($ip, $whitelist)) {
            return true;
        }

        foreach($whitelist as $i){
            $wildcardPos = strpos($i, "*");

            if($wildcardPos !== false && substr($ip, 0, $wildcardPos) . "*" == $i) {
                return true;
            }
        }

        return false;
    }

    public static function getIp() {
        $ip = "";
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }
}