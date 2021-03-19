<header>
    <div class="container top-menu">
        <div class="nav">
            <a href="/">Главная</a>
        </div>
    </div>
    <div class="container middle">
        <div class="logo">
            <img src="/public/img/system/logo.png" alt="Logo">
            <span>SyncEcosystem</span>
        </div>
        <div class="auth-checkout">
            <?php if($_COOKIE['login'] == ''): ?>
            <a href="/user/auth">
                <button class="btn auth">Войти</button>
            </a>

            <?php else: ?>
            <!--
            <a href="/user/reg">
                <button class="btn">Регистрация</button>
            </a>-->

            <a href="/user/dashboard">
                <button class="btn dashboard">Кабинет</button>
            </a>
            <?php endif; ?>
        </div>
    </div>
</header>