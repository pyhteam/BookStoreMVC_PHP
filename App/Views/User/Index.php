<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Danh Sách Tài Khoản
                <a href="/user/create" class="btn btn-success btn-sm float-right">
                    <i class="fa fa-plus"></i>
                    Thêm Mới
                </a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>FullName</th>
                            <th>RoleName</th>
                            <th>CreatedAt</th>
                            <th>CreatedBy</th>
                            <th>UpdatedAt</th>
                            <th>UpdatedBy</th>
                            <th>IsActive</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= $user->Id ?></td>
                                <td><?= $user->Username; ?></td>
                                <td><?= $user->Email; ?></td>
                                <td><?= $user->FullName; ?></td>
                                <td><?= $user->RoleName; ?></td>
                                <td><?= $user->CreatedAt; ?></td>
                                <td><?= $user->CreatedBy; ?></td>
                                <td><?= $user->UpdatedAt; ?></td>
                                <td><?= $user->UpdatedBy; ?></td>
                                <td><?= ($user->IsActive == true) ? 'Active' : 'Inactive'; ?></td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="/user/edit/<?= $user->Id ?>">Edit</a>
                                    <button onclick="remove('<?= $user->Id ?>')" type="button" class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="col-sm-12">
        <?= $pagination->createLinks(); ?>
    </div>
</div>

<script>
    function remove(id) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa?',
            text: "Bạn sẽ không thể khôi phục lại dữ liệu này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/user/delete/' + id,
                    method: 'DELETE',
                    contentType: 'application/json',
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(err) {
                        console.log(err);
                        if (err.status == 200) {
                            Swal.fire(
                                'Đã xóa!',
                                'Dữ liệu đã được xóa.',
                                'success'
                            )
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                            return;
                        }
                    }
                });
            }
        })
    }
</script>