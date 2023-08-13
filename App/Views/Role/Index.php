<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Danh Sách Quyền
                <a href="/role/create" class="btn btn-success btn-sm float-right">
                    <i class="fa fa-plus"></i>
                    Thêm Mới
                </a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>CreatedAt</th>
                            <th>CreatedBy</th>
                            <th>UpdatedAt</th>
                            <th>UpdatedBy</th>
                            <th>IsActive</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roles as $role) : ?>
                            <tr>
                                <td><?= $role->Id ?></td>
                                <td><?= $role->Name; ?></td>
                                <td><?= $role->CreatedAt; ?></td>
                                <td><?= $role->CreatedBy; ?></td>
                                <td><?= $role->UpdatedAt; ?></td>
                                <td><?= $role->UpdatedBy; ?></td>
                                <td><?= ($role->IsActive == true) ? 'Active' : 'Inactive'; ?></td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="/role/edit/<?= $role->Id ?>">Edit</a>
                                    <button onclick="remove('<?= $role->Id ?>')" type="button" class="btn btn-danger btn-sm">Delete</button>
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
                    url: '/role/delete/' + id,
                    method: 'DELETE',
                    contentType: 'application/json',
                    success: function(res) {
                        console.log(res);
                        if (res.success == true) {
                            Swal.fire(
                                'Đã xóa!',
                                res.message,
                                'success'
                            )
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                            return;
                        }
                    },
                    error: function(err) {
                        console.log(err);
                        Swal.fire(
                            'Error!',
                            'Something went wrong!',
                            'error'
                        )
                    }
                });
            }
        })
    }
</script>