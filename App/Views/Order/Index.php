<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Danh Sách Order
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>ShipName</th>
                            <th>ShipAddress</th>
                            <th>ShipPhone</th>
                            <th>TotalPrice</th>
                            <th>Status</th>


                            <th>CreatedAt</th>
                            <th>CreatedBy</th>
                            <th>UpdatedAt</th>
                            <th>UpdatedBy</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; foreach ($orders as $item) : ?>
                            <tr>
                                <td><?= $index ?></td>
                                <td><?= $item->Username ?></td>
                                <td><?= $item->ShipName ?></td>
                                <td><?= $item->ShipAddress ?></td>
                                <td><?= $item->ShipPhone ?></td>
                                <td><?= $item->TotalPrice ?></td>
                                <td><?php 
                                switch($item->Status){
                                    case 'Pending':
                                        echo '<span class="badge badge-warning">Đang chờ</span>';
                                        break;
                                    case 'Approved':
                                        echo '<span class="badge badge-success">Đã duyệt</span>';
                                        break;
                                    case 'Cancelled':
                                        echo '<span class="badge badge-danger">Đã hủy</span>';
                                        break;
                                    default:
                                        echo '<span class="badge badge-dark">Unknown</span>';
                                        break;
                                }
                                ?></td>

                                <td><?= $item->CreatedAt; ?></td>
                                <td><?= $item->CreatedBy; ?></td>
                                <td><?= $item->UpdatedAt; ?></td>
                                <td><?= $item->UpdatedBy; ?></td>
                                <td>
                                    <a href="/order/detail/<?= $item->Id ?>" class="btn btn-primary btn-sm">Chi tiết</a>
                                    <button class="btn btn-success btn-sm" onclick="approve('<?= $item->Id ?>')" type="button">Duyệt đơn</button>
                                    <button onclick="remove('<?= $item->Id ?>')" type="button" class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        <?php $index++; endforeach; ?>
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
                    url: '/order/delete/' + id,
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

    function approve(id) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn duyệt đơn hàng này?',
            text: "Bạn sẽ không thể khôi phục lại dữ liệu này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Duyệt',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/order/update-status/' + id,
                    method: 'POST',
                    contentType: 'application/json',
                    success: function(res) {
                        console.log(res);
                        if (res.success == true) {
                            Swal.fire(
                                'Đã duyệt!',
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