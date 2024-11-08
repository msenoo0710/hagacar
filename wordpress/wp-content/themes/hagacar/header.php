<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- header -->
<header class="header">
    <div class="header__wrap">
        <div class="header__logo">
            <h1 class="header__logo-mark">
                <a href="<?=home_url()?>" class="header__logo-link">
                    <img class="header__logo-mark--white" loading="eager" src="<?=home_url('assets/images/common/logo_bpi_white.svg')?>" width="220" height="40" alt="BODYPLUS GROUP 株式会社 ボディプラスインターナショナル">
                    <img class="header__logo-mark--default" loading="eager" src="<?=home_url('assets/images/common/logo_bpi.svg')?>" width="220" height="40" alt="BODYPLUS GROUP 株式会社 ボディプラスインターナショナル">
                </a>
            </h1>
        </div>
        <div class="header__content">
            <nav class="header__nav">
                <ul class="header__nav-list">
                    <li class="header__nav-item header__nav-item--who_we_are child">
                        <a href="<?=home_url('/who_we_are/')?>"><span>企業情報</span></a>
                        <ol class="header__nav-sublist">
                            <li><a href="<?=home_url('/who_we_are/message/')?>">代表メッセージ</a></li>
                            <li><a href="<?=home_url('/who_we_are/profile/')?>">会社概要</a></li>
                            <li><a href="<?=home_url('/who_we_are/history/')?>">沿革</a></li>
                            <li><a href="<?=home_url('/who_we_are/our_team/')?>">スタッフ紹介</a></li>
                            <li><a href="<?=home_url('/who_we_are/csr/')?>">CSR活動</a></li>
                        </ol>
                    </li>
                    <li class="header__nav-item header__nav-item--services child">
                        <a href="<?=home_url('/services/')?>"><span>事業紹介</span></a>
                        <ol class="header__nav-sublist">
                            <li><a href="<?=home_url('/services/#supplement')?>">サプリメント</a></li>
                            <li><a href="<?=home_url('/services/#haleo')?>">TEAM HALEO</a></li>
                            <li><a href="<?=home_url('/services/#shop')?>">トレーニングジム</a></li>
                        </ol>
                    </li>
                    <li class="header__nav-item"><a href="<?=home_url('/team_haleo/')?>"><span>TEAM HALEO</span></a></li>
                    <li class="header__nav-item"><a href="<?=home_url('/join_us/')?>"><span>採用情報</span></a></li>
                    <li class="header__nav-item">
                        <ul class="header__nav-langlist">
                            <li class="header__nav-langlist-item"><a href="#" data-stt-changelang="ja" data-stt-ignore data-stt-active>JA</a></li>
                            <li class="header__nav-langlist-item"><a href="#" data-stt-changelang="en" data-stt-ignore>EN</a></li>
                        </ul>
                    </li>
                    <li class="header__nav-item header__nav-item--contact"><a href="<?=home_url('/contact/')?>"><span>お問い合わせ</span></a></li>
                </ul>
            </nav>
            <div class="header__hamburger">
                <div class="header__hamburger-bars">
                    <span></span><span></span>
                </div>
            </div>
        </div>
    </div>
    <div class="header__mobile">
        <div class="header__mobile-wrap">
            <div class="header__mobile-lang">
                <ul class="header__mobile-lang-list">
                    <li class="header__mobile-lang-item"><a href="#" data-stt-changelang="ja" data-stt-ignore data-stt-active>JA</a></li>
                    <li class="header__mobile-lang-item"><a href="#" data-stt-changelang="en" data-stt-ignore>EN</a></li>
                </ul>
            </div>
            <div class="header__mobile-content">
                <nav class="header__mobile-nav">
                    <ul class="header__mobile-nav-list">
                        <li class="header__mobile-nav-item header__mobile-nav-item--home">
                            <a href="<?=home_url()?>"><span class="en">HOME</span><span class="ja">ホーム</span></a>
                        </li>
                        <li class="header__mobile-nav-item">
                        <a href="<?=home_url('/who_we_are/')?>"><span class="en">WHO WE ARE</span><span class="ja">企業情報</span></a>
                            <ol class="header__mobile-nav-sublist">
                                <li><a href="<?=home_url('/who_we_are/message/')?>">代表メッセージ</a></li>
                                <li><a href="<?=home_url('/who_we_are/profile/')?>">会社概要</a></li>
                                <li><a href="<?=home_url('/who_we_are/history/')?>">沿革</a></li>
                                <li><a href="<?=home_url('/who_we_are/our_team/')?>">スタッフ紹介</a></li>
                                <li><a href="<?=home_url('/who_we_are/csr/')?>">CSR活動</a></li>
                            </ol>
                        </li>
                        <li class="header__mobile-nav-item">
                        <a href="<?=home_url('/services/')?>"><span class="en">SERVICES</span><span class="ja">事業紹介</span></a>
                            <ol class="header__mobile-nav-sublist">
                                <li><a href="<?=home_url('/services/#supplement')?>">サプリメント</a></li>
                                <li><a href="<?=home_url('/services/#haleo')?>">TEAM HALEO</a></li>
                                <li><a href="<?=home_url('/services/#shop')?>">トレーニングジム</a></li>
                            </ol>
                        </li>
                        <li class="header__mobile-nav-item">
                        <a href="<?=home_url('/join_us/')?>"><span class="en">JOIN US</span><span class="ja">採用情報</span></a>
                            <ol class="header__mobile-nav-sublist">
                                <li><a href="<?=home_url('/join_us/culture/')?>">カルチャー</a></li>
                                <li><a href="<?=home_url('/join_us/voice/')?>">チームからの声</a></li>
                                <li><a href="<?=home_url('/join_us/employee_welfare/')?>">福利厚生について</a></li>
                            </ol>
                        </li>
                    </ul>
                </nav>
                <nav class="header__mobile-subnav">
                    <ul class="header__mobile-subnav-list">
                        <li class="header__mobile-subnav-item header__mobile-subnav-item--home"><a href="<?=home_url()?>"><span class="en">HOME</span><span class="ja">ホーム</span></a></li>
                        <li class="header__mobile-subnav-item"><a href="<?=home_url('/news/')?>"><span class="en">NEWS</span><span class="ja">お知らせ</span></a></li>
                        <li class="header__mobile-subnav-item"><a href="<?=home_url('/column/')?>"><span class="en">COLUMN</span><span class="ja">コラム</span></a></li>
                        <li class="header__mobile-subnav-item"><a href="<?=home_url('/contact/')?>"><span class="en">CONTACT US</span><span class="ja">お問い合わせ</span></a></li>
                        <li class="header__mobile-subnav-item"><a href="<?=home_url('/privacy-policy/')?>"><span class="en">PRIVACY POLICY</span><span class="ja">プライバシーポリシー</span></a></li>
                    </ul>
                    <div class="header__mobile-subnav-team_haleo">
                        <a href="<?=home_url('/team_haleo/')?>">
                            <figure>
                                <img src="<?=home_url('./assets/images/common/header_team_haleo.jpg?24102301')?>" width="100" height="100" alt="TEAM HALEO チームハレオ">
                                <figcaption>
                                    <span class="en">TEAM HALEO</span>
                                    <span class="ja">チームハレオ</span>
                                </figcaption>
                            </figure>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- /header -->