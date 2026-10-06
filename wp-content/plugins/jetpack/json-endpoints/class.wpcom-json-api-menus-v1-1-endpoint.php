<?php
abstract class WPCOM_JSON_API_Menus_Abstract_Endpoint extends WPCOM_JSON_API_Endpoint {

	protected function switch_to_blog_and_validate_user( $site ) {
		$site_id = $this->api->switch_to_blog_and_validate_user( $this->api->get_blog_id( $site ) );
		if ( is_wp_error( $site_id ) ) {
			return $site_id;
		}

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return new WP_Error( 'unauthorised', 'User cannot edit theme options on this site.', 403 );
		}

		if ( defined( 'IS_WPCOM' ) && IS_WPCOM ) {
			$this->load_theme_functions();
		}

		return $site_id;
	}


	protected function get_locations() {
		$locations = array();
		$menus = get_registered_nav_menus();
		if ( !empty( $menus ) ) {
			foreach( $menus as $name => $description ) {
				$locations[] = array( 'name' => $name, 'description' => $description );
			}
		}

		$locations = array_merge( $locations, WPCOM_JSON_API_Menus_Widgets::get() );

		// Primary (first) location should have defaultState -> default,
		// all other locations (including widgets) should have defaultState -> empty.
		for ( $i = 0; $i < count( $locations ); $i++ ) {
			$locations[ $i ]['defaultState'] = $i ? 'empty' : 'default';
		}
		return $locations;
	}

	protected function simplify( $data ) {
		$simplifier = new WPCOM_JSON_API_Menus_Simplifier( $data );
		return $simplifier->translate();
	}

	protected function complexify( $data ) {
		$complexifier = new WPCOM_JSON_API_Menus_Complexify( $data );
		return $complexifier->translate();
	}
}

abstract class WPCOM_JSON_API_Menus_Translator {
	protected $filter = '';

	protected $filters = array();

	public function __construct( $menus ) {
		$this->is_single_menu = ! is_array( $menus );
		$this->menus = is_array( $menus ) ? $menus : array( $menus );
	}

	public function translate() {
		$result = $this->menus;
		foreach ( $this->filters as $f ) {
			$result = call_user_func( array( $this, $f ), $result );
			if ( is_wp_error($result ) ) {
				return $result;
			}
		}
		return $this->maybe_extract( $result );
	}

	protected function maybe_extract( $menus ) {
		return $this->is_single_menu ? $menus[0] : $menus;
	}

	public function whitelist_and_rename_with( $object, $dict ) {
		$keys = array_keys( $dict );
		$return = array();
		foreach ( (array) $object as $k => $v ) {
			if ( in_array( $k, $keys ) ) {
				if ( is_array( $dict[ $k ] ) ) {
					settype( $v, $dict[ $k ]['type'] );
					$return[ $dict[ $k ]['name'] ] = $v;
				} else {
					$new_k = $dict[ $k ];
					$return[ $new_k ] = $v;
				}
			}
		}
		return $return;
	}
}

class WPCOM_JSON_API_Menus_Simplifier extends WPCOM_JSON_API_Menus_Translator {
	protected $filter = 'wpcom_menu_api_translator_simplify';

	protected $filters = array(
		'whitelist_and_rename_keys',
		'add_locations',
		'treeify',
		'add_widget_locations',
	);

	protected $menu_whitelist = array(
		'term_id'       => array( 'name' => 'id', 'type' => 'int' ),
		'name'          => array( 'name' => 'name', 'type' => 'string' ),
		'description'   => array( 'name' => 'description', 'type' => 'string' ),
		'items'         => array( 'name' => 'items', 'type' => 'array' ),
	);

	protected $menu_item_whitelist = array(
		'db_id'             => array( 'name' => 'id', 'type' => 'int' ),
		'object_id'         => array( 'name' => 'content_id', 'type' => 'int' ),
		'object'            => array( 'name' => 'type', 'type' => 'string' ),
		'type'              => array( 'name' => 'type_family', 'type' => 'string' ),
		'type_label'        => array( 'name' => 'type_label', 'type' => 'string' ),
		'title'             => array( 'name' => 'name', 'type' => 'string' ),
		'menu_order'        => array( 'name' => 'order', 'type' => 'int' ),
		'menu_item_parent'  => array( 'name' => 'parent', 'type' => 'int' ),
		'url'               => array( 'name' => 'url', 'type' => 'string' ),
		'target'            => array( 'name' => 'link_target', 'type' => 'string' ),
		'attr_title'        => array( 'name' => 'link_title', 'type' => 'string' ),
		'description'       => array( 'name' => 'description', 'type' => 'string' ),
		'classes'           => array( 'name' => 'classes', 'type' => 'array' ),
		'xfn'               => array( 'name' => 'xfn', 'type' => 'string' ),
	);

