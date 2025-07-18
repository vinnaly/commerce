<?php $__env->startSection("title", "Checkout"); ?>

<?php $__env->startSection("content"); ?>

	<!--================Checkout Area =================-->
	<section class="checkout_area section-margin--small">
		<div class="container">
			<form action="<?php echo e(route("checkout.process")); ?>" method="POST">
				<?php echo csrf_field(); ?>
				<div class="row">
					<!-- ADDRESS SELECTION -->
					<div class="col-12 mb-4">
						<h3>Pilih Alamat Pengiriman</h3>
						<div class="d-flex flex-wrap gap-3">
							<?php $__currentLoopData = $user->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<label class="btn btn-outline-dark address-item" for="address">
									<input data-destination="<?php echo e($address->destination_id); ?>" hidden id="address" name="address_id" required
										type="radio" value="<?php echo e($address->id); ?>">
									<div>
										<strong><?php echo e($address->label); ?></strong><br>
										<small><?php echo e($address->destination_name ?? $address->city_name); ?><?php echo e($address->province_name); ?></small><br>
										<small class="text-muted"><?php echo e($address->address); ?></small>
									</div>
								</label>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<a class="btn btn-outline-primary" href="<?php echo e(route("account.index")); ?>">Tambah Alamat</a>
						</div>
						<?php $__errorArgs = ["address_id"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
							<small class="text-danger"><?php echo e($message); ?></small>
						<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
					</div>

					<!-- ORDER DETAILS -->
					<div class="col-lg-8">
						<h3>Detail Pesanan</h3>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Produk</th>
									<th>Harga / pcs</th>
									<th>Qty</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody>
								<?php $total = 0; ?>
								<?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$lineTotal = $item->product->price * $item->quantity;
										$total += $lineTotal;
									?>
                                    <input type="hidden" name="selected_items[]" value="<?php echo e($item->id); ?>">
									<tr>
										<td class="d-flex gap-2 align-items-center">
											<img src="<?php echo e(asset("storage/" . $item->product->image)); ?>" width="60">
											<div><?php echo e($item->product->name); ?></div>
										</td>
										<td>Rp <?php echo e(number_format($item->product->price, 0, ",", ".")); ?></td>
										<td><?php echo e($item->quantity); ?></td>
										<td>Rp <?php echo e(number_format($lineTotal, 0, ",", ".")); ?></td>
									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>

						<!-- SHIPPING & PAYMENT -->
						<div class="form-group mt-4">
							<label for="shipping_method">Pilih Pengiriman</label>
							<div class="form-control shipping-loading p-3 text-center d-none">
								<div class="spinner-border text-primary" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
								<p class="mt-2">Mengambil data ongkos kirim...</p>
							</div>
							<div class="shipping-container">
								<select class="form-control" disabled id="shipping_method" name="shipping_method" required>
									<option value="">Pilih alamat pengiriman terlebih dahulu</option>
								</select>
							</div>
							<?php $__errorArgs = ["shipping_method"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								<small class="text-danger"><?php echo e($message); ?></small>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
						</div>

						<div class="form-group mt-3">
							<label for="payment_method">Metode Pembayaran</label>
							<select class="form-control" name="payment_method" required>
								<option value="midtrans">Midtrans Payment</option>
								<option value="cod">Bayar di Tempat (COD)</option>
							</select>
							<?php $__errorArgs = ["payment_method"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								<small class="text-danger"><?php echo e($message); ?></small>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
						</div>
					</div>

					<!-- RINGKASAN PEMBAYARAN -->
					<div class="col-lg-4">
						<div class="order_box p-4 border">
							<h4>Ringkasan</h4>
							<ul class="list-unstyled">
								<li class="d-flex justify-content-between">
									<span>Subtotal Pesanan</span>
									<strong>Rp <?php echo e(number_format($total, 0, ",", ".")); ?></strong>
								</li>
								<li class="d-flex justify-content-between">
									<span>Ongkir</span>
									<strong id="shipping-cost">Rp 0</strong>
								</li>
								<li class="d-flex justify-content-between mt-2 border-top pt-2">
									<span>Total</span>
									<strong id="total-cost">Rp <?php echo e(number_format($total, 0, ",", ".")); ?></strong>
								</li>
							</ul>

							<div class="form-check mt-3">
								<input class="form-check-input" id="terms" name="terms" required type="checkbox">
								<label class="form-check-label" for="terms">
									Saya menyetujui <a href="#">syarat & ketentuan*</a>
								</label>
								<?php $__errorArgs = ["terms"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
									<small class="text-danger d-block"><?php echo e($message); ?></small>
								<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
							</div>

							<div class="text-center mt-4">
								<button class="btn btn-primary btn-block w-100" type="submit">Bayar Sekarang</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
	<!--================End Checkout Area =================-->

	<?php $__env->startPush("scripts"); ?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				const addressItems = document.querySelectorAll('.address-item input[type="radio"]');
				const shippingSelect = document.getElementById('shipping_method');
				const shippingCostEl = document.getElementById('shipping-cost');
				const totalCostEl = document.getElementById('total-cost');
				const subtotal = <?php echo e($total); ?>;
				const totalWeight = 1000;
				const shippingLoading = document.querySelector('.shipping-loading');
				const shippingContainer = document.querySelector('.shipping-container');
				const address = document.querySelectorAll('input[type="radio"][name="address_id"]');

				let selectedDestinationId = null;

				function showLoading() {
					shippingLoading.classList.remove('d-none');
					shippingContainer.classList.add('d-none');
				}

				function hideLoading() {
					shippingLoading.classList.add('d-none');
					shippingContainer.classList.remove('d-none');
				}

				async function fetchShippingCost(destinationId) {
					if (!destinationId) {
						console.error('No destination ID provided');
						return;
					}

					selectedDestinationId = destinationId;
					showLoading();

					try {
						console.log('Fetching shipping cost for destination:', destinationId);

						const response = await fetch('/api/cost', {
							method: 'POST',
							headers: {
								'Content-Type': 'application/json',
								'Accept': 'application/json',
								'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
								'X-Requested-With': 'XMLHttpRequest'
							},
							body: JSON.stringify({
								destination: destinationId,
								weight: totalWeight,
								courier: 'jne,jnt'
							})
						});

						if (!response.ok) {
							const errorText = await response.text();
							console.error('Response not OK:', response.status, errorText);
							throw new Error(`HTTP error! status: ${response.status}`);
						}

						const contentType = response.headers.get("content-type");
						if (!contentType || !contentType.includes("application/json")) {
							throw new Error("Response is not JSON");
						}

						const result = await response.json();
						console.log('Shipping cost response:', result);

						if (result.success && result.data) {
							updateShippingOptions(result.data);
						} else {
							throw new Error(result.message || 'Failed to fetch shipping costs');
						}
					} catch (error) {
						console.error('Error fetching shipping costs:', error);
						resetShippingSelect('Error: Gagal mengambil data ongkir');

						if (error.message.includes('not JSON')) {
							resetShippingSelect('Error: Server response invalid');
						} else if (error.message.includes('401') || error.message.includes('403')) {
							resetShippingSelect('Error: Authentication failed');
						}
					} finally {
						hideLoading();
						shippingSelect.disabled = false;
					}
				}

				// PERBAIKAN 3: Fungsi terpisah untuk reset select
				function resetShippingSelect(message = 'Pilih alamat pengiriman terlebih dahulu') {
					shippingSelect.innerHTML = '';
					const defaultOption = document.createElement('option');
					defaultOption.value = '';
					defaultOption.textContent = message;
					shippingSelect.appendChild(defaultOption);

					// Reset shipping cost
					shippingCostEl.innerText = 'Rp 0';
					totalCostEl.innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;
				}

				function updateShippingOptions(data) {
					console.log('Updating shipping options with data:', data); // PERBAIKAN 4: Debug log

					// PERBAIKAN 5: Clear select dengan lebih eksplisit
					shippingSelect.innerHTML = '';

					// Add default option
					const defaultOption = document.createElement('option');
					defaultOption.value = '';
					defaultOption.textContent = 'Pilih metode pengiriman';
					shippingSelect.appendChild(defaultOption);

					if (!data || data.length === 0) {
						const noServiceOption = document.createElement('option');
						noServiceOption.value = '';
						noServiceOption.disabled = true;
						noServiceOption.textContent = 'Tidak ada layanan pengiriman tersedia';
						shippingSelect.appendChild(noServiceOption);
						return;
					}

					// PERBAIKAN 6: Iterasi dengan struktur data yang lebih fleksibel
					data.forEach((courier, index) => {
						console.log(`Processing courier ${index}:`, courier); // Debug log

						// Handle different response structures
						let courierName, services;

						if (courier.name || courier.code) {
							// Structure: [{name: 'JNE', code: 'jne', services: [...]}]
							courierName = courier.name || courier.code.toUpperCase();
							services = courier.service; // Fallback to courier itself if no services
						} else {
							// Direct service structure
							courierName = courier.name || 'Unknown';
							services = [courier];
						}

						const serviceName = courier.service || courier.name ||
							'Layanan Tidak Diketahui';
						const cost = courier.cost || 0;
						const etd = courier.etd || 'N/A';

						const optionText =
							`${courierName} ${serviceName} (${etd}) - Rp${cost.toLocaleString('id-ID')}`;
						const optionValue = `${courier.code || courierName.toLowerCase()}:${cost}`;

						const option = document.createElement('option');
						option.value = optionValue;
						option.textContent = optionText;

						shippingSelect.appendChild(option);
                        shippingSelect.style.display = 'block';
						console.log('Added option:', optionText);
					});

					const changeEvent = new Event('change', {
						bubbles: true
					});
					shippingSelect.dispatchEvent(changeEvent);

					console.log('Final select innerHTML:', shippingSelect.innerHTML);
				}

				function updateTotal() {
					const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];

					if (!selectedOption || !selectedOption.value) {
						shippingCostEl.innerText = 'Rp 0';
						totalCostEl.innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;
						return;
					}

					const costPart = selectedOption.value.split(':')[1];
					const cost = parseInt(costPart, 10);

					if (isNaN(cost)) {
						console.error('Invalid cost value:', costPart);
						shippingCostEl.innerText = 'Rp 0';
						totalCostEl.innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;
						return;
					}

					shippingCostEl.innerText = `Rp ${cost.toLocaleString('id-ID')}`;
					totalCostEl.innerText = `Rp ${(subtotal + cost).toLocaleString('id-ID')}`;
				}

				// PERBAIKAN 8: Event listener yang lebih robust
				address.forEach(function(item) {
					item.addEventListener('change', function() {
						if (this.checked) {
							const destinationId = this.dataset.destination;
							console.log('Address changed, destination ID:', destinationId); // Debug log

							if (destinationId) {
								// Reset select terlebih dahulu
								shippingSelect.disabled = true;
								resetShippingSelect('Memuat opsi pengiriman...');

								fetchShippingCost(destinationId);
							} else {
								console.error('No destination ID found for selected address');
								resetShippingSelect('Error: Alamat tidak memiliki ID destinasi');
								shippingSelect.disabled = false;
							}
						}
					});
				});

				shippingSelect.addEventListener('change', updateTotal);

				// Initialize
				resetShippingSelect();

				// Handle Midtrans callback
				if (window.location.href.includes('payment_status')) {
					const status = new URLSearchParams(window.location.search).get('payment_status');
					if (status === 'success') {
						window.location.href = "<?php echo e(route("payment.finish")); ?>";
					} else if (status === 'pending') {
						window.location.href = "<?php echo e(route("payment.unfinish")); ?>";
					} else {
						window.location.href = "<?php echo e(route("payment.error")); ?>";
					}
				}
			});
		</script>
	<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("frontend.layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Tutik_TSH\resources\views/frontend/product/checkout.blade.php ENDPATH**/ ?>