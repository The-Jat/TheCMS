
<div class="col-lg-12 me-element-item mb-2">
    <div class="icon-bx-wraper left style-1 m-b30">
        <div class="d-flex align-items-center">
            <div class="icon-lg me-2"> 
                <img src="{{request()->elementImage}}" alt="Image">
            </div>
            <h4 class="dz-title m-b15"><span> {{ request()->elementName}} </span></h4>
        </div>
        <div class="icon-content">
            <a href="javascript:void(0);" class="drag-handle btn btn-primary shadow btn-xs sharp me-1">
                <i class="fas fa-arrows-alt"></i>
            </a>
            <a href="javascript:void(0);" class="Me-EditElement btn btn-primary shadow btn-xs sharp me-1" data-element-type="{{ request()->elementType}}" elementId="{{ request()->elementId}}" element-form-data="">
                <i class="fas fa-pencil-alt"></i>
            </a>
            <a href="javascript:void(0);" elementId="{{ request()->elementId}}" class="ME-DeleteElement btn btn-primary shadow btn-xs sharp me-1">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
</div>