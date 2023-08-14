<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Thêm Mới Sách</div>
            <div class="card-body">
                <form method="post" action="/book/create" class="row">
                    <div class="form-group col-6">
                        <label for="name">Tên Sách</label>
                        <input type="text" class="form-control" id="Title" name="Title" placeholder="Enter Title" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="name">Tác Giả</label>
                        <input type="text" class="form-control" id="Author" name="Author" placeholder="Enter Author" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="name">Thể Loại</label>
                        <select class="form-control" id="CategoryId" name="CategoryId" required>
                            <option value="">-- Chọn Thể Loại --</option>
                            <?php foreach ($bookCategories as $item) : ?>
                                <option value="<?= $item->Id ?>"><?= $item->Name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="name">Giá</label>
                        <input type="number" class="form-control" id="Price" name="Price" placeholder="Enter Price" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="name">Số Lượng</label>
                        <input type="number" class="form-control" id="Quantity" name="Quantity" placeholder="Enter Quantity" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="name">Link Ảnh</label>
                        <input type="text" class="form-control" id="Image" name="Image" placeholder="Enter Image" required>
                        <div class="image">
                            <img src="" alt="" id="image" width="100px" height="100px">
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="name">Mô Tả</label>
                        <textarea id="editor" name="Description" placeholder="Enter Description"></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <a href="/book" class="btn btn-primary">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    let theEditor;
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            theEditor = editor; // Save for later use.
        })
        .catch(error => {
            console.error(error);
        });

    function getDataFromTheEditor() {
        return theEditor.getData();
    }
    document.getElementById('Image').addEventListener('change', function() {
        var img = document.getElementById('image');
        img.src = this.value;
    });
</script>