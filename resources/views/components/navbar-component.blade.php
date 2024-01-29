<div class="fixed top-0 w-full bg-amber-200 p-2 z-[9991]">
    <div class="flex justify-between items-center">
        <div class="flex items-center">
               <i class="ri-graduation-cap-line text-lg ml-3 px-2 py-1 rounded-full bg-black text-white"></i>
        </div>
         <div>
        	<span class="text-xs sm:text-md font-black text-center">SMK PEMKAB PONOROGO</span>
        </div>
        <div class="flex items-center hover:cursor-pointer hover:rounded-full hover:bg-red-500 hover:text-white text-red-500 mr-4 px-2 py-1 tooltip tooltip-bottom transition-all duration-150 ease-in-out" onclick="logout()" data-tip="Log Out">
                <i class="ri-logout-box-r-line text-md"></i>
        </div>
    </div>
</div>



<script type="text/javascript">


	function logout()
        {
            $.ajax({
                url: `{{ route('logout') }}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    toastr.info('Success Logout');
                    setTimeout(function() {
                        window.location.href = '/login';
                    }, 2000);
                }
            })
        }
</script>