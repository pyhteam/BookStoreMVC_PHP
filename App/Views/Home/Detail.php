<?php

use App\Services\Common\Helper;
use App\Services\Common\Session;

?>
<!-- ----------single product details------------- -->
<div class="small-container single-product">
    <div class="row">
        <div class="col-2">
            <img src="<?= $book->Image ?>" alt="<?= $book->Slug ?>" width="68%" />
        </div>
        <div class="col-2">
            <h1><?= $book->Title ?></h1>
            <h4><?= Helper::formatCurrencyVND($book->Price) ?></h4>
            <input type="number" id="Quantity" min="1" max="100" value="1" />
            <button type="button" onclick="addToCart()" class="btn">Thêm vào giỏ hàng</button>
            <h3>Mô tả <i class="fa fa-indent"></i></h3>
            <br />
            <p><?= $book->Description ?></p>
        </div>
    </div>
</div>

<!-- -------------title----------------- -->
<div class="small-container">
    <div class="row row-2">
        <h2>Sách liên quan</h2>
        <p>View More</p>
    </div>
</div>
<!-- --------------Product-------------- -->
<div class="small-container">
    <div class="row">
        <?php foreach ($booksRelated as $item) : ?>
            <div class="col-4">
                <a href="/home/detail/<?= $item->Slug ?>/<?= $item->Id ?>">
                    <img src="<?php echo $item->Image ?>" alt="<?= $item->Slug ?>">
                    <a href="/home/detail/<?= $item->Slug ?>/<?= $item->Id ?>">
                        <h4><?= $item->Title ?></h4>
                    </a>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                    <p><?= Helper::formatCurrencyVND($item->Price) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    function addToCart() {
        isLogin = <?= Session::has('user') ? 'true' : 'false' ?>;

        if (!isLogin) {
            Swal.fire({
                icon: 'error',
                title: 'Bạn chưa đăng nhập',
                text: 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng',
                footer: '<a href="/account">Đăng nhập</a>'
            })
            return;
        }
        let cart = {
            UserId: '<?= Session::get('user')->Id ?? 'null'  ?>;',
            BookId: '<?= $book->Id ?>',
            Book: <?= json_encode($book) ?>,
            Quantity: $('#Quantity').val(),
            Price: <?= $book->Price ?>
        };

        let carts = JSON.parse(localStorage.getItem('carts'));
        if (carts == null) {
            carts = [];
        }
        let index = carts.findIndex(x => x.BookId == cart.BookId && x.UserId == cart.UserId);
        if (index == -1) {
            carts.push(cart);
        } else {
            carts[index].Quantity = parseInt(carts[index].Quantity) + parseInt(cart.Quantity);
        }
        localStorage.setItem('carts', JSON.stringify(carts));
        Swal.fire({
            icon: 'success',
            title: 'Thêm vào giỏ hàng thành công',
            showConfirmButton: false,
            timer: 1500
        })
        setTimeout(function() {
            location.reload();
        }, 1500);
    }
</script>