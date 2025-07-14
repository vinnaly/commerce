

<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
<!--================Detail Product Area =================--><div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="owl-carousel owl-theme s_Product_carousel">
                    <div class="single-prd-item">
                        <img class="img-fluid"
                             src="<?php echo e($product->image ? asset('storage/' . $product->image) : asset('images/no-image.png')); ?>"
                             alt="<?php echo e($product->name); ?>">
                    </div>
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3><?php echo e($product->name); ?></h3>
                    <h2>Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></h2>
                    <ul class="list">
                        <li><span>Kategori</span>: <?php echo e($product->category->name ?? '-'); ?></li>
                        <li><span>Status</span>: <?php echo e($product->stock > 0 ? 'Tersedia' : 'Stok Habis'); ?></li>
                    </ul>

                    <div class="product_count mt-4">
                        <label for="quantity" class="mb-2 d-block">Jumlah:</label>

                        <?php if(auth()->guard()->check()): ?>
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="mt-3">
                            <?php echo csrf_field(); ?>
                            <div class="d-flex align-items-center mb-3">
                                <div class="input-group" style="max-width: 160px;">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(-1)">-</button>
                                    </div>
                                    <input type="number" id="quantity" name="quantity" min="1" value="1" class="form-control text-center">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(1)">+</button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">

                            <div class="d-flex flex-column gap-3">
                                <button type="submit" name="action" value="add_to_cart" class="btn btn-outline-primary py-2">
                                    <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                                </button>
                            </div>
                        </form>
                        <?php else: ?>
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group" style="max-width: 140px;">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(-1)">-</button>
                                </div>
                                <input type="number" id="quantity" name="quantity" min="1" value="1" class="form-control text-center" disabled>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(1)">+</button>
                                </div>
                            </div>

                            <!-- Tombol akan memunculkan modal -->
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#guestModal">
                                Tambah ke Keranjang
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--================End Detail Product Area =================-->

<!-- Modal Guest -->
<div class="modal fade" id="guestModal" tabindex="-1" role="dialog" aria-labelledby="guestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title">Login atau Register</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">Sudah punya akun?</p>
        <div class="d-flex justify-content-center gap-3">
          <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary">Ya</a>
          <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-success">Belum</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    function changeQuantity(amount) {
        const qtyInput = document.getElementById('quantity');
        let currentQty = parseInt(qtyInput.value);
        if (!isNaN(currentQty)) {
            currentQty += amount;
            if (currentQty < 1) currentQty = 1;
            qtyInput.value = currentQty;
        }
    }
</script>


<!--================Product Description Area =================-->
<section class="product_description_area">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="desc-tab" data-toggle="tab" href="#desc" role="tab" aria-controls="desc" aria-selected="true">Description</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Reviews</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            
            <div class="tab-pane fade show active" id="desc" role="tabpanel" aria-labelledby="desc-tab">
                <p><?php echo e($product->description); ?></p>
            </div>

            
            <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="review_item">
                            <h4>Blake Ruiz</h4>
                            <div>
                                <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <p>Produk ini sangat berkualitas. Saya suka!</p>
                        </div>
                    </div>
                    <div class="product_reviews mt-5">
  <h4>Ulasan Produk</h4>
  <?php $__empty_1 = true; $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="border p-2 mb-2">
      <strong><?php echo e($review->user->name); ?></strong> - ⭐ <?php echo e($review->rating); ?>/5
      <p><?php echo e($review->comment); ?></p>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p>Belum ada ulasan.</p>
  <?php endif; ?>
</div>

                    <div class="col-md-6">
                        <form class="form-review">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="4" placeholder="Your Review"></textarea>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Product Description Area =================-->

<!-- Modal untuk guest -->
<div class="modal fade" id="guestModal" tabindex="-1" role="dialog" aria-labelledby="guestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="guestModalLabel">Sudah punya akun?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p>Untuk menambahkan ke keranjang, silakan login terlebih dahulu.</p>
        <div class="d-flex justify-content-center gap-2">
          <a href="<?php echo e(route('login')); ?>" class="btn btn-primary mx-2">Iya, Login</a>
          <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-secondary mx-2">Belum, Daftar</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\E-commercekucopy\resources\views/frontend/product/detail.blade.php ENDPATH**/ ?>