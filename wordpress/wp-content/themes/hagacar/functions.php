<?php
/**___________________________________________________________   ___________
__  ____/__  __ /__  ____/__    |__  __/__  ____/_  __ /__  | / /__  ____/
_  /    __  /_/ /_  __/  __  /| |_  /  __  __/  _  / / /_   |/ /__  __/
/ /___  _  _, _/_  /___  _  ___ |  /   _  /___  / /_/ /_  /|  / _  /___
/____/  /_/ |_| /_____/  /_/  |_/_/    /_____/  /____/ /_/ |_/  /_____/

 * DATE: 2024/10/16
 * AUTHOR: CREATEONE
 * URL: http://createone.jp/
 */

/* /////////////////////////////////
  ダッシュボード
///////////////////////////////// */

//ダッシュボード---------------------------------------------------------
/**
 * カスタム投稿タイプの投稿数をダッシュボードに表示する
 */
add_action(
    'dashboard_glance_items',
    function ($elements) {
        global $wp_post_types;
        global $user_level;
        global $user_ID;

        $custom_post_types = get_post_types(array('_builtin' => false, 'public' => true,), 'object', 'and'); // カスタム投稿取得
        if (!$custom_post_types) {
            return;
        } else {
            foreach ($custom_post_types as $custom_post_type) {
                $name = $custom_post_type->name;
                $label = $custom_post_type->labels->name;
                $num_posts = wp_count_posts($name);
                $num = number_format_i18n($num_posts->publish);
                if (current_user_can('edit_posts')) {
                    $elements[] = '<a href="edit.php?post_type=' . $name . '" class="' . $name . '-count">' . $num . '件の' . $label . '</a>';
                }
            }
            return $elements;
        }
    }
);


/**
 * ウィジェットを非表示
 */
remove_action('welcome_panel', 'wp_welcome_panel');



/**
 * 現在の状況（概要）の中身を色々非表示にする
 */
add_action(
    'wp_dashboard_setup',
    function () {
        global $wp_meta_boxes;
        unset($wp_meta_boxes['dashboard']['normal']['core']['aj_dashboard_widget']);   // Async JavaScript
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);   // サイトヘルスステータス
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);   // アクティビティ
        unset($wp_meta_boxes['dashboard']['normal']['core']['wpseo-dashboard-overview']);   // YoastSEO
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);   // 最近のコメント
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);   // 被リンク
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);   // プラグイン
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);   // クイック投稿
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);   // 最近の下書き
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);   // WordPressブログ
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);   // WordPressフォーラム
    }
);


//管理画面全般---------------------------------------------------------

/**
 * ログイン中だけCSS追加
 */
add_action('wp_head', 'adminbar_custom');
function adminbar_custom()
{
    if (is_user_logged_in()) :
        echo '<style type="text/css">
        @media print, screen and (max-width: 768px ){
          #wpadminbar{
            position:fixed;
          }
          .header{
            top:46px!important;
          }
        }
        @media print, screen and (min-width: 769px ){
          .header{
            top:32px!important;
          }
        }
    </style>';
    endif;
}


/**
 * ログイン画面のロゴを変更
 */
add_action(
    'login_head',
    function () {
        echo '<style type="text/css">
        #login h1 a {
          width: 320px;
          height: 100px;
          background-repeat: no-repeat !important;
          background-position: center top;
          -moz-background-size:contain;
          -ms-background-size:contain;
          -o-background-size:contain;
          -webkit-background-size:contain;
          background-size:contain;
          margin-bottom:20px;
          pointer-events: none;
        }
        #login h1 a {
          background-image:url(' . get_theme_file_uri() . '/login_logo.png);
        }
      </style>';
    }
);


/**
 * 表示オプション非表示
 */
function custom_columns($columns)
{
    unset($columns['tags']);
    unset($columns['comments']);
    unset($columns['hsm_pagetitle']);
    unset($columns['hsm_keywords']);
    unset($columns['hsm_description']);
    unset($columns['hsm_description']);
    return $columns;
}
add_filter('manage_posts_columns', 'custom_columns');
add_filter('manage_pages_columns', 'custom_columns');


/**
 * 管理バー
 */
add_action(
    'wp_before_admin_bar_render',
    function () {
        global $wp_admin_bar, $user_level;
        if (current_user_can('activate_plugins')) {
            $wp_admin_bar->remove_menu('wp-logo'); // Wpロゴ
            $wp_admin_bar->remove_node('comments'); // コメント
            $wp_admin_bar->remove_menu('updates'); // 更新
            $wp_admin_bar->remove_menu('wpseo-menu'); // SEO
        } else {
            $wp_admin_bar->remove_menu('wp-logo'); // Wpロゴ
            $wp_admin_bar->remove_node('comments'); // コメント
            $wp_admin_bar->remove_menu('updates'); // 更新
            $wp_admin_bar->remove_menu('wpseo-menu'); // SEO
            $wp_admin_bar->remove_menu('new-content'); //新規
        }
    }
);

