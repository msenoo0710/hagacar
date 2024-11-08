<main id="news" class="page--news">
  <h1 id="pagetitle">
    <?php
    $cats = get_the_category();
    
    if (!empty($cats)) {
        $cat = $cats[0];
        
        // 親カテゴリーがある場合は親カテゴリー名、ない場合は現在のカテゴリー名を表示
        if ($cat->parent) {
            $parent = get_category($cat->parent);
            echo esc_html($parent->cat_name);
        } else {
            echo esc_html($cat->cat_name);
        }
    }
    ?>
    
    <?php if (!have_posts()) : ?>
      お知らせ・ブログ
    <?php endif; ?>
  </h1>

  <section id="article">
    <?php
    if (have_posts()):
      echo '<ul>';
      while (have_posts()) : the_post();


        // アイキャッチ画像の取得
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


        // 投稿の表示
        echo '<li class="article js-fadeUp">';
        echo sprintf('<a href="%s">', get_permalink());
        echo $thumb;
        echo '<div>';
        echo sprintf('<time datetime="%s">%s</time>', get_the_date('Y-m-d'), get_the_date(get_option('date_format')));
        echo $child;
        echo sprintf('<h3>%s</h3>', esc_html(get_the_title()));
        echo '</div>';
        echo '</a>';
        echo '</li>';

      endwhile;
      echo '</ul>';
    else:
      echo '<p class="text-center pt-5">現在投稿がありません。<br><a href="' . home_url() . '">トップへ戻る</a></p>';
    endif;
    ?>

    <!-- ページネーション -->
    <?php if ($wp_query->max_num_pages > 1) : ?>
      <div class="mod__pagination js-fadeUp pt-0">
        <?php
          echo get_the_posts_pagination(array(
            'mid_size'  => 2,          // 現在ページの前後に表示するページ数
            'prev_text' => '« 前へ',   // 「前へ」リンクのテキスト
            'next_text' => '次へ »',   // 「次へ」リンクのテキスト
            'screen_reader_text' => 'ページナビゲーション',  // スクリーンリーダー用テキスト
            'type' => 'list',          // ページネーションのリスト形式で出力
          ));
        ?>
      </div>
    <?php endif; ?>

  </section>
</main>
