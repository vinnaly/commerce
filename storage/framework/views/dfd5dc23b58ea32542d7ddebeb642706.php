<section class="section-margin--small mb-5">
      <div class="container">
        <div class="row">
          <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="sidebar-categories">
              <div class="head">Browse Categories</div>
              <ul class="main-categories">
                <li class="common-filter">
                  <form action="#">
                    <ul>
                     <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="filter-list">
                          <input class="pixel-radio" type="radio" id="category<?php echo e($category->id); ?>"
                                name="category"
                                value="<?php echo e($category->id); ?>"
                                onchange="this.form.submit()"
                                <?php echo e(request('category') == $category->id ? 'checked' : ''); ?> />
                          <label for="category<?php echo e($category->id); ?>">
                            <?php echo e($category->name); ?> <span>(<?php echo e($category->products_count ?? 0); ?>)</span>
                          </label>
                        </li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                  </form>
                </li>
              </ul>
            </div>
<?php /**PATH C:\laragon\www\E-commercekucopy\resources\views/frontend/layouts/navcategory.blade.php ENDPATH**/ ?>