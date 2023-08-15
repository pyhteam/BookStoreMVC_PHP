<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? "Book Store" ?></title>
    <link rel="stylesheet" href="/assets-client/style.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?
      family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="/assets/images/EbookStore-Logo.png" rel="icon" />
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- jquery -->
    <script src="/assets/libs/jquery/jquery.min.js"></script>
</head>

<body>
    <!------------------ Header ------------------>
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="index.html">
                        <img src="/assets-client/images/EbookStore-Logo.png" alt="EbookStore-Logo" /></a>
                </div>
                <!----------  Nav Bar ------------------>
                <nav>
                    <ul id="MenuItems">
                        <li><a href="/">Home</a></li>
                        <li><a href="/ebook">Ebooks</a></li>
                        <li><a href="/about">About</a></li>
                        <li><a href="/contact">Contact</a></li>
                        <li><a href="/account">Account</a></li>
                    </ul>
                </nav>
                <a href="cart.html">
                    <img src="/assets-client/images/cart.png" alt="Shoping Cart" width="28px" height="28px" style="margin-left: 10px; margin-top: 15px" />
                </a>
                <img src="/assets-client/images/menu.png" class="menu-icon" onclick="menutoggle()" />
            </div>

        </div>
    </div>
    <!----------------featured Books -------------------->
    <?php include_once "../App/Views/" . $viewName . ".php"; ?>
    <!------------------offer ------------>
    <div class="offer">
        <div class="small-container">
            <div class="row">
                <div class="col-2">
                    <img src="/assets-client/images/offer-Book.jpg" class="offer-img" />
                </div>
                <div class="col-2">
                    <p>Available on EbookStore</p>
                    <br />
                    <h2>I Don't Want To Die Poor</h2>
                    <br />
                    <small>
                        Making Michael Arceneaux's I Don't Want to Die Poor required
                        reading in high schools across the country would help a lot of
                        young people think twice about the promise that going to college
                        at any cost is the only path to upward social mobility.
                    </small>
                    <a href="#" class="btn">Buy Now &#8594;</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ---------------------publishers------------------- -->
    <div class="publishers">
        <div class="small-container">
            <div class="row">
                <div class="col-5">
                    <img src="/assets-client/images/publisher1.jpg" />
                </div>
                <div class="col-5">
                    <img src="/assets-client/images/publisher2.png" />
                </div>
                <div class="col-5">
                    <img src="/assets-client/images/publisher3.jpeg" />
                </div>
                <div class="col-5">
                    <img src="/assets-client/images/publisher4.jpg" />
                </div>
                <div class="col-5">
                    <img src="/assets-client/images/publisher5.jpg" />
                </div>
            </div>
        </div>
    </div>

    <!-- ---------------------footer------------------- -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <h3>Download Our App</h3>
                    <p>Download App for Android and ios mobile phone.</p>
                    <div class="app-logo">
                        <img src="/assets-client/images/Playstore.png" />
                        <img src="/assets-client/images/Applestore.png" />
                    </div>
                </div>
                <div class="footer-col-2">
                    <img src="/assets-client/images/EbookStore-Logo-footer.png" />
                    <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Reiciendis, Lorem ipsum dolor sit amet.
                    </p>
                </div>
                <div class="footer-col-3">
                    <h3>Useful Links</h3>
                    <ul>
                        <li>Coupons</li>
                        <li>Blog Post</li>
                        <li>Return Policy</li>
                        <li>Join Affiliate</li>
                    </ul>
                </div>
                <div class="footer-col-4">
                    <h3>Follow us</h3>
                    <ul>
                        <li>Facebook</li>
                        <li>Youtube</li>
                        <li>Instagram</li>
                        <li>Twitterr</li>
                    </ul>
                </div>
            </div>
            <hr />
            <p class="copyright">Copyright 2020 - EbookStore</p>
        </div>
    </div>
    <!-- ---------Javascript for toggle menu------------- -->
    <script>
        var MenuItems = document.getElementById("MenuItems");
        MenuItems.style.maxHeight = "0px";

        function menutoggle() {
            if (MenuItems.style.maxHeight == "0px") {
                MenuItems.style.maxHeight = "200px";
            } else {
                MenuItems.style.maxHeight = "0px";
            }
        }
    </script>
</body>

</html>