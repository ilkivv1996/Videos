<?php echo "<?xml version='1.0' encoding='UTF-8'?>";?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if(isset($sitemaps))
    @foreach($sitemaps as $sitemap)
    <sitemap>

        <loc>{{$sitemap->url}}</loc>

        <lastmod>{{$sitemap->updated_at}}</lastmod>

    </sitemap>
    @endforeach
    @endif
</sitemapindex>