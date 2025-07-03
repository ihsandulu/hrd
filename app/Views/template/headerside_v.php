<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar hidebar" style="overflow:auto;">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-label">Home</li>
                <li>
                    <a class="" href="<?= base_url("utama"); ?>" aria-expanded="false">
                        <i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span>
                    </a>

                </li>
                <?php
                // dd(session()->get("position_id")[0][0]);
                if (
                    (
                        isset(session()->get("position_id")[0][0])
                        && (
                            session()->get("position_id") == "1"
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['1']['act_read'])
                        && session()->get("halaman")['1']['act_read'] == "1"
                    )
                ) { ?>
                    <li class="nav-label">Master</li>
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['28']['act_read'])
                            && session()->get("halaman")['28']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'midentity' ? 'active' : ''; ?>" href="<?= base_url("midentity"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Identitas</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['2']['act_read'])
                            && session()->get("halaman")['2']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="has-arrow  " href="#" aria-expanded="false" data-toggle="collapse" data-target="#demo"><i class="fa fa-user"></i><span class="hide-menu">Manajemen Karyawan <span class="label label-rouded label-warning pull-right">2</span></span></a>
                            <ul aria-expanded="false" id="demo" class="collapse">
                                <?php
                                if (
                                    (
                                        isset(session()->get("position_id")[0][0])
                                        && (
                                            session()->get("position_id") == "1"
                                            || session()->get("position_id") == "2"
                                        )
                                    ) ||
                                    (
                                        isset(session()->get("halaman")['3']['act_read'])
                                        && session()->get("halaman")['3']['act_read'] == "1"
                                    )
                                ) { ?>
                                    <li><a href="<?= base_url("mposition"); ?>"><i class="fa fa-caret-right"></i> &nbsp;Posisi</a></li>
                                <?php } ?>
                                <?php
                                if (
                                    (
                                        isset(session()->get("position_id")[0][0])
                                        && (
                                            session()->get("position_id") == "1"
                                            || session()->get("position_id") == "2"
                                        )
                                    ) ||
                                    (
                                        isset(session()->get("halaman")['5']['act_read'])
                                        && session()->get("halaman")['5']['act_read'] == "1"
                                    )
                                ) { ?>
                                    <li><a href="<?= base_url("muser"); ?>"><i class="fa fa-caret-right"></i> &nbsp;Karyawan</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['50']['act_read'])
                            && session()->get("halaman")['50']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mdepartemen' ? 'active' : ''; ?>" href="<?= base_url("mdepartemen"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Departemen</span></a>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['84']['act_read'])
                            && session()->get("halaman")['84']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mjamkerja' ? 'active' : ''; ?>" href="<?= base_url("mjamkerja"); ?>" aria-expanded="false"><i class="fa fa-clock-o"></i><span class="hide-menu">Jam Kerja</span></a>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['85']['act_read'])
                            && session()->get("halaman")['85']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mlibur' ? 'active' : ''; ?>" href="<?= base_url("mlibur"); ?>" aria-expanded="false"><i class="fa fa-clock-o"></i><span class="hide-menu">Libur</span></a>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['91']['act_read'])
                            && session()->get("halaman")['91']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mramadlan' ? 'active' : ''; ?>" href="<?= base_url("mramadlan"); ?>" aria-expanded="false"><i class="fa fa-clock-o"></i><span class="hide-menu">Ramadlan</span></a>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['86']['act_read'])
                            && session()->get("halaman")['86']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mcuti' ? 'active' : ''; ?>" href="<?= base_url("mcuti"); ?>" aria-expanded="false"><i class="fa fa-clock-o"></i><span class="hide-menu">Cuti</span></a>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['87']['act_read'])
                            && session()->get("halaman")['87']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mtunjangan' ? 'active' : ''; ?>" href="<?= base_url("mtunjangan"); ?>" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">Tunjangan</span></a>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['88']['act_read'])
                            && session()->get("halaman")['88']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mbpjs' ? 'active' : ''; ?>" href="<?= base_url("mbpjs"); ?>" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">BPJS</span></a>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['90']['act_read'])
                            && session()->get("halaman")['90']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'minventaris' ? 'active' : ''; ?>" href="<?= base_url("minventaris"); ?>" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">Inventaris</span></a>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['94']['act_read'])
                            && session()->get("halaman")['94']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mter' ? 'active' : ''; ?>" href="<?= base_url("mter"); ?>" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">TER</span></a>
                        </li>
                    <?php } ?>

                    
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['94']['act_read'])
                            && session()->get("halaman")['94']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'mkalender' ? 'active' : ''; ?>" href="<?= base_url("mkalender"); ?>" aria-expanded="false"><i class="fa fa-calendar"></i><span class="hide-menu">Kalender</span></a>
                        </li>
                    <?php } ?>
                    
                    

                <?php } ?>




                <!-- //Transaction// -->
                <?php
                if (
                    (
                        isset(session()->get("position_id")[0][0])
                        && (
                            session()->get("position_id") == "1"
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['9']['act_read'])
                        && session()->get("halaman")['9']['act_read'] == "1"
                    )
                ) { ?>
                    <li class="nav-label">Transaksi</li>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['95']['act_read'])
                            && session()->get("halaman")['95']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'cutihutang' ? 'active' : ''; ?>" href="<?= base_url("cutihutang"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Hutang Cuti</span></a>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['92']['act_read'])
                            && session()->get("halaman")['92']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'lembur' ? 'active' : ''; ?>" href="<?= base_url("lembur"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Lembur</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['98']['act_read'])
                            && session()->get("halaman")['98']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'kontrak' ? 'active' : ''; ?>" href="<?= base_url("kontrak"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Kontrak</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['99']['act_read'])
                            && session()->get("halaman")['99']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'bpjsstatus' ? 'active' : ''; ?>" href="<?= base_url("bpjsstatus"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Status BPJS</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['100']['act_read'])
                            && session()->get("halaman")['100']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'bpjsdata' ? 'active' : ''; ?>" href="<?= base_url("bpjsdata"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Data BPJS</span></a>
                        </li>
                    <?php } ?>

                     <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['97']['act_read'])
                            && session()->get("halaman")['97']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'lain' ? 'active' : ''; ?>" href="<?= base_url("lain"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Lain-lain</span></a>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['60']['act_read'])
                            && session()->get("halaman")['60']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'absen' ? 'active' : ''; ?>" href="<?= base_url("absen"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Absensi</span></a>
                        </li>
                    <?php } ?>
                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['60']['act_read'])
                            && session()->get("halaman")['60']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'gaji' ? 'active' : ''; ?>" href="<?= base_url("gaji"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Penggajian</span></a>
                        </li>
                    <?php } ?>

                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['93']['act_read'])
                            && session()->get("halaman")['93']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'inventarist' ? 'active' : ''; ?>" href="<?= base_url("inventarist"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Pot. Inventaris</span></a>
                        </li>
                    <?php } ?>


                <?php } ?>











                <!-- //Report// -->
                <?php

                // dd(session()->get("halaman")) ;
                if (
                    (
                        isset(session()->get("position_id")[0][0])
                        && (
                            session()->get("position_id") == "1"
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['14']['act_read'])
                        && session()->get("halaman")['14']['act_read'] == "1"
                    )
                ) { ?>
                    <li class="nav-label">Laporan</li>

                    
                    <?php
                    if (
                        (
                            isset(session()->get("position_id")[0][0])
                            && (
                                session()->get("position_id") == "1"
                                || session()->get("position_id") == "2"
                            )
                        ) ||
                        (
                            isset(session()->get("halaman")['96']['act_read'])
                            && session()->get("halaman")['96']['act_read'] == "1"
                        )
                    ) { ?>
                        <li>
                            <a class="<?= current_url(true)->getSegment(1) == 'rcutihutang' ? 'active' : ''; ?>" href="<?= base_url("rcutihutang"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Sisa Cuti</span></a>
                        </li>
                    <?php } ?>

                <?php } ?>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>