<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-10">
            <h3 class="page-header"><?php echo $title; ?></h3>
        </div>
        <div class="col-lg-2">
            <a href="<?php echo site_url('users/addUser'); ?>" class="page-header btn btn-success pull-right">Add User</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo $title; ?>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Sn</th>
                                <th>name</th>
                                <th>email</th>
                                <th>phonenumber</th>
                                <th>address</th>
                                <?php if ($this->session->userdata('is_logged_in') && $this->session->userdata('role') == 0) { ?>
                                <th>Action</th>
                            <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($users as $users_item): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $users_item['fullname']; ?></td>
                                    <td><?php echo $users_item['email']; ?></td>
                                    <td><?php echo $users_item['phonenumber']; ?></td>
                                    <td><?php echo $users_item['address']; ?></td>
                                        <?php if ($this->session->userdata('is_logged_in') && $this->session->userdata('role') == 0) { ?>
                                            <td>
                                            <a href="<?php echo site_url('users/edit/'.$users_item['id']); ?>"><label
                                                        style="cursor: pointer;">Edit</label></a> |
                                            <a href="<?php echo site_url('users/delete/'.$users_item['id']); ?>"
                                               onClick="return confirm('Are you sure you want to delete?')">
                                                <label style="cursor: pointer;">Delete</label></a>
                                            </td>
                                        <?php } // end if ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>