<main class="page--news">
  <article id="entry" class="post_article">
  <?php
  if (have_posts()):
    echo '<div class="entrybody">';
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

    ?>

    <section id="entryhead">
    <?php
    echo sprintf('<time datetime="%s">%s</time>', get_the_date('Y-m-d'), get_the_date(get_option('date_format')));
    echo $child;
    the_title('<h1>', '</h1>'); 
    ?>
    </section>

    <section id="body">
    <?php echo get_the_content(); ?>
    </section>

    <nav id="pager">
      <ul>
        <li class="prev">
          <?php
          $prev_post = get_previous_post();
          if (!empty($prev_post)): ?>
            <a href="<?php echo get_permalink($prev_post->ID); ?>">
              <span class="mod__pager__label">前の記事</span>
            </a>
          <?php endif; ?>
        </li>
        <li class="next">
          <?php
          $next_post = get_next_post();
          if (!empty($next_post)): ?>
            <a href="<?php echo get_permalink($next_post->ID); ?>">
              <span class="mod__pager__label">次の記事</span>
            </a>
          <?php endif; ?>
        </li>
        <li class="return">
          <a href="<?php echo esc_url(home_url('/news/')); ?>">一覧へ戻る</a>
        </li>
      </div>
    </nav>

    <?php
    endwhile;
    echo '</div>';
  else:
    echo '<p class="none">現在投稿がありません。&nbsp;<a href="' . home_url() . '">トップに戻る</a></p>';
  endif;
  ?>
  </article>
</main>
