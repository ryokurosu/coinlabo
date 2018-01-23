<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <url>
        <loc>{{ route('root') }}</loc>
        <lastmod>2018-01-16</lastmod>
    </url>
    <url>
        <loc>{{ route('home') }}</loc>
        <lastmod>2018-01-16</lastmod>
    </url>
    <url>
        <loc>{{ route('article') }}</loc>
        <lastmod>2018-01-16</lastmod>
    </url>
    <url>
        <loc>{{ route('topic') }}</loc>
        <lastmod>2018-01-16</lastmod>
    </url>
    @foreach($articles as $p)
    <url>
        <loc>{{ route('article.page',$p) }}</loc>
        <lastmod>{{ $p->updated_at->format('Y-m-d')}}</lastmod>
        <image:image>
        <image:loc>{{$p->imagePath()}}</image:loc>
        <image:title>{{$p->title}}</image:title>
    </image:image>
</url>
@endforeach
@foreach($users as $p)
<url>
    <loc>{{ route('article.user',$p) }}</loc>
    <lastmod>{{ $p->updated_at->format('Y-m-d')}}</lastmod>
</url>
@endforeach
@foreach($topics as $p)
<url>
    <loc>{{ route('topic.page',$p) }}</loc>
    <lastmod>{{ $p->updated_at->format('Y-m-d')}}</lastmod>
    <image:image>
    <image:loc>{{$p->imagePath()}}</image:loc>
    <image:title>{{$p->title}}</image:title>
</image:image>
</url>
@endforeach
</urlset>

