<div class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><b>Sistem Pakar Ikan</b></a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Daftar Akun Baru</p>
    
          <form method="post" action="login/registerbaru" id="register">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="username" placeholder="Username">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="password" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="ulang_password" placeholder="Ulangi Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="social-auth-links text-center pt-3 mt-3 mb-3">
                <button type="submit" href="#" class="btn btn-block btn-danger">
                    <i class="fa fa-lock mr-2"></i> DAFTAR
                </button>
            </div>
            
            <div class="social-auth-links text-center">
              <br>
              <br>
              <p>- OR -</p>
              <a href="#/apps?page=login">
                Sudah punya akun ?
              </a>
            </div>
        </form>
    
          <!-- /.social-auth-links -->
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
</div>
<script type="text/javascript">
$(function(){
    $("form#register").submit(function(){
        const data = $(this).serializeArray()
        $.ajax({
            url: $(this).attr("action"),
            data: data,
            type:$(this).attr("method"),
            beforeSend: function() {
                $("button").attr("disabled",true);
            },
            complete:function() {
                $("button").attr("disabled",false);								
            },
            success:function(resp) {
              Swal.fire(
                  'Sukses!',
                  resp.message,
                  'success'
              ).then((result) => {
                window.location = '#/apps?page=login'
              })
            
            },
            error:function(error) {
                $("button").attr("disabled",false);
                message("error", error.responseJSON.message)
            }
        })
    return false;
    });
});
</script>