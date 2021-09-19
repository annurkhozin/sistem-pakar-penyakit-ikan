<?php 
    $data['page'] = "penyakit"; 
    $this->load->view("component/navbar");
    $this->load->view("component/sidebar",$data);
?>
<script>
    var penyakit = [];
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Data Penyakit</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#/apps?page=beranda">Home</a></li>
                <li class="breadcrumb-item active">Penyakit</li>
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
                            <th>Penanganan</th>
                            <th>Ikan</th>
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
            <form method="post" id="penyakit" action="penyakit/save">
                <div class="modal-header">
                    <h5 class="modal-title">...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kode_penyakit" required placeholder="Kode penyakit">
                        <input type="hidden" name="kode_lama" required>
                        <input type="hidden" name="form_type" required value="create">
                    </div>
                    <div class="form-group">
                        <label>Nama<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_penyakit" required placeholder="Nama Penyakit">
                    </div>
                    <div class="form-group">
                        <label>Terjadi pada Ikan<span class="text-danger">*</span></label>
                        <select name="kode_ikan" class="form-control" required>
                            <option value="">Pilih ikan</option>
                            <?php $ikan = $this->db->get("ikan")->result();
                                    foreach ($ikan as $key ) {?>
                                        <option value="<?php echo $key->kode_ikan?>"><?php echo $key->nama_ikan?></option>
                                    <?php }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Penanganan<span class="text-danger">*</span></label>
                        <textarea id="summernote" name="penanganan"></textarea>
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
                <h5 class="modal-title">Import data penyakit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <a href="<?php echo base_url()?>assets/excel/Data-Penyakit.xlsx"><i class="fa fa-download"></i> DOWNLOAD template excel</a>
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
        "ajax": "<?php echo base_url()?>penyakit/data",
        "aoColumns": [
                { "data": "kode_penyakit" },
                { "data": "nama_penyakit" },
                { "data": "penanganan" },
                { "data": "nama_ikan" },
                {
                    "mData": "kode_penyakit",
                    "mRender": function (data, type, row) {
                        penyakit.push(row)
                        return '<div class="text-center"><button type="button" class="btn bg-gradient-warning btn-sm" onclick="viewForm(&#39;'+data+'&#39;)"><i class="fa fa-edit"></i></button>&nbsp;<button type="button" class="btn bg-gradient-danger btn-sm" onclick="deleteForm(&#39;'+data+'&#39;)"><i class="fa fa-trash"></i></button></div>'
                    }
                }
            ],
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    })
    
    $("form#penyakit").submit(function(){
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
    $(".import-data").dropzone({ 
        url: "<?php echo base_url()?>penyakit/import",
        paramName: "file",
        dictDefaultMessage: "Klik / Letakkan file excel (data penyakit) di sini.",
        acceptedFiles: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel",
        // maxFiles: 1,
        init: function () {
        this.on("success", function (file, response) {
            Swal.fire(
                'Berhasil!',
                'Data penyakit berhasil diunggah',
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
    var nama = null
    var penanganan = null
    var kode_ikan = null
    if(kode){
        penyakit.forEach(key => {
            if(key.kode_penyakit==kode){
                nama = key.nama_penyakit
                penanganan = key.penanganan
                kode_ikan = key.kode_ikan
            }
            
        });
        $("input[name=form_type]").val("update");
        $('.modal-title').text("Update data") 
    }else{
        nama = null
        penanganan = null
        kode_ikan = null
        $("input[name=form_type]").val("create");
        $('.modal-title').text("Tambah data") 
    }
    $("input[name=kode_lama]").val(kode);
    $("input[name=kode_penyakit]").val(kode);
    $("input[name=nama_penyakit]").val(nama);
    $("select[name=kode_ikan]").val(kode_ikan);
    $("textarea[name=penanganan]").summernote('code', penanganan);
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
            return fetch(`<?php echo base_url()?>penyakit/delete/${kode}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json()
            })
            .catch(error => {
                Swal.showValidationMessage(
                    `Data penyakit tidak dapat dihapus, karena digunakan sebagai referensi data lain.`
                )
            })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Dihapus!',
                'Data penyakit berhasil dihapus',
                'success'
            ).then((result) => {
                table.ajax.reload( null, false );
            })
        }
    })
}

</script>