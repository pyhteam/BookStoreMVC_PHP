<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Thêm Mới Danh Mục Sách</div>
            <div class="card-body">
                <form method="post" action="/book-category/create" class="row">
                    <div class="form-group col-6">
                        <label for="name">Tên Danh Mục Sách</label>
                        <input type="text" class="form-control" id="Name" name="Name" placeholder="Enter name" required>
                    </div>
                    <div class="form-group mt-2">
                        <a href="/book-category" class="btn btn-primary">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>