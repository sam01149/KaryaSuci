
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
            Sesi Perawatan: <?php echo e($session->patient->name); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            
            <div class="md:col-span-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Catatan Sesi Hari Ini</h3>
                        <form action="<?php echo e(route('therapist.session.finish', $session->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="space-y-4">
                                <div>
                                    <label for="assessment" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Asesmen</label>
                                    <textarea id="assessment" name="assessment" rows="5" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required><?php echo e(old('assessment')); ?></textarea>
                                </div>
                                <div>
                                    <label for="diagnosis" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Diagnosis</label>
                                    <textarea id="diagnosis" name="diagnosis" rows="3" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required><?php echo e(old('diagnosis')); ?></textarea>
                                </div>
                                <div>
                                    <label for="treatment_plan" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Rencana Terapi</label>
                                    <textarea id="treatment_plan" name="treatment_plan" rows="5" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required><?php echo e(old('treatment_plan')); ?></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">
                                        Simpan & Selesaikan Sesi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            
            <div class="md:col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                     <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Riwayat Kunjungan</h3>
                        <div class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $pastRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border-b pb-2">
                                <p class="font-semibold"><?php echo e($record->created_at->format('d F Y')); ?></p>
                                <p class="text-sm"><strong>Diagnosis:</strong> <?php echo e($record->diagnosis); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-gray-500">Belum ada riwayat kunjungan.</p>
                        <?php endif; ?>
                        </div>
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
<?php endif; ?><?php /**PATH C:\Users\sam\Documents\File_Coding\HTML, CSS, JAVASCRIPT dan GAMBAR\Kuliah\projek\KaryaSuci\resources\views/therapist/session/treat.blade.php ENDPATH**/ ?>