	/**************************
	 * Filters methods
	 **************************/

	public function treeify( $menus ) {
		return array_map( array( $this, 'treeify_menu' ), $menus );
	}

	// turn the flat item list into a tree of items
	protected function treeify_menu( $menu ) {
		$indexed_nodes = array();
		$tree = array();

		foreach( $menu['items'] as &$item ) {
			$indexed_nodes[ $item['id'] ] = &$item;
		}

		foreach( $menu['items'] as &$item ) {
			if ( $item['parent'] && isset( $indexed_nodes[ $item['parent'] ] ) ) {
				$parent_node = &$indexed_nodes[ $item['parent'] ];
				if ( !isset( $parent_node['items'] ) ) {
					$parent_node['items'] = array();
				}
				$parent_node['items'][ $item['order'] ] = &$item;
			} else {
				$tree[ $item['order'] ] = &$item;
			}
			unset( $item['order'] );
			unset( $item['parent'] );
		}

		$menu['items'] = $tree;
		$this->remove_item_keys( $menu );
		return $menu;
	}

	// recursively ensure item lists are contiguous
	protected function remove_item_keys( &$item ) {
		if ( ! isset( $item['items'] ) || ! is_array( $item['items'] ) ) {
			return;
		}


		foreach( $item['items'] as &$it ) {
			$this->remove_item_keys( $it );
		}

		$item['items'] = array_values( $item['items'] );
	}

	protected function whitelist_and_rename_keys( $menus ) {
		$transformed_menus = array();

		foreach ( $menus as $menu ) {
			$menu = $this->whitelist_and_rename_with( $menu, $this->menu_whitelist );

			if ( isset( $menu['items'] ) ) {
				foreach ( $menu['items'] as &$item ) {
					$item = $this->whitelist_and_rename_with( $item, $this->menu_item_whitelist );
				}
			}

			$transformed_menus[] = $menu;
		}

		return $transformed_menus;
	}

	protected function add_locations( $menus ) {
		$menus_with_locations = array();

		foreach( $menus as $menu ) {
			$menu['locations'] = array_keys( get_nav_menu_locations(), $menu['id'] );
			$menus_with_locations[] = $menu;
		}

		return $menus_with_locations;
	}

	protected function add_widget_locations( $menus ) {
		$nav_menu_widgets = WPCOM_JSON_API_Menus_Widgets::get();

		if ( ! is_array( $nav_menu_widgets ) ) {
			return $menus;
		}

		foreach ( $menus as &$menu ) {
			$widget_locations = array();

			foreach ( $nav_menu_widgets as $key => $widget ) {
				if ( is_array( $widget ) && isset( $widget['nav_menu'] ) &&
				    $widget['nav_menu'] === $menu['id'] ) {
					$widget_locations[] = 'nav_menu_widget-' . $key;
				}
			}
			$menu['locations'] = array_merge( $menu['locations'], $widget_locations );
		}

		return $menus;
	}
}

class WPCOM_JSON_API_Menus_Complexify extends WPCOM_JSON_API_Menus_Translator {
	protected $filter = 'wpcom_menu_api_translator_complexify';

	protected $filters = array(
		'untreeify',
		'set_locations',
		'whitelist_and_rename_keys',
	);

	protected $menu_whitelist = array(
		'id' => 'term_id',
		'name' => 'menu-name',
		'description' => 'description',
		'items' => 'items',
	);

	protected $menu_item_whitelist = array(
		'id' => 'menu-item-db-id',
		'content_id' => 'menu-item-object-id',
		'type' => 'menu-item-object',
		'type_family' => 'menu-item-type',
		'type_label' => 'menu-item-type-label',
		'name' => 'menu-item-title',
		'order' => 'menu-item-position',
		'parent' => 'menu-item-parent-id',
		'url' => 'menu-item-url',
		'link_target' => 'menu-item-target',
		'link_title' => 'menu-item-attr-title',
		'status' => 'menu-item-status',
		'tmp_id' => 'tmp_id',
		'tmp_parent' => 'tmp_parent',
		'description' => 'menu-item-description',
		'classes' => 'menu-item-classes',
		'xfn' => 'menu-item-xfn',
	);

	/**************************
	 * Filters methods
	 **************************/

	public function untreeify( $menus ) {
		return array_map( array( $this, 'untreeify_menu' ), $menus );
	}

	// convert the tree of menu items to a flat list suitable for
	// the nav_menu APIs
	protected function untreeify_menu( $menu ) {
		if ( empty( $menu['items'] ) ) {
			return $menu;
		}

		$items_list = array();
		$counter = 1;
		foreac