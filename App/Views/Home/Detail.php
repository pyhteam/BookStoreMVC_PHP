<?php

use App\Services\Common\Helper;

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
            <input type="number" value="1" />
            <a href="" class="btn">Thêm vào giỏ hàng</a>
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