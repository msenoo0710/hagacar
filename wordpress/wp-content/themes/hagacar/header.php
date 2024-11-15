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
                    <a href="<?=home_url()?>">
                        <img class="header__logo-mark--default" loading="eager" src="<?=home_url('/assets/images/common/logo.png?24083103')?>" width="266" height="296" alt="芳賀自動車">
                        <span>芳賀自動車</span>
                    </a>
                </h1>
            </div>
            <div class="header__content">
                <nav class="header__nav">
                    <ul class="header__nav-list anker">
                        <li class="header__nav-item"><a href="<?=home_url('/service/#sales')?>">
                            <span class="header__nav-link">車両販売</span>
                        </a></li>
                        <li class="header__nav-item"><a href="<?=home_url('/service/#factory')?>">
                            <span class="header__nav-link">車検・整備</span>
                        </a></li>
                        <li class="header__nav-item"><a href="<?=home_url('/service/#insurance')?>">
                            <span class="header__nav-link">保険</span>
                        </a></li>
                        <li class="header__nav-item"><a href="<?=home_url('/company/')?>">
                            <span class="header__nav-link">会社案内</span>
                        </a></li>
                        <li class="header__nav-item"><a href="<?=home_url('/contact/')?>">
                            <span class="header__nav-link">お問い合わせ</span>
                        </a></li>
                    </ul>
                </nav>
                <div class="header__hamburger">
                    <div class="header__hamburger-bars">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__mobile">
            <div class="header__mobile-wrap">
                <div class="header__mobile-content">
                    <nav class="header__mobile-nav">
                        <ul class="header__mobile-nav-list anker">
                            <li class="header__mobile-nav-item"><a href="<?=home_url()?>">
                                <span class="header__mobile-nav-link">ホーム</span>
                            </a></li>
                            <li class="header__mobile-nav-item"><a href="<?=home_url('/service/#sales')?>">
                                <span class="header__mobile-nav-link">車両販売</span>
                            </a></li>
                            <li class="header__mobile-nav-item"><a href="<?=home_url('/service/#factory')?>">
                                <span class="header__mobile-nav-link">車検・整備</span>
                            </a></li>
                            <li class="header__mobile-nav-item"><a href="<?=home_url('/service/#insurance')?>">
                                <span class="header__mobile-nav-link">保険</span>
                            </a></li>
                            <li class="header__mobile-nav-item"><a href="<?=home_url('/company/')?>">
                                <span class="header__mobile-nav-link">会社案内</span>
                            </a></li>
                            <li class="header__mobile-nav-item"><a href="<?=home_url('/contact/')?>">
                                <span class="header__mobile-nav-link">お問い合わせ</span>
                            </a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
<!-- /header -->