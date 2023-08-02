<!DOCTYPE html>
<html lang="en">
<head>
    <title>mediQ</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:500,400,300,700' rel='stylesheet' type='text/css'>
    <script src="/assets/js/core/pace.js"></script>
    <link href="{{mix("/assets/css/laraspace.css")}}" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/img/fav.png">
    <!-- <link rel="apple-touch-icon" sizes="60x60" href="/assets/img/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/img/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/img/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/img/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/img/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/apple-touch-icon-180x180.png"> -->
    <link rel="icon" type="image/png" href="/assets/img/fav.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/assets/img/fav.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/assets/img/fav.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/assets/img/fav.png" sizes="16x16">
    <link rel="manifest" href="/assets/img/fav.png">
    <link rel="mask-icon" href="/assets/img/fav.png" color="#333333">
    <link rel="shortcut icon" href="/assets/img/fav.png">
    <!-- <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="/assets/img/mstile-144x144.png">
    <meta name="msapplication-config" content="/assets/img/browserconfig.xml"> -->
    <meta name="theme-color" content="#333333">
    <meta name="p:domain_verify" content="854a57768a320ce035a9cf5321f5b4c9"/>

      <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-5NJXW55FJZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-5NJXW55FJZ');
</script>

<title>Smart Healthcare Services at Your Home Book on Mobile | mediQ</title>
<meta property="og:title" content="Smart Healthcare Services at Your Home Book on Mobile | mediQ" /> <!--This would get from DB for every individual page-->
<meta property="og:description" content="mediQ provides smart healthcare solutions to health service providers as well as consumers at their doorstep 24/7 in Pakistan conveniently." /> <!--This would get from DB for every individual page-->
<meta property="og:type" content="Website" />
<meta property="og:site_name" content="mediQ" />
<meta property="og:locale" content="en_US" />
<meta property="og:url" content="https://www.mediq.com.pk/" />
<meta property="og:image" content="https://www.mediq.com.pk/assets/img/logo.svg" /> <!--This would get from DB for every individual page-->

<meta name="twitter:title" content="Smart Healthcare Services at Your Home Book on Mobile | mediQ" /> <!--This would get from DB for every individual page-->

<meta name="twitter:description" content="mediQ provides smart healthcare solutions to health service providers as well as consumers at their doorstep 24/7 in Pakistan conveniently." /> <!--This would get from DB for every individual page-->

<meta name="twitter:image" content="https://www.mediq.com.pk/assets/img/logo.svg" /> <!--This would get from DB for every individual page-->

<meta name="twitter:card" content="summary_large_image" />

<meta name="twitter:site" content="@mediQ_SHC" />
</head>
<body class="layout-default skin-default">
<div id="app" class="site-wrapper">
    <div class="mobile-menu-overlay" @click.prevent="$utils.toggleSidebar"></div>
    <transition name="fade" mode="out-in">
        <router-view></router-view>
    </transition>
    <!-- <theme-switcher /> -->
</div>
<script type="text/javascript" src="{{mix("/assets/js/app.js")}}"></script>
</body>
</html>
