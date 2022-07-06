
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= site()->title() ?></title>
    <?= css('/assets/bootstrap-5.0.0-beta2-dist/css/bootstrap.css'); ?>
</head>
<body style="margin-top:50px">
    


<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-4" style>
        <div class="col-md-12">
            <form id="login-form" class="form" action="<?= $page->url() ?>" method="post">
            <img src="assets/images/FIZ-logo_0400x145.png" style="display: block;margin-left: auto; margin-right: auto;">
            <h1 class="text-center" style="margin:50px 0px;"><?= $page->title()->html() ?></h1>

            <?php if($error): ?>
            <div class="alert alert-danger"><?= $page->alert()->kirbytext() ?></div>
            <?php endif ?>


            <div class="form-group">
                <label for="email"><?= $page->username()->html() ?></label>
                <input type="email" id="email" name="email" class="form-control" value="<?= esc(get('email')) ?>" placeholder="trainer@fiz.de" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password"><?= $page->password()->html() ?></label>
                <input type="password" id="password" name="password" class="form-control" value="<?= esc(get('password')) ?>"  autocomplete="off">
            </div>
            <div class="form-group" style="margin-top:10px;">
                 <input type="submit" class="btn btn-primary btn-md" name="login" value="<?= $page->button()->html() ?>">
            </div>
            </form>
        </div>
        </div>
    </div>
</div>
</body>
</html>
