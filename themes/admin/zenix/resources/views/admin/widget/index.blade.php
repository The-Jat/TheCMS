{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

	<div class="container-fluid">
		<div class="row page-titles align-items-center">
			<div class="col-sm-6 p-0">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.widgets.index') }}">{{ __('common.widgets') }}</a></li>
					<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_widgets') }}</a></li>
				</ol>
			</div>

			<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
				<a href="{{ route('admin.widgets.create') }}" class="btn btn-primary me-3 ">Add Widget</a>
				<button class="btn btn-primary show-container-modal ">Create Block</button>
			</div>
		</div>
		<div class="row">
	        <div class="col-sm-4">
				<div class="row">
			        <div class="col-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered sorter-card" id="accordion_all_widgets">
							<div class="card-header accordion-header" data-bs-target="#accordion-all-widgets"  data-bs-toggle="collapse" aria-expanded="true">
								<h4 class="card-title">{{ __('All Widgets') }}</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body collapse show" id="accordion-all-widgets" data-bs-parent="#accordion_all_widgets">
								
								<div class="w3options-sorter-section">
									<div class="w3options-sorter-block w-100 m-0">
										<ul class="widget-sorter-list w3options-sorter-list all-widgets">
											@forelse ($widgets as $widget)
												<li class="sorter-item d-flex align-items-center justify-content-between" data-id="{{$widget->slug}}">
													{{ $widget->title }}
													<div class="icon-content">
														<a href="javascript:void(0);" class="btn btn-warning shadow btn-xs sharp me-1">
															<i class="fas fa-arrows-alt"></i>
														</a>
														<a href="{{ route('admin.widgets.edit',$widget->id) }}" class="btn btn-primary shadow btn-xs sharp me-1">
															<i class="fas fa-pencil-alt"></i>
														</a>
													</div>
												</li>
											@empty
											@endforelse

										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	            
	        </div>
	        <div class="col-sm-8">
	        	<div class="row">
	        		@php
	        			$blockTypes = array();
	        		@endphp

	        		@forelse ($blocks as $block)
	        			@if(!in_array($block->type,$blockTypes))
    						<div class="col-12">
	    						<div class="page-titles">
									<h4>{{$block->type}}</h4>
								</div>
							</div>
						@endif

		        		@php
		        			$blockTypes[] = $block->type;
		        		@endphp


		        		<div class="col-md-6">
							<div class="card accordion accordion-rounded-stylish accordion-bordered sorter-card">
								<div class="card-header accordion-header p-3" data-bs-target="#accordion-{{$block->slug}}"  data-bs-toggle="collapse" aria-expanded="true">
									<h5 class="m-0">
										<a href="javascript:void(0);" data-id="{{$block->id}}" data-slug="{{$block->slug}}" data-title="{{$block->title}}" data-type="{{$block->type}}" class="btn btn-primary shadow btn-xs sharp me-1 edit-sidebar-btn">
											<i class="fas fa-pencil-alt"></i>
										</a>
										{{$block->title}}
									</h5>
									<span class="accordion-header-indicator"></span>
								</div>
								<div class="accordion__body p-4 collapse show"  id="accordion-{{$block->slug}}">
									<div class="w3options-sorter-section">
										<div class="w3options-sorter-block w-100 m-0">
											<ul data-sidebar-id="{{$block->slug}}" class="widget-sorter-list w3options-sorter-list">
												@php
													$items = json_decode($block->content) ?? array();
												@endphp
												@forelse ($items as $item)
												<li class="sorter-item d-flex align-items-center justify-content-between" data-id="{{$item}}">
													<span>{{DzHelper::getBlogTitle($item)}}</span>
													<a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp delete-widget-btn">
															<i class="fa fa-times"></i>
														</a>

												</li>
												@empty
												@endforelse
											</ul>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					@empty
	        		@endforelse
	        	</div>
	        </div>
	    </div>
	</div>
@endsection

@push('inline-modals')
	<div class="modal fade" id="WidgetContainerModal">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
            	<form method="post" action="{{ route('admin.widgets.create_or_update_block') }}">
            		@csrf
            		<div class="modal-header">
	                    <h5 class="modal-title">{{ __('Add New Block') }}</h5>
	                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body" id="WidgetContainerModalBody">
						<div class="row">
							<div class="col-md-12 mb-2 mb-md-3 " id="">
                        		<input type="hidden" name="slug" class="form-control" id="slug" value="{{ old('slug') }}" readonly>
								<label for="title" class="control-label">Title</label>
								<input type="text" name="title" class="form-control MakeSlug" id="ContentTitle" placeholder="{{ __('common.title') }}" value="{{ old('title') }}" rel="slug" required>
							</div>
							<div class="col-md-12 mb-2 mb-md-3 " id="">
								<label for="type" class="control-label">Select Container Type</label>
								<select name="type" id="type" class=" form-control" required>
									<option value="sidebar">Sidebar</option>
									<option value="header">Header</option>
									<option value="footer">Footer</option>
								</select>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
						<a href="javascript:void(0);" class="btn btn-danger delete-block-btn">{{ __('common.delete') }}</a>
						<button type="button" class="btn btn-warning" data-bs-dismiss="modal">{{ __('common.close') }}</button>
						<button type="submit" class="btn btn-primary">{{ __('common.save_changes') }}</button>
					</div>
            	</form>
            </div>
        </div>
    </div>
@endpush

@push('inline-scripts')
	<script>
		var screenOptionArray = '<?php echo json_encode(array()) ?>';

        let modal = $('#WidgetContainerModal');
        modal.find('.delete-block-btn').hide();

		$('.show-container-modal').on('click', function(ev) {
            modal.find('form').attr('action', `{{ route('admin.widgets.create_or_update_block') }}`);
            modal.find('.modal-title').text(`Add New Block`);
			modal.modal('show');
		});

		$('.edit-sidebar-btn').on('click', function() {
            modal.find('form').attr('action', `{{ route('admin.widgets.create_or_update_block', '') }}/${$(this).data('id')}`);
            modal.find('.modal-title').text(`Edit Block`);
            modal.find('[name=title]').val($(this).data('title'));
            modal.find('[name=slug]').val($(this).data('slug'));
            modal.find('.delete-block-btn').attr('href', `{{ route('admin.widgets.destroy_block', '') }}/${$(this).data('id')}`);
    		modal.find('.delete-block-btn').show();
            if($(this).data('type'))
            {
                modal.find('[name=type] option[value='+$(this).data('type')+']').prop("selected", true);
            }
			modal.modal('show');
		});

		modal.on('hidden.bs.modal', function() {
            modal.find('form')[0].reset();
    		modal.find('.delete-block-btn').hide();
        });



		if (jQuery(".widget-sorter-list").length > 0) {

            // Used to add Jquery ui sortable on Widgets & Blocks
	        $(".widget-sorter-list").sortable({
	            connectWith: ".widget-sorter-list",
	            receive: function(event, ui) {
	                // stop items from being dragged into the main block
	                if ($(this).hasClass('all-widgets')) {
	                    $(ui.sender).sortable('cancel');
	                }
	                else{
	                	$(this).find('.icon-content').html('<a href="javascript:void(0);" class="btn btn-danger shadow btn-xs sharp delete-widget-btn"><i class="fa fa-times"></i></a>')
	                }

	            },
	            remove: function(event, ui) {
	                // Add Item into another block without removing from main block
	                if ($(this).hasClass('all-widgets')) {
	                    ui.item.clone().appendTo(ui.item.parent());
	                    $(this).sortable('cancel');
	                }
	            },
	            update: function(event, ui) {
                	if (!$(this).hasClass('all-widgets')) {
	                    let sidebarId = $(this).data('sidebar-id');
		                if (sidebarId) {
		                    updateSidebar(sidebarId, $(this));
		                }
	                }

	            }
	        }).disableSelection();

            function updateSidebar(sidebarId, sidebar) {
	            var itemIds = sidebar.find('.sorter-item').map(function() {
	                return $(this).data('id');
	            }).get();

	            $.ajax({
	                url: '{{ route('admin.widgets.update_block') }}',
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        item_ids: itemIds,
                        sidebar_id: sidebarId
                    },
	                success: function(response) {
	                    console.log('Items updated successfully:', response);
	                },
	                error: function(xhr, status, error) {
	                    console.error('Error updating items:', error);
	                }
	            });
	        }


	        $(document).on('click', '.delete-widget-btn', function() {
	            let widget = $(this).closest('.sorter-item');
	            let sidebar = widget.closest('.widget-sorter-list');
	            let sidebarId = sidebar.data('sidebar-id');

	            widget.remove();

	            if (sidebarId) {
	                updateSidebar(sidebarId, sidebar);
	            }


	        });
        }

	</script>
@endpush