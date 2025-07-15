  <!--================ Start Header Menu Area =================-->
  <header class="header_area">
        <div class="main_menu">
          <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
              <a class="navbar-brand logo_h" href="/"><img src="/assets/img/tsh.jpg" alt="" /></a>
              <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
                  <li class="nav-item "><a class="nav-link" href="<?php echo e(route('home')); ?>">Home</a>
                  <li class="nav-item "><a class="nav-link" href="/collection">All Collection</a></li>
                  </li>
                </ul>
                <ul class="nav-shop">
                  <li class="nav-item">
  <a href="<?php echo e(route('account.index')); ?>">
    <i class="ti-user"></i>
  </a>
</li>

                  <?php if(auth()->guard()->check()): ?>
                      <?php
                        $cartCount = auth()->user()->cartItems()->count();
                      ?>
                      <li class="nav-item">
                        <a href="<?php echo e(route('cart.index')); ?>">
                          <i class="ti-shopping-cart"></i>
                          <?php if($cartCount > 0): ?>
                            <span class="nav-shop__circle"><?php echo e($cartCount); ?></span>
                          <?php endif; ?>
                        </a>
                      </li>
                      <?php endif; ?>

                      <?php if(auth()->guard()->guest()): ?>
                      <li class="nav-item">
                        <a href="<?php echo e(route('login')); ?>">
                          <i class="ti-shopping-cart"></i>
                        </a>
                      </li>
                      <?php endif; ?>
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </header>
      <!--================ End Header Menu Area =================--><?php /**PATH D:\Apps\laragon\www\commerce\resources\views/frontend/layouts/header.blade.php ENDPATH**/ ?>