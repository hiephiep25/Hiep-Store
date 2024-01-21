<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }} "/>
    <link rel="shortcut icon" href="images/fav-icon.png') }}" />
    <link
      rel="stylesheet"
      href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
      integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
      crossorigin="anonymous"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Hiep Hiep Store</title>
  </head>
  <body>
    <!--==Navigation================================-->
    <nav class="navigation">
      <!--logo-------->
      <a href="" class="logo"> <span>e</span>Grocery </a>
      <!--menu-btn---->
      <input type="checkbox" class="menu-btn" id="menu-btn" />
      <label for="menu-btn" class="menu-icon">
        <span class="nav-icon"></span>
      </label>
      <!--menu-------->
      <ul class="menu">
        <li><a href="" class="active">Home</a></li>
        <li><a href="#category">Categories</a></li>
        <li><a href="#popular-bundle-pack">Our Packages</a></li>
        <li><a href="#download-app">Our App</a></li>
        <li><a href="/admin" style="color: white">Admin</a></li>
      </ul>
      <!--right-nav-(cart-like)-->
      <div class="right-nav">
        <!--like----->
        <a href="#" class="like">
          <i class="far fa-heart"></i>
          <span>0</span>
        </a>
        <!--cart----->
        <a href="#" class="cart">
          <i class="fas fa-shopping-cart"></i>
          <span>0</span>
        </a>
      </div>
    </nav>
    <!--nav-end--------------------->
    <!--==Search-banner=======================================-->
    <section id="search-banner">
      <!--bg--------->
      <img src="{{ asset('images/images/bg-1.png') }}" class="bg-1" alt="bg" />
      <img src="{{ asset('images/images/bg-2.png') }}" class="bg-2" alt="bg-2" />
      <!--text------->
      <div class="search-banner-text">
        <h1>Order Your daily Groceries</h1>
        <strong>#Free Delivery</strong>
        <!--search-box------>
        <form action="" class="search-box">
          <!--icon------>
          <i class="fas fa-search"></i>
          <!--input----->
          <input
            type="text"
            class="search-input"
            placeholder="Search your daily groceries"
            name="search"
            required
          />
          <!--btn------->
          <input type="submit" class="search-btn" value="Search" />
        </form>
      </div>
    </section>
    <!--search-banner-end--------------->
    <!--==category=========================================-->
    <section id="category">
      <!--heading---------------->
      <div class="category-heading">
        <h2>Category</h2>
        <span>All</span>
      </div>
      <!--box-container---------->
      <div class="category-container">
        <!--box---------------->
        <a href="#" class="category-box">
          <img src="{{ asset('images/images/fish.png') }}" alt="Fish" />
          <span>Fish & Meat</span>
        </a>
        <!--box---------------->
        <a href="#" class="category-box">
          <img src="{{ asset('images/images/Vegetables.png') }}" alt="Fish" />
          <span>Vegatbles</span>
        </a>
        <!--box---------------->
        <a href="#" class="category-box">
          <img src="{{ asset('images/images/medicine.png') }}" alt="Fish" />
          <span>Medicine</span>
        </a>
        <!--box---------------->
        <a href="#" class="category-box">
          <img src="{{ asset('images/images/baby.png') }}" alt="Fish" />
          <span>Baby</span>
        </a>
        <!--box---------------->
        <a href="#" class="category-box">
          <img src="{{ asset('images/images/office.png') }}" alt="Fish" />
          <span>Office</span>
        </a>
        <!--box---------------->
        <a href="#" class="category-box">
          <img src="{{ asset('images/images/beauty.png') }}" alt="Fish" />
          <span>Beauty</span>
        </a>
        <!--box---------------->
        <a href="#" class="category-box">
          <img src="{{ asset('images/images/Gardening.png') }}" alt="Fish" />
          <span>Gardening</span>
        </a>
      </div>
    </section>
    <!--category-end----------------------------------->
    <!--==Products====================================-->
    <section id="popular-product">
      <!--heading----------->
      <div class="product-heading">
        <h3>Popular Product</h3>
        <span>All</span>
      </div>
      <!--box-container------>
      <div class="product-container">
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/apple.png') }}" alt="apple" />
          <strong>Apple</strong>
          <span class="quantity">1 KG</span>
          <span class="price">2$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/chili.png') }}" alt="apple" />
          <strong>Chili</strong>
          <span class="quantity">1 KG</span>
          <span class="price">3$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/onion.png') }}" alt="apple" />
          <strong>Onion</strong>
          <span class="quantity">1 KG</span>
          <span class="price">1$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/patato.png') }}" alt="apple" />
          <strong>Patato</strong>
          <span class="quantity">1 KG</span>
          <span class="price">2.2$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/garlic.png') }}" alt="apple" />
          <strong>Garlic</strong>
          <span class="quantity">1 KG</span>
          <span class="price">3$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/tamato.png') }}" alt="apple" />
          <strong>Tamato</strong>
          <span class="quantity">1 KG</span>
          <span class="price">1.4$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
      </div>
    </section>
    <!--popular-product-end--------------------->
    <!--Popular-bundle-pack===================================-->
    <section id="popular-bundle-pack">
      <!--heading-------------->
      <div class="product-heading">
        <h3>Popular Bundle Pack</h3>
      </div>
      <!--box-container------>
      <div class="product-container">
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/pack1.png') }}" alt="pack" />
          <strong>Big Pack</strong>
          <span class="quantity">Lemone, Tamato, Patato,+4</span>
          <span class="price">9$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/pack2.jpg') }}" alt="apple" />
          <strong>Large Pack</strong>
          <span class="quantity">Lemone, Tamato, Patato,+2</span>
          <span class="price">5$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/pack3.png') }}" alt="apple" />
          <strong>Small Pack</strong>
          <span class="quantity">Lemone, Tamato, Patato</span>
          <span class="price">3$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/pack1.png') }}" alt="pack" />
          <strong>Big Pack</strong>
          <span class="quantity">Lemone, Tamato, Patato,+4</span>
          <span class="price">9$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/pack2.jpg')}}" alt="apple" />
          <strong>Large Pack</strong>
          <span class="quantity">Lemone, Tamato, Patato,+2</span>
          <span class="price">5$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
        <!--box---------->
        <div class="product-box">
          <img src="{{ asset('images/images/pack3.png') }}" alt="apple" />
          <strong>Small Pack</strong>
          <span class="quantity">Lemone, Tamato, Patato</span>
          <span class="price">3$</span>
          <!--cart-btn------->
          <a href="#" class="cart-btn">
            <i class="fas fa-shopping-bag"></i> Add Cart
          </a>
          <!--like-btn------->
          <a href="#" class="like-btn">
            <i class="far fa-heart"></i>
          </a>
        </div>
      </div>
    </section>
    <!--popular-bundle-pack-end-------------------------------->
    <!--==Clients===============================================-->
    <section id="clients">
      <!--heading---------------->
      <div class="client-heading">
        <h3>What Our Client's Say</h3>
      </div>
      <!--box-container---------->
      <div class="client-box-container">
        <!--box------------->
        <div class="client-box">
          <!--==profile===-->
          <div class="client-profile">
            <!--img--->
            <img src="{{ asset('images/images/client-1.jpg')}}" alt="client" />
            <!--text-->
            <div class="profile-text">
              <strong>James Mcavoy</strong>
              <span>CEO</span>
            </div>
          </div>
          <!--==Rating======-->
          <div class="rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <!--==comments===-->
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugiat ea
            id, itaque architecto atque mollitia aperiam voluptatem consequatur
            incidunt sed placeat, harum recusandae quaerat at hic labore eius
            laborum quas!
          </p>
        </div>
        <!--box------------->
        <div class="client-box">
          <!--==profile===-->
          <div class="client-profile">
            <!--img--->
            <img src="{{ asset('images/images/client-2.jpg')}}" alt="client" />
            <!--text-->
            <div class="profile-text">
              <strong>Adward Mcavoy</strong>
              <span>Software Developer</span>
            </div>
          </div>
          <!--==Rating======-->
          <div class="rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <!--==comments===-->
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugiat ea
            id, itaque architecto atque mollitia aperiam voluptatem consequatur
            incidunt sed placeat, harum recusandae quaerat at hic labore eius
            laborum quas!
          </p>
        </div>
        <!--box------------->
        <div class="client-box">
          <!--==profile===-->
          <div class="client-profile">
            <!--img--->
            <img src="{{ asset('images/images/client-3.jpg')}}" alt="client" />
            <!--text-->
            <div class="profile-text">
              <strong>Ava Alex</strong>
              <span>Marketer</span>
            </div>
          </div>
          <!--==Rating======-->
          <div class="rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <!--==comments===-->
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugiat ea
            id, itaque architecto atque mollitia aperiam voluptatem consequatur
            incidunt sed placeat, harum recusandae quaerat at hic labore eius
            laborum quas!
          </p>
        </div>
      </div>
    </section>
    <!--client-section-end---------->
    <!--==Partnre-logo================================-->
    <section id="partner">
      <!--heading------------>
      <div class="partner-heading">
        <h3>Our Trusted Partner</h3>
      </div>
      <!--logo-container----->
      <div class="logo-container">
        <img src="{{ asset('images/images/logo-1.png') }}" alt="logo" />
        <img src="{{ asset('images/images/logo-2.png') }}" alt="logo" />
        <img src="{{ asset('images/images/logo-3.png') }}" alt="logo" />
        <img src="{{ asset('images/images/logo-4.png') }}" alt="logo" />
      </div>
    </section>
    <!--logo-section-end--------------------->
    <!--==download-app====================================-->
    <section id="download-app">
      <!--img----------------------->
      <div class="app-img">
        <img src="{{ asset('images/images/mobile-app.png') }}" alt="app" />
      </div>
      <!--text---------------------->
      <div class="download-app-text">
        <strong>Download App</strong>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Id officiis,
          ratione, non doloribus similique nam aliquam doloremque, ipsa neque
          voluptas at recusandae est cumque ipsum. Vel sint libero odit placeat?
        </p>
        <!--btns------->
        <div class="download-btns">
          <a href="#"><img src="{{ asset('images/images/appstore-btn.png') }}" alt="" /></a>
          <a href="#"><img src="{{ asset('images/images/googleplay-btn.png') }}" alt="" /></a>
        </div>
      </div>
    </section>
    <!--download-app-section-end------------------------->
    <!--==Footer=============================================-->
    <footer>
      <div class="footer-container">
        <!--logo-container------>
        <div class="footer-logo">
          <a href="#"><span>e</span>Grocery</a>
          <!--social----->
          <div class="footer-social">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
        <!--links------------------------->
        <div class="footer-links">
          <strong>Product</strong>
          <ul>
            <li><a href="#">Clothes</a></li>
            <li><a href="#">Packages</a></li>
            <li><a href="#">Popular</a></li>
            <li><a href="#">New</a></li>
          </ul>
        </div>
        <!--links------------------------->
        <div class="footer-links">
          <strong>Category</strong>
          <ul>
            <li><a href="#">Beauty</a></li>
            <li><a href="#">Meats</a></li>
            <li><a href="#">Kids</a></li>
            <li><a href="#">Clothes</a></li>
          </ul>
        </div>
        <!--links-------------------------->
        <div class="footer-links">
          <strong>Contact</strong>
          <ul>
            <li><a href="#">Phone : +123456789</a></li>
            <li><a href="#">Email : Example@gmail.com</a></li>
          </ul>
        </div>
      </div>
    </footer>
  </body>
</html>
