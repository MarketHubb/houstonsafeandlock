<div id="hs-full-screen-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="hs-full-screen-label" id="filter-sort-modal">
   <div class="hs-overlay-open:mt-0 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-10 opacity-0 transition-all max-w-full max-h-full h-full">
      <div class="flex flex-col bg-white pointer-events-auto max-w-full max-h-full h-full">
         <div class="flex justify-between items-center py-3 px-4 border-b">
            <h3 id="hs-full-screen-label" class="font-bold text-gray-800 ">
               Sort & Filter
            </h3>
            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" aria-label="Close" data-hs-overlay="#hs-full-screen-modal">
               <span class="sr-only">Close</span>
               <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
               </svg>
            </button>
         </div>
         <div class="p-4 overflow-y-auto">
            <div class="px-6" id="filter-sort-container">
               
            </div> 
         </div>
         <div class="flex justify-end items-center gap-x-2 py-3 px-4 mt-auto border-t">
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#hs-full-screen-modal">
               Save
            </button>
         </div>
      </div>
   </div>
</div>

