<?php
    //cek session
    if(!empty($_SESSION['username'])){
?>
<?php require('../config.php'); ?>
<head>
<meta charset="utf-8">
    <title>Agenda Surat Masuk dan Surat Keluar DISKOMINFOTIK Kota Banjarmasin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/AdminLTE.min.css">
	<link rel="stylesheet" href="../assets/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../assets/css/pace.css">
	<link rel="stylesheet" href="../assets/css/table-responsive.css">
	<link rel="stylesheet" href="../assets/css/material-icon.css">
	<link rel="stylesheet" href="../assets/css/material-kit.css">
	<link rel="stylesheet" href="../assets/css/roboto2.css">
	<link rel="stylesheet" href="../assets/css/demo.css">
	<link rel="stylesheet" href="../assets/css/animate.css">
    <style>
    .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
    </style>
	<style>
	body {
    background: #F5F3EE !important;
}
	</style>
	<style>
.infotext {
  display: inline-block;
}
th 
{
   text-align:center; 
   vertical-align:middle;
}
.amodal {
  text-align: center;
  padding: 0!important;
}
.amodal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}

.amodal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
.tes {
	z-index: 10000000 !important;
  }
		pre.prettyprint{
		    background-color: #eee;
		    border: 0px;
		    margin-bottom: 60px;
		    margin-top: 30px;
		    padding: 20px;
		    text-align: left;
		}
		.atv, .str{
		    color: #05AE0E;
		}
		.tag, .pln, .kwd{
		    color: #3472F7;
		}
		.atn{
		    color: #2C93FF;
		}
		.pln{
		    color: #333;
		}
		.com{
		    color: #999;
		}
		.space-top{
		    margin-top: 50px;
		}
		.btn-primary .caret{
		    border-top-color: #3472F7;
		    color: #3472F7;
		}
		.area-line{
		    border: 1px solid #999;
		    border-left: 0;
		    border-right: 0;
		    color: #666;
		    display: block;
		    margin-top: 20px;
		    padding: 8px 0;
		    text-align: center;
		}
		.area-line a{
		    color: #666;
		}
		.container-fluid{
		    padding-right: 15px;
		    padding-left: 15px;
		}
		.table-shopping .td-name{
			min-width: 130px;
		}
	</style>
	<style type="text/css">
@media (max-width:768px){ .footer{position:absolute;width:100%;} }
@media (min-width:768px){ .footer{position:absolute;bottom:0;height:60px;width:100%;}}
html {
  position: relative;
  min-height: 100%;
}
body {
  /* Margin bottom by footer height */
  margin-bottom: 60px;
}
.footerf{
  position: fixed;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 45px;
  background-color: #3F51B5;
}
.footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 45px;
  background-color: #3F51B5;
}
.text-w {
  color: #ffffff;
}
.navbar-nav-s > li > a, .navbar-brand-s {
    padding-top:4px !important; 
    padding-bottom:0 !important;
    height: 28px;
}
.navbar-s {min-height:28px !important;}
body {
	padding-bottom: 0px;
    padding-top: 70px;
}
#tbagian td:nth-child(1)
{
    text-align : center;
}
#tkadis td:nth-child(1)
{
    text-align : center;
}
#tsrtmasuk td:nth-child(8)
{
    text-align : center;
}
#tsrtmasuk td:nth-child(7)
{
    text-align : center;
}
#tsrtmasuk th, #tsrtkeluar th, #tdisposisi th
{
    vertical-align : middle;
}
#tsrtkeluar td:nth-child(1), td:nth-child(7)
{
    text-align : center;
}
#tdisposisi td:nth-child(6)
{
    text-align : center;
}
#tsimpan td:nth-child(1)
{
    text-align : center;
}
	</style>
    <style type="text/css">
.datepicker{
	z-index:10000000!important
}
       .dropdown-menu>li>a,
