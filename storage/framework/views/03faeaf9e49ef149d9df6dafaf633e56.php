<?php $__env->startSection('content'); ?>

<main class="site-main">
      <!--================ Hero banner start =================-->
      <section class="hero-banner">
        <div class="container">
          <div class="row no-gutters align-items-center pt-60px">
            <div class="col-5 d-none d-sm-block">
              <div class="hero-banner__img">
                <img class="img-fluid" src="/assets/img/home/hero-banner.png" alt="" />
              </div>
            </div>
            <div class="col-sm-7 col-lg-6 offset-lg-1 pl-4 pl-md-5 pl-lg-0">
              <div class="hero-banner__content">
                <h4>Belanja Itu Menyenangkan</h4>
                <h1>Temukan Produk Premium Pilihan Kami  </h1>
                <p>Kami menghadirkan berbagai produk unggulan dengan kualitas terbaik untuk memenuhi kebutuhan Anda. Belanja lebih mudah, aman, dan menyenangkan hanya di toko kami</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================ Hero banner start =================-->

      <!--================ Hero Carousel start =================-->
      <!-- <section class="section-margin mt-0">
        <div class="owl-carousel owl-theme hero-carousel">
          <div class="hero-carousel__slide">
            <img src="/assets/img/home/hero-slide1.png" alt="" class="img-fluid" />
            <a href="#" class="hero-carousel__slideOverlay">
              <h3>Wireless Headphone</h3>
              <p>Accessories Item</p>
            </a>
          </div>
          <div class="hero-carousel__slide">
            <img src="/assets/img/home/hero-slide2.png" alt="" class="img-fluid" />
            <a href="#" class="hero-carousel__slideOverlay">
              <h3>Wireless Headphone</h3>
              <p>Accessories Item</p>
            </a>
          </div>
          <div class="hero-carousel__slide">
            <img src="/assets/img/home/hero-slide3.png" alt="" class="img-fluid" />
            <a href="#" class="hero-carousel__slideOverlay">
              <h3>Wireless Headphone</h3>
              <p>Accessories Item</p>
            </a>
          </div>
        </div>
      </section> -->
      <!-- ================ About Us section start ================= -->
<section class="section-margin bg-light py-5">
  <div class="container">
    <div class="section-intro pb-4 text-center">
      <p>Learn More About Us</p>
      <h2 class="section-intro__style">Tentang <span class="text-primary">Kami</span></h2>
    </div>
    <div class="row align-items-center">
      <div class="col-lg-6">
        <h3 class="mb-3">Kami Hadir untuk Memberikan Produk Terbaik</h3>
        <p class="mb-4">
          Kami adalah tim yang berdedikasi untuk menyediakan produk-produk berkualitas tinggi dengan harga yang bersaing. Misi kami adalah memberikan pengalaman belanja online yang mudah, aman, dan menyenangkan bagi seluruh pelanggan.
        </p>
        <ul class="list-unstyled mb-4">
          <li class="mb-2"><i class="ti-check text-success pr-2"></i> Produk asli dan terpercaya</li>
          <li class="mb-2"><i class="ti-check text-success pr-2"></i> Layanan pelanggan responsif</li>
          <li class="mb-2"><i class="ti-check text-success pr-2"></i> Pengiriman cepat dan aman</li>
        </ul>
      </div>
        <div class="col-lg-6 mb-4 mb-lg-0">
        <img class="img-fluid rounded shadow" src="/assets/img/home/hero-banner.png" alt="Tentang Kami">
      </div>
    </div>
  </div>
</section>

<!-- related product -->
 <!-- ================ Produk Unggulan section start ================= -->
<section class="section-margin">
  <div class="container">
    <div class="section-intro pb-60px text-center">
      <p>Produk Pilihan</p>
      <h2>Produk <span class="section-intro__style">Unggulan</span></h2>
    </div>
    <div class="row">
      <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-6 col-lg-4">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" />
              <ul class="card-product__imgOverlay">
                <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                  <input type="hidden" name="quantity" value="1">
                  <button type="submit"><i class="ti-shopping-cart"></i></button>
                </form>
              </ul>
            </div>
            <div class="card-body">
              <h4 class="card-product__title">
                <a href="<?php echo e(route('product.detail', $product->slug)); ?>"><?php echo e($product->name); ?></a>
              </h4>
              <p class="card-product__price">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
              <span class="text-green-600 font-medium">Tersedia <?php echo e($product->stock); ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<!-- ================ Produk Unggulan section end ================= -->

 <!-- end related product -->
