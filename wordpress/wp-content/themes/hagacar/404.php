<?php get_header(); ?>
<main class="page--error404">
    <article class="post_article">
        <section class="mod__mainvisual">
            <div class="mod__mainvisual__wrap">
                <div class="mod__mainvisual__content">
                    <div class="mod__mainvisual__content--heading js-fadeUp">
                        <i>404 NOT FOUND</i>
                        <h1>ページが見つかりません</h1>
                    </div>
                </div>
            </div>
            <div class="mod__mainvisual__background">
                <div class="mod__mainvisual__background--video">
                    <img src="<?=home_url('/assets/images/team_haleo/team_haleo_mv.jpg')?>" width="2000" height="1334" alt="">
                </div>
            </div>
        </section>
        <section class="intro pb-5">
            <div class="intro__wrap pb-5">
                <div class="intro__content js-fadeUp p-5">
                    <p class="mb-5 p-5 text-center">お探しのページは移動<span class="d-inline-block">または削除された可能性があります。</span></p>
                    <a href="<?=home_url()?>" class="mod__button--large">ホームへ戻る</a>
                </div>
            </div>
        </section>
    </article>
</main>
<?php get_footer(); ?>