.navbar-default .navbar-nav>li>a,
.navbar-default .navbar-nav >.active>a,
.navbar-default .navbar-header>a,
.navbar-default .navbar-nav>.active>a,
.navbar-default .navbar-nav .open .dropdown-menu>li>a
{
    color:#2C3E50;
	transition:all 1s;
	-o-transition:all 1s;
	-moz-transition:all 1s;
	-webkit-transition:all 1s
}
.dropdown-menu>li>a:hover,
.navbar-default .navbar-nav>li>a:hover,
.navbar-default .navbar-nav >.active>a,
.navbar-default .navbar-header>a:hover,
.navbar-default .navbar-nav>.active>a:hover,
.navbar-default .navbar-nav .open .dropdown-menu>li>a:hover
{
	color:#FFFFFF;
	background:#2C3E50
}
 
a
{
    cursor:pointer;
}
a:hover .fa
{
    -webkit-animation:fa-spin 1s;animation:fa-spin 1s
}
.hl-left
{
    padding:30px;
    border-radius:10px;
    margin-bottom:60px;
    background-color:#ffffff;
}
.progress-devider
{
    width: 11.11111111111111%;
}


/*
 * Font Awesome Animation
 */
/* WRENCHING */
@keyframes wrench {
	0%{transform:rotate(-12deg)}
	8%{transform:rotate(12deg)}
	10%{transform:rotate(24deg)}
	18%{transform:rotate(-24deg)}
	20%{transform:rotate(-24deg)}
	28%{transform:rotate(24deg)}
	30%{transform:rotate(24deg)}
	38%{transform:rotate(-24deg)}
	40%{transform:rotate(-24deg)}
	48%{transform:rotate(24deg)}
	50%{transform:rotate(24deg)}
	58%{transform:rotate(-24deg)}
	60%{transform:rotate(-24deg)}
	68%{transform:rotate(24deg)}
	75%,100%{transform:rotate(0deg)}
}
.faa-wrench.animated,
.faa-wrench.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-wrench {
	animation: wrench 2.5s ease infinite;
	transform-origin-x: 90%;
	transform-origin-y: 35%;
	transform-origin-z: initial;
}
.faa-wrench.animated.faa-fast,
.faa-wrench.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-wrench.faa-fast {
	animation: wrench 1.2s ease infinite;
}
.faa-wrench.animated.faa-slow,
.faa-wrench.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-wrench.faa-slow {
	animation: wrench 3.7s ease infinite;
}

/* BELL */
@keyframes ring {
	0%{transform:rotate(-15deg)}
	2%{transform:rotate(15deg)}
	4%{transform:rotate(-18deg)}
	6%{transform:rotate(18deg)}
	8%{transform:rotate(-22deg)}
	10%{transform:rotate(22deg)}
	12%{transform:rotate(-18deg)}
	14%{transform:rotate(18deg)}
	16%{transform:rotate(-12deg)}
	18%{transform:rotate(12deg)}
	20%,100%{transform:rotate(0deg)}
}
.faa-ring.animated,
.faa-ring.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-ring {
	animation: ring 2s ease infinite;
	transform-origin-x: 50%;
	transform-origin-y: 0px;
	transform-origin-z: initial;
}
.faa-ring.animated.faa-fast,
.faa-ring.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-ring.faa-fast {
	animation: ring 1s ease infinite;
}
.faa-ring.animated.faa-slow,
.faa-ring.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-ring.faa-slow {
	animation: ring 3s ease infinite;
}

/* VERTICAL */
@keyframes vertical {
	0%{transform:translate(0,-3px)}
	4%{transform:translate(0,3px)}
	8%{transform:translate(0,-3px)}
	12%{transform:translate(0,3px)}
	16%{transform:translate(0,-3px)}
	20%{transform:translate(0,3px)}
	22%,100%{transform:translate(0,0)}
}
.faa-vertical.animated,
.faa-vertical.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-vertical {
	animation: vertical 2s ease infinite;
}
.faa-vertical.animated.faa-fast,
.faa-vertical.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-vertical.faa-fast {
	animation: vertical 1s ease infinite;
}
.faa-vertical.animated.faa-slow,
.faa-vertical.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-vertical.faa-slow {
	animation: vertical 4s ease infinite;
}

