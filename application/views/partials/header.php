<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="theme-color" content="#FFC312">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico');  ?>" />
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.3.1.js');  ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js');  ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/dataTables.bootstrap4.min.js');  ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js');  ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css');  ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.bootstrap4.min.css');  ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sb-admin.css');  ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css'); ?>" />
    <!-- bootstrap-slider js + css  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.2.0/bootstrap-slider.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.2.0/css/bootstrap-slider.min.css" />
    <script type="text/javascript">
        $(document).ready(function() {
            $('#abasteceTable').dataTable({
                columnDefs: [{
                    type: 'br_date',
                    targets: 0
                }]
            });

            $('#tabela').dataTable({

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.maskedinput.js');  ?>"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
</head>

<body>