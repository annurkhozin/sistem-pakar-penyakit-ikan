<?php 
    $data['page'] = "rule"; 
    $this->load->view("component/navbar");
    $this->load->view("component/sidebar",$data);
?>
<script>
    var rules = [];
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Rules (Forward Chaining)</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#/apps?page=beranda">Home</a></li>
                <li class="breadcrumb-item active">Rule sistem</li>
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
                            <th>Ikan</th>
                            <th>Kode rule</th>
                            <th>IF</th>
                            <th>THEN</th>
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
            <form method="post" id="rule" action="rule/save">
                <div class="modal-header">
                    <h5 class="modal-title">...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kode_rule" required placeholder="Kode Rule">
                        <input type="hidden" name="kode_lama">
                        <input type="hidden" name="form_type" value="cretae">
                    </div>
                    <div class="form-group">
                        <label>Ikan<span class="text-danger">*</span></label>
                        <select name="kode_ikan" class="form-control pilih-ikan" required>
                            <option value="">Pilih ikan</option>
                            <?php $ikan = $this->db->get("ikan")->result();
                                    foreach ($ikan as $key ) {?>
                                        <option value="<?php echo $key->kode_ikan?>"><?php echo $key->nama_ikan?></option>
                                    <?php }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>IF (Gejala)<span class="text-danger">*</span></label>
                        <div class="h-50 card card-warning card-gejala" id="accordion">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a class="d-block w-100 collapsed expanse-gejala" data-toggle="collapse" href="#collapseOne" aria-expanded="false">
                                    Pilih Gejala apa saja yang terjadi
                                    </a>
                                </h4>
                                <div class="card-tools">
                                    <a class="d-block w-100 collapsed expanse-gejala" data-toggle="collapse" href="#collapseOne" aria-expanded="false">
                                        <i class="fas fa-angle-double-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div id="collapseOne" class="collapse show" data-parent="#accordion" style="">
                                <ul class="pilih-gejala" style="list-style-type:none;"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>THEN<span class="text-danger">*</span></label>
                        <select name="then_penyakit" class="form-control data-penyakit" required>
                            <option value="">Pilih Penyakit</option>
                        </select>
                    </div>
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
    var data_penyakit = null
    var data_gejala = null
  $(function () {
    
    fetch("<?php echo base_url()?>penyakit/get", {
        method: "GET",
        dataType: 'json',
        ContentType: 'application/json'
    })
    .then((resp) => {
        return resp.json();
    })
    .then((data) => {
        data_penyakit = data
    })
    fetch("<?php echo base_url()?>gejala/get", {
        method: "GET",
        dataType: 'json',
        ContentType: 'application/json'
    })
    .then((resp) => {
        return resp.json();
    })
    .then((data) => {
        data_gejala = data
    })
    $('#sortable-div .sortable-list').sortable({
        connectWith: '#sortable-div .sortable-list',
        placeholder: 'placeholder',
        stop: function(event, ui) {
            var group_rule = $("ul.container-rule li")
            var data_rule = [];
            group_rule.each(function() { 
                data_rule.push($(this).data("id"))
            });
        },
        
    });
    table = $('#data-table').DataTable({
        "dom": "<'row'<'col-sm-6'B><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url()?>rule/data",
        "aoColumns": [
                { "data": "nama_ikan" },
                { "data": "kode_rule" },
                {
                    "mData": "gejala",
                    "mRender": function (data, type, row) {
                        return data.map(function(key){ return ` ${key}`; })
                    }
                },
                { "data": "kode_penyakit" },
                {
                    "mData": "kode_rule",
                    "mRender": function (data, type, row) {
                        rules.push(row)
                        return '<div class="text-center"><button type="button" class="btn bg-gradient-warning btn-sm" onclick="viewForm(&#39;'+data+'&#39;)"><i class="fa fa-edit"></i></button>&nbsp;<button type="button" class="btn bg-gradient-danger btn-sm" onclick="deleteForm(&#39;'+data+'&#39;)"><i class="fa fa-trash"></i></button></div>'
                    }
                }
            ],
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    })
    
    $("form#rule").submit(function(){
        var kode_rule = $('input[name=kode_rule]').val()
        var form_type = $('input[name=form_type]').val()
        var kode_lama = $('input[name=kode_lama]').val()
        var kode_ikan = $('select[name=kode_ikan]').val()
        var then_penyakit = $('select[name=then_penyakit]').val()
        var if_gejala = [];
        const data = $("form#rule").serializeArray()
        const not_allowed = ["ikan","kode_ikan","kode_rule","then_penyakit","kode_lama","form_type"]
        data.forEach(key => {
            if(!not_allowed.includes(key.name) ){
                if_gejala.push(key.name)
            }
        });
        if(!kode_rule){
            message("error", "Kode rule wajib diisi")
        }else if(if_gejala.length < 1){
            message("error", "IF (rule) wajib diisi minimal 1 gejala")
        }else if(!then_penyakit){
            message("error", "Penyakit wajib dipilih")
        }else if(!kode_ikan){
            message("error", "Ikan wajib dipilih")
        }else{
            const data = {
                kode_rule: kode_rule,
                kode_ikan: kode_ikan,
                kode_lama: kode_lama,
                form_type: form_type,
                then_penyakit: then_penyakit,
                if_gejala: if_gejala.toString(),
            }
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
                        rules = [];
                        table.ajax.reload( null, false );
                        $('#modal-default').modal('hide')
                    })
                },
                error:function(error) {
                    $("button").attr("disabled",false);
                    message("error", error.responseJSON.message)
                }
            })
        }
    return false;
    });
});

