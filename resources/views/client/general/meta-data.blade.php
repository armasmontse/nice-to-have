<!-- Place this data between the <head> tags of your website -->
<meta name="description" content="{{ $seo->description }}" />

<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ $seo->title }}">
<meta itemprop="description" content="{{ $seo->description }}">
<meta itemprop="image" content="{{ $seo->thumbnail_image->url }}">

<!-- Twitter Card data -->
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $seo->title }}">
<meta name="twitter:description" content="{{ $seo->description }}">
<meta name="twitter:image:src" content="{{ $seo->thumbnail_image->url }}">

<!-- Open Graph data -->
<meta property="fb:app_id" content="{{ env('FACEBOOK_APP_ID') }}"/>
<meta property="og:title" content="{{ $seo->title }}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{ Request::url() }}" />
<meta property="og:image" content="{{ $seo->thumbnail_image->url }}" />
<meta property="og:description" content="{{ $seo->description }}" />
<meta property="og:site_name" content="{{ env('APPNOMBRE') }}" />
