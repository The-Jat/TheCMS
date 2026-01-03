<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use Modules\W3CPT\Entities\Blog;
use Modules\W3CPT\Entities\BlogCategory;
use Modules\W3CPT\Entities\BlogBlogCategory;
use Modules\W3CPT\Entities\BlogTag;
use Modules\W3CPT\Entities\BlogBlogTag;
use Modules\W3CPT\Entities\BlogMeta;
use Modules\W3CPT\Entities\BlogSeo;

trait DzCptTrait {

	function __construct()
    {

    }

	public function register_w3cpt_post_types()
	{
		$w3PostTypes = Blog::where('post_type', '=', config('w3cpt.post_type'))->get('id')->toArray();

		if ( $w3PostTypes ) {
			foreach ( $w3PostTypes as $cpt_id ) {
				$cpt_meta = BlogMeta::where('blog_id', '=', $cpt_id)->pluck('value', 'title');

				if(!$cpt_meta->isEmpty())
				{
					$postType = $this->post_type_object($cpt_meta);
				}

			}
		}

	}
	
	private function _dz_custom_object_labels($postObj)
	{
		$labels['name'] = $postObj['cpt_label'];
		$labels['singular_name'] = $postObj['cpt_singular_name'];
		$labels['add_new'] = __('common.add_new');
		$labels['add_new_item'] = __('common.add_new').' '.$labels['singular_name'];
		$labels['edit_item'] = __('common.edit').' '.$labels['singular_name'];
		$labels['new_item'] = __('common.new').' '.$labels['singular_name'];
		$labels['view_item'] = __('common.view').' '.$labels['singular_name'];
		$labels['view_items'] = __('common.view').' '.$labels['name'];
		$labels['search_items'] = __('common.search').' '.$labels['name'];
		$labels['not_found'] = 'No '.$labels['name'].' found';
		$labels['not_found_in_trash'] = 'No '.$labels['name'].' found in Trash';
		$labels['parent_item_colon'] = '';
		$labels['all_items'] = $labels['name'];
		$labels['archives'] = $labels['name'];
		$labels['attributes'] = 'Post Attributes';
		$labels['insert_into_item'] = 'Insert into post';
		$labels['uploaded_to_this_item'] = 'Uploaded to this post';
		$labels['featured_image'] = 'Featured image';
		$labels['set_featured_image'] = 'Set featured image';
		$labels['remove_featured_image'] = 'Remove featured image';
		$labels['use_featured_image'] = 'Use as featured image';
		$labels['filter_items_list'] = 'Filter posts list';
		$labels['filter_by_date'] = 'Filter by date';
		$labels['items_list_navigation'] = 'Posts list navigation';
		$labels['items_list'] = 'Posts list';
		$labels['item_published'] = 'Post published.';
		$labels['item_published_privately'] = 'Post published privately.';
		$labels['item_reverted_to_draft'] = 'Post reverted to draft.';
		$labels['item_scheduled'] = 'Post scheduled.';
		$labels['item_updated'] = 'Post updated.';
		$labels['item_link'] = 'Post Link';
		$labels['item_link_description'] = 'A link to a post.';
		$labels['menu_name'] = $labels['name'];
		$labels['name_admin_bar'] = $labels['singular_name'];

		return $labels;
	}
	
	private function _dz_custom_object_taxo_labels($postObj)
	{
		$labels['name'] = $postObj['cpt_tax_label'];
		$labels['singular_name'] = $postObj['cpt_tax_singular_name'];
		$labels['add_new'] = __('common.add_new');
		$labels['add_new_item'] = __('common.add_new').' '.$labels['singular_name'];
		$labels['edit_item'] = __('common.edit').' '.$labels['singular_name'];
		$labels['new_item'] = __('common.new').' '.$labels['singular_name'];
		$labels['view_item'] = __('common.view').' '.$labels['singular_name'];
		$labels['view_items'] = __('common.view').' '.$labels['name'];
		$labels['search_items'] = __('common.search').' '.$labels['name'];
		$labels['not_found'] = 'No '.$labels['name'].' found';
		$labels['not_found_in_trash'] = 'No '.$labels['name'].' found in Trash';
		$labels['parent_item_colon'] = '';
		$labels['all_items'] = $labels['name'];
		$labels['archives'] = $labels['name'];
		$labels['attributes'] = 'Post Attributes';
		$labels['insert_into_item'] = 'Insert into post';
		$labels['uploaded_to_this_item'] = 'Uploaded to this post';
		$labels['featured_image'] = 'Featured image';
		$labels['set_featured_image'] = 'Set featured image';
		$labels['remove_featured_image'] = 'Remove featured image';
		$labels['use_featured_image'] = 'Use as featured image';
		$labels['filter_items_list'] = 'Filter posts list';
		$labels['filter_by_date'] = 'Filter by date';
		$labels['items_list_navigation'] = 'Posts list navigation';
		$labels['items_list'] = 'Posts list';
		$labels['item_published'] = 'Post published.';
		$labels['item_published_privately'] = 'Post published privately.';
		$labels['item_reverted_to_draft'] = 'Post reverted to draft.';
		$labels['item_scheduled'] = 'Post scheduled.';
		$labels['item_updated'] = 'Post updated.';
		$labels['item_link'] = 'Post Link';
		$labels['item_link_description'] = 'A link to a post.';
		$labels['menu_name'] = $labels['name'];
		$labels['name_admin_bar'] = $labels['singular_name'];

		return $labels;
	}

