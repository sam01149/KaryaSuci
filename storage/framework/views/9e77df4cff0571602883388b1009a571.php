<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php echo e(__('Inbox (Pesan Masuk)')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    
                                <a href="<?php echo e(route('inbox.show', $message)); ?>" class="block">
                                    <div class="border-l-4 <?php echo e(is_null($message->read_at) ? 'border-karyasuci-primary' : 'border-gray-300 dark:border-gray-600'); ?> pl-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out">
                                        <div class="flex justify-between items-center">
                                            <p class="font-bold <?php echo e(is_null($message->read_at) ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'); ?>">
                                                Dari: <?php echo e($message->sender->name); ?>

                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($message->created_at->diffForHumans()); ?></p>
                                        </div>
                                        <p class="font-semibold <?php echo e(is_null($message->read_at) ? 'text-gray-800 dark:text-gray-200' : 'text-gray-500 dark:text-gray-400'); ?>"><?php echo e($message->subject); ?></p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate"><?php echo e($message->body); ?></p>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-center text-gray-500">Tidak ada pesan.</p>
                            <?php endif; ?>
                                                </div>
                    <div class="mt-4">
                        <?php echo e($messages->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\sam\Documents\File_Coding\HTML, CSS, JAVASCRIPT dan GAMBAR\Kuliah\projek\KaryaSuci\resources\views/inbox/index.blade.php ENDPATH**/ ?>