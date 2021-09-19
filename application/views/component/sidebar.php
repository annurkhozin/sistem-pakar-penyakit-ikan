<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#/apps?page=beranda" class="brand-link">
        <img src="<?php echo base_url()?>assets/image/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Sistem Pakar Ikan</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">        
        <!-- Sidebar user panel (optional) -->
        <?php if($this->session->userdata("session_id")){?>
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                <?php $name = $this->session->userdata("session_nama")?>
                <img src="<?php echo base_url()?>assets/image/avatar.png" class="img-circle elevation-2" alt="<?php echo $name?>">
                </div>
                <div class="info">
                <a href="#/apps?page=login/profile" class="d-block"><?php echo $name?></a>
                </div>
            </div>
        <?php }else{?>
            <div class="mt-1 pb-1 mb-1 d-flex"></div>
        <?php }?>
        <!-- SidebarSearch Form -->
        <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <select class="form-control form-control-sidebar search-menu" type="search" aria-label="Search">
                <option value="">Search</option>
                <option value="#/apps?page=beranda">Beranda</option>
                <?php if($this->session->userdata("session_type")==1){?>
                    <option value="#/apps?page=admin">Data Admin</option>
                    <option value="#/apps?page=ikan">Data Ikan</option>
                    <option value="#/apps?page=penyakit">Data Penyakit</option>
                    <option value="#/apps?page=gejala">Gejala Penyakit</option>
                    <option value="#/apps?page=rule">Rules (Forward Chaining)</option>
                    <option value="#/apps?page=diagnosa">Diagnosa</option>
                    <option value="#/apps?page=diagnosa/riwayat">Riwayat Diagnosa</option>
                    <option value="#/apps?page=login/profile">Ubah Profil</option>
                <?php }?>
            </select>
            <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
            </button>
            </div>
        </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">Menu</li>
            <li class="nav-item">
                <a href="#/apps?page=beranda" class="nav-link <?php if($page=='beranda'){ echo "active";} ?>">
                    <i class="nav-icon fa fa-home"></i>
                    <p>
                    Beranda
                    </p>
                </a>
            </li>
            <?php if($this->session->userdata("session_id") && $this->session->userdata("session_type")==1){?>
                <li class="nav-item">
                    <a href="#/apps?page=admin" class="nav-link <?php if($page=='admin'){ echo "active";} ?>">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                        Admin
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#/apps?page=ikan" class="nav-link <?php if($page=='ikan'){ echo "active";} ?>">
                        <i class="nav-icon fa fa-fish"></i>
                        <p>
                        Data Ikan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#/apps?page=penyakit" class="nav-link <?php if($page=='penyakit'){ echo "active";} ?>">
                        <i class="nav-icon fa fa-snowflake"></i>
                        <p>
                        Data Penyakit
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#/apps?page=gejala" class="nav-link <?php if($page=='gejala'){ echo "active";} ?>">
                        <i class="nav-icon fa fa-heartbeat"></i>
                        <p>
                        Gejala Penyakit
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#/apps?page=rule" class="nav-link <?php if($page=='rule'){ echo "active";} ?>">
                        <i class="nav-icon fa fa-cubes"></i>
                        <p>
                        Aturan (Rules)
                        </p>
                    </a>
                </li>
            <?php }?>
            <?php if($this->session->userdata("session_id")){?>
                <li class="nav-item">
                    <a href="#/apps?page=diagnosa/riwayat" class="nav-link <?php if($page=='diagnosa'){ echo "active";} ?>">
                        <i class="nav-icon fa fa-stethoscope"></i>
                        <p>
                        Diagnosa
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#/apps?page=login" onclick="return confirm('Anda yakin ingin Keluar!');" class="nav-link">
                        <i class="nav-icon fa fa-power-off"></i>
                        <p>
                        Logout
                        </p>
                    </a>
                </li>
            <?php }?>
            <?php if(!$this->session->userdata("session_id")){?>
                <li class="nav-item">
                    <a href="#/apps?page=diagnosa" class="nav-link <?php if($page=='diagnosa'){ echo "active";} ?>">
                        <i class="nav-icon fa fa-stethoscope"></i>
                        <p>
                        Diagnosa
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#/apps?page=login" class="nav-link">
                        <i class="nav-icon fa fa-key"></i>
                        <p>
                        Login
                        </p>
                    </a>
                </li>
            <?php }?>
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
<!-- /.sidebar -->
</aside>
<script>
    $("select").select2({
        theme: 'bootstrap4',
        dropdownAutoWidth: true, width: 'auto'
    });
    $('select.search-menu').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        if(this.value){
            window.location = this.value
        }
    });
</script>