function viewForm(kode){
    fetch("<?php echo base_url()?>gejala/get", {
        method: "GET",
        dataType: 'json',
        ContentType: 'application/json'
    })
    .then((resp) => {
        return resp.json();
    })
    .then((data) => {
        
    })
    
    $('#modal-default').modal('show')
    var kode_penyakit = null
    var kode_ikan = null
    if(kode){
        rules.forEach(key => {
            if(key.kode_rule==kode){
                kode_penyakit = key.kode_penyakit
                kode_ikan = key.kode_ikan
            }
            
        });
        $("input[name=form_type]").val("update");
        $('.modal-title').text("Update rule") 
        $('.password').hide() 
    }else{
        kode_penyakit = null
        kode_ikan = null
        $("input[name=form_type]").val("create");
        $('.modal-title').text("Tambah rule") 
        $('.password').show() 
    }

    $("select.data-penyakit").empty()
    $("ul.pilih-gejala").empty()
    var data_rules = []
    rules.forEach(key => {
        if(kode == key.kode_rule){
            data_rules = key.gejala
        }
    });
    data_gejala.forEach(key => {
        var checked = ''
        if(key.kode_ikan == kode_ikan){
            if(kode && data_rules.includes(key.kode_gejala)){
                checked = "checked"
            }
            $("ul.pilih-gejala").append(`<li><div class="icheck-primary"> <input type="checkbox" ${checked} name="${key.kode_gejala}" class="checkbox" id="${key.kode_gejala}" data-id="${key.kode_gejala}"><label class="text-muted" style="font-weight: 400;" for="${key.kode_gejala}">${key.gejala}</label></div></li>`);
        }
    });
    $("select.data-penyakit").empty()
    data_penyakit.forEach(key => {
        if(key.kode_ikan == kode_ikan){
            $("select.data-penyakit").append(`<option value="${key.kode_penyakit}">${key.nama_penyakit}</option>`);
        }
    });
    $('select.pilih-ikan').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var kode_ikan = this.value;
        
        $("select.data-penyakit").empty()
        $("ul.pilih-gejala").empty()
        var data_rules = []
        rules.forEach(key => {
            if(kode == key.kode_rule){
                data_rules = key.gejala
            }
        });
        data_gejala.forEach(key => {
            var checked = ''
            if(key.kode_ikan == kode_ikan){
                if(kode && data_rules.includes(key.kode_gejala)){
                    checked = "checked"
                }
                $("ul.pilih-gejala").append(`<li><div class="icheck-primary"> <input type="checkbox" ${checked} name="${key.kode_gejala}" class="checkbox" id="${key.kode_gejala}" data-id="${key.kode_gejala}"><label class="text-muted" style="font-weight: 400;" for="${key.kode_gejala}">${key.gejala}</label></div></li>`);
            }
            
        });

        data_penyakit.forEach(key => {
            if(key.kode_ikan == kode_ikan){
                $("select.data-penyakit").append(`<option value="${key.kode_penyakit}">${key.nama_penyakit}</option>`);
            }
        });
    });

    $("input[name=kode_rule]").val(kode);
    $("input[name=kode_lama]").val(kode);
    $("select[name=then_penyakit]").val(kode_penyakit);
    $("select[name=kode_ikan]").val(kode_ikan);
    $("select").select2({
        theme: 'bootstrap4',
        dropdownAutoWidth: true, width: 'auto'
    });
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
            return fetch(`<?php echo base_url()?>rule/delete/${kode}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json()
            })
            .catch(error => {
                Swal.showValidationMessage(
                    `Rule tidak dapat dihapus, karena digunakan sebagai referensi data lain.`
                )
            })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Dihapus!',
                'Rule berhasil dihapus',
                'success'
            ).then((result) => {
                rules = []
                table.ajax.reload( null, false );
            })
        }
    })
    
}

</script>