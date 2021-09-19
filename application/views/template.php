<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Pakar Ikan</title>
  <link rel="icon" href="<?php echo base_url()?>assets/image/AdminLTELogo.png">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&display=swap"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery.notify.css">
  <!-- dropzone -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/dropzone/dropzone.min.css">
  <!-- sweetalert2 -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">
  <!-- select2 -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
      <?php $this->load->view("component/loading")?>
  </div>

  <div class="html">
  </div>

  <!-- /.content-wrapper -->
  <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer> -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url()?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>assets/js/adminlte.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- dropzone -->
<script src="<?php echo base_url()?>assets/plugins/dropzone/dropzone.min.js"></script>
<!-- sweetalert2 -->
<script src="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- select2 -->
<script src="<?php echo base_url()?>assets/plugins/select2/select2.min.js"></script>
<!-- Sammy -->
<script src="<?php echo base_url()?>assets/js/sammy.min.js"></script>
<!-- Main App -->
<script src="<?php echo base_url()?>assets/js/main.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.notify.min.js"></script>
</body>
<script>
    function message(type, mesage){       
        notify({
            type: type, //alert | success | error | warning | info
            // title: "Pesan",
            message: mesage,
            position: {
                x: "right", //right | left | center
                y: "top" //top | bottom | center
            },
            // icon: '<img src="images/paper_plane.png" />', //<i>
            size: "normal", //normal | full | small
            overlay: false, //true | false
            closeBtn: true, //true | false
            overflowHide: true, //true | false
            spacing: 20, //number px
            theme: "default", //default | dark-theme
            autoHide: true, //true | false
            delay: 2500, //number ms
            onShow: null, //function
            onClick: null, //function
            onHide: null, //function
            template: '<div class="notify"><div class="notify-text"></div></div>'
        });
    }
    function show(){
      var Digital = new Date();
      var hours=Digital.getHours();
      var minutes=Digital.getMinutes();
      var seconds=Digital.getSeconds();
      var day=Digital.getDate();
      var years=Digital.getFullYear();
      var month = new Array();
      month[0] = "Januari";
      month[1] = "Februari";
      month[2] = "Maret";
      month[3] = "April";
      month[4] = "Mei";
      month[5] = "Juni";
      month[6] = "Juli";
      month[7] = "Agustus";
      month[8] = "September";
      month[9] = "Oktober";
      month[10] = "November";
      month[11] = "Desember";
      var month = month[Digital.getMonth()];
      if (hours<=9){
        hours="0"+hours;
      }
      if (minutes<=9){
        minutes="0"+minutes;
      }
      if (seconds<=9){
        seconds="0"+seconds;
      }
      var tampil= hours+":"+minutes+":"+seconds;
      var tampil_day= day+" "+month+" "+years;
      $('#header_date').html(tampil_day)
      $('#header_jam').html(tampil)
      setTimeout("show()",1000);
    }
    show();
</script>
</html>
