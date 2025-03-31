<?php 
use sstashy\ZFunctions; 
$userDetails = ZFunctions::getUserViaSession();
?>
<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-secondary navbar-dark">
            <a href="index.html" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Türk Sohbet</h3>
            </a>
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative">
                    <img class="rounded-circle me-lg-2" src="<?php echo isset($_SESSION['avatarImage']) ? $_SESSION['avatarImage'] : 'purna.png'; ?>" alt="Avatar" style="width: 48px; height: 48px;">
                    <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0"><?php echo htmlspecialchars($userDetails['userName']); ?></h6>
                    <span><?php echo htmlspecialchars(ZFunctions::convertUserRole()); ?></span>
                </div>
            </div>
            <div class="navbar-nav w-100">
                <a href="/" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Ana Sayfa</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>İşlemler</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/usecmd" class="dropdown-item">Komut Kullan</a>
                        <?php if ($userDetails['userRole'] == 1): ?>
                            <a href="/addcmd" class="dropdown-item">Komut Ekle</a>
                            <a href="/delcmd" class="dropdown-item">Komut Sil</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($userDetails['userRole'] == 1): ?>
                    <a href="/users" class="nav-item nav-link"><i class="fa fa-users me-2"></i>Kullanıcılar</a>
                    <a href="/logs" class="nav-item nav-link"><i class="fa fa-database me-2"></i>Loglar</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
    <!-- Sidebar End -->
</div>