/* HORIZONTAL */
@keyframes horizontal {
	0%{transform:translate(0,0)}
	6%{transform:translate(5px,0)}
	12%{transform:translate(0,0)}
	18%{transform:translate(5px,0)}
	24%{transform:translate(0,0)}
	30%{transform:translate(5px,0)}
	36%,100%{transform:translate(0,0)}
}
.faa-horizontal.animated,
.faa-horizontal.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-horizontal {
	animation: horizontal 2s ease infinite;
}
.faa-horizontal.animated.faa-fast,
.faa-horizontal.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-horizontal.faa-fast {
	animation: horizontal 1s ease infinite;
}
.faa-horizontal.animated.faa-slow,
.faa-horizontal.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-horizontal.faa-slow {
	animation: horizontal 3s ease infinite;
}

/* FLASHING */
@keyframes flash {
	0%,100%,50%{opacity:1}
	25%,75%{opacity:0}
}
.faa-flash.animated,
.faa-flash.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-flash {
	animation: flash 2s ease infinite;
}
.faa-flash.animated.faa-fast,
.faa-flash.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-flash.faa-fast {
	animation: flash 1s ease infinite;
}
.faa-flash.animated.faa-slow,
.faa-flash.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-flash.faa-slow {
	animation: flash 3s ease infinite;
}

/* BOUNCE */
@keyframes bounce {
	0%,10%,20%,50%,80%,100%{transform:translateY(0)}
	40%{transform:translateY(-15px)}
	60%{transform:translateY(-15px)}
}
.faa-bounce.animated,
.faa-bounce.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-bounce {
	animation: bounce 2s ease infinite;
}
.faa-bounce.animated.faa-fast,
.faa-bounce.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-bounce.faa-fast {
	animation: bounce 1s ease infinite;
}
.faa-bounce.animated.faa-slow,
.faa-bounce.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-bounce.faa-slow {
	animation: bounce 3s ease infinite;
}

/* SPIN */
@keyframes spin{
	0%{transform:rotate(0deg)}
	100%{transform:rotate(359deg)}
}
.faa-spin.animated,
.faa-spin.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-spin {
	animation: spin 1.5s linear infinite;
}
.faa-spin.animated.faa-fast,
.faa-spin.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-spin.faa-fast {
	animation: spin 0.7s linear infinite;
}
.faa-spin.animated.faa-slow,
.faa-spin.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-spin.faa-slow {
	animation: spin 2.2s linear infinite;
}

/* FLOAT */
@keyframes float{
	0%{transform: translateY(0)}
	50%{transform: translateY(-6px)}
	100%{transform: translateY(0)}
}
.faa-float.animated,
.faa-float.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-float {
	animation: float 2s linear infinite;
}
.faa-float.animated.faa-fast,
.faa-float.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-float.faa-fast {
	animation: float 1s linear infinite;
}
.faa-float.animated.faa-slow,
.faa-float.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-float.faa-slow {
	animation: float 3s linear infinite;
}

/* PULSE */
@keyframes pulse {
	0% {transform: scale(1.1)}
 	50% {transform: scale(0.8)}
 	100% {transform: scale(1.1)}
}
.faa-pulse.animated,
.faa-pulse.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-pulse {
	animation: pulse 2s linear infinite;
}
.faa-pulse.animated.faa-fast,
.faa-pulse.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-pulse.faa-fast {
	animation: pulse 1s linear infinite;
}
.faa-pulse.animated.faa-slow,
.faa-pulse.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-pulse.faa-slow {
	animation: pulse 3s linear infinite;
}

/* SHAKE */
.faa-shake.animated,
.faa-shake.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-shake {
	animation: wrench 2.5s ease infinite;
}
.faa-shake.animated.faa-fast,
.faa-shake.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-shake.faa-fast {
	animation: wrench 1.2s ease infinite;
}
.faa-shake.animated.faa-slow,
.faa-shake.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-shake.faa-slow {
	animation: wrench 3.7s ease infinite;
}

