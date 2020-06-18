<div class="sidebar-footer">
		<!-- item-->
		<a href="" class="link" data-toggle="tooltip" title="Settings" data-original-title="Settings"><i class="fa fa-cog fa-spin"></i></a>
		<!-- item-->
		<a href="" class="link" data-toggle="tooltip" title="Email" data-original-title="Email"><i class="fa fa-envelope"></i></a>
		<!-- item-->

		@if(auth()->check())
		  {{-- <h3>Hi&emsp;<a href="#">{{ auth()->user()->firstname }}</a></h3> --}}
		  {{-- <a href="{{url('/employee/logout')}}">Log Out</a> --}}
			<a href={{url('/logout')}}  class="link"data-toggle="tooltip" title="Logout" data-original-title="Logout"><i class="fa fa-power-off"></i></a>

		@endif
	</div>
