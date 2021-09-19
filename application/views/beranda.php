<?php 
    $data['page'] = "beranda"; 
    $this->load->view("component/navbar");
    $this->load->view("component/sidebar",$data);
    function TrimTrailingZeroes($nbr) {
        return strpos($nbr,',')!==false ? rtrim(rtrim($nbr,'0'),',') : $nbr;
    }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#/apps?page=beranda">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="row">
                    <?php $where_user = array(); 
                        if($this->session->userdata('session_type')==0){
                            $where_user["kode_akun"] = $this->session->userdata('session_id');
                        }?>
                    <?php $total_diagnosa = $this->db->from("diagnosa")->where($where_user)->get()->num_rows();?>
                    <?php $ikan = $this->db->get("ikan")?>
                    <?php foreach ($ikan->result() as $key) { ?>
                                
                        <div class="col-md-12 col-lg-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                <?php if($this->session->userdata('session_id')){ ?>
                                    <?php $where = array(
                                                    "kode_ikan" => $key->kode_ikan
                                                );
                                        if($this->session->userdata('session_type')==0){
                                            $where["kode_akun"] = $this->session->userdata('session_id');
                                        }
                                        $diagnosa = $this->db->from("diagnosa")->where($where)->get()->num_rows()?>
                                    <!-- small card -->
                                    <?php $nama_ikan =  strtolower($key->nama_ikan); 
                                        $card_bg = $nama_ikan == "arwana" ? "bg-success" : ($nama_ikan == "cupang" ? "bg-info" : "bg-warning") ?>
                                    <div class="small-box <?php echo $card_bg;?>">
                                        <div class="inner">
                                            <?php $percen = number_format(($diagnosa/$total_diagnosa) * 100, 2, ',', '.')?>
                                            <h3><?php echo $diagnosa?> (<?php echo TrimTrailingZeroes($percen); ?><sup style="font-size: 20px">%</sup>)</h3>
                                            <p>Total Diagnosa Ikan <?php echo $key->nama_ikan?></p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-fish"></i>
                                        </div>
                                        <a href="#/apps?page=diagnosa/riwayat" class="small-box-footer">
                                            Lihat <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                <?php }?>
    
                                    <div class="card mb-2 bg-gradient-dark">
                                        <img class="card-img-top" src="<?php echo base_url()?>assets/image/<?php echo $key->photo?>" alt="Dist Photo 1">
                                        <div class="card-img-overlay d-flex flex-column justify-content-end">
                                            <h5 class="card-title text-primary text-warning"><strong><?php echo $key->nama_ikan?></strong></h5>
                                            <p class="card-text text-white pb-2 pt-1"><?php echo $key->deskripsi?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>