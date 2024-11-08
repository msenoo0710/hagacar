<?php
get_header();

// フロントページと投稿ページが同じ場合
if (is_front_page() && is_home()) {
    get_template_part('parts/content', 'page'); // デフォルトのフロントページ
} 
// 静的なフロントページ
elseif (is_front_page()) {
    get_template_part('parts/content', 'page');
} 
// 投稿のアーカイブ（ブログ投稿一覧ページ）
elseif (is_home()) {
    get_template_part('parts/content', 'post');
} 
// 単一の投稿または固定ページ
elseif (is_singular()) {
    if (is_page()) {
        // 固定ページ
        get_template_part('parts/content', 'page');
    } else {
        // カスタム投稿タイプや投稿タイプpostの詳細ページ
        get_template_part('parts/content', get_post_type() . '-single');
    }
} 
// カスタム投稿タイプや投稿のアーカイブページ
elseif (is_post_type_archive() || is_category() || is_tax() || is_search()) {
    $post_type = get_post_type();
    
    // 投稿がない場合、クエリされたオブジェクトから投稿タイプを取得
    if (!$post_type) {
        $queried_object = get_queried_object();
        if ($queried_object) {
            if (isset($queried_object->taxonomy)) {
                // タクソノミーに関連付けられた投稿タイプを取得
                $taxonomy = get_taxonomy($queried_object->taxonomy);
                if ($taxonomy && !empty($taxonomy->object_type)) {
                    $post_type = $taxonomy->object_type[0]; // 最初の投稿タイプを取得
                }
            } elseif (isset($queried_object->post_type)) {
                // クエリされたオブジェクトが投稿タイプを持つ場合
                $post_type = $queried_object->post_type;
            } else {
                $post_type = $queried_object->name;
            }
        }
    }

    // 該当する投稿タイプのアーカイブテンプレートを読み込み
    if ($post_type) {
        get_template_part('parts/content', $post_type);
    } else {
        // デフォルトはページのコンテンツ
        get_template_part('parts/content', 'page');
    }
} 
// その他の条件（例：404ページ、検索結果ページなど）
else {
    get_template_part('parts/content', 'page');
}

get_footer();
?>
