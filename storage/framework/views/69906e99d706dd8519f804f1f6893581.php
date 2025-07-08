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
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2 sm:mb-0">
                <?php echo e(__('Detail Pasien: ') . $patient->name); ?>

            </h2>
            
            
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                    Total Kunjungan: <?php echo e($patient->treatmentSessions->count()); ?>

                </span>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($patient->program_status == 'Paket' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800'); ?>">
                    Program: <?php echo e($patient->program_status); ?>

                </span>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                     <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Data Diri Pasien</h3>
                        <a href="<?php echo e(route('patients.index')); ?>" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            &larr; Kembali ke Daftar Pasien
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t dark:border-gray-700 pt-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100"><?php echo e($patient->name); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Kontak</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100"><?php echo e($patient->contact_number ?: '-'); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Lahir</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100"><?php echo e($patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->isoFormat('D MMMM Y') : '-'); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100"><?php echo e($patient->gender ?: '-'); ?></dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100"><?php echo e($patient->address ?: '-'); ?></dd>
                        </div>
                         <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Registrasi</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100"><?php echo e($patient->created_at->isoFormat('D MMMM Y, HH:mm')); ?></dd>
                        </div>
                    </div>

                    <?php if(in_array(Auth::user()->role, ['Admin', 'Manajer'])): ?>
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                         <a href="<?php echo e(route('patients.edit', $patient->id)); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Edit Data Pasien
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Kunjungan & Bukti Kehadiran</h3>
                    <div class="space-y-6">
                        <?php $__empty_1 = true; $__currentLoopData = $patient->treatmentSessions()->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border-b dark:border-gray-700 pb-4 flex flex-col sm:flex-row items-start sm:space-x-4">
                                <?php if($session->patient_photo_path): ?>
                                    <a href="<?php echo e(asset('storage/' . $session->patient_photo_path)); ?>" target="_blank">
                                        <img src="<?php echo e(asset('storage/' . $session->patient_photo_path)); ?>" alt="Foto bukti check-in" class="w-full sm:w-32 h-auto rounded-md object-cover mb-2 sm:mb-0 hover:opacity-80 transition-opacity">
                                    </a>
                                <?php else: ?>
                                    <div class="w-full sm:w-32 h-32 rounded-md bg-gray-200 dark:bg-gray-700 flex items-center justify-center mb-2 sm:mb-0">
                                        <span class="text-xs text-gray-500">No Photo</span>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-grow">
                                    <p class="font-bold text-lg">Kunjungan ke-<?php echo e($session->visit_number); ?></p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal: <?php echo e(\Carbon\Carbon::parse($session->session_date)->isoFormat('dddd, D MMMM Y')); ?></p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Status: <span class="font-semibold"><?php echo e($session->status); ?></span></p>
                                    
                                    
                                    <?php if($session->medicalRecord): ?>
                                    <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-md">
                                        <p class="text-xs font-bold uppercase text-gray-500">Catatan Fisioterapis</p>
                                        <p class="text-sm mt-1"><strong>Diagnosis:</strong> <?php echo e($session->medicalRecord->diagnosis); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p>Belum ada riwayat kunjungan.</p>
                        <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\Users\sam\Documents\File_Coding\HTML, CSS, JAVASCRIPT dan GAMBAR\Kuliah\projek\KaryaSuci\resources\views/patients/show.blade.php ENDPATH**/ ?>