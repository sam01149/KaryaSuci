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
            <?php echo e(__('Log Aktivitas Klinik')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    
                    <form method="GET" action="<?php echo e(route('activity-logs.index')); ?>" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <?php if(in_array(Auth::user()->role, ['Admin', 'Manajer'])): ?>
                                <div>
                                    <label for="branch_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cabang</label>
                                    <select name="branch_id" id="branch_id" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm">
                                        <option value="">Semua Cabang</option>
                                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($branch->id); ?>" <?php if(request('branch_id') == $branch->id): echo 'selected'; endif; ?>><?php echo e($branch->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                                <input type="date" name="start_date" id="start_date" value="<?php echo e(request('start_date')); ?>" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                                <input type="date" name="end_date" id="end_date" value="<?php echo e(request('end_date')); ?>" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm">
                            </div>
                            <div class="flex space-x-2">
                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 bg-karyasuci-primary text-white rounded-md text-sm font-semibold">Filter</button>
                                <a href="<?php echo e(route('activity-logs.index')); ?>" class="w-full inline-flex justify-center py-2 px-4 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md text-sm">Reset</a>
                            </div>
                        </div>
                    </form>
                    
                    <div class="space-y-8">
                        <?php $__empty_1 = true; $__currentLoopData = $groupedLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $logsOnDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="p-4 border rounded-lg dark:border-gray-700">
                                <h3 class="font-bold text-lg mb-2 border-b pb-2 dark:border-gray-600"><?php echo e($date); ?></h3>
                                <div class="space-y-2">
                                    <?php $__currentLoopData = $logsOnDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-start">
                                            <span class="text-sm text-gray-500 dark:text-gray-400 w-20 shrink-0">[<?php echo e($log->created_at->format('H:i')); ?>]</span>
                                            <p class="text-sm"><?php echo e($log->description); ?></p>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-center text-gray-500">Tidak ada aktivitas yang tercatat.</p>
                        <?php endif; ?>
                    </div>

                    <div class="mt-6">
                        <?php echo e($logs->links()); ?>

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
<?php endif; ?><?php /**PATH C:\Users\sam\Documents\File_Coding\HTML, CSS, JAVASCRIPT dan GAMBAR\Kuliah\projek\KaryaSuci\resources\views/activity-logs/index.blade.php ENDPATH**/ ?>