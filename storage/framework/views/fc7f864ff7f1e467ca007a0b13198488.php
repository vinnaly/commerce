

<?php $__env->startSection('content'); ?>
    <!-- ================ Collection section start ================= -->
    <section class="section-margin--small mb-5">
      <!-- NAV CATEGORY -->
      <?php echo $__env->make('frontend.layouts.navcategory', ['categories' => $categories], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- END NAV CATEGORY -->

        </div>
          <div class="col-xl-9 col-lg-8 col-md-7">
            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
              <div class="row">
              <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="col-md-6 col-lg-4">
                <div class="card text-center card-product">
                  <div class="card-product__img">
                    <img class="card-img" src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" />
                    <ul class="card-product__imgOverlay">
                      </li>
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
                    <a href="<?php echo e(route('product.detail', $product->slug)); ?>"><?php echo e($product->name); ?></a></h4>
                    <p class="card-product__price">Rp <?php echo e(number_format($product->price, )); ?></p>
                    <span  class="text-green-600 font-medium">tersedia <?php echo e($product->stock); ?></span>
                  </div>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </section>
            <!-- End Best Seller -->
          </div>
        </div>
      </div>
    </section>
    <!-- ================ Collection section end ================= -->
     <?php $__env->startPush('styles'); ?>
<style>
  .card-product__img {
      height: 220px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
  }

  .card-product__img img {
      max-height: 100%;
      object-fit: contain;
  }

  .card-product__title {
      min-height: 48px;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
  }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\E-commercekucopy\resources\views/frontend/product/collection.blade.php ENDPATH**/ ?>