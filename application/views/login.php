<div class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><b>Sistem Pakar Ikan</b></a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Login dengan akun Anda</p>
    
          <form method="post" action="login/cekLogin" id="login">
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
            <div class="social-auth-links text-center pt-3 mt-3 mb-3">
                <button type="submit" href="#" class="btn btn-block btn-primary">
                    <i class="fa fa-lock mr-2"></i> MASUK
                </button>
            </div>
            
            <div class="social-auth-links text-center">
              <br>
              <br>
              <p>- OR -</p>
              <a href="#/apps?page=login/register">
                Daftar akun baru
              </a>
              ||
              <a href="#/apps?page=beranda">
                <i class="fa fa-home"></i> Beranda
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
    $("form#login").submit(function(){
        const data = $(this).serialize()
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            type:$(this).attr("method"),
            beforeSend: function() {
                $("button").attr("disabled",true);
            },
            complete:function() {
                $("button").attr("disabled",false);								
            },
            success:function(resp) {
                message("success", resp.message)
                setTimeout(
                  window.location = '#/apps?page=beranda'
                ,2000);
            
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