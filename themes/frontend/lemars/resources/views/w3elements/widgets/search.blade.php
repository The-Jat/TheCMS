<div class="widget">
    <div class="search-bx">
        <form action="{{ route('permalink.search') }}" role="search" method="get">
            <div class="input-group">
                <input name="s" type="text" class="form-control" placeholder="{{ $args['title'] ?? __('Search') }}">
                <span class="input-group-append">
                    <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                </span> 
            </div>
        </form>
    </div>
</div>