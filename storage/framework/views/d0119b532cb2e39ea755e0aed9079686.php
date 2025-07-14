<?php
    use Filament\Support\Enums\IconPosition;

    $chartColor = $getChartColor() ?? 'gray';
    $descriptionColor = $getDescriptionColor() ?? 'gray';
    $descriptionIcon = $getDescriptionIcon();
    $descriptionIconPosition = $getDescriptionIconPosition();
    $url = $getUrl();
    $tag = $url ? 'a' : 'div';

    $descriptionIconClasses = \Illuminate\Support\Arr::toCssClasses([
        'fi-wi-stats-overview-stat-description-icon h-5 w-5',
        match ($descriptionColor) {
            'gray' => 'text-gray-400 dark:text-gray-500',
            default => 'text-custom-500',
        },
    ]);

    $descriptionIconStyles = \Illuminate\Support\Arr::toCssStyles([
        \Filament\Support\get_color_css_variables($descriptionColor, shades: [500]) => $descriptionColor !== 'gray',
    ]);
?>

<<?php echo $tag; ?>

    <?php if($url): ?>
        href="<?php echo e($url); ?>"
        <?php if($shouldOpenUrlInNewTab()): ?>
            target="_blank"
        <?php endif; ?>
    <?php endif; ?>
    <?php echo e($getExtraAttributeBag()
            ->class([
                'fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10',
            ])); ?>

>
    <div class="grid gap-y-2">
        <div class="flex items-center gap-x-2">
            <?php if($icon = $getIcon()): ?>
                <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $icon,'class' => 'fi-wi-stats-overview-stat-icon h-5 w-5 text-gray-400 dark:text-gray-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => 'fi-wi-stats-overview-stat-icon h-5 w-5 text-gray-400 dark:text-gray-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
            <?php endif; ?>

            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                <?php echo e($getLabel()); ?>

            </span>
        </div>

        <div
            class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white"
        >
            <?php echo e($getValue()); ?>

        </div>

        <?php if($description = $getDescription()): ?>
            <div class="flex items-center gap-x-1">
                <?php if($descriptionIcon && in_array($descriptionIconPosition, [IconPosition::Before, 'before'])): ?>
                    <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $descriptionIcon,'class' => $descriptionIconClasses,'style' => $descriptionIconStyles]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIcon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIconClasses),'style' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIconStyles)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
                <?php endif; ?>

                <span
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'fi-wi-stats-overview-stat-description text-sm',
                        match ($descriptionColor) {
                            'gray' => 'text-gray-500 dark:text-gray-400',
                            default => 'text-custom-600 dark:text-custom-400',
                        },
                    ]); ?>"
                    style="<?php echo \Illuminate\Support\Arr::toCssStyles([
                        \Filament\Support\get_color_css_variables($descriptionColor, shades: [400, 600]) => $descriptionColor !== 'gray',
                    ]) ?>"
                >
                    <?php echo e($description); ?>

                </span>

                <?php if($descriptionIcon && in_array($descriptionIconPosition, [IconPosition::After, 'after'])): ?>
                    <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $descriptionIcon,'class' => $descriptionIconClasses,'style' => $descriptionIconStyles]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIcon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIconClasses),'style' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($descriptionIconStyles)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if($chart = $getChart()): ?>
        <div
            ax-load
            ax-load-src="<?php echo e(\Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('stats-overview/stat/chart', 'filament/widgets')); ?>"
            wire:ignore
            x-data="statsOverviewStatChart({
                        labels: <?php echo \Illuminate\Support\Js::from(array_keys($chart))->toHtml() ?>,
                        values: <?php echo \Illuminate\Support\Js::from(array_values($chart))->toHtml() ?>,
                    })"
            x-ignore
            class="fi-wi-stats-overview-stat-chart absolute inset-x-0 bottom-0 overflow-hidden rounded-b-xl"
            style="<?php echo \Illuminate\Support\Arr::toCssStyles([
                \Filament\Support\get_color_css_variables($chartColor, shades: [50, 400, 500]) => $chartColor !== 'gray',
            ]) ?>"
        >
            <canvas x-ref="canvas" class="h-6"></canvas>

            <span
                x-ref="backgroundColorElement"
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    match ($chartColor) {
                        'gray' => 'text-gray-100 dark:text-gray-800',
                        default => 'text-custom-50 dark:text-custom-400/10',
                    },
                ]); ?>"
            ></span>

            <span
                x-ref="borderColorElement"
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    match ($chartColor) {
                        'gray' => 'text-gray-400',
                        default => 'text-custom-500 dark:text-custom-400',
                    },
                ]); ?>"
            ></span>
        </div>
    <?php endif; ?>
</<?php echo $tag; ?>>
<?php /**PATH C:\laragon\www\E-commercekucopy\vendor\filament\widgets\src\/../resources/views/stats-overview-widget/stat.blade.php ENDPATH**/ ?>