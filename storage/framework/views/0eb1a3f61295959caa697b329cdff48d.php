<?php $__env->startSection("title", "My Account"); ?>

<?php $__env->startSection("content"); ?>
	<section class="section-margin--small">
		<div class="container">
			<div class="row">
				<div class="col mb-3">
					<h3>Akun Saya</h3>
				</div>
				<div class="col-lg-12">

					
					<div class="card p-4 mb-4">
						<div class="row">
							<div class="col-md-3 text-center">
								<img alt="Profile Picture" class="rounded-circle mb-3" height="100"
									src="<?php echo e(auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : "https://via.placeholder.com/100"); ?>"
									width="100">

								
								<form action="<?php echo e(route("account.picture")); ?>" enctype="multipart/form-data" method="POST">
									<?php echo csrf_field(); ?>
									<input class="form-control mb-2" name="profile_picture" type="file">
									<button class="btn btn-outline-secondary btn-sm btn-block" type="submit">Upload Foto</button>
								</form>
								<?php if(auth()->user()->profile_picture): ?>
									<form action="<?php echo e(route("account.delete-picture")); ?>" method="POST">
										<?php echo csrf_field(); ?> <?php echo method_field("DELETE"); ?>
										<button class="btn btn-sm btn-danger btn-block mt-2" type="submit">Hapus Foto</button>
									</form>
								<?php endif; ?>
							</div>

							<div class="col-md-9">
								<form action="<?php echo e(route("account.update")); ?>" method="POST">
									<?php echo csrf_field(); ?>
									<div class="form-group">
										<label>Nama</label>
										<input
											<?php echo e(auth()->user()->updated_name_at && now()->diffInDays(auth()->user()->updated_name_at) < 30 ? "readonly" : ""); ?>

											class="form-control" name="name" type="text" value="<?php echo e(auth()->user()->name); ?>">
										<?php if(auth()->user()->updated_name_at && now()->diffInDays(auth()->user()->updated_name_at) < 30): ?>
											<small class="text-muted">Nama hanya bisa diubah sebulan sekali.</small>
										<?php endif; ?>
									</div>

									<div class="form-group">
										<label>Email</label>
										<input class="form-control" name="email" type="email" value="<?php echo e(auth()->user()->email); ?>">
									</div>

									<div class="form-group">
										<label>No. HP</label>
										<input class="form-control" name="phone" type="text" value="<?php echo e(auth()->user()->phone); ?>">
									</div>

									<button class="btn btn-primary btn-sm" type="submit">Simpan Perubahan</button>
								</form>

								<div class="form-group mt-3">
									<label>Password</label><br>
									<a class="btn btn-sm btn-outline-primary" data-target="#gantiPasswordModal" data-toggle="modal"
										href="#">Ganti Password</a>
								</div>

								<div class="form-group mt-3">
									<label>Alamat</label>
									<div class="d-flex flex-wrap gap-2">
										<?php $__currentLoopData = $user->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="d-flex mb-2 me-2">
												<button class="mr-1 btn btn-outline-dark btn-sm" onclick="editAddress(<?php echo e($address->id); ?>)" type="button">
													<?php echo e($address->label); ?>

												</button>
												<form action="<?php echo e(route("account.address.delete", $address->id)); ?>" class="ms-1" method="POST">
													<?php echo csrf_field(); ?> <?php echo method_field("DELETE"); ?>
													<button class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus alamat ini?')"
														type="submit">×</button>
												</form>
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
									<button class="btn btn-outline-dark btn-sm mt-2" onclick="addNewAddress()" type="button">Tambah Alamat</button>
									<?php if(session("success")): ?>
										<p><?php echo e(session("success")); ?></p>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>

					
					<ul class="nav nav-tabs mb-3" id="accountTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#pesanan" id="pesanan-tab" role="tab">Pesanan Saya</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#riwayat" id="riwayat-tab" role="tab">Riwayat Pesanan</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#ulasan" id="ulasan-tab" role="tab">Ulasan Saya</a>
						</li>
					</ul>

					
					<div class="tab-content" id="accountTabContent">

						
						<div class="tab-pane fade show active" id="pesanan" role="tabpanel">
							<?php if($orders->where("status", "!=", "completed")->count()): ?>
								<?php $__currentLoopData = $orders->where("status", "!=", "completed"); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="card p-3 mb-2">
										<strong>ID Pesanan: #<?php echo e($order->id); ?></strong>
										<p><?php echo e($order->created_at->format("d M Y")); ?> • Total: Rp <?php echo e(number_format($order->total, 0, ",", ".")); ?></p>
										<p>Status: <span class="badge badge-warning"><?php echo e(ucfirst($order->payment_status)); ?></span></p>
										<form action="<?php echo e(route("account.orders.complete", $order->id)); ?>" method="POST"
											onsubmit="return confirm('Yakin pesanan ini sudah kamu terima?')">
											<?php echo csrf_field(); ?>
											<button class="btn btn-sm btn-success" type="submit">Pesanan Selesai</button>
										</form>
									</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
								<p class="text-muted">Tidak ada pesanan dalam proses.</p>
							<?php endif; ?>
						</div>

						
						<div class="tab-pane fade" id="riwayat" role="tabpanel">
							<?php if($orders->where("status", "completed")->count()): ?>
								<?php $__currentLoopData = $orders->where("status", "completed"); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="card p-3 mb-2">
										<strong>ID Pesanan: #<?php echo e($order->id); ?></strong>
										<p><?php echo e($order->created_at->format("d M Y")); ?> • Total: Rp <?php echo e(number_format($order->total, 0, ",", ".")); ?></p>
										<div class="d-flex gap-2">
											<a class="btn btn-sm btn-info"
												href="<?php echo e(route("product.detail", $order->orderItems->first()->product->slug ?? "#")); ?>">Beli Lagi</a>
											<button class="btn btn-sm btn-warning" data-target="#reviewModal<?php echo e($order->id); ?>" data-toggle="modal">
												Beri Nilai
											</button>
										</div>
									</div>
									<?php echo $__env->make("frontend.account.review-modal", ["order" => $order], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
								<p class="text-muted">Belum ada riwayat pesanan.</p>
							<?php endif; ?>
						</div>

						
						<div class="tab-pane fade" id="ulasan" role="tabpanel">
							<?php if($reviews->count()): ?>
								<?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="card p-3 mb-2">
										<strong><?php echo e($review->product->name ?? "-"); ?></strong>
										<p class="mb-1">Rating: <?php echo e($review->rating); ?> / 5</p>
										<p><?php echo e($review->comment); ?></p>
									</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
								<p class="text-muted">Belum ada ulasan yang Anda berikan.</p>
							<?php endif; ?>
						</div>
					</div>

					
					<div class="text-center mt-4">
						<form action="<?php echo e(route("logout")); ?>" id="logout-form" method="POST">
							<?php echo csrf_field(); ?>
							<button class="btn btn-danger" type="submit">Log out</button>
						</form>
					</div>

				</div>
			</div>
		</div>
	</section>

	
	<div class="modal fade" id="gantiPasswordModal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo e(route("account.password")); ?>" method="POST">
					<?php echo csrf_field(); ?>
					<div class="modal-header">
						<h5 class="modal-title">Ganti Password</h5>
					</div>
					<div class="modal-body">
						<input class="form-control mb-2" name="current_password" placeholder="Password Lama" required type="password">
						<input class="form-control mb-2" name="new_password" placeholder="Password Baru" required type="password">
						<input class="form-control" name="new_password_confirmation" placeholder="Konfirmasi Password Baru" required
							type="password">
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary" type="submit">Simpan</button>
						<button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	
	<div class="modal fade" id="addressModal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addressModalLabel">Tambah Alamat Baru</h5>
					<button aria-label="Close" class="close" data-dismiss="modal" type="button">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?php echo e(route("account.address.add")); ?>" id="addressForm" method="POST">
					<?php echo csrf_field(); ?>
					<input id="addressMethod" name="_method" type="hidden" value="POST">
					<input id="destination_name" name="destination_name" type="hidden">
					<input id="province_name" name="province_name" type="hidden">
					<input id="city_name" name="city_name" type="hidden">

					<div class="modal-body">
						<div class="form-group mb-3">
							<label for="label">Label Alamat</label>
							<input class="form-control" id="label" name="label" placeholder="Rumah, Kantor, dll" required
								type="text">
						</div>

						<div class="form-group mb-3">
							<label for="destination_search">Cari Kota/Kabupaten</label>
							<div class="position-relative">
								<input autocomplete="off" class="form-control" id="destination_search"
									placeholder="Ketik nama kota/kabupaten..." type="text">
								<div class="invalid-feedback">Pilih destinasi dari hasil pencarian</div>

								
								<div class="position-absolute" id="search_loading"
									style="right: 10px; top: 50%; transform: translateY(-50%); display: none;">
									<div class="spinner-border spinner-border-sm text-secondary" role="status">
										<span class="sr-only">Loading...</span>
									</div>
								</div>
							</div>

							
							<div class="list-group position-absolute w-100" id="destination_results"
								style="z-index: 1000; max-height: 200px; overflow-y: auto; display: none;"></div>

							
							<div class="mt-2" id="selected_destination" style="display: none;">
								<small class="text-muted">Destinasi dipilih:</small>
								<div class="alert alert-info py-2 mb-0">
									<strong id="selected_destination_name"></strong>
									<button class="btn btn-sm btn-outline-secondary float-right" onclick="clearDestinationSelection()"
										type="button">Ubah</button>
								</div>
							</div>
						</div>

						<div class="form-group mb-3">
							<label for="address">Alamat Lengkap</label>
							<textarea class="form-control" id="address" name="address"
							 placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan, Kecamatan" required rows="3"></textarea>
						</div>

						<div class="form-group mb-3">
							<label for="zip">Kode Pos</label>
							<input class="form-control" id="zip" name="zip" placeholder="Kode Pos" type="text">
						</div>

						<div class="form-group mb-3">
							<label for="phone">Nomor Telepon</label>
							<input class="form-control" id="phone" name="phone" placeholder="Nomor Telepon" type="text">
						</div>
					</div>

					<div class="modal-footer">
						<button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button>
						<button class="btn btn-primary" disabled id="submit_address" type="submit">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php $__env->startPush("scripts"); ?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				const destinationSearch = document.getElementById('destination_search');
				const destinationResults = document.getElementById('destination_results');
				const selectedDestination = document.getElementById('selected_destination');
				const selectedDestinationName = document.getElementById('selected_destination_name');
				const searchLoading = document.getElementById('search_loading');
				const submitButton = document.getElementById('submit_address');
				const addressForm = document.getElementById('addressForm');
				const addressMethod = document.getElementById('addressMethod');
				const addressModalLabel = document.getElementById('addressModalLabel');

				let searchTimeout;
				let selectedDestinationData = null;

				async function searchDestinations(query) {
					if (query.length < 3) {
						destinationResults.style.display = 'none';
						return;
					}

					try {
						searchLoading.style.display = 'block';

						const response = await fetch(
							`/api/destinations/search?search=${encodeURIComponent(query)}&limit=10&offset=0`, {
								method: 'GET',
								headers: {
									'Accept': 'application/json',
									'Content-Type': 'application/json',
									'X-Requested-With': 'XMLHttpRequest'
								}
							}
						);

						if (!response.ok) {
							throw new Error(`HTTP error! status: ${response.status}`);
						}

						const contentType = response.headers.get("content-type");
						if (!contentType || !contentType.includes("application/json")) {
							throw new Error("Response is not JSON");
						}

						const data = await response.json();
						searchLoading.style.display = 'none';

						if (data.success && data.data && data.data.length > 0) {
							displaySearchResults(data.data);
						} else {
							displayNoResults();
						}
					} catch (error) {
						console.error('Error searching destinations:', error);
						searchLoading.style.display = 'none';

						if (error.message.includes('not JSON')) {
							displayErrorResults('Server error. Silakan coba lagi.');
						} else {
							displayErrorResults();
						}
					}
				}

				function displaySearchResults(destinations) {
					destinationResults.innerHTML = '';

					destinations.forEach(destination => {
						const item = document.createElement('a');
						item.className = 'list-group-item list-group-item-action';
						item.href = '#';

						// Handle different possible response formats from RajaOngkir
						const destinationId = destination.destination_id || destination.city_id || destination.id;
						const cityName = destination.city_name || destination.name || destination.city || '';
						const provinceName = destination.province_name || destination.province || '';
						const type = destination.type || '';
						const postalCode = destination.postal_code || destination.zip || '';

						// Build display name
						let displayName = '';
						if (destination.subdistrict_name) {
							displayName = destination.subdistrict_name;
						} else {
							displayName = type ? `${type} ${cityName}` : cityName;
							if (provinceName) {
								displayName += `, ${provinceName}`;
							}
						}

						item.innerHTML = `
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">${displayName}</h6>
                    <small class="text-muted">${provinceName}</small>
                </div>
                ${postalCode ? `<small class="text-muted">Kode Pos: ${postalCode}</small>` : ''}
            `;

						item.addEventListener('click', function(e) {
							e.preventDefault();
							selectDestination({
								id: destinationId,
								name: displayName,
								cityName: cityName,
								provinceName: provinceName,
								data: destination
							});
						});

						destinationResults.appendChild(item);
					});

					destinationResults.style.display = 'block';
				}

				function displayNoResults() {
					destinationResults.innerHTML =
						'<div class="list-group-item text-muted">Tidak ada hasil ditemukan</div>';
					destinationResults.style.display = 'block';
				}

				function displayErrorResults(message = 'Gagal mencari destinasi. Silakan coba lagi.') {
					destinationResults.innerHTML =
						`<div class="list-group-item text-danger">${message}</div>`;
					destinationResults.style.display = 'block';
				}

				function selectDestination(destination) {
					selectedDestinationData = destination;

					// Update UI
					destinationSearch.value = destination.name;
					selectedDestinationName.textContent = destination.name;
					selectedDestination.style.display = 'block';
					destinationResults.style.display = 'none';

					// Create hidden input for destination_id if not exists
					let destinationIdInput = document.getElementById('destination_id');
					if (!destinationIdInput) {
						destinationIdInput = document.createElement('input');
						destinationIdInput.type = 'hidden';
						destinationIdInput.id = 'destination_id';
						destinationIdInput.name = 'destination_id';
						addressForm.appendChild(destinationIdInput);
					}

					// Set the values
					destinationIdInput.value = destination.id;
					document.getElementById('destination_name').value = destination.name;
					document.getElementById('province_name').value = destination.provinceName || '';
					document.getElementById('city_name').value = destination.cityName || '';

					// Enable submit button
					submitButton.disabled = false;
					destinationSearch.classList.remove('is-invalid');

					console.log('Selected destination:', {
						id: destination.id,
						name: destination.name,
						cityName: destination.cityName,
						provinceName: destination.provinceName
					});
				}

				window.clearDestinationSelection = function() {
					selectedDestinationData = null;
					destinationSearch.value = '';
					selectedDestination.style.display = 'none';

					// Clear hidden inputs
					const destinationIdInput = document.getElementById('destination_id');
					if (destinationIdInput) {
						destinationIdInput.value = '';
					}
					document.getElementById('destination_name').value = '';
					document.getElementById('province_name').value = '';

					submitButton.disabled = true;
					destinationSearch.focus();
				};

				destinationSearch.addEventListener('input', function() {
					clearTimeout(searchTimeout);
					const query = this.value.trim();

					if (selectedDestinationData && this.value === selectedDestinationData.name) {
						return;
					}

					if (selectedDestinationData) {
						clearDestinationSelection();
					}

					searchTimeout = setTimeout(() => {
						searchDestinations(query);
					}, 300);
				});

				// Hide results when clicking outside
				document.addEventListener('click', function(e) {
					if (!destinationSearch.contains(e.target) && !destinationResults.contains(e.target)) {
						destinationResults.style.display = 'none';
					}
				});

				// Focus on search input when modal opens
				$('#addressModal').on('shown.bs.modal', function() {
					destinationSearch.focus();
				});

				// Validate form submission
				addressForm.addEventListener('submit', function(e) {
					if (!selectedDestinationData) {
						e.preventDefault();
						destinationSearch.classList.add('is-invalid');
						alert('Silakan pilih destinasi dari hasil pencarian');
						return false;
					}

					// Log form data before submit for debugging
					const formData = new FormData(addressForm);
					console.log('Form data being submitted:');
					for (let [key, value] of formData.entries()) {
						console.log(key + ': ' + value);
					}
				});

				// Function to add new address
				window.addNewAddress = function() {
					addressForm.reset();
					clearDestinationSelection();

					// Reset form action and method
					addressForm.action = "<?php echo e(route("account.address.add")); ?>";
					addressMethod.value = 'POST';

					addressModalLabel.textContent = 'Tambah Alamat Baru';
					$('#addressModal').modal('show');
				};

				// Function to edit existing address
				window.editAddress = function(addressId) {
					addressForm.reset();
					clearDestinationSelection();

					addressForm.action = `/account/address/${addressId}`;
					addressMethod.value = 'PUT';

					addressModalLabel.textContent = 'Edit Alamat';

					fetch(`/account/address/${addressId}/data`, {
							headers: {
								'Accept': 'application/json',
								'X-Requested-With': 'XMLHttpRequest'
							}
						})
						.then(response => {
							if (!response.ok) {
								throw new Error(`HTTP error! status: ${response.status}`);
							}
							return response.json();
						})
						.then(data => {
							document.getElementById('label').value = data.label;
							document.getElementById('address').value = data.address;
							document.getElementById('zip').value = data.zip || '';
							document.getElementById('phone').value = data.phone || '';

							if (data.destination_id && data.destination_name) {
								selectDestination({
									id: data.destination_id,
									name: data.destination_name,
									data: data
								});
							}
						})
						.catch(error => {
							console.error('Error fetching address data:', error);
							alert('Gagal mengambil data alamat.');
						});

					$('#addressModal').modal('show');
				};
			});
		</script>
	<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Apps\laragon\www\commerce\resources\views/frontend/account/index.blade.php ENDPATH**/ ?>