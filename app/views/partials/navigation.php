
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="#">
        <img src="/images/logo_eagle_w.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Falcon Cloud <span class="text-muted">Storage</span>
    </a>
    <div class="ml-auto">
        <?php if ($page == "login") : ?>
            <a href="/register" class="btn btn-secondary">Register</a>
        <?php elseif ($page == "register") : ?>
            <a href="/" class="btn btn-green text-white">Login</a>
        <?php endif; ?>       
    </div>
</nav>