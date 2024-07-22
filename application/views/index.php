<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Stem CRM | Webapp</title>
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?=base_url();?>assets/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?=base_url();?>assets/css/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?=base_url();?>assets/css/adminlte.min.css">
        <style>
           /* body{background:url('https://picsum.photos/1280/1024.webp?random=1') center/cover no-repeat fixed;align-items:center;min-height:100vh;} */
           button.btn.btn-primary.btn-block, input.form-control {border-radius: 23px;}
           body {
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        </style>
    </head>
    <body class="hold-transition login-page">
  
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <img src="https://stemlearning.in/wp-content/uploads/2020/07/stem-new-logo-2-1.png" width="70%" />
                    <a href="#" class="h1"><b>CRM</b>App</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <?=form_open('Menu/login')?>
                    <div class="input-group mb-3">
                        <input type="text" name="user" class="form-control" placeholder="User ID">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa-solid fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <br>
                        <br>
                        <hr>
                        
                        <div class="col-12">
                          <?php if ($this->session->flashdata('error_message')) { ?>
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong><?php echo $this->session->flashdata('error_message'); ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <?php } ?>
                          </div>

                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.social-auth-links -->
                
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    <!-- jQuery -->
    <script src="https://stemapp.in/assets/js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://stemapp.in/assets/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://stemapp.in/assets/js/adminlte.min.js"></script>
    <script>
   document.addEventListener('DOMContentLoaded', function() {
            var images = [
                'https://stemapp.in/assets/image/login/2.jpg',
                'https://stemapp.in/assets/image/login/3.jpg',
                'https://stemapp.in/assets/image/login/4.jpg',
                'https://stemapp.in/assets/image/login/5.jpg',
                'https://stemapp.in/assets/image/login/6.jpg',
                'https://stemapp.in/assets/image/login/7.jpg',
                'https://stemapp.in/assets/image/login/8.jpg',
                'https://stemapp.in/assets/image/login/9.jpg'
            ].sort(() => .5 - Math.random());
            var randImage = images[0];
            document.body.style.backgroundImage = 'url(' + randImage + ')';
        });

</script>
</body>
</html>