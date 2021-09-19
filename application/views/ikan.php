<?php 
    $data['page'] = "ikan"; 
    $this->load->view("component/navbar");
    $this->load->view("component/sidebar",$data);
?>
<script>
    var ikan = [];
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Data ikan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#/apps?page=beranda">Home</a></li>
                <li class="breadcrumb-item active">Ikan</li>
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
                    <button type="button" class="btn bg-gradient-success" onclick="viewImport()"><i class="fa fa-file-excel"></i> Import</button>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
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
            <form method="post" id="ikan" action="ikan/save">
                <div class="modal-header">
                    <h5 class="modal-title">...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kode_ikan" required placeholder="Kode ikan">
                        <input type="hidden" name="kode_lama" required>
                        <input type="hidden" name="form_type" required value="create">
                    </div>
                    <div class="form-group">
                        <label>Nama<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_ikan" required placeholder="Nama ikan">
                    </div>
                    <div class="form-group">
                        <label>Link photo</label>
                        <div class="dropzone upload-photo"></div>
                        <input type="text" class="form-control" readonly name="photo">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi<span class="text-danger">*</span></label>
                        <textarea id="summernote" name="deskripsi"></textarea>
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
<div class="modal fade" id="modal-import">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import data ikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <a href="<?php echo base_url()?>assets/excel/Data-Ikan.xlsx"><i class="fa fa-download"></i> DOWNLOAD template excel</a>
                <div class="dropzone import-data"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    var table = null
    $(function () {
    $('#summernote').summernote({
        height: 150,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: true   
    })
    table = $('#data-table').DataTable({
        "dom": "<'row'<'col-sm-6'B><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url()?>ikan/data",
        "aoColumns": [
                { "data": "kode_ikan" },
                { "data": "nama_ikan" },
                { "data": "deskripsi" },
                {
                    "mData": "kode_ikan",
                    "mRender": function (data, type, row) {
                        ikan.push(row)
                        return '<div class="text-center"><button type="button" class="btn bg-gradient-warning btn-sm" onclick="viewForm(&#39;'+data+'&#39;)"><i class="fa fa-edit"></i></button>&nbsp;<button type="button" class="btn bg-gradient-danger btn-sm" onclick="deleteForm(&#39;'+data+'&#39;)"><i class="fa fa-trash"></i></button></div>'
                    }
                }
            ],
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    })
    
    $("form#ikan").submit(function(){
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
    $(".upload-photo").dropzone({ 
        url: "<?php echo base_url()?>ikan/photo",
        paramName: "file",
        dictDefaultMessage: "Klik / Letakkan photo ikan di sini.",
        acceptedFiles: "image/*",
        // maxFiles: 1,
        init: function () {
        this.on("success", function (file, response) {
            $('input[name=photo]').val(`${response.fileName}`)
        });
        
        this.on("error", function (file, error, xhr) {
            message('error','Gagal mengunggah photo')
        });
        }
    });
    $(".import-data").dropzone({ 
        url: "<?php echo base_url()?>ikan/import",
        paramName: "file",
        dictDefaultMessage: "Klik / Letakkan file excel (data ikan) di sini.",
        acceptedFiles: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel",
        // maxFiles: 1,
        init: function () {
        this.on("success", function (file, response) {
            Swal.fire(
                'Berhasil!',
                'Data ikan berhasil diunggah',
                'success'
            ).then((result) => {
                $('#modal-import').modal("hide")
                table.ajax.reload( null, false );
            })
        });
        
        this.on("error", function (file, error, xhr) {
            message('error','Gagal mengunggah data')
        });
        }
    });
});

function viewForm(kode){
    $('#modal-default').modal('show')
    $('.upload-photo').empty()
    var nama = null
    var deskripsi = null
    if(kode){
        ikan.forEach(key => {
            if(key.kode_ikan==kode){
                nama = key.nama_ikan
                deskripsi = key.deskripsi
            }
            
        });
        $("input[name=form_type]").val("update");
        $('.modal-title').text("Update data") 
    }else{
        nama = null
        deskripsi = null
        $("input[name=form_type]").val("create");
        $('.modal-title').text("Tambah data") 
    }
    $("input[name=photo]").val(null);
    $("input[name=kode_lama]").val(kode);
    $("input[name=kode_ikan]").val(kode);
    $("input[name=nama_ikan]").val(nama);
    $("textarea[name=deskripsi]").summernote('code', deskripsi);
}


function viewImport(){
    $('#modal-import').modal('show')
}

function deleteForm(kode){
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
            return fetch(`<?php echo base_url()?>ikan/delete/${kode}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json()
            })
            .catch(error => {
                Swal.showValidationMessage(
                    `Data ikan tidak dapat dihapus, karena digunakan sebagai referensi data lain.`
                )
            })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Dihapus!',
                'Data ikan berhasil dihapus',
                'success'
            ).then((result) => {
                table.ajax.reload( null, false );
            })
        }
    })
}

</script>