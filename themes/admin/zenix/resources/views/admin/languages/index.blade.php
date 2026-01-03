{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.languages.index') }}">{{ __('common.languages') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.update_languages') }}</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
    	<div class="col-md-4">
    		<div class="row">
    			<div class="col-md-12">
					<form action="{{ route('admin.languages.show') }}" method="POST" id="LanguageForm">
			        	@csrf
			    		<div class="card">
							<div class="card-header">
								<h4 class="card-title">{{ __('common.load_language') }}</h4>

							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-12 form-group">
										<label class="form-label">{{ __('common.language') }}</label>
										<select name="language" id="language" class="form-control default-select" data-live-search="true">
											<option disabled selected>{{ __('Choose one') }}</option>
											@forelse($installed_language as $key => $language)
												<option value="{{ $key }}" {{ session('language') == $key ? 'selected' : '' }}>{{ $language }}</option>
	                                        @empty
	                                        @endforelse
										</select>
										@error('language')
				                            <p class="text-danger">
				                                {{ $message }}
				                            </p>
				                        @enderror
									</div>
									<div class="col-md-12 form-group">
										<label class="form-label">{{ __('common.files') }}</label>
										<select name="file_name" id="file_name" class="form-control">
											<option value="">{{ __('Choose one') }}</option>
											@forelse($allfiles as $file)
												<option value="{{ $file }}">{{ $file }}</option>
											@empty
											@endforelse
										</select>
										@error('file_name')
				                            <p class="text-danger">
				                                {{ $message }}
				                            </p>
				                        @enderror
									</div>
								</div>
							</div>
                            <div class="card-footer justify-content-between d-flex">
							    <button type="submit" class="btn btn-primary">{{ __('common.load') }}</button>
                                <a href="javascript:void(0)" class="btn btn-primary add-new-lang " data-bs-toggle="modal" data-bs-target="#langModal">
                                    <i class="fa fa-plus"></i> {{ __('common.addnewlanglable') }}
                                </a>
                            </div>

						</div>
					</form>
				</div>
			</div>
    	</div>
    	<div class="col-md-8">
    		<div class="row">
    			<div class="col-md-12" >
					<form action="{{ route('admin.languages.index') }}" method="POST" id="UpdateLanguageFile">
						@csrf
			    		<div class="card">
							<div class="card-header">
								<h4 class="card-title">{{ __('common.update_languages') }}</h4>

							</div>
							<div class="card-body">
								<div class="row language-table-scroll">

									<div class="col-md-12">
										<input type="hidden" name="language_hidden" id="language_hidden">
										<input type="hidden" name="file_name_hidden" id="file_name_hidden">
										<table class="table table-responsive table-bordered">
											<thead>
												<tr>
													<th>{{ __('common.key') }}</th>
													<th>{{ __('common.value') }}</th>
												</tr>
											</thead>
											<tbody id="LanguageData">
												<tr>
													<td colspan="2" align="center">{{ __('common.no_language_found') }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="p-4 border-0 border-top">
								<button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
    	</div>
    </div>

</div>
<div class="modal fade" id="langModal" tabindex="-1" aria-labelledby="langModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="langModalLabel">{{ __('common.addnewlang') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="{{ route('admin.languages.add')}}" id="lang-id">
            @csrf
            <div class="modal-body">
                <div class="col-md-12 form-group">
                    <label class="form-label">{{ __('common.language') }}</label>
                    <select name="new_language" id="new-language" class="form-control default-select" data-live-search="true">
                        <option disabled selected>{{ __('Choose one') }}</option>
                        @forelse($languages as $key => $language)
                            <option value="{{ $key }}" >{{ $language }}</option>
                        @empty
                        @endforelse
                    </select>
                    @error('language')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
