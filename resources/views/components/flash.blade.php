@if(session('flash_message'))
    <div class="fixed-top mt-5 container">
        <div class="alert alert-dismissible fade show my-3">
            {{session('flash_message')}}
        </div>
    </div>
@endif