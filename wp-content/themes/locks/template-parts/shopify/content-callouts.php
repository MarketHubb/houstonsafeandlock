 <?php if (!isset($args)) return; ?>

 <dl class="mt-16 grid grid-cols-2 gap-x-8 gap-y-12 sm:mt-20 sm:grid-cols-2 sm:gap-y-16 lg:mt-28 lg:grid-cols-4">


     <?php $i = 1; ?>
     <?php foreach ($args as $callout): ?>

         <?php if ($callout['value']): ?>

             <?php
                $value = $callout['type'] === 'Capacity' ? $callout['value'] . ' Gun' : $callout['value'];
                $container_class = $i === 1 ? ' border-transparent' : ' border-l-gray-200 border-y-transparent border-r-transparent';
                ?>

             <div class="flex flex-col-reverse pl-6 border <?php echo $container_class; ?>">

                 <dt class="text-base/7 text-gray-400 font-medium uppercase">
                     <?php echo $callout['type']; ?>
                 </dt>
                 <dd class="text-xl font-semibold tracking-tight text-gray-800 mb-0">

                     <?php if ($callout['image']): ?>
                         <img src="<?php echo $callout['image']; ?>" class="!h-6 !w-auto block mb-6 drop-shadow-lg opacity-70 filter-badge" />
                     <?php endif ?>

                     <?php echo $value; ?>
                 </dd>
             </div>

         <?php endif ?>

         <?php $i++; ?>

     <?php endforeach ?>

 </dl>