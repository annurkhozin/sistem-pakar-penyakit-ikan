<?php 
    $data['page'] = "diagnosa"; 
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
            <h1 class="m-0">Diagnosa</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#/apps?page=beranda">Home</a></li>
                <li class="breadcrumb-item"><a href="#/apps?page=diagnosa/riwayat">Riwayat</a></li>
                <li class="breadcrumb-item active">Diagnosa</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="<?php echo base_url()?>diagnosa/save" id="diagnosa" method="post">
                            <div class="form-group">
                                <label>Ikan<span class="text-danger">*</span></label>
                                <select name="ikan" class="form-control js-select-tags pilih-ikan">
                                    <option value="">Pilih ikan yang akan dianalisa</option>
                                </select>
                            </div>
                            <div class="card card-warning card-gejala" id="accordion">
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
                                    <div class="card-body">
                                        <ul class="pilih-gejala" style="list-style-type:none;"></ul> 
                                    </div>
                                    <div class="card-footer text-center btn-check">
                                        <button type="button" onclick="cekPenyakit()" class="btn btn-success">CEK</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row card-hasil">
                                <div class="col-12">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3 class="persentase"></h3>
                                            <h5 class="nama-penyakit"></h5>
                                            <span class="badge bg-warning">Penanganan</span>
                                            <p class="penanganan"></p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-snowflake"></i>
                                        </div>
                                        <a href="javascript:void(0)" onclick="detailDiagnosa()" class="small-box-footer">Detail diagnosa <i class="fas fa-arrow-circle-down"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row container detail-diagnosa">
                                <table class="table table-bordered table-detail-diagnosa">
                                    <thead>
                                        <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Kode</th>
                                        <th>Nama Penyakit</th>
                                        <th class="text-center">Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <?php if($this->session->userdata("session_id")){?>
                            <div class="text-center btn-submit">
                                <button type="submit" class="btn btn-primary">SIMPAN</button>
                            </div>
                            <?php }?>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Penanganan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <p class="text-penanganan"></p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<script>
    var rule_data = null
    var data_gejala = null
    var data_penyakit = null
    var ikan_dipilih = null
    var submit_gejala = []
    var submit_penyakit = []
    $(function () {

        $(".js-select-tags").select2({
            theme: 'bootstrap4'
        });

        fetch("<?php echo base_url()?>rule/get", {
            method: "GET",
            dataType: 'json',
            ContentType: 'application/json'
        })
        .then((resp) => {
            return resp.json();
        })
        .then((data) => {
            rule_data = data.data ? data.data : []
        })

        fetch("<?php echo base_url()?>penyakit/get", {
            method: "GET",
            dataType: 'json',
            ContentType: 'application/json'
        })
        .then((resp) => {
            return resp.json();
        })
        .then((data) => {
            data_penyakit = data ? data : []
        })

        fetch("<?php echo base_url()?>ikan/get", {
            method: "GET",
            dataType: 'json',
            ContentType: 'application/json'
        })
        .then((resp) => {
            return resp.json();
        })
        .then((data) => {
            data.forEach(key => {
                $("select.pilih-ikan").append(`<option value="${key.kode_ikan}">${key.nama_ikan}</option>`);
            });
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

        $(".card-gejala").hide()
        $(".card-hasil").hide()
        $(".btn-submit").hide()
        $(".detail-diagnosa").hide()
        
        $('select.pilih-ikan').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            ikan_dipilih = valueSelected
            $(".card-gejala").collapse('show')
            if(valueSelected){
                $(".card-gejala").show()
                $(".btn-check").show()
                $("ul.pilih-gejala").empty()
                data_gejala.forEach(key => {
                    if(key.kode_ikan == valueSelected){
                        $("ul.pilih-gejala").append(`<li><div class="icheck-primary"> <input type="checkbox" name="${key.kode_gejala}" class="checkbox" id="${key.kode_gejala}" data-id="${key.kode_gejala}"><label class="text-muted" style="font-weight: 400;" for="${key.kode_gejala}">${key.gejala}</label></div></li>`);
                    }
                });
            }else{
                $(".card-gejala").hide()
            }
        });

        $("form#diagnosa").submit(function(){
            const data = {
                kode_ikan: ikan_dipilih,
                gejala: (submit_gejala).toString(),
                penyakit: JSON.stringify(submit_penyakit),
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
                        $('.btn-submit').hide()
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

function cekPenyakit(){
    const data = $("form#diagnosa").serializeArray()
    const gejala = []
    data.forEach(key => {
        if(key.name != "ikan"){
            gejala.push(key.name)
        }
    });
    submit_gejala = gejala
    if(submit_gejala.length > 0){

        $(".expanse-gejala").click() 
        
        rule_data.forEach(key => {
            if(key.kode_ikan == ikan_dipilih){
                const rule_gejala = key.gejala // data gejala sesuai rule, misal [GA01,GA02,GA03,GA04]
                let i = 0 // jumlah data awal yang sama
                gejala.forEach(element => { // gejala apa saja yang dipilih user
                    if(rule_gejala.includes(element)){ // ngecek gejala yang dipilih user masuk pada rule mana
                        i++ // increment ketika gejala masuk di salah satu rule
                    }
                });
                key.jumlah_rule = rule_gejala.length // jumlah asli rule
                key.sama_rule = i // jumlah gejala yang sama
                key.persentase = ((i/rule_gejala.length) * 100).toFixed(2) // persentase gejala yang dipilih dari keseluruhan gejala pada rule
            }else{
                key.persentase = 0 // jika gejala tidak masuk pada semua rule
            }
        });

        $(".btn-submit").show()
        $(".card-hasil").show()
        // untuk mengurutkan berdasarkan persentase yang tertinggi
        rule_data.sort((a,b) => (Number(a.persentase) < Number(b.persentase)) ? 1 : ((Number(b.persentase) < Number(a.persentase)) ? -1 : 0))
        var ikan = $('select.pilih-ikan').val()
        var tertinggi = 0
        rule_data.forEach(key => {
            if(key.kode_ikan == ikan){
                return tertinggi = Number(rule_data[0].persentase)
            }
        });
    
        const kode_penyakit_terpilih = []
        rule_data.forEach(key => {
            if(Number(key.persentase) >= tertinggi && ikan == key.kode_ikan){
                kode_penyakit_terpilih.push(key.kode_penyakit)
            }
        });
        var penyakit_terpilih = []
        var penanganan_terpilih = []
        data_penyakit.forEach(key => {
            if(kode_penyakit_terpilih.includes(key.kode_penyakit)){
                penyakit_terpilih.push(key.nama_penyakit)
                penanganan_terpilih.push(key.penanganan)
            }
        });
        if(tertinggi <= 0){
            penyakit_terpilih = ["Penyakit belum ditemukan"]
        }
        $('.persentase').html(`${tertinggi}<sup style="font-size: 20px">%</sup>`)
        $('.nama-penyakit').html(`${penyakit_terpilih.map(function(key){ return ` ${key}`; })}`)
        $('.penanganan').html(`${penanganan_terpilih.map(function(key){ return ` ${key}`; })}`)
        tableDetailDiagnosa()
    }else{
        message("error","Pilih gejala penyakit")
    }
}

var showDetailData = false
function detailDiagnosa(){
    showDetailData = !showDetailData
    tableDetailDiagnosa()
}

function tableDetailDiagnosa(){
    if(showDetailData){
        $(".detail-diagnosa").show()
    }else{
        $(".detail-diagnosa").hide()
    }
    $('.table-detail-diagnosa tbody').empty();
    var newRow = ''
    let no = 1
    var ikan = $('select.pilih-ikan').val()
    submit_penyakit = []
    rule_data.forEach(key => {
        if(key.kode_ikan == ikan){
            const data = {
                kode_penyakit: key.kode_penyakit,
                persentase: key.persentase
            }
            submit_penyakit.push(data)
            var nama_penyakit = null
            data_penyakit.forEach(el => {
                if(el.kode_penyakit == key.kode_penyakit){
                    nama_penyakit = el.nama_penyakit
                }
            });
            // untuk nampilin tabel detail persentase diagnosa setiap penyakit
            newRow += `<tr>
                            <td>${no}</td>
                            <td>${key.kode_penyakit}</td>
                            <td style="cursor: pointer;" class="text-primary" onclick="penanganan('${key.kode_penyakit}')">${nama_penyakit}</td>
                            <td class="text-center">
                                <span class="badge bg-danger">${Number(key.persentase)}%</span>
                            </td>
                        </tr>`
            no++
        }
    });
    $('.table-detail-diagnosa tbody').append(newRow);
}

function penanganan(kode){
    $('#modal-default').modal("show")
    var penanganan = null
    data_penyakit.forEach(el => {
        if(el.kode_penyakit == kode){
            penanganan = el.penanganan
        }
    });
    $('.text-penanganan').html(penanganan)
}

</script>