<!-- ================ About Us section end ================= -->

      <!--================ Hero Carousel end =================-->

      <!-- ================ trending product section start ================= -->
      <!-- <section class="section-margin calc-60px">
        <div class="container">
          <div class="section-intro pb-60px">
            <p>Popular Item in the market</p>
            <h2>Trending <span class="section-intro__style">Product</span></h2>
          </div>
          <div class="row">
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card text-center card-product">
                <div class="card-product__img">
                  <img class="card-img" src="/assets/img/product/product1.png" alt="" />
                  <ul class="card-product__imgOverlay">
                    <li>
                      <button><i class="ti-search"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-shopping-cart"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-heart"></i></button>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <p>Accessories</p>
                  <h4 class="card-product__title"><a href="single-product.html">Quartz Belt Watch</a></h4>
                  <p class="card-product__price">$150.00</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card text-center card-product">
                <div class="card-product__img">
                  <img class="card-img" src="/assets/img/product/product2.png" alt="" />
                  <ul class="card-product__imgOverlay">
                    <li>
                      <button><i class="ti-search"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-shopping-cart"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-heart"></i></button>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <p>Beauty</p>
                  <h4 class="card-product__title"><a href="single-product.html">Women Freshwash</a></h4>
                  <p class="card-product__price">$150.00</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card text-center card-product">
                <div class="card-product__img">
                  <img class="card-img" src="/assets/img/product/product3.png" alt="" />
                  <ul class="card-product__imgOverlay">
                    <li>
                      <button><i class="ti-search"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-shopping-cart"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-heart"></i></button>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <p>Decor</p>
                  <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
                  <p class="card-product__price">$150.00</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card text-center card-product">
                <div class="card-product__img">
                  <img class="card-img" src="/assets/img/product/product4.png" alt="" />
                  <ul class="card-product__imgOverlay">
                    <li>
                      <button><i class="ti-search"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-shopping-cart"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-heart"></i></button>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <p>Decor</p>
                  <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
                  <p class="card-product__price">$150.00</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card text-center card-product">
                <div class="card-product__img">
                  <img class="card-img" src="/assets/img/product/product5.png" alt="" />
                  <ul class="card-product__imgOverlay">
                    <li>
                      <button><i class="ti-search"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-shopping-cart"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-heart"></i></button>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <p>Accessories</p>
                  <h4 class="card-product__title"><a href="single-product.html">Man Office Bag</a></h4>
                  <p class="card-product__price">$150.00</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card text-center card-product">
                <div class="card-product__img">
                  <img class="card-img" src="/assets/img/product/product6.png" alt="" />
                  <ul class="card-product__imgOverlay">
                    <li>
                      <button><i class="ti-search"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-shopping-cart"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-heart"></i></button>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <p>Kids Toy</p>
                  <h4 class="card-product__title"><a href="single-product.html">Charging Car</a></h4>
                  <p class="card-product__price">$150.00</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card text-center card-product">
                <div class="card-product__img">
                  <img class="card-img" src="/assets/img/product/product7.png" alt="" />
                  <ul class="card-product__imgOverlay">
                    <li>
                      <button><i class="ti-search"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-shopping-cart"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-heart"></i></button>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <p>Accessories</p>
                  <h4 class="card-product__title"><a href="single-product.html">Blutooth Speaker</a></h4>
                  <p class="card-product__price">$150.00</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card text-center card-product">
                <div class="card-product__img">
                  <img class="card-img" src="/assets/img/product/product8.png" alt="" />
                  <ul class="card-product__imgOverlay">
                    <li>
                      <button><i class="ti-search"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-shopping-cart"></i></button>
                    </li>
                    <li>
                      <button><i class="ti-heart"></i></button>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <p>Kids Toy</p>
                  <h4 class="card-product__title"><a href="#">Charging Car</a></h4>
                  <p class="card-product__price">$150.00</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> -->
      <!-- ================ trending product section end ================= -->
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\tutik_tsh\resources\views/frontend/home.blade.php ENDPATH**/ ?>