<?php if (isset($component)) { $__componentOriginalbe23554f7bded3778895289146189db7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbe23554f7bded3778895289146189db7 = $attributes; } ?>
<?php $component = Filament\View\LegacyComponents\Page::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Filament\View\LegacyComponents\Page::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="grid grid-cols-12 gap-4">
        <!-- Kategori -->
        <div class="col-span-12 flex flex-wrap gap-2">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button 
                    wire:click="filterByCategory(<?php echo e($category->id); ?>)"
                    class="px-4 py-2 bg-gray-100 hover:bg-primary-600 hover:text-white rounded shadow-sm transition">
                    <?php echo e($category->name); ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pencarian -->
        <div class="col-span-12 mt-2">
            <input 
                type="text" 
                wire:model="search" 
                placeholder="Cari produk..." 
                class="w-full border rounded p-2 shadow-sm"
            >
        </div>

        <!-- Daftar Produk -->
        <div class="col-span-8 grid grid-cols-3 gap-4 mt-2">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div 
        class="border rounded-lg p-4 text-center hover:shadow-lg cursor-pointer"
        wire:click="addToCart(<?php echo e($product->id); ?>)"
    >
        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="h-24 mx-auto object-contain mb-2">
        
        <h4 class="text-sm font-semibold"><?php echo e($product->name); ?></h4>
        
        <p class="text-primary-600 font-bold">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
        
        <p class="text-xs text-gray-500 mt-1">
            Stok: 
            <?php if($product->stock > 0): ?>
                <span class="text-green-600 font-medium"><?php echo e($product->stock); ?></span>
            <?php else: ?>
                <span class="text-red-600 font-medium">Habis</span>
            <?php endif; ?>
        </p>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="col-span-3 text-gray-500">Produk tidak ditemukan.</p>
<?php endif; ?>

        </div>

        <!-- Detail & Transaksi -->
        <div class="col-span-4">
            <div class="border p-4 rounded-lg shadow space-y-4">
                <h3 class="text-lg font-bold">DETAIL TRANSAKSI</h3>

                <?php if(count($cart) > 0): ?>
                    <table class="w-full text-sm">
                        <thead>
                            <tr>
                                <th class="text-left">Produk</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item['name']); ?></td>
                                    <td><?php echo e($item['quantity']); ?></td>
                                    <td>Rp <?php echo e(number_format($item['subtotal'], 0, ',', '.')); ?></td>
                                    <td>
                                        <button wire:click="removeItem(<?php echo e($index); ?>)" class="text-red-500 text-xs">✖</button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="mt-4 border-t pt-2 flex justify-between font-bold">
                        <span>Total:</span>
                        <span>Rp <?php echo e(number_format($this->getTotal(), 0, ',', '.')); ?></span>
                    </div>

                    <div class="mt-4 text-right">
                        <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['wire:click' => 'processOrder']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'processOrder']); ?>
                            Bayar Sekarang
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600">Belum ada produk yang dipilih.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbe23554f7bded3778895289146189db7)): ?>
<?php $attributes = $__attributesOriginalbe23554f7bded3778895289146189db7; ?>
<?php unset($__attributesOriginalbe23554f7bded3778895289146189db7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbe23554f7bded3778895289146189db7)): ?>
<?php $component = $__componentOriginalbe23554f7bded3778895289146189db7; ?>
<?php unset($__componentOriginalbe23554f7bded3778895289146189db7); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Tutik_TSH\resources\views/filament/pages/pos.blade.php ENDPATH**/ ?>