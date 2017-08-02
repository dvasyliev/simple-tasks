<?php include DIR_TEMPLATE . '/common/header.php' ?>

<?php if( !$is_logged ): ?>
    <div class="container">
        <form class="form-horizontal form-signin" id="login-form" action="/admin/login" method="POST" >
            <div class="form-group">
                <label for="inputLogin" class="col-sm-2 control-label">Логин</label>
                <div class="col-sm-10">
                    <input type="login"
                           name="login"
                           class="form-control"
                           id="inputLogin"
                           placeholder="Логин">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Пароль</label>
                <div class="col-sm-10">
                    <input type="password"
                           name="password"
                           class="form-control"
                           id="inputPassword"
                           placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-default" value="Войти">
                </div>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php include DIR_TEMPLATE . '/common/footer.php' ?>