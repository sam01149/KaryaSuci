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
    
    <div x-data="{ showAddressModal: false, fullAddress: '' }">
         <?php $__env->slot('header', null, []); ?> 
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <?php echo e(__('Arsip Data Pasien')); ?>

            </h2>
         <?php $__env->endSlot(); ?>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    
                    <form method="GET" action="<?php echo e(route('patients.archive')); ?>" class="mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">
        
        
        <div class="sm:col-span-2 lg:col-span-2">
            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cari Nama/No. Induk</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input type="text" name="search" id="search" class="flex-1 block w-full rounded-none rounded-l-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" placeholder="Ketik untuk mencari..." value="<?php echo e(request('search')); ?>">
                <button type="submit" class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-r-md">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
        </div>

        
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                     <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <input type="date" name="start_date" id="start_date" value="<?php echo e(request('start_date')); ?>" class="block w-full pl-10 dark:bg-gray-900 rounded-md shadow-sm">
            </div>
        </div>
        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
             <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                     <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <input type="date" name="end_date" id="end_date" value="<?php echo e(request('end_date')); ?>" class="block w-full pl-10 dark:bg-gray-900 rounded-md shadow-sm">
            </div>
        </div>
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
        
        
        
        <div class="flex items-end space-x-2">
            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-karyasuci-primary text-white rounded-md text-sm font-semibold">Filter</button>
            <a href="<?php echo e(route('patients.archive')); ?>" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md text-sm">Reset</a>
        </div>
    </div>
</form>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No. Induk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Alamat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jenis Kelamin</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tgl. Daftar</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-6 py-4"><?php echo e($loop->iteration + $patients->firstItem() - 1); ?></td>
                                    <td class="px-6 py-4 font-bold"><?php echo e($patient->id); ?></td>
                                    <td class="px-6 py-4"><?php echo e($patient->name); ?></td>
                                    <td class="px-6 py-4 max-w-xs">
                                            <span class="truncate"><?php echo e(\Illuminate\Support\Str::limit($patient->address, 40)); ?></span>
                                            <?php if(strlen($patient->address) > 40): ?>
                                            <button @click="fullAddress = '<?php echo e(addslashes($patient->address)); ?>'; showAddressModal = true" class="ml-1 text-xs text-blue-500 hover:underline">[Lihat]</button>
                                            <?php endif; ?>
                                        </td>
                                    <td class="px-6 py-4"><?php echo e($patient->gender); ?></td>
                                    <td class="px-6 py-4"><?php echo e($patient->created_at->format('d M Y')); ?></td>
                                    
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="7" class="text-center py-4">Tidak ada data pasien yang cocok dengan filter.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4"><?php echo e($patients->links()); ?></div>
                </div>
            </div>
        </div>
        <div x-show="showAddressModal" @keydown.escape.window="showAddressModal = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75" x-cloak>
            <div @click.away="showAddressModal = false" class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Alamat Lengkap</h3>
                <p class="text-base text-gray-600 dark:text-gray-300 whitespace-pre-wrap" x-text="fullAddress"></p>
                <div class="mt-6 flex justify-end">
                    <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['@click' => 'showAddressModal = false']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['@click' => 'showAddressModal = false']); ?>Tutup <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $attributes = $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $component = $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\Users\sam\Documents\File_Coding\HTML, CSS, JAVASCRIPT dan GAMBAR\Kuliah\projek\KaryaSuci\resources\views/patients/archive.blade.php ENDPATH**/ ?>