	public function post_type_object($postObj)
	{	
		if(!empty($postObj))
		{
			$postObj['name'] = $postObj['cpt_name'];
			$postObj['cpt_label']  = $postObj['cpt_label'];
			$postObj['cpt_labels'] = $this->_dz_custom_object_labels($postObj);
		}	
		
		return $postObj;
	}

	public function taxonomy_object($postObj)
	{		
		$postObj['name'] = $postObj['cpt_tax_name'];
		$postObj['cpt_tax_label']  = $postObj['cpt_tax_label'];
		$postObj['cpt_tax_labels'] = $this->_dz_custom_object_taxo_labels($postObj);
		
		return $postObj;
	}

	public function get_post_types($args=array())
	{
		$where = $postTypes = array();
		if(!empty($args))
		{
			foreach ( $args as $key => $value ) {
				$where[] = array('title' => $key, 'value' => $value);
			}
		}
		$cptIds = Blog::where('post_type', '=', config('w3cpt.post_type'))->get('id');

		if(!$cptIds->isEmpty())
		{
			foreach ($cptIds as $cptId) {
				$query = BlogMeta::query()->where(['blog_id' => $cptId->id, 'title' => 'cpt_name']);
				if(!empty($args))
				{
					foreach ( $args as $key => $value ) {
						$query->orWhere(['title' => $key, 'value' => $value]);
					}
				}
				$postType =  $query->pluck('value', 'title');
				$postTypes[] = $postType['cpt_name'];
			}
		}

		return $postTypes;
	}

	public function w3_post_types($post_type=Null)
	{
		$postTypes = array();
		$cptIds = Blog::where('post_type', '=', config('w3cpt.post_type'))->get('id');

		if(!$cptIds->isEmpty())
		{
			foreach ($cptIds as $cptId) {
				$postType = BlogMeta::where(['blog_id' => $cptId->id])->pluck('value', 'title');
				$postTypes[$postType['cpt_name']] = $postType;
			}
		}

		if($post_type != Null)
		{
			return isset($postTypes[$post_type]) ? $postTypes[$post_type] : array();
		}

		return $postTypes;
	}

	public function w3_taxonomies($post_type=Null)
	{
		$postTypes = array();
		$cptIds = Blog::where('post_type', '=', config('w3cpt.post_type_taxo'))->get('id');

		if(!$cptIds->isEmpty())
		{
			foreach ($cptIds as $cptId) {
				$postType = BlogMeta::where(['blog_id' => $cptId->id])->pluck('value', 'title');
				$postTypes[$postType['cpt_tax_name']] = $postType;
			}
		}

		if($post_type != Null)
		{
			return isset($postTypes[$post_type]) ? $postTypes[$post_type] : array();
		}

		return $postTypes;
	}

	public function get_post_type_object($post_type=Null)
	{
		$postObj = $this->w3_post_types($post_type);
		return $this->post_type_object($postObj);
	}

	public function get_taxonomy_object($post_type=Null)
	{
		$postObj = $this->w3_taxonomies($post_type);
		return $this->taxonomy_object($postObj);
	}

	public function get_cpt_screen_options($args=array(), $type=Null)
	{
		$where = $postTypes = $newScreenOptions = array();
		if(!empty($args))
		{
			foreach ( $args as $key => $value ) {
				$where[] = array('title' => $key, 'value' => $value);
			}
		}
		$cptIds = Blog::where('post_type', '=', config('w3cpt.post_type'))->where('status', '=', 1)->get('id');

		if(!$cptIds->isEmpty())
		{
			foreach ($cptIds as $cptId) {
				$query = BlogMeta::query()->where(['blog_id' => $cptId->id]);
				if(!empty($args))
				{
					foreach ( $args as $key => $value ) {
						$query->orWhere(['title' => $key, 'value' => $value]);
					}
				}
				$postType =  $query->pluck('value', 'title');
				$postTypes[$postType['cpt_name']] = $postType['cpt_label'];
				$newScreenOptions[\Str::studly($postType['cpt_name'])] = array('visibility' => true);
			}
		}

		if($type != Null)
		{
			$screenOptions = array_merge(config($type.'.ScreenOption'), $newScreenOptions);
			\Config::set($type.'.ScreenOption', $screenOptions);
		}
		
		return $postTypes;

	}

	public function taxonomies_by_cpt($forScreenOption=false)
	{
		$cptIds = Blog::where('post_type', '=', config('w3cpt.post_type_taxo'))->pluck('id');
	   	$categories = array();

		if(!$cptIds->isEmpty())
		{
			foreach($cptIds as $cptId)
			{
				$taxonomies = BlogMeta::where('blog_id', '=', $cptId)->whereIn('title', ['cpt_tax_name', 'cpt_tax_label'])->pluck('value', 'title');

				if(!$taxonomies->isEmpty())
			   	{
			   		$taxName = \Str::studly($taxonomies['cpt_tax_name']);
					if($forScreenOption)
					{
						/* this is use for screen options checkbox */
						$categories[\Str::studly($taxName)] = array('visibility' => true, 'display_title' => $taxonomies['cpt_tax_label'], 'lang' => false);
					}
					else
					{
						$categories[\Str::studly($taxName)] = BlogCategory::where('type', '=', $taxonomies['cpt_tax_name'])->get();
					}
			   	}

			}
		}
	   	
	   	return $categories;
	}

	public function getPostsByPostType($post_type)
	{
		$blogObj = new Blog();
		return $blogObj->getPostsByPostType($post_type);
	}

	public function getTaxonomiesByPostType($post_type)
	{
		$blogObj = new Blog();
		return $blogObj->getTaxonomiesByPostType($post_type);
	}

}