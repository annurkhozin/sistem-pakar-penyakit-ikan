<?php 
    $data['page'] = "admin"; 
    $this->load->view("component/navbar");
    $this->load->view("component/sidebar",$data);
?>
<script>
    var admin = [];
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Data Admin</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#/apps?page=beranda">Home</a></li>
                <li class="breadcrumb-item active">Admin sistem</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    <button type="button" class="btn bg-gradient-success" onclick="viewForm(null)"><i class="fa fa-plus"></i> Tambah</button>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Tipe akun</th>
                            <th class="text-center" style="width: 55px;">Aksi</th>
                        </tr>
                    </thead>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="admin" action="admin/save">
                <div class="modal-header">
                    <h5 class="modal-title">...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_lengkap" required placeholder="Nama Pengguna">
                    </div>
                    <div class="form-group">
                        <label>Username<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" required placeholder="Username">
                        <input type="hidden" name="kode_akun">
                        <input type="hidden" name="username_lama" required>
                        <input type="hidden" name="form_type" required value="create">
                    </div>
                    <div class="form-group">
                        <label>Password<span class="text-danger password">*</span></label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label>Tipe akun<span class="text-danger">*</span></label>
                        <select name="tipe_akun" class="form-control" required>
                            <option value="1">Admin</option>
                            <option value="0">User</option>
                        </select>
                    </div>
                    <p class="text-muted">Catatan: <span class="text-danger">*</span>(wajib diisi).</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    var table = null
    $(function () {
    table = $('#data-table').DataTable({
        "dom": "<'row'<'col-sm-6'B><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url()?>admin/data",
        "aoColumns": [
                { "data": "username" },
                { "data": "nama_lengkap" },
                {
                    "mData": "tipe_akun",
                    "mRender": function (data, type, row) {
                        return data==1 ? "Admin" : "User"
                    }
                },
                {
                    "mData": "kode_akun",
                    "mRender": function (data, type, row) {
                        admin.push(row)
                        return '<div class="text-center"><button type="button" class="btn bg-gradient-warning btn-sm" onclick="viewForm(&#39;'+data+'&#39;)"><i class="fa fa-edit"></i></button>&nbsp;<button type="button" class="btn bg-gradient-danger btn-sm" onclick="deleteForm(&#39;'+data+'&#39;)"><i class="fa fa-trash"></i></button></div>'
                    }
                }
            ],
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    })
    
    $("form#admin").submit(function(){
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
                Swal.fire(
                    'Berhasil!',
                    resp.message,
                    'success'
                ).then((result) => {
                    admin = []
                    table.ajax.reload( null, false );
                    $('#modal-default').modal('hide')
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

function viewForm(kode){
    $('#modal-default').modal('show')
    var username = null
    var nama_lengkap = null
    var tipe_akun = null
    if(kode){
        admin.forEach(key => {
            if(key.kode_akun==kode){
                tipe_akun = key.tipe_akun
                username = key.username
                nama_lengkap = key.nama_lengkap
            }
            
        });
        $("input[name=form_type]").val("update");
        $('.modal-title').text("Update data") 
        $('.password').hide() 
    }else{
        username = null
        nama_lengkap = null
        tipe_akun = null
        $("input[name=form_type]").val("create");
        $('.modal-title').text("Tambah data") 
        $('.password').show() 
    }
    $('select[name=tipe_akun]').val(tipe_akun) 
    $("input[name=kode_akun]").val(kode);
    $("input[name=tipe_akun]").val(tipe_akun);
    $("input[name=username_lama]").val(username);
    $("input[name=username]").val(username);
    $("input[name=nama_lengkap]").val(nama_lengkap);
}

function deleteForm(kode){
    var count_admin = 0
    var is_user = false
    const is_admin = []
    admin.forEach(key => {
        if(key.tipe_akun == 1 && !is_admin.includes(key.kode_akun)){
            is_admin.push(key.kode_akun)
            count_admin++
        }
        if(kode == key.kode_akun){
            is_user = key.tipe_akun=="0" ? true : false
        }
    });

    if(count_admin > 1 || is_user){
        Swal.fire({
            title: 'Anda Yakin?',
            text: "Data akan dihapus permanen",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Saja',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(`<?php echo base_url()?>admin/delete/${kode}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Data admin tidak dapat dihapus, karena digunakan sebagai referensi data lain.`
                    )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Dihapus!',
                    'Data admin berhasil dihapus',
                    'success'
                ).then((result) => {
                    admin = []
                    table.ajax.reload( null, false );
                })
            }
        })
    }else{
        Swal.fire(
            'Dilarang!',
            'Data admin tidak dapat dihapus, karena hanya terdapat 1 admin.',
            'warning'
        )
    }
    
}

</script>