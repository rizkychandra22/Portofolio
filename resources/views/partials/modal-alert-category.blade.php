@if (session()->has('success_category') || session()->has('danger_category'))
    <div x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => show = false, 3000)"
        class="alert alert-{{ session()->has('success_category') ? 'success' : 'danger' }} alert-dismissible show py-2 small fade mb-4 shadow-sm">
            <button class="close" @click="show = false" style="line-height:0;">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="fas {{ session()->has('success_category') ? 'fa-check-circle' : 'fa-exclamation-triangle' }} mr-2"></i>
            {{ session('success_category') ?? session('danger_category') }}
    </div>
@endif