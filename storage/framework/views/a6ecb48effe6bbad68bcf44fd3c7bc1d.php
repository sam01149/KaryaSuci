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
            <?php echo e(__('Absensi Pasien')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <?php if($message = Session::get('success')): ?>
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p><?php echo e($message); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if($message = Session::get('error')): ?>
                         <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p><?php echo e($message); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                        <form action="<?php echo e(route('patients.index')); ?>" method="GET" class="w-full sm:w-1/2">
                            <div class="flex">
                                <input type="text" name="search" placeholder="Cari nama pasien..." class="w-full dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-l-md shadow-sm" value="<?php echo e(request('search')); ?>">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest">Cari</button>
                            </div>
                        </form>
                        <a href="<?php echo e(route('patients.create')); ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            Daftarkan Pasien Baru
                        </a>
                    </div>

                   <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cabang</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Hari Ini</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?php echo e($loop->index + $patients->firstItem()); ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"><?php echo e($patient->name); ?></td>
                
                
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    <?php echo e($patient->branch ? $patient->branch->name : 'N/A'); ?>

                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <?php if(in_array($patient->id, $checkedInPatientIds ?? [])): ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Sudah Absen
                        </span>
                    <?php else: ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            Belum Absen
                        </span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-4">
                        <?php if(!in_array($patient->id, $checkedInPatientIds ?? [])): ?>
                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'checkin-modal-<?php echo e($patient->id); ?>')"
                                class="text-green-600 hover:text-green-900 font-semibold">
                                Absen
                            </button>
                        <?php endif; ?>
                        <a href="<?php echo e(route('patients.print.pdf', $patient->id)); ?>"  class="text-gray-600 dark:text-gray-400 hover:underline">Print</a>
                        <a href="<?php echo e(route('patients.detail', $patient->id)); ?>" class="text-blue-600 hover:text-blue-900 font-semibold">Detail</a>


                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-patient')): ?>
                            <a href="<?php echo e(route('patients.edit', $patient->id)); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
                            <form action="<?php echo e(route('patients.destroy', $patient->id)); ?>" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus pasien ini akan menghapus semua data terkait. Anda yakin?');" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data pasien yang cocok.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
                    <div class="mt-4">
                        <?php echo e($patients->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'checkin-modal-'.e($patient->id).'','show' => $errors->checkin->isNotEmpty() && old('patient_id_for_modal') == $patient->id,'focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'checkin-modal-'.e($patient->id).'','show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->checkin->isNotEmpty() && old('patient_id_for_modal') == $patient->id),'focusable' => true]); ?>
    <form action="<?php echo e(route('patients.checkin', $patient->id)); ?>" method="post" enctype="multipart/form-data" class="p-6">
        <?php echo csrf_field(); ?>
        
        <input type="hidden" name="patient_id_for_modal" value="<?php echo e($patient->id); ?>">

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Absensi Pasien: <span class="font-bold"><?php echo e($patient->name); ?></span>
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Silakan ambil dan upload foto pasien sebagai bukti kehadiran hari ini.
        </p>

        
        
        
        <?php if($errors->checkin->any()): ?>
            <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <strong class="font-bold">Terjadi Kesalahan!</strong>
                <ul class="mt-2 list-disc list-inside">
                    <?php $__currentLoopData = $errors->checkin->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        

        <div class="mt-6">
            
            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'check_in_photo_'.e($patient->id).'','value' => 'Foto Pasien (Wajib)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'check_in_photo_'.e($patient->id).'','value' => 'Foto Pasien (Wajib)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
            <input id="check_in_photo_<?php echo e($patient->id); ?>" name="check_in_photo" type="file" class="block w-full mt-1 text-sm ..." accept="image/*" required>
        </div>
        <div class="mt-6 flex justify-end">
            <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['xOn:click' => '$dispatch(\'close\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-on:click' => '$dispatch(\'close\')']); ?>
                Batal
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $attributes = $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $component = $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => 'ms-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ms-3']); ?>
                Konfirmasi Absensi
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
        </div>
    </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\sam\Documents\File_Coding\HTML, CSS, JAVASCRIPT dan GAMBAR\Kuliah\projek\KaryaSuci\resources\views/patients/index.blade.php ENDPATH**/ ?>