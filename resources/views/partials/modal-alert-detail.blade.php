@if (session()->has('success_detail') || session()->has('danger_detail'))
    <div
        x-data="{ show:true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        class="alert alert-{{ session()->has('success_detail') ? 'success' : 'danger' }}
                alert-dismissible fade show py-2 small shadow-sm">
        <button class="close" @click="show = false" style="line-height:0;">
            <span>&times;</span>
        </button>
        <i class="fas {{ session()->has('success_detail') ? 'fa-check-circle' : 'fa-exclamation-triangle' }} mr-2"></i>
        {{ session('success_detail') ?? session('danger_detail') }}
    </div>
@endif