<nav class="navbar navbar-danger navbar-bottom">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-toggle collapsed" data-target="#navbar" data-toggle="collapse">
                <i class="fa fa-chevron-down faa-vertical animated"></i>
            </a>
            <a tabindex="0" class="navbar-brand faa-pulse faa-slow animated" data-toggle="" data-trigger="focus" data-html="true" data-placement="bottom" data-title="Brand Quote..." data-content="<img class='img-responsive' height='140' width='140' src='data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='/<p>Your Brand Image</p>">
                <i class="fa fa-envelope"></i>
                <i class="fa fa-lg">D</i>
                <i class="fa fa-lg">I</i>
                <i class="fa fa-lg">S</i>
                <i class="fa fa-lg">K</i>
                <i class="fa fa-lg">O</i>
                <i class="fa fa-lg">M</i>
                <i class="fa fa-lg">I</i>
                <i class="fa fa-lg">N</i>
                <i class="fa fa-lg">F</i>
                <i class="fa fa-lg">O</i>
                <i class="fa fa-lg">T</i>
                <i class="fa fa-lg">I</i>
                <i class="fa fa-lg">K</i>
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a class="faa-parent animated-hover">
                       <i class="fa fa-fw fa-lg fa-home faa-tada faa-fast"></i>Home
                    </a>
                </li>
                 <li class="dropdown">
                    <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
    	               <i class="fa fa-fw fa-lg fa-folder faa-tada faa-fast"></i>Data Master
    	               <span class="fa fa-caret-down"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
    	               <li>
    		              <a href="instansi.php" class="faa-parent animated-hover">
    			             <i class="fa fa-fw fa-level-down faa-tada faa-fast"></i>Instansi
    		              </a>
    	               </li>
    	               <li>
    		              <a href="bagian.php" class="faa-parent animated-hover">
    			             <i class="fa fa-fw fa-external-link faa-tada faa-fast"></i>Bagian
    		              </a>
    	               </li>
    	               <li>
    		              <a href="jenis.php" class="faa-parent animated-hover">
    			             <i class="fa fa-fw fa-search faa-tada faa-fast"></i>Jenis
    		              </a>
    	               </li>	
    	               <li>
    		              <a class="faa-parent animated-hover">
    			             <i class="fa fa-fw fa-file-pdf-o faa-tada faa-fast"></i>!
    		              </a>
    	               </li>
    	               <li class="divider"></li>
    	               <li>
    		              <a class="faa-parent animated-hover">
    			             <i class="fa fa-fw fa-flag faa-tada faa-fast"></i>!
    		              </a>
    	               </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
    	               <i class="fa fa-fw fa-lg fa-folder faa-tada faa-fast"></i>Products
    	               <span class="fa fa-caret-down"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
    	               <li>
    		              <a class="faa-parent animated-hover">
    			             <i class="fa fa-fw fa-level-down faa-tada faa-fast"></i>Portfolio
    		              </a>
    	               </li>
    	               <li>
    		              <a class="faa-parent animated-hover">
    			             <i class="fa fa-fw fa-external-link faa-tada faa-fast"></i>Individual
    		              </a>
    	               </li>
    	               <li>
    		              <a class="faa-parent animated-hover">
    			             <i class="fa fa-fw fa-search faa-tada faa-fast"></i>Search
    		              </a>
    	               </li>	
    	               <li>
    		              <a class="faa-parent animated-hover">
    			             <i class="fa fa-fw fa-file-pdf-o faa-tada faa-fast"></i>!
    		              </a>
    	               </li>
    	               <li class="divider"></li>
    	               <li>
    		              <a class="faa-parent animated-hover">
    			             <i class="fa fa-fw fa-flag faa-tada faa-fast"></i>!
    		              </a>
    	               </li>
                    </ul>
                </li>
                <li>
                    <a class="faa-parent animated-hover">
	                   <i class="fa fa-fw fa-lg fa-map-marker faa-tada faa-fast"></i>!
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
               <li class="dropdown">
                    <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
    	               <strong><?php echo $_SESSION['nama_user'];?></strong>
    	               <span class="material-icons">face</span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
    	               <li>
    		              <a href="../logout.php" class="faa-parent animated-hover">
    			             <i class="fa fa-fw fa-level-down faa-tada faa-fast"></i>Keluar!
    		              </a>
    	               </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>