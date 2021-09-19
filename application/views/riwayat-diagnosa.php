<?php 
    $data['page'] = "diagnosa"; 
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
            <h1 class="m-0">Riwayat Diagnosa</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#/apps?page=beranda">Home</a></li>
                <li class="breadcrumb-item active">Riwayat</li>
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
                    <a href="#/apps?page=diagnosa" class="btn bg-gradient-success"><i class="fa fa-plus"></i> Diagnosa Penyakit</a>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Ikan</th>
                            <th>Tanggal</th>
                            <th>Gejala</th>
                            <th>Penyakit</th>
                            <th>Persentase</th>
                            <th>Penanganan</th>
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
<script>
    var table = null
    $(function () {
    
    table = $('#data-table').DataTable({
        "dom": "<'row'<'col-sm-6'B><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url()?>diagnosa/data",
        "aoColumns": [
                { "data": "user" },
                { "data": "nama_ikan" },
                { "data": "tanggal" },
                {
                    "mData": "gejala",
                    "mRender": function (data, type, row) {
                        return data.map(function(key){ return ` ${key.gejala}`; }) 
                    }
                },
                {
                    "mData": "penyakit",
                    "mRender": function (data, type, row) {
                        return data[0].nama_penyakit 
                    }
                },
                {
                    "mData": "penyakit",
                    "mRender": function (data, type, row) {
                        return `<span class="badge bg-danger">${data[0].persentase}%</span> `
                    }
                },
                {
                    "mData": "penyakit",
                    "mRender": function (data, type, row) {
                        return data[0].penanganan
                    }
                },
            ],
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    })
    
});


</script>