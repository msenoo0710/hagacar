<?php
/**-+-+-+-+-+-+-+-+-+-+-+-+-+
|O|N|E|T|A|K|E|P|R|O|J|E|C|T|
+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 * DATE: 2024/11/09
 * AUTHOR: OneTakeProject
 * URL: http://createone.jp/
 */

/* /////////////////////////////////
  ダッシュボード
///////////////////////////////// */

// カスタム投稿タイプの投稿数をダッシュボードに表示する
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

// ウィジェットを非表示
remove_action('welcome_panel', 'wp_welcome_panel');

// 現在の状況（概要）の中身を色々非表示にする
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

// ログイン中だけCSS追加
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

// ログイン画面のロゴを変更
add_action(
  'login_head',
  function () {
      echo '<style type="text/css">
      #login h1 {
        display: block;
        width: 320px;
        height: 100px;
        margin: 0 auto;
        background-image:url(' . get_theme_file_uri() . '/login_logo.png);
        background-repeat: no-repeat;
        background-position: center top;
        background-size: contain;
        a{
          visibility:hidden;
        }
      }
    </style>';
  }
);

// 管理画面投稿一覧ページにCSSを適用
add_action(
'admin_head',
function () {
    echo '<style type="text/css">
    .featured-image img, .featured-image-none{ max-height: unset; height: auto;}
  </style>';
}
);

// 表示オプション非表示
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

// 管理バー
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

// サイドメニュー
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

// 固定ページとmwwpformでビジュアルエディターを無効化
add_filter('user_can_richedit', 'disable_visual_editor_for_pages_and_mwwpform');
function disable_visual_editor_for_pages_and_mwwpform($can_richedit) {
  if (get_post_type() === 'page' || get_post_type() === 'mw-wp-form') {
      return false; // 固定ページと mwwpform でビジュアルエディターを無効化
  }
  return $can_richedit; // 他の投稿タイプではビジュアルエディターを有効
}

// 自動挿入されるPタグを削除する
add_action('template_redirect', 'conditionally_remove_wpautop');
function conditionally_remove_wpautop() {
  if (is_page()) { // 固定ページの場合のみ
      remove_filter('the_content', 'wpautop');
      remove_filter('the_excerpt', 'wpautop');
  }
}

// カテゴリー選択部分で「新規カテゴリーを追加」と「よく使うもの」を非表示にする
function hide_category_tabs_adder(){
global $pagenow, $post_type, $post;
if (is_admin() && ($pagenow == 'post-new.php' || $pagenow == 'post.php')) {
  list($html) = null;

  if (is_singular('post')) {
    // 投稿の場合
    $taxonomies = get_post_taxonomies($post->ID);
  } else {
    // 投稿タイプの場合
    $taxonomies = get_object_taxonomies($post_type);
  }
  if (!empty($taxonomies)) {
    foreach ($taxonomies as $taxonomy) {
      $html .= '#' . $taxonomy . '-tabs, #' . $taxonomy . '-adder {display:none;} ';
    }
  }
  echo '<style type="text/css">
  #category-tabs, #category-adder {display:none;}
  .components-button.is-link {display:none;}
  .tabs-panel{max-height:100%!important;border:none!important;}
  ' . $html . '
  </style>';
}
}
add_action('admin_head', 'hide_category_tabs_adder');

// カテゴリーをチェックした時に、並び順が変更にならないようにする
function ps_wp_terms_checklist_args($args, $post_id){
if (isset($args['checked_ontop']) !== false) {
  $args['checked_ontop'] = false;
}
return $args;
}
add_filter('wp_terms_checklist_args', 'ps_wp_terms_checklist_args', 10, 2);

// Gutenberg用のCSSを読み込む
add_action('enqueue_block_assets', function () {
if (is_front_page()) return;
$editor_style_url = get_theme_file_uri('/style.css');
wp_enqueue_style('theme-editor-style', $editor_style_url);
});
function gutenberg_support_setup(){
if (is_front_page()) return;
add_theme_support('wp-block-styles');
}
add_action('after_setup_theme', 'gutenberg_support_setup');

// エディター用のCSSを読み込む
function custom_editor_fonts() {
$editor_style_url = get_theme_file_uri('/style.css');
add_editor_style( $editor_style_url );
}
add_action( 'after_setup_theme', 'custom_editor_fonts' );

// タグ・カテゴリー無効化
function my_unregister_taxonomies(){
global $wp_taxonomies;

/*
   * 投稿機能から「カテゴリー」を削除
   */
// if (!empty($wp_taxonomies['category']->object_type)) {
//   foreach ($wp_taxonomies['category']->object_type as $i => $object_type) {
//       if ($object_type == 'post') {
//           unset($wp_taxonomies['category']->object_type[$i]);
//       }
//   }
// }

/*
* 投稿機能から「タグ」を削除
*/
if (!empty($wp_taxonomies['post_tag']->object_type)) {
  foreach ($wp_taxonomies['post_tag']->object_type as $i => $object_type) {
    if ($object_type == 'post') {
      unset($wp_taxonomies['post_tag']->object_type[$i]);
    }
  }
}

return true;
}
add_action('init', 'my_unregister_taxonomies');

// アイキャッチ画像をサポートするようにテーマを設定
function mytheme_setup() {
add_theme_support('post-thumbnails'); // アイキャッチ画像サポートを有効化
}
add_action('after_setup_theme', 'mytheme_setup');




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
        echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@400;500;700;900&display=swap&family=Noto+Sans+JP:wght@100..900&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
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
        wp_enqueue_script('assets-js-script', home_url('/assets/js/script.js?' . $timestamp), null, null, true);


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





/* /////////////////////////////////
	Contact Form 7カスタム
///////////////////////////////// */
// Return-Path設定
add_action('phpmailer_init', function($phpmailer){
	$phpmailer->SMTPKeepAlive = true;
	$phpmailer->Sender = 'haga@hagacar.com';
});

// ふりがな判定
function wpcf7_validate_hurigana($result, $tag) {
    $tag = new WPCF7_Shortcode($tag);
    $name = $tag->name;
    $value = isset($_POST[$name]) ? trim(wp_unslash(strtr((string) $_POST[$name], "\n", " "))) : "";

    // 入力項目名が 'name_kana' の場合に実行
    if ($name === "name_kana") {
        // カタカナ以外が含まれている場合
        // if (!preg_match("/^[ァ-ヶー]+$/u", $value)) {
        //     $result->invalidate($tag, "カタカナで入力してください。");
        // }
        // ひらがな以外が含まれている場合
        if (!preg_match("/^[ぁ-んー]+$/u", $value)) {
          $result->invalidate($tag, "ひらがなで入力してください。");
        }
    }
    return $result;
}
add_filter('wpcf7_validate_text', 'wpcf7_validate_hurigana', 11, 2);
add_filter('wpcf7_validate_text*', 'wpcf7_validate_hurigana', 11, 2);

// pタグの自動生成無効化
add_filter('wpcf7_autop_or_not', '__return_false');

// Contact Form 7用にユニークなtracking_numberを生成する関数
function generate_tracking_number() {
  // 例: 現在の年月日とランダムな数値を組み合わせた番号
  $tracking_number = strtoupper(uniqid());
  return $tracking_number;
}

// Contact Form 7にtracking_numberのショートコードを追加
function add_tracking_number_shortcode($form_tag) {
  if ($form_tag['name'] == 'tracking_number') {
      $form_tag['values'] = array(generate_tracking_number());
  }
  return $form_tag;
}
add_filter('wpcf7_form_tag', 'add_tracking_number_shortcode');