<?php
if ( ! function_exists( 'keni_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function keni_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on keni, use a find and replace
		 * to change 'keni' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'keni', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'gnav' => esc_html__( 'Global nav', 'keni' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'	  => 250,
			'width'	   => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
	remove_action('wp_head', 'wp_generator'); // WordPressバージョン表記を削除
	remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer manifestを削除
endif;
add_action( 'after_setup_theme', 'keni_setup' );

function keni_remove_tagline ( $title ) {
  if ( isset( $title['tagline'] ) ) {
    unset( $title['tagline'] );
  }
  return $title;
}
add_filter( 'document_title_parts', 'keni_remove_tagline' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function keni_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'keni_content_width', 640 );
}
add_action( 'after_setup_theme', 'keni_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function keni_widgets_init() {
	// サイドバー
	register_sidebar( array(
		'name'		  => esc_html__( 'Sidebar', 'keni' ),
		'id'			=> 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'keni' ),
		'before_widget' => '<div id="%1$s" class="keni-section_wrap widget %2$s"><section class="keni-section">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<h3 class="sub-section_title">',
		'after_title'   => '</h3>',
	) );

	// Topページ上部
	register_sidebar( array(
		'name'          => esc_html__( 'Before content for Top Page', 'keni' ),
		'id'            => 'free-before-top',
		'description'   => esc_html__( 'Add widgets here.', 'keni' ),
		'before_widget' => '<div id="%1$s" class="keni-section_wrap widget %2$s"><section class="keni-section">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<div class="sub-section_title">',
		'after_title'   => '</div>',
	) );

	// Topページ下部
	register_sidebar( array(
		'name'          => esc_html__( 'After content for Top Page', 'keni' ),
		'id'            => 'free-after-top',
		'description'   => esc_html__( 'Add widgets here.', 'keni' ),
		'before_widget' => '<div id="%1$s" class="keni-section_wrap widget %2$s"><section class="keni-section">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<h3 class="sub-section_title">',
		'after_title'   => '</h3>',
	) );

	// 個別ページ上部
	register_sidebar( array(
		'name'          => esc_html__( 'Before content for Singlar', 'keni' ),
		'id'            => 'free-before-single',
		'description'   => esc_html__( 'Add widgets here.', 'keni' ),
		'before_widget' => '<div id="%1$s" class="keni-section_wrap widget %2$s"><section class="keni-section">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<div class="sub-section_title">',
		'after_title'   => '</div>',
	) );

	// CTAエリア
	register_sidebar( array(
		'name'          => esc_html__( 'CTA Area', 'keni' ),
		'id'            => 'free-cta',
		'description'   => esc_html__( 'Add widgets here.', 'keni' ),
		'before_widget' => '<div id="%1$s" class="keni-section_wrap widget %2$s"><section class="keni-section">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<h3 class="sub-section_title">',
		'after_title'   => '</h3>',
	) );

	// 個別ページ下部
	register_sidebar( array(
		'name'          => esc_html__( 'After content for Singlar', 'keni' ),
		'id'            => 'free-after-single',
		'description'   => esc_html__( 'Add widgets here.', 'keni' ),
		'before_widget' => '<div id="%1$s" class="keni-section_wrap widget %2$s"><section class="keni-section">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<h3 class="sub-section_title">',
		'after_title'   => '</h3>',
	) );

	// 一覧ページ上部
	register_sidebar( array(
		'name'          => esc_html__( 'Before content for Archive', 'keni' ),
		'id'            => 'free-before-archive',
		'description'   => esc_html__( 'Add widgets here.', 'keni' ),
		'before_widget' => '<div id="%1$s" class="keni-section_wrap widget %2$s"><section class="keni-section">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<div class="sub-section_title">',
		'after_title'   => '</div>',
	) );

	// 一覧ページ下部
	register_sidebar( array(
		'name'          => esc_html__( 'After content for Archive', 'keni' ),
		'id'            => 'free-after-archive',
		'description'   => esc_html__( 'Add widgets here.', 'keni' ),
		'before_widget' => '<div id="%1$s" class="keni-section_wrap widget %2$s"><section class="keni-section">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<h3 class="sub-section_title">',
		'after_title'   => '</h3>',
	) );

	// フッター01
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 01', 'keni' ),
		'id'            => 'footer-01',
		'description'   => esc_html__( 'Add widgets here.', 'keni' ),
		'before_widget' => '<div id="%1$s" class="keni-section_wrap widget %2$s"><section class="keni-section">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<h3 class="sub-section_title">',
		'after_title'   => '</h3>',
	) );

	// フッター02
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 02', 'keni' ),
		'id'            => 'footer-02',
		'description'   => esc_html__( 'Add widgets here.', 'keni' ),
		'before_widget' => '<div id="%1$s" class="keni-section_wrap widget %2$s"><section class="keni-section">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<h3 class="sub-section_title">',
		'after_title'   => '</h3>',
	) );

	// フッター03
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 03', 'keni' ),
		'id'            => 'footer-03',
		'description'   => esc_html__( 'Add widgets here.', 'keni' ),
		'before_widget' => '<div id="%1$s" class="keni-section_wrap widget %2$s"><section class="keni-section">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<h3 class="sub-section_title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'keni_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function keni_scripts() {

	wp_enqueue_style( 'keni-style', get_stylesheet_uri() );

    // 賢威の設定で圧縮する設定を参照し処理を切り替え
    $keni_minify_flg = (int)get_option( 'keni_minify_flg', 0 );
    $keni_minify_flg = apply_filters( 'keni_minify_flg_hook', $keni_minify_flg );
    if ( $keni_minify_flg != 1 ) {
        $path_template_directory = get_template_directory_uri();
        $path_stylesheet_directory = get_stylesheet_directory_uri();

        wp_enqueue_style('keni_base', $path_template_directory . "/base.css");
        wp_enqueue_style('keni-advanced', $path_template_directory . "/advanced.css");

        if ($path_template_directory != $path_stylesheet_directory) {
            wp_enqueue_style('my-keni_base', $path_stylesheet_directory . "/base.css");
            wp_enqueue_style('my-keni-advanced', $path_stylesheet_directory . "/advanced.css");
        }
    } else {
		add_action( 'wp_head', 'keni_minify_css', 20 );
	}

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'keni-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'keni-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( keni_is_toc() ) {
		wp_enqueue_script( 'keni-toc', get_template_directory_uri() . '/js/keni-toc.js', array('jquery'), '', true );
	}

	wp_enqueue_script( 'keni-utility', get_template_directory_uri() . '/js/utility.js', array('jquery'), '', true );
	wp_enqueue_script( 'keni-insertstyle', get_template_directory_uri() . '/js/insertstyle.js', array('jquery'), '', true );

    wp_enqueue_script(
        'fontawesome',
        get_template_directory_uri() . '/js/fontawesome-all.js', array(), '',  true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'keni_scripts' );


/**
 * Admin Enqueue scripts and styles.
 */
function keni_admin_scripts(){
	wp_register_script('keni_primary_category', get_template_directory_uri() .'/js/keni_primary_category.js');
	wp_register_script('keni_jquery-ui', get_template_directory_uri() .'/js/jquery-ui.min.js');
	wp_register_script('keni_repeatable', get_template_directory_uri() .'/js/repeatable/jquery.sheepItPlugin.js');

	wp_enqueue_style( 'keni-admin', get_template_directory_uri() . '/keni/common/admin.css');
	wp_enqueue_style( 'keni-advanced', get_template_directory_uri() . '/advanced.css');
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker');
	wp_register_script( 'keni_category_contents', get_template_directory_uri() . '/js/keni_category_contents.js' );
	if ( preg_match( '/wp-admin\/edit-tags.php\?taxonomy=/', $_SERVER['REQUEST_URI'] ) ) {
		wp_enqueue_script( 'keni_category_contents' );
	}
	wp_enqueue_script('keni_primary_category');
	wp_enqueue_script('keni_jquery-ui');
	wp_enqueue_script('keni_repeatable');
	wp_register_script( 'add-title-count', get_template_directory_uri() . '/js/text_count.js' );
	wp_enqueue_script( 'add-title-count' );
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'keni_admin_scripts' );

/**
 * Admin footer script
 */
function keni_admin_add_js() {
?>
    <script type="text/javascript">
        jQuery(function($){

            $(function() {
                $( "#keni-tabs" ).tabs({
                    activate: function( event, ui ) {
                        var this_li = $('#'+event.target.id).find('[href="' +ui.newPanel.selector+ '"]').parent();
                        $(this_li).siblings().removeClass('tabs');
                        $(this_li).addClass('tabs');
                    }
                });
                // 選ばれているタブを開く
                let selectedTab = $('#toppage_meta_setting .main ul li [name="keni_main_visual_type"]:checked').map(function(){
                    return $(this).parent().text();
                }).get();

                selectedTabs($.trim(selectedTab[0]));

                function selectedTabs (selectText) {
                    var selectIndex = 0;
                    $('#keni-tabs .category-tabs li[role="tab"]').each(function(){
                        if( $(this).text() == selectText ) {
                            return false;
                        }
                        selectIndex++;
                    });
                    $('#keni-tabs').tabs({
                        active: selectIndex
                    });
                }
                // メインビジュアルを変更するためのmetaboxを検索
                var titleIndex;

                $('.metabox-holder .hndle').each(function(){
                    if($(this).text() == 'メインビジュアル') {
                        titleIndex = $('.metabox-holder .hndle').index(this);
                        $(this).closest('#toppage_meta_setting').addClass('mv-setting');
                        return false;
                    }
                });

                $('.mv-setting input[type="radio"]').on('click' ,function(){
                    let inputText = $.trim($(this).parent().text());
                    selectedTabs(inputText);
                });

                $('.mv-setting .category-tabs li[role="tab"]').on('click' ,function(){
                    let tabIndex = $('.mv-setting .category-tabs li[role="tab"]').index(this);
                    $('.mv-setting .main ul:eq(0) li').eq(tabIndex).find('input[type="radio"]').prop('checked', true);
                });
            });

        });
    </script>
<?php
}
add_action('admin_footer', 'keni_admin_add_js');


/**
 * Editor style
*/
function keni_add_editor_style() {

	$uri_template_directory = get_template_directory_uri();
	$uri_stylesheet_directory = get_stylesheet_directory_uri();

	add_editor_style( $uri_template_directory . '/base.css' );
	add_editor_style( $uri_template_directory . '/advanced.css');
	if ( $uri_template_directory != $uri_stylesheet_directory ) {
		add_editor_style( $uri_stylesheet_directory . '/base.css' );
		add_editor_style( $uri_stylesheet_directory . '/advanced.css');
	}
	add_editor_style( $uri_template_directory . '/keni/common/admin.css');

}
add_action('admin_init', 'keni_add_editor_style');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function keni_customize_preview_js() {
	wp_enqueue_script( 'themename-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'keni_customize_preview_js' );

/**
 * Load files
 */
locate_template( 'keni/module/keni-shortcode/keni-shortcode.php', true );
locate_template( 'keni/module/keni-archive/keni-archive.php', true );
locate_template( 'keni/module/keni-setting/keni-setting.php', true );
locate_template( 'keni/module/keni-user/keni-user.php', true );
locate_template( 'keni/module/keni-layout/keni-layout.php', true );
locate_template( 'keni/module/keni-seo/keni-seo.php', true );
locate_template( 'keni/module/keni-sns/keni-sns.php', true );
locate_template( 'keni/module/keni-post/keni-post.php', true );
locate_template( 'keni/module/keni-sitecolor/keni-sitecolor.php', true );
// 共通コンテンツ機能
if ( apply_filters( "keni_common_contents_display", true ) ) {
	locate_template( 'keni/module/keni-common-content/keni-common-content.php', true );
}
locate_template( 'keni/module/keni-widget/keni-widget.php', true );
locate_template( 'keni/module/keni-minify/keni-minify.php', true );

locate_template( 'keni/module/keni-util/keni-util.php', true );
locate_template( 'keni/module/keni-pv/keni-pv.php', true );

/**
 * Load Post types
 */
// 共通コンテンツ 投稿タイプ
if ( apply_filters( "keni_common_contents_display", true ) ) {
	locate_template( 'post-types/keni_cc.php', true );
}
// 賢威リンクカード 投稿タイプ
if ( apply_filters( "keni_linkcard_display", true ) ) {
	locate_template( 'post-types/keni-linkcard-cf.php', true );
}

/**
 * Remove WordPress Format
 */
if ( get_option( 'keni_remove_format', 0 ) == "1" ) {
	keni_remove_format();
}

/**
 * ajax 設定
 */
function keni_add_ajaxurl() {
	?>
    <script>
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
        var sns_cnt = <?php echo ( get_option('keni_disabled_sns_count', 0) > 0 ? "false" : "true" ); ?>;
    </script>
	<?php
}
add_action( 'wp_head', 'keni_add_ajaxurl', 1 );