/**
 * サイドメニュー
 */
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php'); // 「コメント」を非表示
    remove_menu_page('separator1'); // 「ダッシュボード」区切りを非表示
    remove_menu_page('separator2'); // 「外観」の間の区切りを非表示
});




/* /////////////////////////////////
  投稿一覧と投稿編集画面
///////////////////////////////// */
// 固定ページでのみグーテンベルクを無効化
add_filter('use_block_editor_for_post_type', 'disable_gutenberg_for_pages', 10, 2);
function disable_gutenberg_for_pages($is_enabled, $post_type) {
    if ($post_type === 'page') {
        return false; // 固定ページでグーテンベルクを無効化
    }
    return $is_enabled; // 他の投稿タイプではグーテンベルクを有効
}

// 固定ページと mwwpform でビジュアルエディターを無効化
add_filter('user_can_richedit', 'disable_visual_editor_for_pages_and_mwwpform');
function disable_visual_editor_for_pages_and_mwwpform($can_richedit) {
    if (get_post_type() === 'page' || get_post_type() === 'mw-wp-form') {
        return false; // 固定ページと mwwpform でビジュアルエディターを無効化
    }
    return $can_richedit; // 他の投稿タイプではビジュアルエディターを有効
}

add_action('template_redirect', 'conditionally_remove_wpautop');
function conditionally_remove_wpautop() {
    if (is_page()) { // 固定ページの場合のみ
        remove_filter('the_content', 'wpautop');
    }
}




/* /////////////////////////////////
  ファイルの読み込み
///////////////////////////////// */
/**
 * CSS/JSを追加
 */
