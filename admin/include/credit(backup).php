<?php
$y = date('Y');
?>
<nav class="navbar navbar-inverse navbar-fixed-bottom">
    <div class="container-fluid">
        <div class="navbar-footer">
            <a class="navbar-toggle collapsed" data-target="#navbar" data-toggle="collapse">
                <i class="fa fa-chevron-down faa-vertical animated"></i>
            </a>
            <a tabindex="0" class="navbar-brand navbar-right faa-pulse faa-slow" data-toggle="popover" data-trigger="focus" data-html="true" data-placement="bottom" data-title="Brand Quote..." data-content="<img class='img-responsive' height='140' width='140' src='data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='/<p>Your Brand Image</p>">
                <i class="fa fa-lg">Agenda</i>
                <i class="fa fa-lg">Surat</i>
                <i class="fa fa-lg">Masuk</i>
                <i class="fa fa-lg">Dan</i>
                <i class="fa fa-lg">Surat</i>
                <i class="fa fa-lg">Keluar</i>
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-left">
                 <li>
                    <a href="../logout.php" class="faa-parent animated-hover">
	                   <i class="fa fa-fw fa-lg fa-sign-out faa-tada faa-fast animated"></i>Copyright <i class="fa fa-copyright"></i><?php echo $y;?><i>DISKOMINFOTIK Kota Banjarmasin</i> All rights reserved
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>