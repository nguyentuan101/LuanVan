<div class="benh_search" id="benh_search">
            <div class="basic-search">
                <label id="search">Loại Bệnh</label>
            </div>
            <div class="list_all_benh">            
                <div class="all_benh">
                    <?php
                        $subClass_benh = get_subClassOf_benh();
                        if (isset($subClass_benh)) {
                            foreach( $subClass_benh as $row ){  ?>
                                <p><?php print $row['label']; ?></p>
                                <div class="part_benh">
                                    <?php   // Danh sach loai benh
                                        $loaibenh2 = get_all_benh($row['loaibenh']);
                                        if (isset($loaibenh2)) {
                                            foreach( $loaibenh2 as $row2 ){?>
                                                <div class="element_benh">
                                                    <a href="desease-detail.php?id=<?php print urlencode($row2['loaibenh']); ?>">
                                                        <div class="ptram"><span>  </span></div>
                                                        <span> <?php print $row2['label']; ?> </span>
                                                    </a>
                                                </div>
                                            <?php  }
                                        } ?>
                                </div>
                            <?php }
                        } ?>  
                </div>    
            </div>
        </div>  <!-- benh_search -->