add_action(
    'init',
    function () {
        if (is_admin()) return;
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', home_url('/assets/vendor/jquery/3.7.1.js'), null, null, false);
    }
);
add_action(
    'wp_head',
    function () {
        echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
        echo '<link rel="preload" href="'.home_url('/assets/vendor/slick/slick.css').'" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
    }
);
add_action(
    'wp_enqueue_scripts',
    function () {
        if (is_admin()) return;

        //タイムスタンプを取得
        $timestamp = time() . mt_rand(1000, 9999);

        //vendor
        wp_enqueue_style('bootstrap-cdn', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', null, null, 'screen');

        //css
        wp_enqueue_style('themes-css-style', get_stylesheet_uri());
        wp_enqueue_style('assets-css-style', home_url('/assets/css/style.css?' . $timestamp), null, null, 'all');

        //js
        wp_enqueue_script('shutto-cdn', 'https://d.shutto-translation.com/trans.js?id=61746', null, null, true);
        wp_enqueue_script('assets-vendor-scrollmagic', home_url('/assets/vendor/scrollmagic/ScrollMagic.min.js'), null, null, true);
        wp_enqueue_script('assets-vendor-scrollmagic-debug', home_url('/assets/vendor/scrollmagic/debug.addIndicators.min.js'), null, null, true);
        wp_enqueue_script('assets-vendor-velocity', home_url('/assets/vendor/velocity/velocity.min.js'), null, null, true);
        wp_enqueue_script('assets-vendor-velocity-ui', home_url('/assets/vendor/velocity/velocity.ui.min.js'), null, null, true);
        wp_enqueue_script('assets-vendor-slick', home_url('/assets/vendor/slick/slick.min.js'), null, null, true);
        wp_enqueue_script('assets-js-script', home_url('/assets/js/script.js'), null, null, true);


        //固定ページ
        if (get_field('meta-cssjs')):
            $headGroupArry =  split_line_text(get_field('meta-cssjs'));
            foreach ($headGroupArry as $key => $val):
                // URLを解析
                $parsed_url = parse_url($val);
                // ホストが存在しない、または内部ドメインの場合はhome_urlで括る
                if (!isset($parsed_url['host']) || strpos($parsed_url['host'], home_url()) !== false) {
                    $val = home_url($val);
                }
                $ext = substr($val, strrpos($val, '.') + 1);
                if (strpos($ext, 'css') !== false):
                    wp_enqueue_style('temp_head' . $key, $val, null, null, 'all');
                endif;
                if (strpos($ext, 'js') !== false):
                    wp_enqueue_script('temp_head' . $key, $val, null, null, true);
                endif;
            endforeach;
        endif;

        if (get_field('meta-css-inline')):
            $custom_css = get_field('meta-css-inline');
            // ダミーのスタイルハンドルを登録
            wp_register_style('custom-inline-style', false);
            // wp_enqueue_styleを使ってスタイルをエンキュー
            wp_enqueue_style('custom-inline-style');
            // インラインスタイルを追加
            wp_add_inline_style('custom-inline-style', $custom_css);
        endif;

        if (get_field('meta-js-inline')):
            $custom_js = get_field('meta-js-inline');
            // ダミーのスクリプトハンドルを登録
            wp_register_script('custom-inline-script', false);
            // wp_enqueue_scriptを使ってスクリプトをエンキュー
            wp_enqueue_script('custom-inline-script');
            // インラインスクリプトを追加
            wp_add_inline_script('custom-inline-script', $custom_js);
        endif;
    }
);


// スクリプトとスタイルシートのURLからバージョンパラメータを削除
function remove_version_scripts_styles($src)
{
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'remove_version_scripts_styles', 9999);

/**
 * 改行を含むテキストを改行毎に分割する関数
 * $text     : 対象文字列
 * $trim     : 空白を削除するか
 * $zero     : 改行のみの文字を含むか
 * $remake   : キーを採番し直すか
 **/
function split_line_text($text, $trim = true, $zero = true, $remake = true)
{
    $strLines = array();
    // 改行毎に配列に格納
    $strLines = explode("\n", $text);
    if ($trim == true) {
        // 空白(スペース)を削除する
        $strLines = array_map('trim', $strLines);
    }
    if ($zero == true) {
        // 文字を含まない改行のみを削除する
        $strLines = array_filter($strLines, 'strlen');
    }
    if ($remake == true) {
        // キーを採番し直す
        $strLines = array_values($strLines);
    }
    return $strLines;
}


/* /////////////////////////////////
  ショートコード
///////////////////////////////// */

/**
 * お知らせ（一覧）
 */
function display_news_shortcode($atts)
{
  // ショートコードの属性を解析し、デフォルトを設定
  extract(shortcode_atts(array(
    'posts_per_page' => 3,  // 最大3件の記事を取得
    'show' => 1,            // セクションのラップ表示を制御
  ), $atts));

  $args = array(
    'post_type'      => 'post',         // 投稿タイプ
    'posts_per_page' => $posts_per_page, // 表示する件数
  );

  $query = new WP_Query($args);
  $output = ''; // 出力を初期化

  if (!$query->have_posts()) {
    return '<p class="none">投稿がありません。</p>'; // 投稿がない場合のメッセージ
  }

  if ($show == 1) {
    $output .= '<section id="news">';
    $output .= '<h2 class="headline01">お知らせ・ブログ</h2>';
  }

  $output .= '<ul>';

  while ($query->have_posts()) {
    $query->the_post();
    
    // アイキャッチ画像を取得
    if (has_post_thumbnail()) {
      $thumb = '<figure>'.wp_get_attachment_image(get_post_thumbnail_id(), 'full').'</figure>';
    } else {
      // デフォルト画像を指定
      $thumb = '<figure><img src="https://placehold.jp/41b88d/ffffff/640x480.jpg?text=NoImage" alt="No Image" /></figure>';
    }

    // カテゴリー情報の取得
    $cats = get_the_category();
    $child = '';
    foreach ($cats as $cat) {
      $color = ColorfulCategories::getColorForTerm($cat->term_id, true);  // カテゴリー色取得
      if ($cat->parent) {
        $child = '<i style="background-color: ' . esc_attr($color) . ';">' . esc_html($cat->cat_name) . '</i>';
      }
    }

    // 記事のHTML構造
    $output .= '<li class="article js-fadeUp">';
    $output .= sprintf('<a href="%s">', get_permalink());
    $output .= $thumb;
    $output .= '<div>';
    $output .= sprintf('<time datetime="%s">%s</time>', get_the_date('Y-m-d'), get_the_date(get_option('date_format')));
    $output .= $child;
    $output .= sprintf('<h3>%s</h3>', esc_html(get_the_title()));
    $output .= '</div>';
    $output .= '</a>';
    $output .= '</li>';
  }

  $output .= '</ul>';
  $output .= '<a href="' . esc_url(home_url('/news/')) . '">もっと見る</a>';


  if ($show == 1) {
    $output .= '</section>';
  }

  wp_reset_postdata(); // クエリのリセット

  return $output;
}

add_shortcode('display_news', 'display_news_shortcode');
