<div class="row">
    <div class="col-12">
        <?php if (isset($message)) : ?>
            <div class="alert alert-success" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header">Sửa Tài Khoản</div>
            <div class="card-body">
                <form method="post" action="/user/edit/<?= $user->Id ?>" class="row">
                    <div class="form-group col-6">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="Username" placeholder="Enter username" value="<?= $user->Username ?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="Email" placeholder="Enter email" value="<?= $user->Email ?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="fullname">Fullname</label>
                        <input type="text" class="form-control" id="fullname" name="FullName" placeholder="Enter fullname" value="<?= $user->FullName ?>">
                    </div>
                    <div class="form-group col-6">
                        <label for="password">Password</label>
                        <input type="password" required class="form-control" id="password" name="Password" placeholder="Enter password">
                    </div>
                    <!-- Choose Role -->
                    <div class="form-group col-6">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="RoleId">
                            <?php foreach ($roles as $role) : ?>
                                <option  value="<?php echo $role->Id ?>"><?php echo $role->Name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <a href="/user" class="btn btn-primary">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>