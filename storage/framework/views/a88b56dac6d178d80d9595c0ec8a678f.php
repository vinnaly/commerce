<?php $__env->startSection("title", "Keranjang Belanja"); ?>
<?php $__env->startSection("content"); ?>

<section class="cart_area">
	<div class="container">
		<div class="cart_inner">
			<!-- FORM CHECKOUT -->
			<form action="<?php echo e(route("checkout.show")); ?>" id="cart-form" method="GET">
				<?php echo csrf_field(); ?>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Pilih</th>
								<th>Product</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Total</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr data-id="<?php echo e($item->id); ?>">
									<td>
										<input class="cart-checkbox" name="selected_items[]" type="checkbox" value="<?php echo e($item->id); ?>">
									</td>
									<td>
										<div class="media">
											<img alt="<?php echo e($item->product->name); ?>" src="<?php echo e(asset("storage/" . $item->product->image)); ?>" width="70">
											<div class="media-body">
												<p><?php echo e($item->product->name); ?></p>
											</div>
										</div>
									</td>
									<td>
										<h5 class="price" data-price="<?php echo e($item->product->price); ?>">
											Rp <?php echo e(number_format($item->product->price, 0, ",", ".")); ?>

										</h5>
									</td>
									<td>
										<input class="form-control quantity-input" data-id="<?php echo e($item->id); ?>" min="1"
											name="quantities[<?php echo e($item->id); ?>]" type="number" value="<?php echo e($item->quantity); ?>">
									</td>
									<td>
										<h5 class="item-total">
											Rp <?php echo e(number_format($item->product->price * $item->quantity, 0, ",", ".")); ?>

										</h5>
									</td>
									<td>
										<form action="<?php echo e(route("cart.destroy", $item->id)); ?>" id="delete-form-<?php echo e($item->id); ?>" method="POST"
											style="display:none;">
											<?php echo csrf_field(); ?>
											<?php echo method_field("DELETE"); ?>
										</form>
										<button class="btn btn-danger"
											onclick="event.preventDefault(); document.getElementById('delete-form-<?php echo e($item->id); ?>').submit();">Hapus</button>
									</td>
								</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<tr>
								<td colspan="4">
									<h5>Subtotal</h5>
								</td>
								<td>
									<h5 id="subtotal-display">Rp 0</h5>
								</td>
								<td>
									<button class="btn btn-primary" type="submit">Check out</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</section>

<?php $__env->startPush("scripts"); ?>
<script>
	document.querySelectorAll('.quantity-input').forEach(input => {
		input.addEventListener('change', function () {
			const id = this.dataset.id;
			const qty = this.value;

			if (qty < 1) {
				if (confirm('Kuantitas kurang dari 1. Hapus produk ini dari keranjang?')) {
					document.getElementById('delete-form-' + id).submit();
				} else {
					this.value = 1;
				}
				return;
			}

			fetch("<?php echo e(route("cart.update")); ?>", {
				method: 'PATCH',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
				},
				body: JSON.stringify({
					id: id,
					quantity: qty
				})
			}).then(() => updateSubtotal());
		});
	});

	function updateSubtotal() {
		let subtotal = 0;
		document.querySelectorAll('input.cart-checkbox:checked').forEach(checkbox => {
			const row = checkbox.closest('tr');
			const price = parseInt(row.querySelector('.price').dataset.price);
			const qty = parseInt(row.querySelector('.quantity-input').value);
			subtotal += price * qty;
		});
		document.getElementById('subtotal-display').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
	}

	document.querySelectorAll('.cart-checkbox, .quantity-input').forEach(el => {
		el.addEventListener('change', updateSubtotal);
	});

	const form = document.getElementById('cart-form');
	form.addEventListener('submit', function (e) {
		const checked = document.querySelectorAll('.cart-checkbox:checked');
		if (checked.length === 0) {
			e.preventDefault();
			alert('Pilih minimal satu produk untuk checkout!');
		}
	});

	document.addEventListener('DOMContentLoaded', updateSubtotal);
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\tutik_tsh\resources\views/frontend/product/cart.blade.php ENDPATH**/ ?>