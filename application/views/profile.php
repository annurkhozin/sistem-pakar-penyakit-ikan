<?php 
    $data['page'] = "profile"; 
    $this->load->view("component/navbar");
    $this->load->view("component/sidebar",$data);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Profile</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#/apps?page=beranda">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal" action="login/profileupdate" method="post" id="profile"> 
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama lengkap</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="nama_lengkap" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="username" placeholder="Username">
                          <input type="hidden" class="form-control" name="username_lama">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Ulangi</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" name="ulang_password" placeholder="Ulangi Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
    </section>
    <!-- /.content -->
</div>
<script>
    $(function () {
    fetch("<?php echo base_url()?>login/profiledata", {
        method: "GET",
        dataType: 'json',
        ContentType: 'application/json'
    })
    .then((resp) => {
        return resp.json();
    })
    .then((data) => {
        $("input[name=nama_lengkap]").val(data.nama_lengkap);
        $("input[name=username]").val(data.username);
        $("input[name=username_lama]").val(data.username);
    })
    $("form#profile").submit(function(){
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
                    'Berhasil!',
                    resp.message,
                    'success'
                ).then((result) => {
                    // console.log(resp)
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