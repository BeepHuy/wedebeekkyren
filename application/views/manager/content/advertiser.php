<div class="row">
    <div class="box col-md-12">
        <div data-original-title="" class="box-header">
            <h2><i class="glyphicon glyphicon-user"></i><span class="break"></span>Members</h2>
            <div class="box-icon">
                <!-- <a class="btn-add" href="<?php echo base_url() . $this->config->item('manager') . '/addusers/'; ?>"><i class="glyphicon glyphicon-plus"></i></a> -->
                <a class="btn-add" href="#"><i class="glyphicon glyphicon-plus"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
        <!-- <?php echo base_url('v3/regmanager/'.$this->managerid);?> -->
            <table class="table table-striped table-bordered">
                <thead>
                    <tr role="row">
                        <th>Id</th>
                        <th>Email address</th>
                        <th>Website</th>
                        <th>Skype | Telegarm</th>
                        <th>Date</th>
                        <th>Country</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dulieu)) {
                        foreach ($dulieu as $dulieu) { ?>
                            <tr>
                                <td><?php echo $dulieu->id; ?></td>
                                <td><?php echo $dulieu->email; ?></td>
                                <td>
                                    <?php $info = unserialize($dulieu->mailling);
                                    echo $info['website']; ?>
                                </td>
                                <td><?php echo $info['im_service']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($dulieu->created)); ?></td>
                                <td><?php echo $info['country']; ?></td>
                            </tr> <?php }
                            } ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <div style="margin:20px 0;float:left" class="form-group form-inline filter">
                        <select title="<?php echo $this->uri->segment(3); ?>" name="filter_cat" size="1" class="form-control input-sm">
                            <option value="0">all</option>
                            <?php
                            if (!empty($category)) {
                                $where = $this->session->userdata('where');

                                foreach ($category as $category1) {
                                    echo '
                                            <option value="' . $category1->id . '"';
                                    if (!empty($where['manager'])) {
                                        echo $where['manager'] == $category1->id ? ' selected' : '';
                                    }
                                    echo '>' . $category1->title . '</option>
                                        ';
                                }
                            }
                            ?>
                        </select>
                        <label></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/span-->
</div>
<!-- phan modal--->

<!-- Large modal -->


<!--end modal--->