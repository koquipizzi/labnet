
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <?php

    use app\assets\admin\page\SignAsset;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    app\assets\AppAsset::register($this);
    dmstr\web\AdminLteAsset::register($this);
   // app\assets\AdminLtePluginAsset::register($this);
    dmstr\web\AdminLteAsset::register($this);
   // app\assets\AdminLtePluginAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
   ?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Lab</b>NET</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Inicie Sesión</p>

       <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => ['template'=>'']
    ]); ?>
                  <?= $form->field($model, 'username',[
                'template' => '            
                    <div class="form-group">
                        <div class="input-group input-group-lg rounded no-overflow">
                            {input}
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        </div>
                    </div>
                ',
            ])->textInput(['autofocus' => true,'placeholder'=>'Nombre de Usuario']); ?>            
            
            <?= $form->field($model, 'password',[
                'template' => '            
                    <div class="form-group">
                        <div class="input-group input-group-lg rounded ">
                            {input}
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        </div>
                    </div>
                ',
            ])->passwordInput(['placeholder'=>'Contraseña']); ?>
    
      <div class="row">
       <div class="col-xs-1">
       </div>
        <div class="col-xs-6">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Recordarme
            </label>
          </div>
        </div>
        <!-- /.col -->
        
        <!--</div>-->

        <div class="col-xs-4">
            <?= Html::submitButton('Acceder', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-btn']) ?>
        </div>
        <!-- /.col -->
      </div>
     <?php ActiveForm::end(); ?>
    <!-- /.social-auth-links -->
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
