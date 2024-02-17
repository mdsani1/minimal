<x-backend.layouts.master>

    <x-slot name="page_title">
        Dashboard
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Dashboard
            </x-slot>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    @push('css')
        <link rel="stylesheet" href={{asset("ui/dist/css/adminlte.min.css")}}>
    @endpush
</x-backend.layouts.master>
