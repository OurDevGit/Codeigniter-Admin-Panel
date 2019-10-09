<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-10">
            <h3 class="page-header"><?php echo $title; ?></h3>
        </div>
        <div class="col-lg-2">
            <a href="<?php echo site_url('news'); ?>" class="page-header btn btn-success pull-right">News List</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $title; ?></div>
                <?php $attributes = array("name" => "addUserform", "role" => "form"); ?>
                <?php echo form_open_multipart('users/addUser', $attributes); ?>
                <div class="panel-body">
                <div class="form-group <?php echo form_error('title') ? 'has-error' : '' ?>"">
                    <label class="control-label"> Name</label>
                    <input name="fullname" placeholder="Eneter Fullname" class="form-control">
                </div>
                <div class="form-group <?php echo form_error('title') ? 'has-error' : '' ?>"">
                    <label class="control-label"> Email</label>
                    <input name="email" placeholder="Eneter Email" class="form-control">
                </div>
                <div class="form-group <?php echo form_error('title') ? 'has-error' : '' ?>"">
                    <label class="control-label"> Phonenumber</label>
                    <input name="phonenumber" placeholder="Eneter Phonenumber" class="form-control">
                </div>
                <div class="form-group <?php echo form_error('title') ? 'has-error' : '' ?>"">
                    <label class="control-label"> Address</label>
                    <input name="address" placeholder="Eneter Address" class="form-control">
                </div>
                <div class="form-group <?php echo form_error('text') ? 'has-error' : '' ?>">
                    <label class="control-label">Enter Password</label>
                    <input name="password" placeholder="Eneter Address" class="form-control">
                </div>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
                <button type="submit" name="submit" class="btn btn-success">Submit</button>
                <a href="<?php echo site_url('users/getUsers'); ?>" class="btn btn-warning">Cancel</a>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
