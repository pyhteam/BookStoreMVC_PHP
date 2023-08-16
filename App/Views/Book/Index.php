<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Danh Sách Book
                <a href="/book/create" class="btn btn-success btn-sm float-right">
                    <i class="fa fa-plus"></i>
                    Thêm Mới
                </a>
                <!-- Form Search -->
                <div class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input onkeyup="search()" id="keySearch" type="text" class="form-control" placeholder="Search...">
                        <button onclick="search()" class="btn btn-primary" type="button">
                            <i class="bx bx-search-alt align-middle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>CategoryName</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Slug</th>
                            <th>CreatedAt</th>
                            <th>CreatedBy</th>
                            <th>UpdatedAt</th>
                            <th>UpdatedBy</th>
                            <th>IsActive</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        <?php foreach ($books as $item) : ?>
                            <tr>
                                <td><?= $item->Id ?></td>
                                <td><?= $item->Title; ?></td>
                                <td><?= $item->Author; ?></td>

                                <td><?= $item->CategoryName; ?></td>
                                <td><?= $item->Price; ?></td>
                                <td><?= $item->Quantity; ?></td>
                                <td><?= $item->Image ? '<img src="' . $item->Image . '" width="60px" height="60px">' : 'No Image'; ?></td>
                                <td><?= $item->Slug; ?></td>


                                <td><?= $item->CreatedAt; ?></td>
                                <td><?= $item->CreatedBy; ?></td>
                                <td><?= $item->UpdatedAt; ?></td>
                                <td><?= $item->UpdatedBy; ?></td>
                                <td><?= ($item->IsActive == true) ? 'Active' : 'Inactive'; ?></td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="/book/edit/<?= $item->Id ?>">Edit</a>
                                    <button onclick="remove('<?= $item->Id ?>')" type="button" class="btn btn-danger btn-sm">Delete</button>
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
                    url: '/book/delete/' + id,
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

    function search() {
        var key = $('#keySearch').val();
        $.ajax({
            url: '/book/search/' + key,
            method: 'POST',
            contentType: 'application/json',
            success: function(res) {
                console.log(res);
                if (res.success == true) {
                    var html = '';
                    res.data.forEach(element => {
                        html += `
                        <tr>
                            <td>${element.Id}</td>
                            <td>${element.Title}</td>
                            <td>${element.Author}</td>
                            <td>${element.CategoryName}</td>
                            <td>${element.Price}</td>
                            <td>${element.Quantity}</td>
                            <td>${element.Image ? '<img src="' + element.Image + '" width="60px" height="60px">' : 'No Image'}</td>
                            <td>${element.Slug}</td>
                            <td>${element.CreatedAt}</td>
                            <td>${element.CreatedBy}</td>
                            <td>${element.UpdatedAt}</td>
                            <td>${element.UpdatedBy}</td>
                            <td>${(element.IsActive == true) ? 'Active' : 'Inactive'}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="/book/edit/${element.Id}">Edit</a>
                                <button onclick="remove('${element.Id}')" type="button" class="btn btn-danger btn-sm">Delete</button>
                            </td> 
                        `
                    });
                    $('#dataTable').html(html);
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
</script>