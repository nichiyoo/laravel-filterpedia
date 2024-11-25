 @if (session()->has('error'))
   <div class="flex items-center gap-2 mb-4 text-red-600">
     <i data-lucide="triangle-alert" class="size-5"></i>
     <span>{{ session('error') }}</span>
   </div>
 @elseif (session()->has('success'))
   <div class="flex items-center gap-2 mb-4 text-green-600">
     <i data-lucide="circle-check" class="size-5"></i>
     <span>{{ session('success') }}</span>
   </div>
 @endif
