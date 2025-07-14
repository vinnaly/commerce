<div class="modal fade" id="reviewModal<?php echo e($order->id); ?>" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?php echo e(route('account.reviews.submit', $order->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="modal-header">
          <h5 class="modal-title" id="reviewModalLabel">Beri Ulasan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="card mb-3 p-3">
            <div class="d-flex align-items-center mb-2">
              <img src="<?php echo e(asset('storage/' . $item->product->image)); ?>" width="60" class="mr-3">
              <strong><?php echo e($item->product->name); ?></strong>
            </div>

            <input type="hidden" name="reviews[<?php echo e($item->product->id); ?>][product_id]" value="<?php echo e($item->product->id); ?>">

            <div class="form-group">
              <label>Rating:</label><br>
              <?php for($i = 1; $i <= 5; $i++): ?>
                <label class="mr-1">
                  <input type="radio" name="reviews[<?php echo e($item->product->id); ?>][rating]" value="<?php echo e($i); ?>" required>
                  ⭐
                </label>
              <?php endfor; ?>
            </div>

            <div class="form-group">
              <label>Review:</label>
              <textarea class="form-control" name="reviews[<?php echo e($item->product->id); ?>][comment]" rows="3"></textarea>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php /**PATH C:\laragon\www\E-commercekucopy\resources\views/frontend/account/review-modal.blade.php ENDPATH**/ ?>