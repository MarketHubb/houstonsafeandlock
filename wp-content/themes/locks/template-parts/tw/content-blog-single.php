<?php if(isset($args)) { ?>

<div class="tw-bg-white tw-px-6 tw-py-24 lg:tw-px-8">
   <div class="tw-mx-auto tw-max-w-3xl tw-text-base tw-leading-7 tw-text-gray-700">
      <p class="tw-text-base tw-font-semibold tw-leading-7 tw-text-indigo-600"><?php echo get_the_date(); ?></p>
      <h1 class="tw-mt-2 tw-text-3xl tw-font-bold tw-tracking-tight tw-text-gray-900 sm:tw-text-4xl"><?php echo get_the_title(); ?></h1>

      <?php
      echo get_the_content(); 
     $sections = get_field('sections'); 

       ?>

       <div class="tw-hidden">
      <p class="tw-mt-6 tw-text-xl tw-leading-9 tw-mb-6">Aliquet nec orci mattis amet quisque ullamcorper neque, nibh sem. At arcu, sit dui mi, nibh dui, diam eget aliquam. Quisque id at vitae feugiat egestas ac. Diam nulla orci at in viverra scelerisque eget. Eleifend egestas fringilla sapien.</p>
      <div class="tw-mt-10 tw-max-w-2xl">
         <p>Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed amet vitae sed turpis id. Id dolor praesent donec est. Odio penatibus risus viverra tellus varius sit neque erat velit. Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris,d semper sed amet vitae sed turpis id.</p>
         <ul role="list" class="tw-mt-8 tw-max-w-xl tw-space-y-8 tw-text-gray-600">
            <li class="tw-flex tw-gap-x-3">
               <svg class="tw-mt-1 tw-h-5 tw-w-5 tw-flex-none tw-text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
               </svg>
               <span><strong class="tw-font-semibold tw-text-gray-900">Data types.</strong> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.</span>
            </li>
            <li class="tw-flex tw-gap-x-3">
               <svg class="tw-mt-1 tw-h-5 tw-w-5 tw-flex-none tw-text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
               </svg>
               <span><strong class="tw-font-semibold tw-text-gray-900">Loops.</strong> Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo.</span>
            </li>
            <li class="tw-flex tw-gap-x-3">
               <svg class="tw-mt-1 tw-h-5 tw-w-5 tw-flex-none tw-text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
               </svg>
               <span><strong class="tw-font-semibold tw-text-gray-900">Events.</strong> Ac tincidunt sapien vehicula erat auctor pellentesque rhoncus. Et magna sit morbi lobortis.</span>
            </li>
         </ul>
         <p class="tw-mt-8">Et vitae blandit facilisi magna lacus commodo. Vitae sapien duis odio id et. Id blandit molestie auctor fermentum dignissim. Lacus diam tincidunt ac cursus in vel. Mauris varius vulputate et ultrices hac adipiscing egestas. Iaculis convallis ac tempor et ut. Ac lorem vel integer orci.</p>
         <h2 class="tw-mt-16 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900">From beginner to expert in 3 hours</h2>
         <p class="tw-mt-6">Id orci tellus laoreet id ac. Dolor, aenean leo, ac etiam consequat in. Convallis arcu ipsum urna nibh. Pharetra, euismod vitae interdum mauris enim, consequat vulputate nibh. Maecenas pellentesque id sed tellus mauris, ultrices mauris. Tincidunt enim cursus ridiculus mi. Pellentesque nam sed nullam sed diam turpis ipsum eu a sed convallis diam.</p>
         <figure class="tw-mt-10 tw-border-l tw-border-indigo-600 tw-pl-9">
            <blockquote class="tw-font-semibold tw-text-gray-900">
               <p>“Vel ultricies morbi odio facilisi ultrices accumsan donec lacus purus. Lectus nibh ullamcorper ac dictum justo in euismod. Risus aenean ut elit massa. In amet aliquet eget cras. Sem volutpat enim tristique.”</p>
            </blockquote>
            <figcaption class="tw-mt-6 tw-flex tw-gap-x-4">
               <img class="tw-h-6 tw-w-6 tw-flex-none tw-rounded-full tw-bg-gray-50" src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
               <div class="tw-text-sm tw-leading-6"><strong class="tw-font-semibold tw-text-gray-900">Maria Hill</strong> – Marketing Manager</div>
            </figcaption>
         </figure>
         <p class="tw-mt-10">Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed amet vitae sed turpis id. Id dolor praesent donec est. Odio penatibus risus viverra tellus varius sit neque erat velit.</p>
      </div>
      <figure class="tw-mt-16">
         <img class="tw-aspect-video tw-rounded-xl tw-bg-gray-50 tw-object-cover" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=facearea&w=1310&h=873&q=80&facepad=3" alt="">
         <figcaption class="tw-mt-4 tw-flex tw-gap-x-2 tw-text-sm tw-leading-6 tw-text-gray-500">
            <svg class="tw-mt-0.5 tw-h-5 tw-w-5 tw-flex-none tw-text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
               <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
            </svg>
            Faucibus commodo massa rhoncus, volutpat.
         </figcaption>
      </figure>
      <div class="tw-mt-16 tw-max-w-2xl">
         <h2 class="tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900">Everything you need to get up and running</h2>
         <p class="tw-mt-6">Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.</p>
         <p class="tw-mt-8">Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed amet vitae sed turpis id. Id dolor praesent donec est. Odio penatibus risus viverra tellus varius sit neque erat velit.</p>
      </div>
      </div>
   </div>
</div>
<?php } ?>