/* TADA */
@keyframes tada {
	0% {transform: scale(1)}
	10%,20% {transform:scale(.9) rotate(-8deg);}
	30%,50%,70% {transform:scale(1.3) rotate(8deg)}
	40%,60% {transform:scale(1.3) rotate(-8deg)}
	80%,100% {transform:scale(1) rotate(0)}
}

.faa-tada.animated,
.faa-tada.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-tada {
	animation: tada 2s linear infinite;
}
.faa-tada.animated.faa-fast,
.faa-tada.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-tada.faa-fast {
	animation: tada 1s linear infinite;
}
.faa-tada.animated.faa-slow,
.faa-tada.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-tada.faa-slow {
	animation: tada 3s linear infinite;
}

/* PASSING */
@keyframes passing {
	0% {transform:translateX(-50%); opacity:0}
	50% {transform:translateX(0%); opacity:1}
	100% {transform:translateX(50%); opacity:0}
}

.faa-passing.animated,
.faa-passing.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-passing {
	animation: passing 2s linear infinite;
}
.faa-passing.animated.faa-fast,
.faa-passing.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-passing.faa-fast {
	animation: passing 1s linear infinite;
}
.faa-passing.animated.faa-slow,
.faa-passing.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-passing.faa-slow {
	animation: passing 3s linear infinite;
}

/* PASSING REVERSE */

@keyframes passing-reverse {
	0% {transform:translateX(50%); opacity:0}
	50% {transform:translateX(0%); opacity:1}
	100% {transform:translateX(-50%); opacity:0}
}

.faa-passing-reverse.animated,
.faa-passing-reverse.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-passing-reverse {
	animation: passing-reverse 2s linear infinite;
}
.faa-passing-reverse.animated.faa-fast,
.faa-passing-reverse.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-passing-reverse.faa-fast {
	animation: passing-reverse 1s linear infinite;
}
.faa-passing-reverse.animated.faa-slow,
.faa-passing-reverse.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-passing-reverse.faa-slow {
	animation: passing-reverse 3s linear infinite;
}

/* WAVE */
@keyframes burst {
	0% {opacity:.6}
	50% {transform:scale(1.8);opacity:0}
	100%{opacity:0}
}
.faa-burst.animated,
.faa-burst.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-burst {
	animation: burst 2s infinite linear
}
.faa-burst.animated.faa-fast,
.faa-burst.animated-hover.faa-fast:hover,
.faa-parent.animated-hover:hover > .faa-burst.faa-fast {
	animation: burst 1s infinite linear
}
.faa-burst.animated.faa-slow,
.faa-burst.animated-hover.faa-slow:hover,
.faa-parent.animated-hover:hover > .faa-burst.faa-slow {
	animation: burst 3s infinite linear
}
.faa-burst.animated.faa-sloww,
.faa-burst.animated-hover.faa-sloww:hover,
.faa-parent.animated-hover:hover > .faa-burst.faa-sloww {
	animation: burst 4s infinite linear
}

	</style>
	<!--<script src="https://unpkg.com/sweetalert2@7.0.7/dist/sweetalert2.all.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>-->
    <script src="../assets/js/table-responsive.js"></script>
    <script src="../assets/js/jquery-3.2.1.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.dataTables.js"></script>
    <script src="../assets/js/dataTables.bootstrap.js"></script>
	<script src="../assets/js/pace.js"></script>
	<script src="../assets/js/prettify.js"></script>
	<script src="../assets/js/material.min.js"></script>
	<script src="../assets/js/material-kit.js"></script>
	<script src="../assets/js/nouislider.min.js"></script>
	<script src="../assets/js/validator.js"></script>
	<script src="../assets/js/date-picker.js"></script>
	<script>
		$('[data-toggle="tooltip"]').tooltip();
	</script>
</head>
<?php
    } else {
        header("Location: ../index.php");
        die();
    }
?>