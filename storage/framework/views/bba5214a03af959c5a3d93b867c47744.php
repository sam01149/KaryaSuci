
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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <?php echo e(__('Antrian Pembayaran')); ?>

            </h2>
            
            <a href="<?php echo e(route('cashier.history.index')); ?>" class="text-sm font-medium text-blue-600 hover:underline">
                Lihat Riwayat Hari Ini &rarr;
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if($message = Session::get('success')): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p><?php echo e($message); ?></p>
                </div>
            <?php endif; ?>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-6">
                        <?php $__empty_1 = true; $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="p-4 border rounded-lg dark:border-gray-700" x-data="{ open: false }">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-lg"><?php echo e($session->patient->name); ?></p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Selesai: <?php echo e($session->updated_at->format('H:i')); ?> | Terapis: <?php echo e($session->therapist->name ?? 'N/A'); ?></p>
                                        <span class="px-2 py-1 mt-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($session->patient->program_status == 'Paket' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800'); ?>">
                                            Program: <?php echo e($session->patient->program_status); ?>

                                        </span>
                                    </div>
                                    <button @click="open = !open" class="text-sm text-blue-600 hover:underline">
                                        <span x-show="!open">Tampilkan Detail</span>
                                        <span x-show="open">Sembunyikan Detail</span>
                                    </button>
                                </div>
                                
                                
                                <div x-show="open" x-transition class="mt-4 pt-4 border-t dark:border-gray-600">
                                    
                                    <?php if($session->medicalRecord): ?>
                                        <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-md">
                                            <h4 class="font-semibold">Ringkasan Penanganan:</h4>
                                            <p class="text-sm"><strong>Asesmen:</strong> <?php echo e($session->medicalRecord->assessment); ?></p>
                                            <p class="text-sm"><strong>Diagnosis:</strong> <?php echo e($session->medicalRecord->diagnosis); ?></p>
                                            <p class="text-sm"><strong>Penanganan:</strong> <?php echo e($session->medicalRecord->treatment_plan); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    
                                    <form action="<?php echo e(route('cashier.session.pay', $session->id)); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                                        <?php echo csrf_field(); ?>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label for="amount_<?php echo e($session->id); ?>" class="block text-sm font-medium">Jumlah Bayar</label>
                                                <input type="number" id="amount_<?php echo e($session->id); ?>" name="amount" placeholder="Rp" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm" required>
                                            </div>
                                            <div>
                                                <label for="payment_type_<?php echo e($session->id); ?>" class="block text-sm font-medium">Tipe Sesi</label>
                                                <select id="payment_type_<?php echo e($session->id); ?>" name="payment_type" class="mt-1 block w-full dark:bg-gray-900 rounded-md shadow-sm">
                                                    <option value="Umum">Umum</option>
                                                    <option value="Paket">Paket</option>
                                                </select>
                                            </div>
                                             <div>
                                                <label for="receipt_photo_<?php echo e($session->id); ?>" class="block text-sm font-medium">Upload Bukti Bayar</label>
                                                <input type="file" id="receipt_photo_<?php echo e($session->id); ?>" name="receipt_photo" class="mt-1 block w-full text-sm" required>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="mt-4 p-4 border-t dark:border-gray-600" x-data="{ registerProgram: false }">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="register_program" x-model="registerProgram" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm">
                                                <span class="ms-2 text-sm">Daftarkan/Perbarui Program Paket untuk pasien ini?</span>
                                            </label>
                                            <div x-show="registerProgram" class="mt-4 space-y-4">
                                                <input type="hidden" name="program_status" value="Paket">
                                                <div>
                                                    <label for="program_proof_photo_<?php echo e($session->id); ?>" class="block text-sm font-medium">Upload Bukti Program Paket</label>
                                                    <input type="file" id="program_proof_photo_<?php echo e($session->id); ?>" name="program_proof_photo" class="mt-1 block w-full text-sm">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500">
                                                Proses & Selesaikan Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-center text-gray-500">Belum ada pasien yang menunggu pembayaran.</p>
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
<?php endif; ?><?php /**PATH C:\Users\sam\Documents\File_Coding\HTML, CSS, JAVASCRIPT dan GAMBAR\Kuliah\projek\KaryaSuci\resources\views/cashier/queue/index.blade.php ENDPATH**/ ?>